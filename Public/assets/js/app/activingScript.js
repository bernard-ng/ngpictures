$(document).ready(function(){
	$('.button-collapse').sideNav();
	$('.collapsible').collapsible();
	$('.carousel .big').carousel({fullWidth: true});
    $('.carousel').carousel();
	$('.slider').slider();
    $('.dropdown-button').dropdown();
	$('.parallax').parallax();
	$('.modal').modal();
	
	
	//datepicker pour l'adm
    $('.datepicker').pickadate({
    	selectMonths: true,
    	selectYears: 5,
    	today: "Ajourd'hui",
    	clear: "Effacez",
    	close: 'ok',
    	closeOnSelect: false
	});


	if (tinymce !== undefined) {
		tinymce.init({
	        selector:"textarea#content",
	        theme: "modern",
	        skin: "lightgray",
	        width: "100%",
	        height: 400,
	        statusbar: true,
	        relative_urls: false,
	        menubar: false,
	        toolbar: "styleselect |  bold italic  alignleft aligncenter alignright alignjustify  bullist numlist | link | image | preview ",
	        plugins: [ "link image lists preview" ],
	        style_formats: [
	          {title : "Titre", items: [
	            {title : "Niveau 1", format: "h2"},
	            {title : "Niveau 2", format: "h3"},
	            {title : "Niveau 3", format: "h4"}
	          ]},
	          {title: "Inline", items: [
	            {title: "Gras", icon: "bold", format: "bold"},
	            {title: "Italique", icon: "italic", format: "italic"},
	            {title: "Code", icon: "code", format: "code"}
	          ]},
	          {title: "Blocks", items: [
	            {title: "Paragraphe", format: "p"},
	            {title: "Citation", format: "blockquote"},
	            {title: "Div", format: "div"}
	          ]}
	        ]
	    });

	    tinymce.init({
	        selector:"textarea#comment",
	        theme: "modern",
	        skin: "lightgray",
	        width: "100%",
	        height: 150,
	        relative_urls: false,
	        menubar: false,
	        toolbar: "styleselect |  bold italic | link image ",
	        plugins: [ "link image lists preview " ],
	        style_formats: [
	          {title: "Blocks", items: [
	            {title: "Paragraphe", format: "p"},
	            {title: "Citation", format: "blockquote"},
	            {title: "Div", format: "div"}
	          ]}
	        ]
	    });
	}
	
}) 