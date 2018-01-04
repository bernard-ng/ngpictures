/*
 * This is my javascript code for ngpictures project, 
 * as you know I am a beginner so hope you gonna make perfect this code et gonna my logic
 * all annimation and smart effect are here, ajax gonna be in app.ajax.js
 * 
 * 
 * PS: I'm a french speaker so if my english is broken , just understand...
 * @author Bernard ng;
 */
$(document).ready(function(){

    //shim pour le scrollY
    var scrollY = function(){
        var supportPageOffset = window.PageYOffset !== undefined ;
        var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");
        return y = supportPageOffset ? window.PageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop
    };


    //bar de progression pour la galerie
    (function(){
        var progressBar = {
        countImg : 0,
        loadedImg: 0,
            
        init : function(){
                var that = this;
                var imgs = $('a img.galery-item');
                that.countImg = imgs.length;

                //on cree la bare de progression
                var $progressBarContainer = $('<div/>').attr('id','progress-bar-container');
                var $progressBar = $('<div/>').attr('id','progress-bar');
                $progressBarContainer.append($progressBar).appendTo('#menu');

                //le fake container histoir de compter mm les image charger du cache.
                var $fakeContainer = $('<div/>').attr('id','fakeImgContainer');
                $fakeContainer.appendTo($('body'));
                
                //on parcours le element en le ajoutant au fake
                imgs.each(function(){
                    $img =  $('<img/>').attr('src', $(this).attr('src'));
                    $img.on('load error', function(){
                            that.loadedImg++;
                            that.update();
                        });

                    $fakeContainer.append($img);
                });

            },

            update : function(){
                $('#progress-bar').stop().animate({
                    'width' : (progressBar.loadedImg / progressBar.countImg) * 100 + '%' 
                }, 300, 'linear', function(){
                    if (progressBar.loadedImg === progressBar.countImg) {
                        setTimeout(function(){
                            $('#progress-bar-container').stop().animate({
                                'opacity' : 0
                            }, 500, 'linear', function(){
                                $('#progress-bar-container').remove();
                                $('#fakeImgContainer').remove();
                            })
                        }, 500)
                    }
                });
            }
        };

        if ($('#galery') !== undefined) {
            progressBar.init();
        }
    })();


    //Message flash
    (function(){
        var $flash = $('#flash');
        if ($flash.length > 0) {
            $flash.click(function(){
                $(document).removeChild($flash);
            });
            $flash.fadeIn(600).delay(5000).slideUp();
        }
    })();

    
    //Navbar animation
    (function(){
        $window = $(window);
        $window.scroll(function(){
            if($window.scrollTop() > 20){
                $("#menu").addClass('shrink');
            }else{
                $("#menu").removeClass('shrink');
            }
        })
    })();

    //rendre active un item du menu
    (function(){
        $activeLink = $('#menu-item-active').attr('data-isActive');
        if ($activeLink !== undefined) {
            $link = $('ul.links').find("li#" + $activeLink);
            $link.addClass('active');
        }
    })();

    (function(){
        class Tooltip {
            
            static bind(selector) {
                document.querySelectorAll(selector).forEach(element => new Tooltip(element));
            }

            constructor(element) {
                this.element = element;
                this.title = element.getAttribute('title');
                this.tooltip = null;
                this.element.addEventListener('mouseover', this.mouseOver.bind(this));
                this.element.addEventListener('mouseout', this.mouseOut.bind(this));
            }

            mouseOver() {
               var tooltip = this.create();
               var width = this.tooltip.offsetWidth;
               var height = this.tooltip.offsetHeight;
               var left = this.element.offsetWidth / 2 - width / 2 + this.element.getBoundingClientRect().left + document.documentElement.scrollLeft;
               var top = this.element.getBoundingClientRect().top - height -15 + document.documentElement.scrollTop;
               tooltip.style.left = left + "px";
               tooltip.style.top = top + "px";
               tooltip.classList.add('visible');
                
            }

            mouseOut() {
                if (this.tooltip !== null) {
                    this.tooltip.classList.remove('visible');
                    this.tooltip.addEventListener('transitionend', function(){
                        document.body.removeChild(this.tooltip);
                        this.tooltip = null
                    })
                }
            }
            create() {
                if (this.tooltip === null) {
                    var tooltip = document.createElement('div');
                    tooltip.innerHTML = this.title;
                    tooltip.classList.add('tooltip');
                    document.body.appendChild(tooltip);
                    this.tooltip = tooltip;
                    return tooltip
                }
                return this.tooltip
            }
        }

        Tooltip.bind('[title]');
        Tooltip.bind('[data-tooltip');
    })();


    // timer relatif
    (function(){
        if (document.querySelectorAll('time[data-time') !== undefined) {
            if (NodeList.prototype.forEach === undefined) {
                NodeList.prototype.forEach = function (callback) {
                    [].forEach.call(this, callback)
                }
            }

            var terms = [
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
                    var seconds = Math.floor((new Date()).getTime()/1000 - parseInt(node.dataset.time, 10));
                    var prefix = seconds > 0 ? 'Il y a ' : 'Dans ' ;
                    var term = null;
                    seconds = Math.abs(seconds);

                    for (term of terms) { if (seconds < term.time) { break }}
                    node.innerHTML = prefix + term.text.replace('%d', Math.round(seconds/term.divide));

                    var nextTick = seconds % term.divide;
                    if ( nextTick === 0) {
                        nextTick = term.divide
                    }
                }

                window.setTimeout(function(){
                    if (node.parentNode){
                        window.requestAnimationFrame ?  window.requestAnimationFrame(setText) : setText()
                    }
                },  1000);

                setText();
            })
        }
    })();
});
