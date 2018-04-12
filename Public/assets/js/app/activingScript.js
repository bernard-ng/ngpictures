$(document).ready(function(){
	$('.button-collapse').sideNav({
		size: 250
	});
	$('.user-actions-sideNav').sideNav({
		edge: 'right',
		closeOnClick: true,
		draggable: false,
	})
	$("img.boxed").materialbox();
	$('.collapsible').collapsible();
	$('.carousel .big').carousel({fullWidth: true});
    $('.carousel').carousel();
	$('.slider').slider({
		interval: 5000
	});
	$('.slider.fullsize').slider({
		transition: 300,
		interval: 5000
	});
    $('.dropdown-button').dropdown();
	$('.parallax').parallax();
	$('.modal').modal();
	$('.ul-tabs').tabs();
	$('select').material_select();
});
