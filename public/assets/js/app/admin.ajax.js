document.addEventListener('DOMContentLoaded', function () {

    /**
     * suppression du contenu
     */
    function formDelete(element){
        let forms = document.querySelectorAll(element);
        if (typeof forms !== 'undefined') {
            for (let i = 0; i < forms.length; i++) {
                let deleteForm = forms[i];
                deleteForm.querySelector('#delete').addEventListener('click', function(e){
                    e.preventDefault();
                    e.stopPropagation();

                    let deleteBtn = this;
                    let isConfirmed = window.confirm("Vous-vous vraiment supprimer ?");
                    if (isConfirmed) {
                        let form = deleteBtn.parentElement;
                        let id = form.querySelector("input[name='id']").value;
                        let type = form.querySelector("input[name='type']").value;
                        setLoader(deleteBtn);

                        if (getXhr()) {
                            let xhr = getXhr();
                            let data = new FormData;
                            data.append('id', id);
                            data.append('type', type);

                            xhr.open('POST', form.getAttribute('action'), true);
                            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        setLoader(deleteBtn);
                                        $(deleteBtn).parents('tr').fadeOut();
                                        return true;
                                    } else {
                                        removeLoader(deleteBtn, '<i class="icon icon-cancel" style="font-size: smaller !important;"></i>');
                                        setFlash(
                                            'danger',
                                            xhr.responseText? xhr.responseText : msg.undefinedError
                                        );
                                        return false;
                                    }
                                }
                            };
                            xhr.timeout = 10000;
                            xhr.send(data);
                        }
                    }
                    return false;
                })
            }
        }
    }


    /**
     * ajout ou retrait du contenu en ligne
     */
    function confirmPost(element){
        let confirmLinks = document.querySelectorAll(element);
        if (typeof confirmLinks !== 'undefined') {
            for(let i = 0; i < confirmLinks.length; i++) {
                confirmLinks[i].addEventListener('click', function(e){
                    e.preventDefault();
                    e.stopPropagation();

                    let confirmBtn = this.querySelector('button');
                    let nativeText = confirmBtn.innerHTML;
                    setLoader(confirmBtn);

                    let isConfirmed = window.confirm("Voulez-vous vraiment Continuer ?");
                    if (isConfirmed) {
                        if (getXhr()) {
                            let xhr = getXhr();
                            xhr.open('GET', this.getAttribute('href'), true);
                            xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        removeLoader(confirmBtn, xhr.responseText);
                                    } else {
                                        confirmBtn = nativeText;
                                        setFlash(
                                            'danger',
                                            xhr.responseText? xhr.responseText : msg.undefinedError
                                        );
                                        return false;
                                    }
                                }
                            };
                            xhr.timeout = 10000;
                            xhr.send();
                        }
                    }
                    return false;
                });
            }
        }
        return false;
    }

    formDelete("form[data-action='delete-ajax']");
    confirmPost("a#confirm");
});