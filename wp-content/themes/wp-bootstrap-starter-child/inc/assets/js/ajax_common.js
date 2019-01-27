window.ac = {};
ac.el = {};
ac.fn = {};
ac.fn.ajaxHandlers = {};
ac.fn.pickerifyHandlers = {};

jQuery(document).ready(function ($) {
    ac.fn.initAjaxObject();
    ac.fn.ajaxifyPage();
});

/**
 * Runs though all elements containing AJAXIFY_ME class.
 * Collects basic props collected in an element class fields.
 * @todo to implement collection of extra props from data-data atributed, like a json-encoded object
 * Choice for a class-encoded basic props is an intended one.
 * Removes an existing event listener (if any)
 * Assigns new event listener for an ajax call
 */
ac.fn.ajaxifyPage = function(){
    var toAjaxifyElems = document.getElementsByClassName(AJAXIFY_ME);
    if(!toAjaxifyElems || toAjaxifyElems.length < 1) return;
    for(var i = 0; i < toAjaxifyElems.length; i++){
         ac.fn.ajaxifyElem(toAjaxifyElems[i]);
    }
};

ac.fn.ajaxifyElem = function(elem){
    var props = ac.fn.collectAjaxifyProps(elem);console.log(props);
    var funcName = elem.getAttribute('name')+props.event;
    try{ elem.removeEventListener(props.event,window.ac.fn.ajaxHandlers[funcName]);
    } catch (e){
        // do nothing
    };
    window.ac.fn.ajaxHandlers[funcName] = function(e){
        e.preventDefault();
        var req = new AjaxRequest();
        req.action = props.action;
        req.directive = props.directive;
        req.group = props.group;
        req.status = props.status;
        req.cargo = {};
        if(props.allForms){
            req.cargo = ac.fn.collectAllFormsData(null,props.collectFormDataWithArrays);
        }
        if(props.form){
            ac.fn.collectFormData(props.form,props.collectFormDataWithArrays,req.cargo);
        }
        if(props.functionPrepare){
            if(typeof window[props.functionPrepare] === 'function'){
                window[props.functionPrepare](req, elem, e);
            }
        }
        console.log("req",req);
        jQuery.ajax({
            url: ajax_object.ajax_url, data: req, type: "POST", dataType: "json", complete: function (data, status) {
                console.log("res",data.responseJSON);
                console.log(status);
                //if (status != 'success' && status != "completed") {
                if (status != 'success') {
                    toastr.error('Server Error');
                    return;
                }
                res = data.responseJSON;
                var r = new AjaxResponse(res);
                ac.fn.showMessages(res);
                var htmlContainer = r.getHtmlContainer();
                if(htmlContainer.length < 2){
                    htmlContainer = props.htmlContainer;
                } 
                if(htmlContainer){
                    var container = ac.fn.wildFetchElement(htmlContainer);
                    console.log(container);
                    
                    if(container ){
                        container.innerHTML = r.getHtmlString();
                    }
                    // var container = ac.fn.wildFetchElement(r.getHtmlContainer());
                    // if(container ){
                    //     container.innerHTML = r.getHtmlString();
                    // }
                }
                if(props.function){
                    if(typeof window[props.function] === 'function'){
                        window[props.function](res, elem, e);
                    }
                }
                ac.fn.pickerifyForm();
            }
        });
    };
    elem.addEventListener(props.event, window.ac.fn.ajaxHandlers[funcName]);

    // if no form specified - all forms
    // event type
    // action
    // group
    // directive
    // message handling
    // response func handling

};

ac.fn.collectAjaxifyProps = function(elem){
    var props = new AjaxifyProps();
    var classList = elem.classList;
    for(var i = 0; i < classList.length; i++){
        var class_ = classList[i];
        if(class_.indexOf(AJAX_PROPS) !== -1){
            var parts = class_.split(AJAX_DELIM);
            var payload = parts[2];
            //if(CARGO == parts[1]){
                try{
                    payload = JSON.parse(atob(payload));
                } catch(e){
                    // do nothing
                    payload = {};
                }
            //}
            props[lodash.camelCase(parts[1])] = payload;
        }
    }
    
    return props;
};

