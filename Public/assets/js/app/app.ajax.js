 (function () {
    let links = document.querySelectorAll("[target='_self']");
    [].slice.call(links).forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            Turbolinks.visit(this.href);
            return true;
        })
    })
})()


/**
 * envoyer un commentaire en ajax
 * @param element
 */
function formFeedComments(element) {
    let postContainer = document.querySelector(element);
    let activeUser = document.querySelector("meta[active-user]");
    if (postContainer) {
        let posts = postContainer.getElementsByTagName("article");
        for (let i = 0; i < posts.length; i++) {
            let submitBtn = posts[i].querySelector("button[type='submit']");
            submitBtn.addEventListener('click', function () {
                setLoader(this);
            });

            posts[i].querySelector("form").addEventListener('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                let comment = this.querySelector('textarea').value;
                let closeBtn = this.querySelector("[type='reset']");
                let showComment = posts[i].querySelector("[data-action='showComment']");
                let icon = showComment.querySelector("i.icon");

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
                                        removeLoader(submitBtn, 'Envoyer');
                                        setEventTrigger(closeBtn, 'click');
                                        setFlash(
                                            'danger',
                                            xhr.responseText ? xhr.responseText : msg.undefinedError
                                        );
                                    }
                                }
                            }
                            closeBtn.addEventListener('click', function () {
                                xhr.abort();
                            });
                            xhr.send(new FormData(this));
                        }
                    } else {
                        removeLoader(submitBtn, 'Envoyer');
                        setEventTrigger(closeBtn, 'click');
                        setFlash('danger', msg.formFieldRequired);
                    }
                } else {
                    removeLoader(submitBtn, 'Envoyer');
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
    let postContainer = document.querySelector(element);
    let activeUser = document.querySelector("meta[active-user]");
    if (postContainer) {
        let posts = postContainer.getElementsByTagName("article");
        for (let i = 0; i < posts.length; i++) {
            let likeBtn = posts[i].querySelector("a[data-action='like']");
            likeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (activeUser) {
                    this.classList.toggle('active');
                    let icon = this.querySelector('i.icon');
                    let showLikes = this.parentElement.parentElement.querySelector("[data-action='showLikes']");

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
                                        xhr.responseText ? xhr.responseText : msg.undefinedError
                                    );
                                }
                            }
                        };
                        xhr.send();
                        xhr.timeout = 10000;
                        xhr.addEventListener('abort', function () {
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
    window.setInterval(function () {
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
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                window.setTimeout(function () {
                                    let verse = JSON.parse(xhr.responseText);
                                    verseContainer.querySelector("[data-content='txt']").innerHTML = verse.txt;
                                    verseContainer.querySelector("[data-content='ref']").innerHTML = verse.ref;
                                    indicator.classList.add('active');
                                }, 10000);
                            } catch (e) {
                                return false;
                            }
                        } else {
                            setFlash(
                                'danger',
                                xhr.responseText ? xhr.responseText : msg.undefinedError
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
    }, 10000);
}


/**
 * inifinty scroll, ajour du contenu avec ajax
 */
function loadPosts(element) {
    let action = "inactive";
    let statusBar = document.querySelector('#statusBar');
    let postContainer = document.querySelector(element);

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
                                action = "inactive";
                                statusBar.innerHTML = "Aucun contenu à charger";
                            } else {
                                action = "active";
                                statusBar.innerHTML = "Chargement...";
                            }
                            postContainer.append(xhr.responseText);
                        } else {
                            statusBar.innerHTML = "Impossible de charger la suite";
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    window.addEventListener('scroll', function () {
        let windowHeight = window.getBoundingClientRect().height;
        let containerHeight = window.getBoundingClientRect().height;
        if (window.scrollTop() + windowHeight > containerHeight && action === "inactive") {
            action = "active";

            window.setTimeout(function () {
                getData(postContainer.lastElementChild.getAttribute("id"));
            }, 2000);
        }
    })
}


