//Main Scripts
//---------------------------------------------------------------------

/**
 * premet de rendre un itme du menu active
 * @returns {boolean}
 */
function toggleMenuItem() {
    let active = document.querySelector("#menu-item-active");
    if (active) {
        try {
            let link = document.querySelector("ul.links").querySelector("li#"+ active.getAttribute('data-active'));
            if (link) {
                link.classList.add('active');
            }
        } catch (e) {
            return false;
        }
    } else {
        return false;
    }
}


function transparizeMenu()
{
    let menu = document.querySelector("[data-action='menu']");
    let slider = document.querySelector("[data-action-requires='menu-transparent']")

    if (slider === null) {
        menu.classList.remove('transparent');
    } else if (window.scrollY > 10 && menu.classList.contains('transparent'))  {
        menu.classList.remove('transparent');
    }

    if (slider !== null) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                if (menu.classList.contains('transparent')) {
                    menu.classList.remove('transparent');
                }
            } else {
                if (!menu.classList.contains('transparent')) {
                    menu.classList.add('transparent');
                }
            }
        });
    }
}


/**
 * premet de rendre un item du menu mobile active
 * @returns {boolean}
 */
function toggleMobileMenuItem() {
    let active = document.querySelector("#menu-mobile-item-active");
    if (active) {
        try {
            let link = document
                    .querySelector("ul.mobile-links")
                    .querySelector("li#"+ active.getAttribute('data-active'));
            if (link) {
                link.classList.add('active');
            }
        } catch (e) {
            return false;

        }
    } else {
        return false;
    }
}


/**
 * cree un timer relatif pour les dates
 */
function relativeTimer(element){
    if (document.querySelectorAll(element) ) {
        if (NodeList.prototype.forEach === undefined) {
            NodeList.prototype.forEach = function (callback) {
                [].forEach.call(this, callback);
            }
        }

        let terms = [
            {time: 10, divide: 1, text: "%d secondes"},
            {time: 45, divide: 1, text: "moins d'une minute"},
            {time: 90, divide: 60, text: "environ une minute"},
            {time: 45 * 60, divide: 60, text: "%d minutes"},
            {time: 90 * 60, divide: 60 * 60 , text: "environ une heure"},
            {time: 24 * 60 * 60 , divide: 60 * 60 , text: "%d heures"},
            {time: 42 * 60 * 60 , divide: 24 * 60 * 60 , text: "environ un jour"},
            {time: 30 * 24 * 60 * 60, divide: 24 * 60 * 60 , text: "%d jours"},
            {time: 42 * 24 * 60 * 60 , divide: 24 * 60 * 60 * 30, text: "environ un mois"},
            {time: 365 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "%d mois"},
            {time: 365 * 1.5 * 24 * 60 * 60 , divide: 24 * 60 * 60 * 365, text: "environ un an"},
            {time: Infinity, divide: 24 * 60 * 60 * 365 , text: "%d ans"}
        ];

        document.querySelectorAll('time[data-time]').forEach(function(node) {
            function setText(){
                let seconds = Math.floor((new Date()).getTime()/1000 - parseInt(node.getAttribute('data-time'), 10));
                let prefix = seconds > 0 ? 'Il y a ' : 'Dans ' ;
                let term;
                seconds = Math.abs(seconds);

                for (term of terms) {
                    if (seconds < term.time) {
                        break;
                    }
                }

                node.innerHTML = prefix + term.text.replace('%d', Math.round(seconds/term.divide));

                let nextTick = seconds % term.divide;
                if (nextTick === 0) {
                    nextTick = term.divide;
                }

                window.setTimeout(function(){
                    if (node.parentNode){
                        window.requestAnimationFrame ? window.requestAnimationFrame(setText) : setText();
                    }
                },  nextTick);
            }
            setText();
        });
    } else {
        return false;
    }
}

/**
 * rend un element sticky
 * @param selector
 */
