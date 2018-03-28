$(document).ready(function(){
	$('.button-collapse').sideNav({
		size: 250
	});
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
});