/**
 * charge les information d'une image  en ajax
 */
function loadPictureInfo(element) {
    let gallery = document.querySelector(element);
    if (gallery) {
        let activeContent = null;
        let activeItem = null;

        let slideDown = function (element) {
            let height = element.offsetHeight;
            element.style.height = "0px";
            element.style.transitionDuration = '.5s';
            element.offsetHeight; // force du repaint
            element.style.height = height + "px";

            window.setTimeout(function () {
                element.style.height = null
            }, 500);
        };

        let slideUp = function (element) {
            let height = element.offsetHeight;
            element.style.height = height + "px";
            element.offsetHeight; // force du repaint
            element.style.height = "0px";

            window.setTimeout(function () {
                element.parentNode.removeChild(element);
            }, 500);
        };

        let scrollTo = function (target, offset = 0) {
            window.scrollTo({
                behavior: "smooth",
                left: 0,
                top: target.offsetTop - offset
            });
        };

        let show = function (item) {
            let offset = 0;
            if (activeContent !== null) {
                slideUp(activeContent);
                if (activeContent.offsetTop < item.offsetTop) {
                    offset = activeContent.offsetHeight;
                }
            }

            if (activeItem === item) {
                activeItem = null;
                activeContent = null;
            } else {
                let body = item.querySelector("[data-action='gallery-item-body']").cloneNode(true);
                body.classList.add('active');
                item.after(body);
                slideDown(body);
                scrollTo(item, offset);
                activeContent = body;
                activeItem = item;
            }
        };

        if (typeof gallery !== 'undefined') {
            let items = [].slice.call(gallery.querySelectorAll("[data-action='gallery-item']"));
            items.forEach((item) => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    show(item);
                })
            });
        } else {
            return false;
        }
    } else {
        return false;
    }
}


/**
 * login ajax
 * @param element
 */
function formLogin(element) {
    let form = document.querySelector(element);
    if (form) {
        let submitBtn = form.querySelector("button[type='submit']")
        submitBtn.addEventListener('click', function () {
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

                            errors.name ? formDataInvalid(name, errors.name) : '';
                            errors.password ? formDataInvalid(password, errors.password) : '';
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
function formSign(element) {
    let form = document.querySelector(element);
    if (form) {
        let submitBtn = form.querySelector("button[type='submit']")
        submitBtn.addEventListener('click', function () {
            setLoader(this);
        });
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let name = form.querySelector("input[name='name']");
            let email = form.querySelector("input[name='email']");
            let password = form.querySelector("input[name='password']");
            let password_confirm = form.querySelector("input[name='password_confirm']");
            resetValidation([name, email, password, password_confirm]);

            if (getXhr()) {
                let xhr = getXhr();
                xhr.open('POST', this.getAttribute('action'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                xhr.send(new FormData(this));
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            removeLoader(submitBtn, 'Inscription');
                            redirect(xhr.responseText);
                        } else if (xhr.status === 403) {
                            removeLoader(submitBtn, 'Inscription');
                            let errors = JSON.parse(xhr.responseText);

                            errors.name ? formDataInvalid(name, errors.name) : '';
                            errors.email ? formDataInvalid(email, errors.email) : '';
                            errors.password ? formDataInvalid(password, errors.password) : '';
                            errors.password_confirm ? formDataInvalid(password_confirm, errors.password_confirm) : '';
                        } else {
                            removeLoader(submitBtn, 'Inscription');
                            xhr.responseText ? setFlash('danger', xhr.responseText) : setFlash('danger', msg.undefinedError);
                        }
                    }
                }
            }
        });
    }
}


/**
 * ideas ajax et bug
 * @param element
 */
function formGenericSubmit(element) {
    let form = document.querySelector(element);
    if (form) {
        let submitBtn = form.querySelector("button[type='submit']")
        submitBtn.addEventListener('click', function () {
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


/**
 * save posts
 * @param element
 * @returns {boolean}
 */
function savePost(element) {
    let saveBtn = document.querySelectorAll(element);
    let activeUser = document.querySelector("meta[active-user]");
    if (typeof saveBtn !== 'undefined') {
        [].slice.call(saveBtn).forEach((saveBtn) => {
            saveBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                let that = this;
                let icon = that.firstElementChild;

                if (activeUser) {
                    if (icon.classList.contains('blue-txt')) {
                        icon.classList.remove('icon-bookmark', 'blue-txt');
                        icon.classList.add('icon-bookmark-empty');
                    } else {
                        icon.classList.remove('icon-bookmark-empty');
                        icon.classList.add('icon-bookmark', 'blue-txt');
                    }

                    if (getXhr()) {
                        let xhr = getXhr();
                        xhr.open('GET', this.getAttribute('href'));
                        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    if (xhr.responseText === 'true') {
                                        that.innerHTML = "<i class='icon icon-bookmark blue-txt'></i>"
                                        setFlash('success', msg.postSaved);
                                        return true;
                                    } else {
                                        that.innerHTML = "<i class='icon icon-bookmark-empty'></i>"
                                        setFlash('success', msg.postRemoveSave);
                                        return true;
                                    }
                                } else {
                                    setFlash('danger', xhr.responseText ? xhr.responseText : msg.undefinedError);
                                    return false;
                                }
                            }
                        };
                        xhr.send();
                    } else {
                        return false;
                    }
                } else {
                    setFlash('danger', msg.usersNotLogged);
                    return false;
                }
            });
        })
    } else {
        return false;
    }
}