ac.fn.showMessages = function(carrier, showPopup, containerClass,popupConf){
    if(showPopup === null || showPopup === undefined) showPopup= true;
    var msg = ac.fn.collectMsgFromCarrier(carrier,showPopup);
    if(!msg) return;
    if(showPopup) ac.fn.renderPopupMessages(msg,popupConf);

};

ac.fn.collectMsgFromCarrier = function(carrier, showPopup){
    var msg = {};
    var debugs, errors, info, warnings;
    if(carrier[DEBUGS]){
        msg.debugs = ac.fn.collectMsgType(carrier[DEBUGS]);
    }
    if(carrier[ERRORS]){
        msg.errors = ac.fn.collectMsgType(carrier[ERRORS]);
    }
    if(carrier[INFO]){
        msg.info = ac.fn.collectMsgType(carrier[INFO]);
    }
    if(carrier[WARNINGS]){
        msg.warnings = ac.fn.collectMsgType(carrier[WARNINGS]);
    }  
    if(debugs === false && errors === false && info === false && warnings === false){
        return;
    } 
    //TODO to make rendering of containerized messages;
    if(Object.keys(msg).length < 1) msg = false;
    return msg;
};

ac.fn.collectMsgType = function(msg, type){
    if(msg === undefined || msg === null || msg === false || !msg) return false;
    var ret= {};
    ret.textsArr = [];
    ret.elemsArr = [];
    if(Array.isArray(msg)) {
        for(var i = 0; i < msg.length; i++) {
            ret.textsArr.push(msg[i]);
            ret.elemsArr.push(ac.fn.renderMsg(msg[i],type)); 
        }
    } else {
        for (var m in msg) {
            if(!msg.hasOwnProperty(m)) continue;
            textsArr.puch(msg[m]);
            elemsArr.push(ac.fn.renderMsg(msg[i],type));
        }
    }
    return ret;
};

ac.fn.renderMsg = function(msg,type){
    if(type === ERRORS){
        msg = msg;
    } else if (type === DEBUGS){
        msg = msg;
    }else if (type === WARNINGS) {
        msg = msg;
    } else {
        // INFO
        msg = msg;
    }

    return msg;
};

ac.fn.renderPopupMessages = function(msg, conf){
    if(conf === null || conf === undefined || !conf){
        conf = {};
    }
    if(msg.debugs){
        for(var i = 0; i < msg.debugs.textsArr.length; i++){
            toastr.success(msg.debugs.textsArr[i]);
        }
    }
    if(msg.errors){
        for(var i = 0; i < msg.errors.textsArr.length; i++){
            toastr.error(msg.errors.textsArr[i]);
        }
    }
    if(msg.info){
        for(var i = 0; i < msg.info.textsArr.length; i++){
            toastr.info(msg.info.textsArr[i]);
        }
    }
    if(msg.warnings){
        for(var i = 0; i < msg.warnings.textsArr.length; i++){
            toastr.warning(msg.warnings.textsArr[i]);
        }
    }
}

ac.fn.clearMessages = function(containerClass, keepPopUps){

};



ac.fn.findItsForm = function(elem){
    var formFound = false;
    var form = elem;
    while(!formFound){
        if(form.tagName.toLowerCase() === 'form'){
            formFound = true;
        } else {
            form = form.parentNode;
        }
    }

    return form;
};

ac.fn.collectAllFormsData = function(data, withArrays){
    if(data === null || data === undefined || data === false){
        var data = {};
    }
    if(!withArrays) withArrays = false;
    for(var i = 0; i < document.forms.length; i++){
        ac.fn.collectFormData(document.forms[i],withArrays,data);        
    }

    return data;
};

