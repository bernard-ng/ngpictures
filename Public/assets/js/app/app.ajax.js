$('document').ready(function(){

    //System de like en Ajax
    /*(function(){
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
    })()*/

    //Ajoute du nouveau contenu avec Ajax
    (function(){
        var action = 'inactive';
        var feedMore = $("#feedMore");
        var container = $('#dataContainer')

        function loadData(lastId){
            $.post({
                url: "/ajax/"+ feedMore.attr('data-ajax'),
                data: {lastId: lastId}
            })
            .then(
                function(data) {
                    if (data == '') {
                        feedMore.html('aucun contenu à charger');
                        action = 'active';
                    } else {
                        feedMore.html('<i class="icon icon-refresh rotate"></i> chargement...');
                        action = 'inactive';
                    }
                    container.append(data);
                }, function() {
                    feedMore.html('impossible de charger la suite');
                }
            );
        }

        $(window).scroll(function(){
            if ($(window).scrollTop() + $(window).height() > container.height() && action == 'inactive') {
                action = 'active';
                setTimeout(function(){
                    loadData($("#dataContainer article").last().attr('id'));
                },3000);
            }
        })
    })();


    (function(){
        verse = $('#versesContainer')
        verse.each(function(){
            if (verse != undefined) {
                function loadData() {
                    $.ajax({url: "/ajax/verset"})
                    .then(
                        function(data) {
                            verse.html(''); verse.html(data);
                        }, function () {
                            verse.html('<div class="card-stacked mb-20 ml-20 mg-20 mg-20"><p>impossible de charger les versets</p></div>');
                        }
                    );
                }
            setInterval(function(){
                loadData();
            },6000)
            }
        })
    })()

})
