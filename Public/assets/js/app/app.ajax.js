/**
 * envoyer un commentaire en ajax
 * @param element
 */
function formFeedComments(element) {
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
                            closeBtn.addEventListener('click', function(){
                                xhr.abort();
                            });
                            xhr.send(new FormData(this));
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
 * envyoer est afficher
 * @param element
 */
function formShowComments(element) {

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
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    showLikes.innerHTML = xhr.responseText;
                                } else {
                                    setFlash(
                                        'danger',
                                        xhr.responseText? xhr.responseText : msg.undefinedError
                                    );
                                }
                            }
                        };
                        xhr.send();
                        xhr.timeout = 10000;
                        xhr.addEventListener('abort', function(){
                            setFlash('warning', msg.undefinedError);
                        });
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
    window.setInterval(function(){
        let verseContainer = document.querySelector(element);
        if (verseContainer) {
            let indicator = verseContainer.querySelector('.indicator');

            if (getXhr()) {
                let xhr = getXhr();
                if (indicator.classList.contains('active')) {
                    indicator.classList.remove('active');
                }
                xhr.open('GET', verseContainer.getAttribute('data-ajax'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                window.setTimeout(function(){
                                    let verse = JSON.parse(xhr.responseText);
                                    verseContainer.querySelector("[data-content='txt']").innerHTML = verse.txt;
                                    verseContainer.querySelector("[data-content='ref']").innerHTML = verse.ref;
                                    indicator.classList.add('active');
                                },10000);
                            } catch (e) {
                                return false;
                            }
                        } else {
                            setFlash(
                                'danger',
                                xhr.responseText? xhr.responseText : msg.undefinedError,
                            );
                        }
                    }
                };
                xhr.timeout = 10000;
                xhr.send();
            }
        } else {
            return false;
        }
    },10000);
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


/**
 * login ajax
 * @param element
 */
function formLogin(element){
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
            resetValidation([name, password]);

            if (getXhr()) {
                let xhr = getXhr();
                xhr.open('POST', this.getAttribute('action'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.send(new FormData(this));
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            removeLoader(submitBtn, 'Connexion');
                            redirect(xhr.responseText);
                        } else if (xhr.status === 403) {
                            removeLoader(submitBtn, 'Connexion');
                            let errors = JSON.parse(xhr.responseText);

                            if (errors.name) {
                                formDataInvalid(name, errors.name);
                            } else if (errors.password) {
                                formDataInvalid(password, errors.password);
                            }
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


/**
 * sign up ajax
 * @param element
 */
function formSign(element){}


/**
 * ideas ajax et bug
 * @param element
 */
function formGenericSubmit(element) {
    let form = document.querySelector(element);
    if (form) {
        let submitBtn = form.querySelector("button[type='submit']")
        submitBtn.addEventListener('click', function(){
            setLoader(this);
        });
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let textarea = this.querySelector('textarea');
            resetValidation([textarea]);

            if (getXhr()) {
                let xhr = getXhr();
                xhr.open('POST', this.getAttribute('action'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.send(new FormData(this));
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            removeLoader(submitBtn, 'Envoyer');
                            Turbolinks.visit(window.location.origin + xhr.responseText);
                        } else if (xhr.status === 403) {
                            removeLoader(submitBtn, 'Envoyer');
                            let errors = JSON.parse(xhr.responseText);
                            if (errors.ideas) {
                                formDataInvalid(textarea, errors.ideas);
                            } else if (errors.bugs) {
                                formDataInvalid(textarea, errors.bugs);
                            }
                        } else {
                            removeLoader(submitBtn, 'Envoyer');
                            xhr.responseText ? setFlash('danger', xhr.responseText) : setFlash('danger', msg.undefinedError);
                        }
                    }
                }
            }
        });
    }
}

(function(){
    let $active = false;
    $("#gallery .gallery-item").on("click", function(){

        let $item = $(this);
        let $details = $item.parent().nextAll(".gallery-details:first")

        if ($item.hasClass("active")) {
            return true;
        }

        $(".gallery-item").removeClass("active");
        $(".gallery-details").removeClass('jumbotron jumbotron-img dark');
        $(".gallery-details").html("");
        $item.addClass("active");

        $details.addClass('jumbotron jumbotron-img dark');
        $details.html(
            '<div class="ng-progress-indeterminate">' +
                '<span></span>' +
                '<span></span>' +
                '<span></span>' +
                '<span></span>' +
                '<span></span>' +
            '</div>'
        );

        $.ajax(
            {url: $item.parent().attr('data-url')}
        ).then(
            function($detailsInfo) {
                $detailsInfo = $detailsInfo.substring($detailsInfo.indexOf('}') + 1, $detailsInfo.length + 1);
                $details.addClass('jumbotron jumbotron-img dark').html('');
                $details.append($detailsInfo).slideDown();
                $work_details =  $details.find('.gallery-container-details');

                let $del = $active;
                if ($active) {
                    $active.slideUp(300, function() {
                        $del.remove()
                    })
                }

                //animation
                for (let i = 1; i <= 3; i++)
                {
                    $(".stagger" + i, $work_details).css({
                        opacity:0, marginLeft:-30
                    }).delay(300 + 100 * i).animate({
                        opacity:1, marginLeft: 0
                    })
                }

                $active = $work_details;
                $active.find(".gallery-details-img").on("click", function() {
                    $(this).find('img').materialbox()
                });

                scrollTo($active);
            },
            function() {
                return Materialize.toast("Impossibe de charge l'Image", 5000, "danger")
            }
        );

        window.location.hash = $item.parent().attr('id')
    });

    let scrollTo = function(cible) {
        window.setTimeout(function(){
            $('html, boby').animate({scrollTop: $(cible).offset().top - 80 }, 750);
        }, 300)
    }

    if (window.location.hash) {
        let $target = $(window.location.hash + " img.gallery-item");
        if ($target.length > 0) {
            $target.trigger('click');
            scrollTo($target)
        }
    }
})();

//------------------------------------------------------------------------------------
//loadVerses("[data-action='verses']");
formLogin("form[data-action='login']");
formGenericSubmit("form[data-action='ideas']");
formGenericSubmit("form[data-action='bugs']");
formFeedComments('#dataContainer');
likes("#dataContainer");
