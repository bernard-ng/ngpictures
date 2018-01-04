$('document').ready(function(){

    //System de like en Ajax
    (function(){
        var articles = document.querySelectorAll('article');
        if (articles !== undefined) {
            $(articles).each(
                function(){
                    var $that = $(this);
                    var $likeBtn = $that.find('#likeBtn');

                    $likeBtn.on('click live', function(e){
                        $this = $(this);
                        e.preventDefault(); e.stopPropagation();
                        $this.toggleClass('active');
                        $that.find('#showLikes').html('...');

                        $.ajax({
                            url: $likeBtn.attr('href')
                        }).then(
                            function(data) {
                                $that.find('#showLikes').html(data);
                            }, function (xhr) {
                                alert(xhr.responseText);
                            }
                        );
                    })
                }
            )
        }
    })();


    //Ajoute du nouveau contenu avec Ajax
    (function(){
        var action = 'inactive';
        var feedMore = $("#feedMore");
        var container = $('#dataContainer');

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
        verses = $('#versesContainer');
        verses.each(function(){
            if (verses !== undefined) {
                function loadData() {
                    $.ajax({url: "/ajax/verset"})
                    .then(
                        function(data) {
                            verses.html(''); verses.html(data);
                        }, function () {
                            verses.html('<div class="card-stacked mb-20 ml-20 mg-20 mg-20"><p>Impossible de charger les versets</p></div>');
                        }
                    );
                }
                setInterval(function(){
                    loadData();
                },6000)
            }
        })
    })()

});