function makeSticky(selector) {
    /**
     * return le nombre de scroll en Y
     * @returns {number}
     */
    let scrollY = function () {
        let supportPageOffset   = window.pageXOffset !== undefined;
        let isCSS1Compat        = ((document.compatMode || "") === "CSS1Compat");
        return supportPageOffset ? window.pageYOffset :
            isCSS1Compat? document.documentElement.scrollTop : document.body.scrollTop;
    };

    let elements = document.querySelectorAll(selector);
    for (let i = 0; i < elements.length; i++) {
        (function(element){
            let boundingRect = element.getBoundingClientRect();
            let top          = boundingRect.top + scrollY();
            let offset       = parseInt(element.getAttribute('data-sticky-offset') || 0, 10);
            let constraint      = element.getAttribute('data-sticky-constraint')?
                document.querySelector(element.getAttribute('data-sticky-constraint')) : document.body;
            let constraintRect = constraint.getBoundingClientRect();
            let constraintBottom = constraintRect.top + scrollY() + constraintRect.height - offset - boundingRect.height;

            let fakeElement             =   document.createElement('div');
            fakeElement.style.width     =   boundingRect.width + "px";
            fakeElement.style.height    =   boundingRect.height + "px";

            let onScrollSticky = function () {
                if (scrollY() > constraintBottom && element.style.position !== 'absolute') {
                    element.style.position  = 'absolute';
                    element.style.bottom    = '0';
                    element.style.top       = 'auto';
                } else if (scrollY() > top - offset && scrollY() < constraintBottom && element.style.position !== 'fixed') {
                    element.style.position = 'fixed';
                    element.style.top   = offset + "px";
                    element.style.bottom       = 'auto';
                    element.style.width = boundingRect.width + "px";
                    element.parentNode.insertBefore(fakeElement, element);
                } else if (scrollY() < top - offset && element.style.position !== 'static') {
                    element.style.position = "static";
                    if(element.parentNode.contains(fakeElement))  {
                        element.parentNode.removeChild(fakeElement);
                    }
                }
            };

            let onResizeSticky = function () {
                element.style.width = "auto";
                element.style.position = "static";
                fakeElement.style.display = 'none';
                boundingRect = element.getBoundingClientRect();
                top          = boundingRect.top + scrollY();

                constraintRect = constraint.getBoundingClientRect();
                constraintBottom = constraintRect.top + scrollY() + constraintRect.height - offset - boundingRect.height;

                fakeElement.style.width     =   boundingRect.width + "px";
                fakeElement.style.height    =   boundingRect.height + "px";
                fakeElement.style.display   =   "block";
                onScrollSticky();
            };

            window.addEventListener('scroll', onScrollSticky);
            window.addEventListener('resize', onResizeSticky);
        })(elements[i]);
    }
}


/**
 * les bouttons de partages sur les social network
 */
function share() {
    let sharePopup = function (url, title) {
        let windowTop = window.screenTop || window.screenY;
        let windowLeft = window.screenLeft || window.screenX;
        let windowWidth = window.innerWidth || document.documentElement.clientWidth;
        let windowHeight = window.innerHeight || document.documentElement.clientHeight;
        let popupWidth = 640;
        let popupHeight = 320;
        let popupLeft = (windowLeft + windowWidth / 2) - popupWidth / 2;
        let popupTop = (windowTop + windowHeight / 2) - popupHeight / 2;

        window.open(
            url,
            title,
            "scrollbars=yes, " +
            "width="+popupWidth+",height="+popupHeight+",top="+popupTop+",left="+popupLeft
        ).focus();
        return true;
    };

    let twitter = document.querySelector("[data-action='share-twitter']");
    if (twitter) {
        twitter.addEventListener('click', function (e){
            e.preventDefault();
            e.stopPropagation();
            let url = encodeURIComponent(this.getAttribute('data-url'));
            let text = "Du nouveau sur Ngpictures !!!";
            let share =
                "https://twitter.com/intent/tweet?text=" + text +
                "&via=Ngpictures"
                + "&url=" + url;

            sharePopup(share, "Partager Sur Twitter");
        });
    }

    let facebook = document.querySelector("[data-action='share-facebook']");
    if (facebook) {
        facebook.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = encodeURIComponent(this.getAttribute('data-url'));
            let share = "https://www.facebook.com/sharer.php?u="+url;
            sharePopup(share, "Partager Sur Facebook");
        });
    }

    let googlePlus = document.querySelector("[data-action='share-google-plus']");
    if (googlePlus) {
        googlePlus.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = encodeURIComponent(this.getAttribute('data-url'));
            let share = "https://plus.google.com/share?url="+url;
            sharePopup(share, "Partager Sur Google+");
        });
    }
}


/**
 * affiche l'image a uploader avant l'upload
 */
function showImageBeforeUpload(element) {
    let form = document.querySelector(element);
    if (form) {
        let input = form.querySelector("input[type='file']");
        let showContainer = document.querySelector("[data-action='show-uploaded-file']");
        let admitExt = ['jpg', 'jpeg', 'png', 'gif'];
        let adminTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

        let getFile = function(files) {
            let reader = new FileReader();
            reader.readAsDataURL(files);
            reader.addEventListener('load', function() {
                let tag = document.createElement('img');
                tag.classList.add('responsive-img');
                tag.src = this.result;
                showContainer.innerHTML = "";
                showContainer.appendChild(tag);
            });
        };

        input.addEventListener('change', function() {
            let file = this.files[0];
            let ext = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
            let type = file.type;

            if (admitExt.includes(ext, 0) && adminTypes.includes(type, 0)) {
                if (file.size <= 6291456) {
                    getFile(file);
                } else {
                    setFlash('danger',msg.filesGreaterThanLimit)
                }
            } else {
                setFlash("danger", msg.filesNotImage);
            }
        });
    }
}

//CALL
//----------------------------------------------------------------------
transparizeMenu();
toggleMenuItem();
toggleMobileMenuItem();
relativeTimer('time[data-time]');
makeSticky('[data-sticky]');
share();
showImageBeforeUpload("[data-action='upload']");
