msg = {
    success: "Action effectuée",
    browserNotUpdate: "Erreur, veuillez mettre à jour votre navigateur",
    undefinedError: "Aucune Connexion Internet",
    deleteNotAllowed: "Vous n'avez pas le droit de suppression",
    editNotAllowed: "Vous n'avez pas le droit d'éition",

    formAllRequired: "Tous les champs doivent être compléter",
    formMultiErrors: "Le formulaire a été mal rempli",
    formFieldRequired: "Le champ doit être complété",
    formBadSlug: 'Le slug ne doit contenir que des chiffres, des lettres et des tirés',
    formIdeaSubmitted: "Ola, nous avons bien reçu votre idée",
    formCommentSubmitted: "Votre commentaire a bien été posté",
    formPostSubmitted: "Votre publication a bien été effectuée",
    formBugSubmitted: "Nous avons bien reçu votre message et comptons régler le bug dans le plus bref délais",
    formResetSubmitted: "Les instructions de rappel de mot de passe vous ont été envoyées par mail",
    formRegistrationSubmitted: "Un email de confirmation de compte vous a été envoyé, veuillez le confirmer pour continuer",
    formContactSubmitted: 'Nous avons bien reçu votre message et comptons vous répondre dans le plus bref délais',

    filesNotImage: "Le fichier à télécharger doit être une image (jpg, jpeg, png, gif)",
    filesNotUploaded: "Ooups, votre image n'a pas pu être télécharger",
    filesNotDirectory: "Impossibe d'ouvrir le dossier demandé, veuillez réessayer",
    filesDownloadFailed: "Ooups, une Erreur s'est produite lors du téléchargement",
    filesNotFound: "La photo que vous désirer télécharger n'est plus disponible",
    filesGreaterThanLimit: "L'image est trop grande, 15Mo maximum",

    commentNotFound: "Ce commentaire n'éxiste pas ou plus",
    commentDeleteSuccess: "Votre commentaire a bien été supprimé",
    commentEditSuccess: "Votre commentaire a bien été édité",

    usersNotfound: "Cet utilisateur n'a pas été trouvé",
    usersLoginSuccess: "Vous êtes maintenant connecté",
    usersNotLogged: "Connectez-vous pour continuer",
    usersUnfollowingSuccess: "Vous ne suivez plus cet utilisateur",
    usersFollowingSuccess: "Vous suivez cet utilisateur",

    postSaved: "Publication ajoutée aux enregistrements",
    postRemoveSave: "Publication Rétirée des enregistrerments"
};

function setFlash(type, message) {
    Materialize.toast(message, 4000, type);
}

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

function redirect(url) {
    Turbolinks.visit(window.location.origin + url);
}

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

function setLoader(element) {
    element.classList.add("disabled");
    element.innerText = '';
    element.innerHTML = '';
    element.innerHTML =
        '<div class="ng-progress-indeterminate">' +
        '<span></span>' +
        '<span></span>' +
        '<span></span>' +
        '<span></span>' +
        '<span></span>' +
        '</div>';
}

function formDataInvalid(element, msg) {
    element.classList.add('invalid');
    element.nextElementSibling.innerText = '';
    element.nextElementSibling.innerText = msg;
}

function resetValidation(elements) {
    for (let i = 0; i < elements.length; i++) {
        elements[i].classList.remove('invalid');
        elements[i].nextElementSibling.innerText = '';
    }
}

function removeLoader(element, text) {
    element.classList.remove("disabled");
    element.innerText = '';
    element.innerHTML = '';
    element.innerHTML = text;
}

