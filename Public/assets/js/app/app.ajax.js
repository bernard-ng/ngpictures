document.addEventListener('load Turbolinks:load', function(){
    class Ngpictures {

        /**
         * premet de rendre un itme du menu active
         * @returns {boolean}
         */
        static toggleMenuItem() {
            let menu    =   document.querySelector('#menu-items');
            let active  =   document.querySelector('#menu-items-active').textContent;
            active.toLowerCase();

            if (menu && active !== undefined) {
                let item = menu.querySelector("#"+active);
                if (item) {
                    return item.classList.toggle('active');
                } else {
                    return false;
                }
            }
        }

        /**
         * premet de rendre un item du menu mobile active
         * @returns {boolean}
         */
        static toggleMobileMenuItem() {
            let menu    =   document.querySelector('#menu-items');
            let active  =   document.querySelector('#menu-items-active').textContent;
            active.toLowerCase();

            if (menu && active !== undefined) {
                let item = menu.querySelector("#"+active);
                if (item) {
                    return item.classList.toggle('active');
                } else {
                    return false;
                }
            }
        }


        /**
         * recupere une instance du xhr pour les req ajax.
         * @returns {*}
         */
        static getXhr() {
            let xhr;
            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
                if (xhr.overrideMimeType()) {
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
        static likes(element) {
            let postContainer = document.querySelector(element);
            if (postContainer !== undefined) {
                postContainer.addEventListener('onclick', '.likeBtn', function(e) {
                    e.preventDefaults();
                    e.stopPropagation();
                    this.classList.toggle('active');
                    if (self.getXhr()) {
                        let xhr = self.getXhr();
                        xhr.open('GET', this.getAttribute('href'), true);
                        xhr.send();
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    this.textContent = xhr.responseText;
                                } else {
                                    window.alert(xhr.responseText);
                                }
                            }
                        }
                    }
                })
            }
        }
    }
});

Ngpictures.toggleMenuItem();
Ngpictures.toggleMobileMenuItem();
Ngpictures.likes('#post-container');