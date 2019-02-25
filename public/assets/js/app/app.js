function toggleMenuItem() {
    let active = document.querySelector("#menu-item-active");
    if (active) {
        try {
            let link = document.querySelector("ul.links").querySelector("li#" + active.getAttribute('data-active'));
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

function transparizeMenu() {
    let menu = document.querySelector("[data-action='menu']");
    let slider = document.querySelector("[data-action-requires='menu-transparent']")

    if (menu !== null) {
        if (slider === null) {
            menu.classList.remove('transparent');
        } else if (window.scrollY > 10 && menu.classList.contains('transparent')) {
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
}

function toggleMobileMenuItem() {
    let active = document.querySelector("#menu-mobile-item-active");
    if (active) {
        try {
            let link = document
                .querySelector("ul.mobile-links")
                .querySelector("li#" + active.getAttribute('data-active'));
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

function relativeTimer(element) {
    if (document.querySelectorAll(element)) {
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
            {time: 90 * 60, divide: 60 * 60, text: "environ une heure"},
            {time: 24 * 60 * 60, divide: 60 * 60, text: "%d heures"},
            {time: 42 * 60 * 60, divide: 24 * 60 * 60, text: "environ un jour"},
            {time: 30 * 24 * 60 * 60, divide: 24 * 60 * 60, text: "%d jours"},
            {time: 42 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "environ un mois"},
            {time: 365 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "%d mois"},
            {time: 365 * 1.5 * 24 * 60 * 60, divide: 24 * 60 * 60 * 365, text: "environ un an"},
            {time: Infinity, divide: 24 * 60 * 60 * 365, text: "%d ans"}
        ];

        function setText(node) {
            try {
                let seconds = Math.floor((new Date()).getTime() / 1000 - parseInt(node.getAttribute('data-time'), 10));
                let prefix = seconds > 0 ? 'Il y a ' : 'Dans ';
                let term;
                seconds = Math.abs(seconds);

                for (term of terms) {
                    if (seconds < term.time) {
                        break;
                    }
                }

                node.innerHTML = prefix + term.text.replace('%d', Math.round(seconds / term.divide));

                let nextTick = seconds % term.divide;
                if (nextTick === 0) {
                    nextTick = term.divide;
                }

                window.setTimeout(function () {
                    if (node.parentNode) {
                        window.requestAnimationFrame ? window.requestAnimationFrame(setText) : setText();
                    }
                }, nextTick);
            } catch(e) {
                return false;
            }
        }

        document.querySelectorAll('time[data-time]').forEach(function (node) {
            if (!node.hasAttribute('data-time-initialized', 'true')) {
                node.setAttribute('data-time-initialized', 'true');
                setText(node);
            }
        });
    } else {
        return false;
    }
}

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
            "width=" + popupWidth + ",height=" + popupHeight + ",top=" + popupTop + ",left=" + popupLeft
        ).focus();
        return true;
    };

    let twitter = document.querySelectorAll("[data-action='share-twitter']");
    if (twitter) {
        for (let i = 0; i < twitter.length; i++) {
            twitter[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let url = encodeURIComponent("https://larytech.com" + this.getAttribute('data-url'));
                let text = "Du nouveau sur Ngpictures !!!";
                let share =
                    "https://twitter.com/intent/tweet?text=" + text +
                    "&via=Ngpictures"
                    + "&url=" + url;

                sharePopup(share, "Partager Sur Twitter");
            });
        }
    }

    let facebook = document.querySelectorAll("[data-action='share-facebook']");
    if (facebook) {
        for (let i = 0; i < facebook.length; i++) {
            facebook[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let url = encodeURIComponent("https://larytech.com" + this.getAttribute('data-url'));
                let share = "https://www.facebook.com/sharer.php?u=" + url;
                sharePopup(share, "Partager Sur Facebook");
            });
        }
    }

    let googlePlus = document.querySelectorAll("[data-action='share-google-plus']");
    if (googlePlus) {
        for (let i = 0; i < googlePlus.length; i++) {
            googlePlus[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let url = encodeURIComponent("https://larytech.com" + this.getAttribute('data-url'));
                let share = "https://plus.google.com/share?url=" + url;
                sharePopup(share, "Partager Sur Google+");
            });
        }
    }

    let whatsapp = document.querySelector("[data-action='share-whatsapp']");
    if (whatsapp) {
        for (let i = 0; i < whatsapp.length; i++) {
            whatsapp[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let url = encodeURIComponent("https://larytech.com" + this.getAttribute('data-url'));
                window.location = "https://wa.me/?text=" + url;
            });
        }
    }
}

function showImageBeforeUpload(element) {
    let form = document.querySelector(element);
    if (form) {
        let input = form.querySelector("input[type='file']");
        let showContainer = document.querySelector("[data-action='show-uploaded-file']");
        let admitExt = ['jpg', 'jpeg', 'png', 'gif'];
        let adminTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

        let getFile = function (files) {
            let reader = new FileReader();
            reader.readAsDataURL(files);
            reader.addEventListener('load', function () {
                let tag = document.createElement('img');
                tag.classList.add('responsive-img');
                tag.src = this.result;
                showContainer.innerHTML = "";
                showContainer.appendChild(tag);
            });
        };

        input.addEventListener('change', function () {
            let file = this.files[0];
            let ext = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
            let type = file.type;

            if (admitExt.includes(ext, 0) && adminTypes.includes(type, 0)) {
                if (file.size <= 15728640) {
                    getFile(file);
                } else {
                    setFlash('danger', msg.filesGreaterThanLimit)
                }
            } else {
                setFlash("danger", msg.filesNotImage);
            }
        });
    }
}

function loadApp() {
    transparizeMenu();
    toggleMenuItem();
    toggleMobileMenuItem();
    relativeTimer('time[data-time]');
    share();
    showImageBeforeUpload("[data-action='upload']");
}

loadApp();