ac.fn.collectFormData = function (id, withArrays, data) {
    if(!withArrays) withArrays = false;
    if (id !== null && (typeof id !== 'object')) {
        var form = ac.fn.wildFetchElement(id);
        if(!form) return false;
    } else {
        form = id;
    }
    if (form.tagName.toLowerCase() !== 'form') {
        return false;
    }
    if(data === null || data === undefined || data === false){
        var data = {};
    }
    var uniqueNames = [];
    if (!form.elements || form.elements.length === 0) {
        return false;
    }
    for (var i = 0; i < form.elements.length; i++) {
        var el = form.elements[i];
        var name = el.getAttribute('name');
        var value = {};
        var prevValue = {};

        // resolve value
        value = el.value;

        var elType = el.tagName.toLowerCase();
        value = ac.fn.getElementValue(el)
        if (withArrays) {
            if(uniqueNames.indexOf(name) === -1){
                uniqueNames.push(name);
                data[name] = value;
            } else if (uniqueNames.indexOf(name) !== -1 && !Array.isArray(data[name])){
                prevValue = data[name];
                data[name] = [];
                data[name].push(prevValue);
                data[name].push(value);
            }
        } else {
            data[name] = value;
        }
    }

    return data;
};

ac.fn.getElementValue = function(el){
    type = el.tagName.toLowerCase();
    if(type === 'input'){
        type = el.getAttribute('type');
    }
    value = {};
    if(type === 'checkbox'){
        if(el.checked === true){
            value = 1;
        } else {
            value = 0;
        }
    } else {
        value = el.value;
    }

    return value;
};
//todo to find if should be undefined without quotes?
ac.fn.wildFetchElement = function (id) {
    var el = document.getElementById(id);
    if (el && el !== "undefined") {
        return el;
    }
    el = document.getElementsByName(id)[0];
    if (el && el !== "undefined") {
        return el;
    }
    el = document.getElementsByClassName(id)[0];
    if (el && el !== "undefined") {
        return el;
    }
    return false;
};


ac.fn.initAjaxObject = function () {
    if (ajax_object === undefined) {
        return;
    }
    for (var name in ajax_object) {
        if (!ajax_object.hasOwnProperty(name)) continue;
        window[name] = ajax_object[name];
    }
};

class AjaxResponse {
    //TODO TO REDO INTO A CLASS WITH PRIVATE MEMBERS AND GETTRES AND SETTERS
    //https://philipwalton.com/articles/implementing-private-and-protected-members-in-javascript/

    /*
    action;
    cargo;
    consts;
    debugs;
    errors;
    html;
    htmlString;
    info;
    lang;
    status
    warnings;
    */
    constructor(props = null) {

        this.action = null;
        this.cargo = null;
        this.consts = null;
        this.debugs = null;
        this.errors = null;
        this.html = null;
        this.htmlContainer= null;
        this.htmlString = null;
        this.info = null;
        this.lang = null;
        this.showPopupMessages = null;
        this.status = null;
        this.warnings = null;
        
        if (props === null) return;
        for (var name in props) {    
            if (!this.hasOwnProperty(lodash.camelCase(name))) continue;
            this[lodash.camelCase(name)] = props[name];
        }
    }

    getAction() {
        return parseInt(this.action);
    }
    getCargo(key = null) {
        if (key === null) return this.cargo;
        else return this.cargo[key];
    }
    getConsts(key = null) {
        if (key === null) return this.consts[key];
        else return this.consts;
    }
    getDebugs(key = null) {
        if (key === null) return this.debugs[key];
        else return this.debugs;
    }
    getErrors(key = null) {
        if (key === null) return this.errors[key];
        else return this.errors;
    }
    getHtml(key = null) {
        if (key === null) return this.html[key];
        else return this.html;
    }
    getHtmlContainer(){
        return this.htmlContainer;
    }
    getHtmlString() {
        return this.htmlString;
    }
    getInfo(key = null) {
        if (key === null) return this.info[key];
        else return this.info;
    }
    getLang(key = null) {
        if (key === null) return this.lang[key];
        else return this.lang;
    }
    getShowPopupMessages(){
        return this.showPopupMessages;
    }
    getStatus() {
        return parseInt(this.status);
    }
    getWarnings(key = null) {
        if (key === null) return this.warnings[key];
        else return this.warnings;
    }

};

class AjaxRequest {
    constructor() {
        this.action;
        this.cargo;
        this.directive;
        this.group;
        this.status;
    }

    setAction(action) {
        this.action = action;
    }

