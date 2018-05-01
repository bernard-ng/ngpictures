// HELPERS
//------------------------------------------------------------------------------------

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
 * cree un toast de materializecss
 * @param message
 * @param type
 */
function setFlash(type, message) {
    Materialize.toast(message, 4000, type);
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
    let loader = document.createElement("span");
    loader.classList.add("loader");
    element.innerText = '';
    element.innerHtml = '';
    element.appendChild(loader);
}


/**
 * remove un loader dans un element et remplace par le text
 * @param element
 * @param text
 */
function removeLoader(element, text) {
    let loader = element.querySelector("span.loader");
    element.removeChild(loader);
    element.innerText = text;
}


/**
 * le message d'erreur ou de success.
 */
var msg = {
    usersNotLogged:         "Connectez-vous pour continuer",
    browserNotUpdate:       "Erreur, veuillez mettre à jour votre navigateur",
    undefinedError:         "Aucune Connexion Internet",
    formFieldRequired:      "Compléter le champ",
    formCommentSubmitted:   "Commentaire Ajouté",
};


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



// CALLS
//------------------------------------------------------------------------------------
comments('#dataContainer');
likes("#dataContainer");
window.setInterval(loadVerses("#verses"), 5000);
