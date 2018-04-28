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
            }
        }
    }

    if (!xhr) {
        return false;
    }
    return xhr;
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
                    window.alert('not online');
                }
            });
        }
    } else {
        return false;
    }
}
likes("#dataContainer");

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
                        window.alert(xhr.responseText);
                    }
                }
            }
        }
    }
}

window.setInterval(loadVerses("#verses"), 10000);
