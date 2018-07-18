function parserHtml(html) {
    var t = document.createElement('template');
    t.innerHTML = html;
    return t.content.cloneNode(true);
}

function loadGeneric(element) {
    let action = "inactive";
    let statusBar = document.querySelector('#statusBar');
    let container = document.querySelector(element);

    if (statusBar !== null && container !== null) {
        function getData(lastId) {
            if (lastId == 1) {
                statusBar.innerHTML = "<center>Aucun contenu à charger</center>";
                return false;
            }
            if (container && statusBar) {
                let xhr = getXhr();
                if (xhr) {
                    if (container.getAttribute('data-ajax')) {
                        let url = `/ajax/${container.getAttribute('data-ajax')}?lastId=${lastId}`;
                        xhr.open('GET', url, true);
                        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                        xhr.send();
                        setLoader(statusBar);
                    }

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                if (xhr.responseText = '') {
                                    action = "inactive";
                                    statusBar.innerHTML = "<center>Aucun contenu à charger</center>";
                                } else {
                                    action = "active";
                                    setLoader(statusBar);
                                }

                                action = "inactive";
                                let data = parserHtml(xhr.responseText);
                                container.append(data);
                                loadInit();
                                loadLazy();
                                loadAjax();
                                loadApp();
                                getDataWithoutScroll();
                            } else {
                                action = "inactive";
                                statusBar.innerHTML = "<center>Aucun contenu à charger</center>";
                            }
                        }
                    }
                }
            } else {
                return false;
            }
        }

        let bottom;
        let winSize;

        function getDataWithoutScroll() {
            bottom = $(container.lastElementChild).offset().top + $(container.lastElementChild).height();
            winSize = $(window).scrollTop() + $(window).height();
            if (winSize > bottom && action === "inactive") {
                action = "active";
                window.setTimeout(function () {
                    getData(container.lastElementChild.getAttribute("id"));
                }, 2000);
            }
        }

        getDataWithoutScroll();

        window.addEventListener('scroll', function () {
            if (action === "inactive") {
                bottom = $(container.lastElementChild).offset().top + $(container.lastElementChild).height();
                winSize = $(window).scrollTop() + $(window).height();

                try {
                    if (winSize > bottom) {
                        action = "active";
                        window.setTimeout(function () {
                            getData(container.lastElementChild.getAttribute("id"));
                        }, 2000);
                    }
                } catch (e) {
                    return false;
                }
            }
        })
    }
}


loadGeneric('#dataContainer');