$(document).ready(function () {
    $('.button-collapse').each(function (i, btn) {
        if (!btn.hasAttribute('data-ng-collapse-initialized', 'true')) {
            btn.setAttribute('data-ng-collapse-initialized', 'true');
            $(btn).sideNav({
                size: 250
            });
        }
    });
    $('.user-actions-sideNav').sideNav({
        edge: 'right',
        closeOnClick: true,
        draggable: false,
    });
    $('.services-slideNav').sideNav({
        edge: 'right',
        closeOnClick: true,
        draggable: false,
    });
    $("img.boxed").materialbox();
    $('.collapsible').collapsible();
    $('.carousel').each(function (i, c) {
        if (!c.hasAttribute('data-ng-carousel-initialized', 'true')) {
            c.setAttribute('data-ng-carousel-initialized', 'true');
            $(c).carousel({
                dist: 0,
                indicators: true,
                noWrap: false
            });
        }
    })
    $('.slider').each(function (i, s) {
        if (!s.hasAttribute('data-ng-slider-initialized', 'true')) {
            s.setAttribute('data-ng-slider-initialized', 'true');
            $(s).slider({
                interval: 5000
            });
        }
    });
    $('.tool').each(function (i, t) {
        if (!t.hasAttribute('data-ng-tool-initialized', 'true')) {
            t.setAttribute('data-ng-tool-initialized', 'true');
            $(t).tooltip({
                position: 'top',
                delay: 50,
            })
        }
    });
    $('.dropdown-button').each(function (i, d) {
        if (!d.hasAttribute('data-ng-dropdown-initialized', 'true')) {
            d.setAttribute('data-ng-dropdown-initialized', 'true');
            $(d).dropdown({
                hover: false,
                gutter: 5,
                belowOrigin: false,
                alignment: 'right'
            })
        }
    });
    $('.parallax').parallax();
    $('.modal').each(function (i, m) {
        if (!m.hasAttribute('data-ng-modal-initialized', 'true')) {
            m.setAttribute('data-ng-modal-initialized', 'true');
            $(m).modal({
                opacity: 0.5,
                dismissible: false,
                outDuration: 150,
                inDuration: 150,
                preventScrolling: false
            });
        }
    })
    $('.tabs').tabs();
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: false,
        selectYears: false,
        today: "Aujourd'hui",
        clear: "Effacer",
        close: "ok",
        container: 'body',
        closeOnSelect: false,
    });
    $('.timepicker').pickatime({
        default: 'now',
        fromnow: 0,
        twelvehour: true,
        donetext: 'Ok',
        cleartext: 'Effacer',
        canceltext: 'Annuler',
        container: 'body',
        autoclose: false,
        ampmclickable: true,
    });

    if (typeof particlesJS !== "undefined") {
        try {
            particlesJS("particles-container", {
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
                        "color": "#4c4c4c",
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
        } catch (e) {
            return false;
        }
    }
});

