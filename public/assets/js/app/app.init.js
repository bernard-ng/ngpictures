/**
 * le message d'erreur ou de success.
 */
msg = {
    success : "Action effectuée",
    browserNotUpdate:       "Erreur, veuillez mettre à jour votre navigateur",
    undefinedError:         "Aucune Connexion Internet",
    deleteNotAllowed : "Vous n'avez pas le droit de suppression",
    editNotAllowed : "Vous n'avez pas le droit d'édition",

    formAllRequired : "Tous les champs doivent être compléter",
    formMultiErrors : "Le formulaire a été mal rempli",
    formFieldRequired : "Le champ doit être complété",
    formBadSlug : 'Le slug ne doit contenir que des chiffres, des lettres et des tirés',
    formIdeaSubmitted : "Ola, nous avons bien reçu votre idée",
    formCommentSubmitted : "Votre commentaire a bien été posté",
    formPostSubmitted : "Votre publication a bien été effectuée",
    formBugSubmitted : "Nous avons bien reçu votre message et comptons régler le bug dans le plus bref délais",
    formResetSubmitted : "Les instructions de rappel de mot de passe vous ont été envoyées par mail",
    formRegistrationSubmitted : "Un email de confirmation de compte vous a été envoyé, veuillez le confirmer pour continuer",
    formContactSubmitted : 'Nous avons bien reçu votre message et comptons vous répondre dans le plus bref délais',

    filesNotImage : "Le fichier à télécharger doit être une image (jpg, jpeg, png, gif)",
    filesNotUploaded : "Ooups, votre image n'a pas pu être télécharger",
    filesNotDirectory : "Impossibe d'ouvrir le dossier demandé, veuillez réessayer",
    filesDownloadFailed : "Ooups, une Erreur s'est produite lors du téléchargement",
    filesNotFound : "La photo que vous désirer télécharger n'est plus disponible",
    filesGreaterThanLimit: "L'image est trop grande, 6Mo maximum",

    commentNotFound : "Ce commentaire n'éxiste pas ou plus",
    commentDeleteSuccess : "Votre commentaire a bien été supprimé",
    commentEditSuccess : "Votre commentaire a bien été édité",

    usersNotfound : "Cet utilisateur n'a pas été trouvé",
    usersLoginSuccess: "Vous êtes maintenant connecté",
    usersNotLogged : "Connectez-vous pour continuer",
    usersUnfollowingSuccess : "Vous ne suivez plus cet utilisateur",
    usersFollowingSuccess : "Vous suivez cet utilisateur",
};

/**
 * cree un toast de materializecss
 * @param message
 * @param type
 */
function setFlash(type, message) {
    Materialize.toast(message, 4000, type);
}


/**
 * recupere une instance du xhr pour les req ajax.
 * @returns {*}
 */
function getXhr() {
    let xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
        if (xhr.overrideMimeType) {
            xhr.overrideMimeType('text/xml');
        }
    } else if (window.ActiveXObject) {
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                setFlash('danger', msg.browserNotUpdate);
            }
        }
    }

    if (!xhr) {
        return false;
    }
    return xhr;
}


/**
 * redirection en ajax
 * @param url
 */
function redirect(url) {
    Turbolinks.visit(window.location.origin + url);
}


/**
 * permet de simuler le declanchement d'un event.
 * @param element
 * @param eventName
 */
function setEventTrigger(element, eventName) {
    switch (eventName) {
        case 'click':
            element.click();
            break;
        case 'focus':
            element.focus();
            break;
        default:
            let event = document.createEvent('Event');
            event.initEvent(eventName, false, true);
            element.dispatchEvent(event);
            break;
    }
}


/**
 * cree un loader dans un element...
 */
function setLoader(element) {
    element.classList.add("disabled");
    element.innerText = '';
    element.innerHtml = '';
    element.innerText = 'Chargement...';
}

/**
 * si un champ a des erreurs
 * @param element
 * @param msg
 */
function formDataInvalid(element, msg) {
    element.classList.add('invalid');
    element.nextElementSibling.innerText = '';
    element.nextElementSibling.innerText = msg;
}


/**
 * restore la validation des champs
 * @param elements
 */
function resetValidation(elements) {
    for (let i = 0; i < elements.length; i++) {
        elements[i].classList.remove('invalid');
        elements[i].nextElementSibling.innerText = '';
    }
}


/**
 * remove un loader dans un element et remplace par le text
 * @param element
 * @param text
 */
function removeLoader(element, text) {
    element.classList.remove("disabled");
    element.innerText = '';
    element.innerHtml = '';
    element.innerText = text;
}


$(document).ready(function(){
    $('.button-collapse').sideNav({
        size: 250
    });
    $('.user-actions-sideNav').sideNav({
        edge: 'right',
        closeOnClick: true,
        draggable: false,
    });

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

    $('.tool').tooltip();
    $('.dropdown-button').dropdown();
    $('.parallax').parallax();
    $('.modal').modal({
        opacity: 0.5,
        dismissible: false,
        outDuration: 150,
        inDuration: 150,
        preventScrolling: false
    });
    $('.ul-tabs').tabs();
    $('select').material_select();

    if (typeof ParticlesJS !== "undefined") {
        particlesJS("particles-container",
            {
                "particles": {
                    "number": {
                        "value": 100,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "random"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        },
                        "image": {
                            "src": "img/github.svg",
                            "width": 100,
                            "height": 100
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 2,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 160.3412060865523,
                        "color": "#cccccc",
                        "opacity": 0.4890406785639845,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": false,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
    }

});
