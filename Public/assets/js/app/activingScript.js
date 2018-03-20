$(document).ready(function(){
	$('.button-collapse').sideNav();
	$('.user-actions-sideNav').sideNav({
		edge: 'right',
		closeOnClick: true,
		draggable: false,
	})
	$('.collapsible').collapsible();
	$('.carousel .big').carousel({fullWidth: true});
    $('.carousel').carousel();
	$('.slider').slider();
    $('.dropdown-button').dropdown();
	$('.parallax').parallax();
	$('.modal').modal();
	$('.ul-tabs').tabs();
	$('select').material_select();

	//Message flash
	(function(){
        var $flash = $('#flash');
        if ($flash.length > 0) {
            Materialize.toast($flash.find('.flash-content-message'), 3000);
        }
    })();

});
