/*$('document').ready(function(){


     (function(){
        var links = $('a');
        links.click(function(e){
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this);
            $.ajax({
                url : $this.attr('href'),
                beforeSend : function(){
                    $('#pageContent').html('chargement...');
                }
            })
            .done(
                function(data){
                    $data = $(data);
                    $('body').html("");
                    $('body').html($data);
                }
            )
        })
    })()

    //System de like en Ajax
    (function(){
        var options = $('#articleOptions');
        if (options != undefined) {
            options.each(options,function(){
                var likeBtn = $(this).find('#likeBtn');
                var dislikeBtn = $(this).find('#dislikeBtn');

                if (dislikeBtn != undefined) {
                    dislikeBtn.click(function(e){
                        $this = $(this)
                        e.preventDefault()
                        e.stopPropagation()
                        $this.siblings('.active').removeClass('active')
                        $this.toggleClass('active')
                    })
                }
                
                likeBtn.click(function(e){
                    $this = $(this)
                    e.preventDefault();
                    e.stopPropagation();
                    $this.siblings('.active').removeClass('active');
                    $this.toggleClass('active');
                })
            })
        }
    })()


    //Ajoute du nouveau contenu avec Ajax
    (function(){
        var feedMore = document.querySelector('#feedMore');
        if (feedMore != undefined) {
            feedMore.addEventListener('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).html(' ');
                $(this).html('<div class="progress"><div class="indeterminate"></div></div>');
            })
        } 
    })();

})
 */