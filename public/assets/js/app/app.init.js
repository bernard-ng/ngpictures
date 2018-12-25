    /**
     * le message d'erreur ou de success.
     */
    msg = {
        success: "Action effectu�e",
        browserNotUpdate: "Erreur, veuillez mettre � jour votre navigateur",
        undefinedError: "Aucune Connexion Internet",
        deleteNotAllowed: "Vous n'avez pas le droit de suppression",
        editNotAllowed: "Vous n'avez pas le droit d'�dition",

        formAllRequired: "Tous les champs doivent �tre compl�ter",
        formMultiErrors: "Le formulaire a �t� mal rempli",
        formFieldRequired: "Le champ doit �tre compl�t�",
        formBadSlug: 'Le slug ne doit contenir que des chiffres, des lettres et des tir�s',
        formIdeaSubmitted: "Ola, nous avons bien re�u votre id�e",
        formCommentSubmitted: "Votre commentaire a bien �t� post�",
        formPostSubmitted: "Votre publication a bien �t� effectu�e",
        formBugSubmitted: "Nous avons bien re�u votre message et comptons r�gler le bug dans le plus bref d�lais",
        formResetSubmitted: "Les instructions de rappel de mot de passe vous ont �t� envoy�es par mail",
        formRegistrationSubmitted: "Un email de confirmation de compte vous a �t� envoy�, veuillez le confirmer pour continuer",
        formContactSubmitted: 'Nous avons bien re�u votre message et comptons vous r�pondre dans le plus bref d�lais',

        filesNotImage: "Le fichier � t�l�charger doit �tre une image (jpg, jpeg, png, gif)",
        filesNotUploaded: "Ooups, votre image n'a pas pu �tre t�l�charger",
        filesNotDirectory: "Impossibe d'ouvrir le dossier demand�, veuillez r�essayer",
        filesDownloadFailed: "Ooups, une Erreur s'est produite lors du t�l�chargement",
        filesNotFound: "La photo que vous d�sirer t�l�charger n'est plus disponible",
        filesGreaterThanLimit: "L'image est trop grande, 15Mo maximum",

        commentNotFound: "Ce commentaire n'�xiste pas ou plus",
        commentDeleteSuccess: "Votre commentaire a bien �t� supprim�",
        commentEditSuccess: "Votre commentaire a bien �t� �dit�",

        usersNotfound: "Cet utilisateur n'a pas �t� trouv�",
        usersLoginSuccess: "Vous �tes maintenant connect�",
        usersNotLogged: "Connectez-vous pour continuer",
        usersUnfollowingSuccess: "Vous ne suivez plus cet utilisateur",
        usersFollowingSuccess: "Vous suivez cet utilisateur",

        postSaved: "Publication ajout�e aux enregistrements",
        postRemoveSave: "Publication R�tir�e des enregistrerments"
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
        element.innerHTML = '';
        element.innerHTML = text;
    }


    //lancement des librarie extrene, jquery, materialize, etc...
    $(document).ready(function () {
        $('.button-collapse').sideNav({
            size: 250
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
        $('.carousel').carousel({
            dist: 0,
            indicators: true,
            noWrap: false
        });
        $('.slider').slider({
            interval: 5000
        });
        $('.slider.fullsize').slider({
            transition: 300,
            interval: 5000
        });

        $('.tool').tooltip({
            position: 'top',
            delay: 50,

        });
        $('.dropdown-button').dropdown({
            hover: false,
            gutter: 5,
            belowOrigin: false,
            alignment: 'right'
        });
        $('.parallax').parallax();
        $('.modal').modal({
            opacity: 0.5,
            dismissible: false,
            outDuration: 150,
            inDuration: 150,
            preventScrolling: false
        });
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
        /**
         * le message d'erreur ou de success.
         */
        msg = {
            success: "Action effectu�e",
            browserNotUpdate: "Erreur, veuillez mettre � jour votre navigateur",
            undefinedError: "Aucune Connexion Internet",
            deleteNotAllowed: "Vous n'avez pas le droit de suppression",
            editNotAllowed: "Vous n'avez pas le droit d'�dition",

            formAllRequired: "Tous les champs doivent �tre compl�ter",
            formMultiErrors: "Le formulaire a �t� mal rempli",
            formFieldRequired: "Le champ doit �tre compl�t�",
            formBadSlug: 'Le slug ne doit contenir que des chiffres, des lettres et des tir�s',
            formIdeaSubmitted: "Ola, nous avons bien re�u votre id�e",
            formCommentSubmitted: "Votre commentaire a bien �t� post�",
            formPostSubmitted: "Votre publication a bien �t� effectu�e",
            formBugSubmitted: "Nous avons bien re�u votre message et comptons r�gler le bug dans le plus bref d�lais",
            formResetSubmitted: "Les instructions de rappel de mot de passe vous ont �t� envoy�es par mail",
            formRegistrationSubmitted: "Un email de confirmation de compte vous a �t� envoy�, veuillez le confirmer pour continuer",
            formContactSubmitted: 'Nous avons bien re�u votre message et comptons vous r�pondre dans le plus bref d�lais',

            filesNotImage: "Le fichier � t�l�charger doit �tre une image (jpg, jpeg, png, gif)",
            filesNotUploaded: "Ooups, votre image n'a pas pu �tre t�l�charger",
            filesNotDirectory: "Impossibe d'ouvrir le dossier demand�, veuillez r�essayer",
            filesDownloadFailed: "Ooups, une Erreur s'est produite lors du t�l�chargement",
            filesNotFound: "La photo que vous d�sirer t�l�charger n'est plus disponible",
            filesGreaterThanLimit: "L'image est trop grande, 6Mo maximum",

            commentNotFound: "Ce commentaire n'�xiste pas ou plus",
            commentDeleteSuccess: "Votre commentaire a bien �t� supprim�",
            commentEditSuccess: "Votre commentaire a bien �t� �dit�",

            usersNotfound: "Cet utilisateur n'a pas �t� trouv�",
            usersLoginSuccess: "Vous �tes maintenant connect�",
            usersNotLogged: "Connectez-vous pour continuer",
            usersUnfollowingSuccess: "Vous ne suivez plus cet utilisateur",
            usersFollowingSuccess: "Vous suivez cet utilisateur",

            postSaved: "Publication ajout�e aux enregistrements",
            postRemoveSave: "Publication R�tir�e des enregistrerments"
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
            element.innerHTML = '';
            element.innerHTML = text;
        }


        //lancement des librarie extrene, jquery, materialize, etc...
        $(document).ready(function () {
            $('.button-collapse').sideNav({
                size: 250
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
            $('.carousel').carousel({
                dist: 0,
                indicators: true,
                noWrap: false
            });
            $('.slider').slider({
                interval: 5000
            });
            $('.slider.fullsize').slider({
                transition: 300,
                interval: 5000
            });

            $('.tool').tooltip({
                position: 'top',
                delay: 50,

            });
            $('.dropdown-button').dropdown({
                hover: false,
                gutter: 5,
                belowOrigin: false,
                alignment: 'right'
            });
            $('.parallax').parallax();
            $('.modal').modal({
                opacity: 0.5,
                dismissible: false,
                outDuration: 150,
                inDuration: 150,
                preventScrolling: false
            });
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

                function loadLazy() {
                    if (lazyLoader) {
                        lazyLoader.update();
                    }
                }
            } catch (e) {
                return false;
            }
        }
    }

    loadInit();
