/**
 * recupere une instance du xhr pour les req ajax.
 * @returns {*}
 */
function getXhr() {
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
function likes(element) {
    let postContainer = document.querySelector(element);
    if (postContainer !== undefined && null) {
        postContainer.addEventListener('onclick', '.likeBtn', function(e) {
            e.preventDefaults();
            e.stopPropagation();

            this.classList.toggle('active');
            if (getXhr()) {
                let xhr = getXhr();
                xhr.open('GET', this.getAttribute('href'), true);
                xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
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
        });
    } else {
        return false;
    }
}

likes("#dataContainer");