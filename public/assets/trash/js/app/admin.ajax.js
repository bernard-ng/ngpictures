$('document').ready(function () {

    /**
     * suppression du contenu
     */
    (function(){
        $('table').on('click', '#delete', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var confirmed = confirm("Voulez-vous vraiment supprimer ?");
            if (confirmed) {
                var $id = ($(this).parent().find('input[name=id]').val());
                var $type = ($(this).parent().find('input[name=type]').val());
                $btn.html('<i class="icon icon-refresh rotate" style="font-size: smaller !important;"></i>');
                $.post(
                    $btn.parent().attr('action'),
                    {id: $id, type: $type}
                ).then(
                    function(){
                        $btn.html('<i class="icon icon-refresh rotate" style="font-size: smaller !important;"></i>');
                        $btn.parents('tr').fadeOut();
                    },
                    function (xhr) {
                        $btn.html('<i class="icon icon-remove" style="font-size: smaller !important;"></i>');
                        alert(xhr.responseText);
                    }
                );
            }
            return false;
        })
    })();


    /**
     * ajout ou retrait du contenu en ligne
     */
    (function(){
        $('table').on('click', 'a#confirm', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var $text = $btn.html();
            var confirmed = confirm("Voulez-vous vraiment continuer ?");
            if (confirmed) {
                $.ajax({
                    url: $btn.attr('href'),
                    method: 'GET',
                    cache: false
                }).then(
                    function (data) {
                        $btn.find('button').html(data);
                    },
                    function (xhr) {
                        alert(xhr.responseText);
                        $btn.html($text);
                    }
                )
            }
        })
    })();


});