    setCargo(cargo, key) {
        if (key === null) this.cargo = cargo;
        else this.cargo[key] = cargo;
    }
    setDirective(directive) {
        this.directive = parseInt(directive);
    }
    setGroup(group) {
        this.group = parseInt(group);
    }
    setStatus(status) {
        this.status = parseInt(status);
    }
};

ac.fn.getPropFromClass = function (node, prefix){ 
    var classList = node.classList;
    var value = false;
    for(var i = 0; i < classList.length;i++){
        var class_ = classList[i];
        if(class_.indexOif(prefix) !== -1){
            value = class_.split(prefix)[1];
        }
    }

    return value;
};

class AjaxifyProps {
    constructor(){
        this.action = 'stds_router';
        this.allForms = true;
        this.cargo;
        this.collectFormDataWithArrays = false;
        this.directive = "";
        this.event = 'click';
        this.form = false;
        this.function = false;
        this.functionPrepare = false;
        this.group = "";
        this.htmlContainer = false;
        this.messageContainer = "";
        this.showPopup = true;
        this.status = 1;
    }
};


/*
    PICKERIFICATION

*/

ac.fn.pickerifyForm = function() {
    /* find an element that contains pickerify elements */
    var carrier = document.getElementsByClassName(PICKERIFY_ME)[0];
    if(!carrier){
        return false;
    }
    var [txt,img, imgSrc] = ac.fn.findPickerifyProps(carrier);
    
    txt = document.getElementsByClassName(txt)[0];
    img = document.getElementsByClassName(img)[0];
    imgSrc = document.getElementsByClassName(imgSrc)[0];
    
    if(!txt && !img){
        return;
    }
    var form = ac.fn.findItsForm(carrier);
    for(var i = 0; i < form.elements.length; i++){
        if(form.elements[i].tagName.toLowerCase() !== 'input' && form.elements[i].getAttribute('type') !== 'checkbox'){
            continue;
        }
        var el = form.elements[i];
        var elName = el.getAttribute('name');
        el.removeEventListener('change',ac.fn.pickerifyHandlers[elName]);
        ac.fn.pickerifyHandlers[elName] = ac.fn.setPickerifyPropsOnPage.bind(null, form.elements[i],form.elements,txt,img, imgSrc);
        el.addEventListener('click',ac.fn.pickerifyHandlers[elName]);
    }    
}

ac.fn.findPickerifyProps = function(carrier){
    /* find params */
    var txt = false;
    var img = false;
    var imgSrc = false;
    var parts = [];
    for(var i = 0; i < carrier.classList.length; i++){
        if(carrier.classList[i].indexOf(PICKERIFY_ME) === -1){
            continue;
        }
        parts = carrier.classList[i].split(DELIM);
        if(parts.indexOf(PICKER_TARGET_IMG) !== -1){
            img = parts[2];
        }
        if(parts.indexOf(PICKER_TARGET_TEXT) !== -1){
            txt = parts[2];
        }
        if(parts.indexOf(PICKER_TARGET_IMG_NAME) !== -1){
            imgSrc = parts[2];
        }
    } 

    return [txt, img, imgSrc];
}

ac.fn.setPickerifyPropsOnPage = function(el, elems, txt, img, imgSrc){
    /* if user is unchecking the element, reset text and img src */
 
    if(el.checked == false){
        el.checked = false;
        if(txt) txt.value = '';
        if(img) img.setAttribute('src','#');
        return;
    }
    for(var i = 0; i < elems.length; i++){
        if(elems[i].tagName.toLowerCase() !== 'input' && elems[i].getAttribute('type') !== 'checkbox'){
            continue;
        }
        elems[i].checked = false;
    }
    el.checked = true;
    var name = el.getAttribute('name').split(AJAX_DELIM)[1];
    var parts = name.split('/');
    name = parts[parts.length -1];
    var url = "";
    for(i = 0; i < el.classList.length; i++){
        if(el.classList[i].indexOf(SELECTED_ITEM) === -1){
            continue;
        }
        url = el.classList[i].split(DELIM)[1];
    }
     if(txt){
         txt.value = name;
     }   
     if(img){
         img.setAttribute('src',url);
     }
     if(imgSrc){
         imgSrc.value = url;
     }
}