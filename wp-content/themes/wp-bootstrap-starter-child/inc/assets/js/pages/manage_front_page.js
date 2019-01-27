window.mf = {};
window.mf.el = {};
window.mf.fn = {};
mf.fn.hotOfferHandlers = {};

jQuery(document).ready(function ($) {
    console.log(ajax_object);
    mf.fn.findElems();
    /* init content window */
    if(parseInt(mf.el.selectForm.value) !==EMPTY_) {
        mf.el.selectForm.dispatchEvent(new Event('change'));
    }
    //mh.fn.initMediaHandlerControls();  
});

function handleFormSelector(req, elem, evt){
    var formCont = document.getElementsByClassName('current_form')[0];
    formCont.classList.add('d-none');
    req.setDirective(elem.value);
}

function handleFormSelectorResponse(res,elem,e){console.log(res);
    var formCont = document.getElementsByClassName('current_form')[0];
    var body = formCont.querySelector('.card-body');
    var header = formCont.querySelector('.card-header');
    var res = new AjaxResponse(res);
    if(res.action === parseInt(LOAD_ADD_HOT_OFFER)){
        formCont.classList.remove('d-none');
        //body.innerHTML = res.htmlString;
        header.textContent = 'ADD HOT OFFER';
        mf.fn.wireUpHotOfferPreview();
    } else if(res.action === parseInt(LOAD_ACTIVATE_HOT_OFFERS_FORM)) {
        //body.innerHTML = res.htmlString;
        formCont.classList.remove('d-none');
        header.textContent = 'ACTIVATE HOT OFFERS';
        //ac.fn.ajaxifyPage();
        //window.mf.fn.initializeUpdatePostsStatusBtn();
    } else if (res.action === parseInt(TEST)){
        //body.innerHTML = res.htmlString;
        formCont.classList.remove('d-none');
        header.textContent = 'TEST';
    } else if (res.action === parseInt(GET_MEDIA_VIEWER)){
        formCont.classList.remove('d-none');
        header.textContent = 'MEDIA HANDLER';
        mh.fn.initMediaHandlerControls();
    }
    ac.fn.ajaxifyPage();
}
function handleLoadHotOffersSubmitClick(){
    console.log(arguments);
}

mf.fn.wireUpHotOfferPreview = function(){
    var title = document.getElementsByName('title')[0];
    var imgTxt = document.getElementsByName('alt')[0];
    var txt = document.getElementsByName('text')[0];
    //var imgSrc = document.getElementsByName(IMG_NAME_PREVIEW)[0];

    title.removeEventListener('input',mf.fn.hotOfferHandlers['title']);
    mf.fn.hotOfferHandlers['title'] = mf.fn.wireUpHotOfferTitlePreview.bind(null,title);
    title.addEventListener('input',mf.fn.hotOfferHandlers['title']);

    imgTxt.removeEventListener('input',mf.fn.hotOfferHandlers['alt']);
    mf.fn.hotOfferHandlers['alt'] = mf.fn.wireUpHotOfferImgTxtPreview.bind(null,imgTxt);
    imgTxt.addEventListener('input',mf.fn.hotOfferHandlers['alt']);

    txt.removeEventListener('input',mf.fn.hotOfferHandlers['text']);
    mf.fn.hotOfferHandlers['text'] = mf.fn.wireUpHotOfferTxtPreview.bind(null,txt);
    txt.addEventListener('input',mf.fn.hotOfferHandlers['text']);

    // imgSrc.removeEventListener('change',mf.fn.hotOfferHandlers['imgSrc']);
    // mf.fn.hotOfferHandlers['imgSrc'] = mf.fn.wireUpHotOfferImgSrcPreview.bind(null,imgSrc);
    // imgSrc.addEventListener('change',mf.fn.hotOfferHandlers['imgSrc']);

};

mf.fn.wireUpHotOfferTitlePreview = function(title) {
    var container = document.getElementsByClassName('hot_offer_carousel_item')[0];
    if(!container) return;
    var imgTitle = container.querySelector('.card-title');
    imgTitle.textContent = title.value;

};

mf.fn.wireUpHotOfferImgTxtPreview = function(imgTxt) {
    var container = document.getElementsByClassName('hot_offer_carousel_item')[0];
    if(!container) return;
    var img = container.querySelector('.'+PICKER_TARGET_IMG);
    img.setAttribute('alt',imgTxt.value);
};

mf.fn.wireUpHotOfferTxtPreview = function(txt) {
    var container = document.getElementsByClassName('hot_offer_carousel_item')[0];
    if(!container) return;
    var text = container.querySelector('.card-text');
    text.textContent = txt.value;
};

// mf.fn.wireUpHotOfferImgSrcPreview = function(imgSrc) {
//    var trueSrc = document.getElementsByName('src')[0];
//    trueSrc.value = imgSrc.value;
//    var parts = imgSrc.value.split('/');
//    imgSrc.value = parts[parts.length - 1];
// };




mh = {};
mh.el = {};
mh.fn = {};

mh.fn.initMediaHandlerControls = function(){
    mh.el.switchUploadWindowBtn = document.getElementsByName('switch_upload_window_btn')[0];
    mh.el.uploadContainer = document.getElementsByClassName('media_handler_upload_container')[0];
    mh.el.browserContainer = document.getElementsByClassName('media_handler_browser')[0];
    if(mh.el.switchUploadWindowBtn){
        mh.el.switchUploadWindowBtn.addEventListener('click', mh.fn.switchUploadWindow.bind(null,mh.el.switchUploadWindowBtn));
    }

}
mh.fn.switchUploadWindow = function(btn,e){
    e.preventDefault();
    if(!mh.el.uploadContainer){
        return;
    }
    mh.el.uploadContainer.classList.toggle('d-none');
    mh.el.browserContainer.classList.toggle('d-none');

};


mf.fn.findElems = function(){
    mf.el.selectForm = document.getElementsByClassName('display_form')[0];
    mf.el.uploadContainer = document.getElementsByClassName('media_handler_upload_container')[0];

};