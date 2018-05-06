/**
 * le message d'erreur ou de success.
 */
const msg = {
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
function setLoader(element){
    element.classList.add("disabled");
    element.innerText = '';
    element.innerHtml = '';
    element.innerText = "Chargement...";
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


// MAIN SCRIPTS
//------------------------------------------------------------------------------------

/**
 * envoyer un commentaire en ajax
 * @param element
 */
function comments(element) {
    let postContainer       =   document.querySelector(element);
    let activeUser          =   document.querySelector("meta[active-user]");
    if (postContainer) {
        let posts = postContainer.getElementsByTagName("article");
        for (let i = 0; i < posts.length; i++) {
            let submitBtn =  posts[i].querySelector("button[type='submit']");
            submitBtn.addEventListener('click', function(){
                setLoader(this);
            });

            posts[i].querySelector("form").addEventListener('submit', function(e){
                e.preventDefault();
                e.stopPropagation();

                let comment         =   this.querySelector('textarea').value;
                let closeBtn        =   this.querySelector("[type='reset']");
                let showComment     =   posts[i].querySelector("[data-action='showComment']");
                let icon            =   showComment.querySelector("i.icon");

                if (activeUser) {
                    if (comment.length > 0 && comment !== ' ') {
                        if (getXhr()) {
                            let xhr = getXhr();
                            xhr.open('POST', this.getAttribute('action'), true);
                            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                            xhr.send(new FormData(this));
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        let number = parseInt(xhr.responseText, 10);
                                        icon.classList.remove('icon-comment');
                                        icon.classList.remove('icon-comment-empty');

                                        if (number >= 1) {
                                            icon.classList.add('icon-comment');
                                            showComment.querySelector('span').innerText = number.toString();

                                            removeLoader(submitBtn, "Envoyer");
                                            setEventTrigger(closeBtn, 'click');
                                            setFlash('success', msg.formCommentSubmitted);
                                        } else {
                                            icon.classList.add('icon-comment-empty');
                                            showComment.querySelector('span').innerText = number.toString();

                                            removeLoader(submitBtn, "Envoyer");
                                            setEventTrigger(closeBtn, 'click');
                                            setFlash('success', msg.formCommentSubmitted);
                                        }
                                    } else {
                                        removeLoader(submitBtn,'Envoyer');
                                        setEventTrigger(closeBtn, 'click');
                                        setFlash(
                                            'danger',
                                            xhr.responseText ? xhr.responseText : msg.undefinedError
                                        );
                                    }
                                }
                            }
                        }
                    } else {
                        removeLoader(submitBtn,'Envoyer');
                        setEventTrigger(closeBtn, 'click');
                        setFlash('danger', msg.formFieldRequired);
                    }
                } else {
                    removeLoader(submitBtn,'Envoyer');
                    setEventTrigger(closeBtn, 'click');
                    setFlash('danger', msg.usersNotLogged);
                }
            });
        }
    }
}


/**
 * system de likes ajax
 * @param element
 */
function likes(element) {
    let postContainer   =   document.querySelector(element);
    let activeUser      =   document.querySelector("meta[active-user]");
    if (postContainer) {
        let posts = postContainer.getElementsByTagName("article");
        for (let i = 0; i < posts.length; i++) {
            let likeBtn = posts[i].querySelector("a[data-action='like']");
            likeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (activeUser) {
                    this.classList.toggle('active');
                    let icon        =   this.querySelector('i.icon');
                    let showLikes   =   this.parentElement.parentElement.querySelector("[data-action='showLikes']");

                    if (this.classList.contains('active')) {
                        icon.classList.remove('icon-heart-empty');
                        icon.classList.add('icon-heart', 'red-txt');
                    } else {
                        icon.classList.remove('icon-heart', 'red-txt');
                        icon.classList.add('icon-heart-empty');
                    }

                    if (getXhr()) {
                        let xhr = getXhr();
                        xhr.open('GET', this.getAttribute('href'), true);
                        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                        xhr.send();

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    showLikes.innerHTML = xhr.responseText;
                                } else {
                                    window.alert(xhr.responseText);
                                }
                            }
                        }
                    }
                } else {
                    setFlash('danger', msg.usersNotLogged);
                }
            });
        }
    } else {
        return false;
    }
}


/**
 * recuperer les donnees de godfirst
 * @param element
 */
function loadVerses(element) {
    let verseContainer = document.querySelector(element);
    if (verseContainer) {
        xhr = getXhr();
        if (xhr) {
            xhr.open('GET', '/ajax/verset', true);
            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
            xhr.send();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        verseContainer.innerHTML = '';
                        verseContainer.innerHTML = xhr.responseText;
                    } else {
                        setFlash(
                            xhr.responseText? xhr.responseText : msg.undefinedError,
                            5000,
                            'danger'
                        );
                    }
                }
            }
        }
    }
}


/**
 * inifinty scroll, ajour du contenu avec ajax
 */
