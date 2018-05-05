import * as M from "../materialize";

document.addEventListener('DOMContentLoaded', function(){

    M.AutoInit();

    let buttonsCollapse = document.querySelectorAll('.button-collapse');
    M.Sidenav.init(buttonsCollapse, {
        size: 250
    });

    let collapsible = document.querySelectorAll('.collapsible');
    M.Collapsible(collapsible);

    let userActionSidenav = document.querySelectorAll('.user-actions-sideNav');
    M.Sidenav.init(userActionSidenav, {
        edge: 'right',
        closeOnClick: true,
        draggable: false
    });

	let imageBoxed = document.querySelectorAll('img.boxed');
	M.Materialbox.init(imageBoxed);

	let carouselBig = document.querySelectorAll('.carousel .big');
	M.Carousel.init(carouselBig, {
	    fullWidth: true
    });

	let carousel = document.querySelectorAll('.carousel');
	M.Carousel.init(carousel);

	let slider = document.querySelectorAll('.slider');
	M.Slider.init(slider, {
	    interval: 5000
    });

    let sliderFullsize = document.querySelectorAll('.slider');
    M.slider.init(sliderFullsize, {
        transition: 300,
        interval: 5000
    });

    let parallax = document.querySelectorAll('.parallax');
    M.Parallax.init(parallax);


	$('.modal').modal({
        opacity: 0.5,
        dismissible: false,
        outDuration: 150,
        inDuration: 150,
        preventScrolling: false
    });
	$('.ul-tabs').tabs();
	$('select').material_select();

    // if (ParticlesJS !== undefined) {
    //     particlesJS("particles-container",
    //         {
    //             "particles": {
    //                 "number": {
    //                     "value": 100,
    //                     "density": {
    //                         "enable": true,
    //                         "value_area": 800
    //                     }
    //                 },
    //                 "color": {
    //                     "value": "random"
    //                 },
    //                 "shape": {
    //                     "type": "circle",
    //                     "stroke": {
    //                         "width": 0,
    //                         "color": "#000000"
    //                     },
    //                     "polygon": {
    //                         "nb_sides": 5
    //                     },
    //                     "image": {
    //                         "src": "img/github.svg",
    //                         "width": 100,
    //                         "height": 100
    //                     }
    //                 },
    //                 "opacity": {
    //                     "value": 0.5,
    //                     "random": true,
    //                     "anim": {
    //                         "enable": false,
    //                         "speed": 2,
    //                         "opacity_min": 0.1,
    //                         "sync": false
    //                     }
    //                 },
    //                 "size": {
    //                     "value": 3,
    //                     "random": true,
    //                     "anim": {
    //                         "enable": false,
    //                         "speed": 40,
    //                         "size_min": 0.1,
    //                         "sync": false
    //                     }
    //                 },
    //                 "line_linked": {
    //                     "enable": true,
    //                     "distance": 160.3412060865523,
    //                     "color": "#cccccc",
    //                     "opacity": 0.4890406785639845,
    //                     "width": 1
    //                 },
    //                 "move": {
    //                     "enable": true,
    //                     "speed": 6,
    //                     "direction": "none",
    //                     "random": false,
    //                     "straight": false,
    //                     "out_mode": "out",
    //                     "bounce": false,
    //                     "attract": {
    //                         "enable": false,
    //                         "rotateX": 600,
    //                         "rotateY": 1200
    //                     }
    //                 }
    //             },
    //             "interactivity": {
    //                 "detect_on": "canvas",
    //                 "events": {
    //                     "onhover": {
    //                         "enable": false,
    //                         "mode": "grab"
    //                     },
    //                     "onclick": {
    //                         "enable": false,
    //                         "mode": "push"
    //                     },
    //                     "resize": true
    //                 },
    //                 "modes": {
    //                     "grab": {
    //                         "distance": 400,
    //                         "line_linked": {
    //                             "opacity": 1
    //                         }
    //                     },
    //                     "bubble": {
    //                         "distance": 400,
    //                         "size": 40,
    //                         "duration": 2,
    //                         "opacity": 8,
    //                         "speed": 3
    //                     },
    //                     "repulse": {
    //                         "distance": 200,
    //                         "duration": 0.4
    //                     },
    //                     "push": {
    //                         "particles_nb": 4
    //                     },
    //                     "remove": {
    //                         "particles_nb": 2
    //                     }
    //                 }
    //             },
    //             "retina_detect": true
    //         });
    // }

});
