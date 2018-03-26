$(document).ready(function(){
	$('.button-collapse').sideNav();
	$('.collapsible').collapsible();
	$('.carousel .big').carousel({fullWidth: true});
    $('.carousel').carousel();
	$('.slider').slider();
    $('.dropdown-button').dropdown();
	$('.parallax').parallax();
	$('.modal').modal();
	$('.ul-tabs').tabs();
	$('select').material_select();


	//datepicker pour l'adm
    $('.datepicker').pickadate({
    	selectMonths: true,
    	selectYears: 5,
    	today: "Ajourd'hui",
    	clear: "Effacez",
    	close: 'ok',
    	closeOnSelect: false
	});

});