function loadPosts(element) {
    let action          =   "inactive";
    let statusBar       =   document.querySelector('#statusBar');
    let postContainer   =   document.querySelector(element);

    function getData(lastId) {
        if (postContainer && statusBar) {
            let xhr = getXhr();
            if (xhr) {
                xhr.open('POST', "/ajax/" + statusBar.getAttribute('data-ajax'));
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.send((new FormData()).append("lastId", lastId));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            if (xhr.responseText = '') {
                                action                  =   "inactive";
                                statusBar.innerHTML     =   "Aucun contenu à charger";
                            } else {
                                action                  =   "active";
                                statusBar.innerHTML     =   "Chargement...";
                            }
                            postContainer.append(xhr.responseText);
                        } else {
                            statusBar.innerHTML         =   "Impossible de charger la suite";
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    window.addEventListener('scroll', function(){
        let windowHeight        =   window.getBoundingClientRect().height;
        let containerHeight     =   window.getBoundingClientRect().height;
        if (window.scrollTop() + windowHeight > containerHeight && action === "inactive") {
            action = "active";

            window.setTimeout(function(){
                getData(postContainer.lastElementChild.getAttribute("id"));
            }, 2000);
        }
    })
}


/**
 * charge les information d'une image  en ajax
 */
function loadPictureInfo() {
    let active = false;

    document.querySelector("#gallery .gallery-item").addEventListener('click', function(e){
       e.stopPropagation();

       let item = this;
       let details = item.nextElementSibling.querySelectorAll(".gallery-details:frist");

       if (item.classList.contains('active')) {
           return true;
       }

       let galleryItem = document.querySelectorAll('.gallery-item');
       let galleryDetails = document.querySelectorAll('.gallery-details');
       for(let i = 0; i < galleryItem.length; i++) {
           galleryItem[i].classList.remove('active');
       }

       for(let i = 0; i < galleryDetails.length; i++) {
           galleryDetails.classList.remove('jumbotron', 'jumbotron-img', 'dark');
       }

       item.classList.add('active');

       if (getXhr()) {
           let xhr = getXhr();
           xhr.open('GET', item.parentElement.getAttribute('data-show'), true);
           xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
           xhr.send();
           xhr.onreadystatechange = function () {
               if (xhr.readState() === 4) {
                   if  (xhr.status === 200) {
                       details.classList.add('jumbotron', 'jumbotron-img', 'dark');
                       details.appendChild(xhr.responseText);
                       let workDetails = details.querySelector('.gallery-container-details');

                       let toDelete = active;
                       if (active) {
                           document.removeChild(toDelete);
                       }

                       active = workDetails;
                       active.querySelector(".gallery-details-img").addEventListener("click", function(e) {
                           e.stopPropagation();
                           this.getElementsByTagName('img')[0].materialbox()
                       });
                       scrollTo(active);
                   } else {
                       setFlash('danger', xhr.responseText? xhr.responseText : msg.undefinedError);
                   }
               }
           }
       }

        window.location.hash = item.parentElement.getAttribute('id');
    });

    let scrollTo = function(cible) {
        window.setTimeout(function(){
            document.body.scrollTop = cible.getBoundingClientRect().top - 80;
            document.querySelector('html').scrollTop = cible.getBoundingClientRect.top - 80;
        }, 300)
    };

    if (window.location.hash) {
        let target = document.querySelector(window.location.hash + "img.gallery-item");
        if (target.length > 0) {
            setEventTrigger(target, 'click');
            scrollTo($target);
        }
    }
}



function login(element){
    let form = document.querySelector(element);
    if (form) {
        let submitBtn = form.querySelector("button[type='submit']")
        submitBtn.addEventListener('click', function(){
            setLoader(this);
        });
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let name = form.querySelector("input[name='name']");
            let password = form.querySelector("input[name='password']");
            name.nextElementSibling.innerText = "";
            password.nextElementSibling.innerText = "";

            if (getXhr()) {
                let xhr = getXhr();
                xhr.open('POST', this.getAttribute('action'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.send(new FormData(this));
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            removeLoader(submitBtn, 'Connexion');
                            Turbolinks.visit(window.location.origin + xhr.responseText);
                        } else if (xhr.status === 403) {
                            removeLoader(submitBtn, 'Connexion');
                            let errors = JSON.parse(xhr.responseText);
                            errors.name ? name.nextElementSibling.innerText = errors.name : null;
                            errors.password ? password.nextElementSibling.innerText = errors.password : null;
                        } else {
                            removeLoader(submitBtn, 'Connexion');
                            xhr.responseText ? setFlash('danger', xhr.responseText) : setFlash('danger', msg.undefinedError);
                        }
                    }
                }
            }
        });
    }
}
login("form[data-action='login']");

// CALLS
//------------------------------------------------------------------------------------
comments('#dataContainer');
likes("#dataContainer");
window.setInterval(loadVerses("#verses"), 5000);
