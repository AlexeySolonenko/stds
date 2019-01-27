jQuery(document).ready(function($){
    console.log(ajax_object);
    console.log('news posts');
    //$.ajax({});
    /*
    var data = {"action":"my_action"};
    jQuery.post(ajax_object.ajax_url, data, function(response) {
		alert('Got this from the server: ' + response);
		console.log('Got this from the server: ' + response);
	});*/
	

	
	
		var update = document.getElementsByClassName('update_post')[0];
	update.addEventListener('click',function(e){
	    e.preventDefault;
	   var data = {"action":"ajax_router", 'directive':'update_post','content':document.getElementsByName('content')[0].value, 'content_class':document.getElementsByName('content_class')[0].value};
        jQuery.ajax({
            url:ajax_object.ajax_url, data:data, type:"POST",dataType:"json",complete:function(data, status) {
                console.log(data.responseJSON);
                document.getElementsByClassName('msg_cntr')[0].innerHTML = data.responseJSON.msg;
		         
	    	    
	        }
	    }); 
	});
	
	
	var loadPost = document.getElementsByClassName('load_post')[0];
	loadPost.addEventListener('click',function(e){
	    e.preventDefault;
	   var data = {"action":"ajax_router", 'directive':'load_post'};
        jQuery.ajax({
            url:ajax_object.ajax_url, data:data, type:"POST",dataType:"json",complete:function(data, status) {
                console.log(data);
                document.getElementsByClassName('cntnr')[0].innerHTML = data.responseJSON.html;
		         
	    	    
	        }
	    }); 
	});
	
});