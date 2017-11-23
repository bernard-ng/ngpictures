(function($){


var url = "../require-files/membres/tchatAjax.php";
var lastId = 0;
var timer = window.setInterval(getMessage,3000);

$(document).ready(slideDown());


function slideDown(){

	$('body').animate({scrollDown : 0}, 1500)
}

function hideChatloader(){
	$("center span.loader").remove();
}


$(function(){

	$('#tchatFrom form').submit(function(e)
	{

	 	window.clearInterval(timer)
	 	showLoader();
	 	var message = $('#tchatFrom form textarea[name=message]').val();
	 	

	 	$.post(url,{action:"addMessage",message:message},function(data){

	 		if(data.erreur == "ok"){

	
	 			getMessage();

	 			lastId = data.lastId;
	 			$('#tchatFrom form textarea[name=message]').val("");
	 			
	 		}else{

	 			window.alert(data.erreur);
	 		}
	 		timer = window.setInterval(getMessage,5000);
	 		hideLoader()



	 	},"json");

	 	return false;
	})



})


function getMessage(){

	$.post(

		url,

		{action:"getMessage",lastId:lastId},

		function(data){

		$('body').animate({scrollDown : 0 },2000)
 		if(data.erreur == "ok"){
 			
 			$('#tchat ol.chat').append(data.result);
 			lastId = data.lastId;

 		}else{
 			window.alert(data.erreur);
 		}


 	},"json");

 	return false;

}


function showLoader(){
	$('#tchatFrom form button').attr('disabled','disabled');
	$('#tchatFrom form button span').remove();
	$('#tchatFrom form button').append('<span class="section"><span class="loader loader-quart"></span></span>');
}

function hideLoader(){
	$('#tchatFrom form button').removeAttr('disabled');
	$('#tchatFrom form button span').remove();
	$('#tchatFrom form button').append('<span class="glyphicon glyphicon-send"></span>');
}




})(jQuery)