function follow(element) {
    let followBtns = document.querySelectorAll(element);
    let activeUser = document.querySelector("meta[active-user]");
    if (typeof followBtns !== 'undefined') {
        [].slice.call(followBtns).forEach(function (followBtn) {
            followBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                let that = this;
                let nativeText = that.innerText;
                setLoader(that);

                if (activeUser) {
                    let followLink = this.getAttribute('href');
                    if (getXhr()) {
                        let xhr = getXhr();
                        xhr.open('GET', followLink);
                        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    removeLoader(that, xhr.responseText);
                                    return true;
                                } else {
                                    removeLoader(that, nativeText);
                                    setFlash('danger', xhr.responseText ? xhr.responseText : msg.undefinedError);
                                    return false;
                                }
                            }
                        }
                        xhr.send();
                    }
                } else {
                    setFlash('danger', msg.usersNotLogged);
                    return false;
                }
            })
        })
    } else {
        return false;
    }
}


/**
 * telechargement et incrementation
 * @param element
 * @returns {boolean}
 */
function downloadFile(element) {
    let downloadBtn = document.querySelectorAll(element);
    if (typeof downloadBtn !== 'undefined') {
        for (let i = 0; i < downloadBtn.length; i++) {
            downloadBtn[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                let downloadLink = this.getAttribute('href');
                let that = this;

                if (getXhr()) {
                    let xhr = getXhr();
                    xhr.open('GET', downloadLink);
                    xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                that.innerHTML = "<span>" + xhr.responseText + "&nbsp;<i class='icon icon-download'></i>";
                                window.location = downloadLink + "?option=once";
                                return true;
                            } else {
                                setFlash('danger', xhr.responseText ? xhr.responseText : msg.undefinedError);
                                return false;
                            }
                        }
                    };
                    xhr.send();
                }
            })
        }
    } else {
        return false;
    }
}

//------------------------------------------------------------------------------------
loadVerses("[data-action='verses']");
follow("[data-action='following']");
savePost("[data-action='save']");
downloadFile("[data-action='download']");
formLogin("form[data-action='login']");
formSign("form[data-action='sign']");
formGenericSubmit("form[data-action='ideas']");
formGenericSubmit("form[data-action='bugs']");
formFeedComments('#dataContainer');
likes("#dataContainer");