function loadInit() {
    msg = {
        success: "Action effectuée",
        browserNotUpdate: "Erreur, veuillez mettre à jour votre navigateur",
        undefinedError: "Aucune Connexion Internet",
        deleteNotAllowed: "Vous n'avez pas le droit de suppression",
        editNotAllowed: "Vous n'avez pas le droit d'éition",

        formAllRequired: "Tous les champs doivent être compléter",
        formMultiErrors: "Le formulaire a été mal rempli",
        formFieldRequired: "Le champ doit être complété",
        formBadSlug: 'Le slug ne doit contenir que des chiffres, des lettres et des tirés',
        formIdeaSubmitted: "Ola, nous avons bien reçu votre idée",
        formCommentSubmitted: "Votre commentaire a bien été posté",
        formPostSubmitted: "Votre publication a bien été effectuée",
        formBugSubmitted: "Nous avons bien reçu votre message et comptons régler le bug dans le plus bref délais",
        formResetSubmitted: "Les instructions de rappel de mot de passe vous ont été envoyées par mail",
        formRegistrationSubmitted: "Un email de confirmation de compte vous a été envoyé, veuillez le confirmer pour continuer",
        formContactSubmitted: 'Nous avons bien reçu votre message et comptons vous répondre dans le plus bref délais',

        filesNotImage: "Le fichier à télécharger doit être une image (jpg, jpeg, png, gif)",
        filesNotUploaded: "Ooups, votre image n'a pas pu être télécharger",
        filesNotDirectory: "Impossibe d'ouvrir le dossier demandé, veuillez réessayer",
        filesDownloadFailed: "Ooups, une Erreur s'est produite lors du téléchargement",
        filesNotFound: "La photo que vous désirer télécharger n'est plus disponible",
        filesGreaterThanLimit: "L'image est trop grande, 15Mo maximum",

        commentNotFound: "Ce commentaire n'éxiste pas ou plus",
        commentDeleteSuccess: "Votre commentaire a bien été supprimé",
        commentEditSuccess: "Votre commentaire a bien été édité",

        usersNotfound: "Cet utilisateur n'a pas été trouvé",
        usersLoginSuccess: "Vous êtes maintenant connecté",
        usersNotLogged: "Connectez-vous pour continuer",
        usersUnfollowingSuccess: "Vous ne suivez plus cet utilisateur",
        usersFollowingSuccess: "Vous suivez cet utilisateur",

        postSaved: "Publication ajoutée aux enregistrements",
        postRemoveSave: "Publication Rétirée des enregistrerments"
    };

    function setFlash(type, message) {
        Materialize.toast(message, 4000, type);
    }

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

    function redirect(url) {
        Turbolinks.visit(window.location.origin + url);
    }

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

    function setLoader(element) {
        element.classList.add("disabled");
        element.innerText = '';
        element.innerHTML = '';
        element.innerHTML =
            '<div class="ng-progress-indeterminate">' +
            '<span></span>' +
            '<span></span>' +
            '<span></span>' +
            '<span></span>' +
            '<span></span>' +
            '</div>';
    }

    function formDataInvalid(element, msg) {
        element.classList.add('invalid');
        element.nextElementSibling.innerText = '';
        element.nextElementSibling.innerText = msg;
    }

    function resetValidation(elements) {
        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.remove('invalid');
            elements[i].nextElementSibling.innerText = '';
        }
    }

    function removeLoader(element, text) {
        element.classList.remove("disabled");
        element.innerText = '';
        element.innerHTML = '';
        element.innerHTML = text;
    }

    $(document).ready(function () {
        $('.button-collapse').each(function (i, btn) {
            if (!btn.hasAttribute('data-ng-collapse-initialized', 'true')) {
                btn.setAttribute('data-ng-collapse-initialized', 'true');
                $(btn).sideNav({
                    size: 250
                });
            }
        });
        $('.user-actions-sideNav').sideNav({
            edge: 'right',
            closeOnClick: true,
            draggable: false,
        });
        $('.services-slideNav').sideNav({
            edge: 'right',
            closeOnClick: true,
            draggable: false,
        });
        $("img.boxed").materialbox();
        $('.collapsible').collapsible();
        $('.carousel').each(function (i, c) {
            if (!c.hasAttribute('data-ng-carousel-initialized', 'true')) {
                c.setAttribute('data-ng-carousel-initialized', 'true');
                $(c).carousel({
                    dist: 0,
                    indicators: true,
                    noWrap: false
                });
            }
        })
        $('.slider').each(function (i, s) {
            if (!s.hasAttribute('data-ng-slider-initialized', 'true')) {
                s.setAttribute('data-ng-slider-initialized', 'true');
                $(s).slider({
                    interval: 5000
                });
            }
        });
        $('.tool').each(function (i, t) {
            if (!t.hasAttribute('data-ng-tool-initialized', 'true')) {
                t.setAttribute('data-ng-tool-initialized', 'true');
                $(t).tooltip({
                    position: 'top',
                    delay: 50,
                })
            }
        });
        $('.dropdown-button').each(function (i, d) {
            if (!d.hasAttribute('data-ng-dropdown-initialized', 'true')) {
                d.setAttribute('data-ng-dropdown-initialized', 'true');
                $(d).dropdown({
                    hover: false,
                    gutter: 5,
                    belowOrigin: false,
                    alignment: 'right'
                })
            }
        });
        $('.parallax').parallax();
        $('.modal').each(function (i, m) {
            if (!m.hasAttribute('data-ng-modal-initialized', 'true')) {
                m.setAttribute('data-ng-modal-initialized', 'true');
                $(m).modal({
                    opacity: 0.5,
                    dismissible: false,
                    outDuration: 150,
                    inDuration: 150,
                    preventScrolling: false
                });
            }
        })
        $('.tabs').tabs();
        $('select').material_select();
        $('.datepicker').pickadate({
            selectMonths: false,
            selectYears: false,
            today: "Aujourd'hui",
            clear: "Effacer",
            close: "ok",
            container: 'body',
            closeOnSelect: false,
        });
        $('.timepicker').pickatime({
            default: 'now',
            fromnow: 0,
            twelvehour: true,
            donetext: 'Ok',
            cleartext: 'Effacer',
            canceltext: 'Annuler',
            container: 'body',
            autoclose: false,
            ampmclickable: true,
        });

        if (typeof particlesJS !== "undefined") {
            try {
                particlesJS("particles-container", {
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
                            "color": "#4c4c4c",
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
            } catch (e) {
                return false;
            }
        }
    });

    if (typeof LazyLoad !== 'undefined') {
        try {
            lazyLoader = new LazyLoad({
                elements_selector: "img[data-src]"
            });
        } catch (e) {
            return false;
        }
    }
}

loadInit();
