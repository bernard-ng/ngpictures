'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*
 * This is my javascript code for ngpictures project, 
 * as you know I am a beginner so hope you gonna make perfect this code et gonna my logic
 * all annimation and smart effect are here, ajax gonna be in app.ajax.js
 * 
 * 
 * PS: I'm a french speaker so if my english is broken , just understand...
 * @author Bernard ng;
 */

//bar de progression pour la galerie
var progressBar = {
    countImg: 0,
    loadedImg: 0,

    init: function init() {
        var that = this;
        that.countImg = $('a img.galery-item').length;

        //on cree la bare de progression
        var $progressBarContainer = $('<div/>').attr('id', 'progress-bar-container');
        var $progressBar = $('<div/>').attr('id', 'progress-bar');
        $progressBarContainer.append($progressBar).appendTo('#menu');

        //le fake container histoir de compter mm les image charger du cache.
        var $fakeContainer = $('<div/>').attr('id', 'fakeImgContainer');
        $fakeContainer.appendTo($('body'));

        //on parcours le element en le ajoutant au fake
        $('a img.galery-item').each(function () {
            $img = $('<img/>').attr('src', $(this).attr('src'));
            $img.on('load error', function () {
                that.loadedImg++;
                that.update();
            });

            $fakeContainer.append($img);
        });
    },

    update: function update() {
        $('#progress-bar').stop().animate({
            'width': progressBar.loadedImg / progressBar.countImg * 100 + '%'
        }, 300, 'linear', function () {
            if (progressBar.loadedImg == progressBar.countImg) {
                setTimeout(function () {
                    $('#progress-bar-container').stop().animate({
                        'opacity': 0
                    }, 500, 'linear', function () {
                        $('#progress-bar-container').remove();
                        $('#fakeImgContainer').remove();
                    });
                }, 500);
            }
        });
    }
};

if ($('#galery') != undefined) {
    progressBar.init();
}

$(document).ready(function () {

    //shim pour le scrollY
    var scrollY = function scrollY() {
        var supportPageOffset = window.PageYOffset !== undefined;
        var isCSS1Compat = (document.compatMode || "") === "CSS1Compat";
        return y = supportPageOffset ? window.PageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
    };

    // System de click pour la home page
    (function () {
        var $destination = $("#mainImg");
        var $imgs = $("#previousImgs img,#nextImgs img");
        if ($destination && $imgs !== undefined) {
            $imgs.click(function (e) {
                $this = $(this);
                e.preventDefault();e.stopPropagation();
                var $fake = $('<img/>').attr('src', $this.attr('src'));

                $destination.find('img').remove().fadeOut();
                $destination.append($fake);

                $destination.slideDown();
                //$destination.slideIn();
            });
        }
    })();

    // timer relatif
    (function () {
        if (document.querySelector('time[data-time') !== undefined) {
            if (NodeList.prototype.forEach === undefined) {
                NodeList.prototype.forEach = function (callback) {
                    [].forEach.call(this, callback);
                };
            }

            var terms = [{ time: 10, divide: 1, text: "%d secondes" }, { time: 45, divide: 1, text: "moins d'une minute" }, { time: 90, divide: 60, text: "environ une minute" }, { time: 45 * 60, divide: 60, text: "%d minutes" }, { time: 90 * 60, divide: 60 * 60, text: "environ une heure" }, { time: 24 * 60 * 60, divide: 60 * 60, text: "%d heures" }, { time: 42 * 60 * 60, divide: 24 * 60 * 60, text: "environ un jour" }, { time: 30 * 24 * 60 * 60, divide: 24 * 60 * 60, text: "%d jours" }, { time: 42 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "environ un mois" }, { time: 365 * 24 * 60 * 60, divide: 24 * 60 * 60 * 30, text: "%d mois" }, { time: 365 * 1.5 * 24 * 60 * 60, divide: 24 * 60 * 60 * 365, text: "environ un an" }, { time: Infinity, divide: 24 * 60 * 60 * 365, text: "%d ans" }];

            document.querySelectorAll('time[data-time]').forEach(function (node) {
                function setText() {
                    var seconds = Math.floor(new Date().getTime() / 1000 - parseInt(node.dataset.time, 10));
                    var prefix = seconds > 0 ? 'Il y a ' : 'Dans ';
                    var term = null;
                    seconds = Math.abs(seconds);

                    var _iteratorNormalCompletion = true;
                    var _didIteratorError = false;
                    var _iteratorError = undefined;

                    try {
                        for (var _iterator = terms[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                            term = _step.value;
                            if (seconds < term.time) {
                                break;
                            }
                        }
                    } catch (err) {
                        _didIteratorError = true;
                        _iteratorError = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion && _iterator.return) {
                                _iterator.return();
                            }
                        } finally {
                            if (_didIteratorError) {
                                throw _iteratorError;
                            }
                        }
                    }

                    node.innerHTML = prefix + term.text.replace('%d', Math.round(seconds / term.divide));

                    var nextTick = seconds % term.divide;
                    if (nextTick === 0) {
                        nextTick = term.divide;
                    }
                }

                window.setTimeout(function () {
                    if (node.parentNode) {
                        window.requestAnimationFrame ? window.requestAnimationFrame(setText) : setText();
                    }
                }, 1000);

                setText();
            });
        }
    })();

    //Message flash
    (function () {
        var $flash = $('#flash');
        if ($flash.length > 0) {
            $flash.fadeIn(600).delay(3000).fadeOut();
        }
    })();

    //Navbar animation
    (function () {
        $window = $(window);
        $window.scroll(function () {
            if ($window.scrollTop() > 20) {
                $("#menu").addClass('shrink');
            } else {
                $("#menu").removeClass('shrink');
            }
        });
    })();

    //rendre active un item du menu
    (function () {
        $activeLink = $('#menu-item-active').attr('data-isActive');
        if ($activeLink != undefined) {
            $link = $('ul.links').find("li#" + $activeLink);
            $link.addClass('active');
        }
    })();

    //system de hover pour la galery
    (function () {
        var $img = $('#galery .photo');
        if ($img !== undefined) {
            var current = null;
            var top = parseInt($('a:first span.photo-title').css('top'));
            var top2 = parseInt($('a:first span.photo-desc').css('top'));

            $('.photo').mouseover(function () {
                if (current && $(this).index() !== current.index()) {
                    current.find('span.photo-bg').hide().fadeOut();
                    current.find('span.photo-title').show().animate({ top: top + 15, opacity: 0 }, 90, 'linear');
                    current.find('span.photo-desc').show().animate({ top: top2 + 35, opacity: 0 }, 90, 'linear');
                }

                if (current && $(this).index() === current.index()) {
                    return null;
                }

                $(this).find('span.photo-bg').hide().stop().fadeTo(200, 0.8);
                $(this).find('span.photo-title').css({ opacity: 0, top: top + 15 }).animate({ opacity: 1, top: top }, 200, 'linear');

                $(this).find('span.photo-desc').css({ opacity: 0, top: top2 + 35 }).animate({ opacity: 1, top: top2 });
                current = $(this);
            });

            $('.photo').mouseout(function () {
                if (current && $(this).index() !== current.index()) {
                    current.find('span.photo-bg').stop().fadeOut();
                    current.find('span.photo-title').show().animate({ top: top + 15, opacity: 0 }, 200, 'linear');
                    current.find('span.photo-desc').show().animate({ top: top2 + 15, opacity: 0 }, 200, 'linear');
                }
            });
        }
    })();

    (function () {
        var Tooltip = function () {
            _createClass(Tooltip, null, [{
                key: 'bind',
                value: function bind(selector) {
                    document.querySelectorAll(selector).forEach(function (element) {
                        return new Tooltip(element);
                    });
                }
            }]);

            function Tooltip(element) {
                _classCallCheck(this, Tooltip);

                this.element = element;
                this.title = element.getAttribute('title');
                this.tooltip = null;
                this.element.addEventListener('mouseover', this.mouseOver.bind(this));
                this.element.addEventListener('mouseout', this.mouseOut.bind(this));
            }

            _createClass(Tooltip, [{
                key: 'mouseOver',
                value: function mouseOver() {
                    var tooltip = this.create();
                    var width = this.tooltip.offsetWidth;
                    var height = this.tooltip.offsetHeight;
                    var left = this.element.offsetWidth / 2 - width / 2 + this.element.getBoundingClientRect().left + document.documentElement.scrollLeft;
                    var top = this.element.getBoundingClientRect().top - height - 15 + document.documentElement.scrollTop;
                    tooltip.style.left = left + "px";
                    tooltip.style.top = top + "px";
                    tooltip.classList.add('visible');
                }
            }, {
                key: 'mouseOut',
                value: function mouseOut() {
                    if (this.tooltip !== null) {
                        this.tooltip.classList.remove('visible');
                        this.tooltip.addEventListener('transitionend', function () {
                            document.body.removeChild(this.tooltip);
                            this.tooltip = null;
                        });
                    }
                }
            }, {
                key: 'create',
                value: function create() {
                    if (this.tooltip === null) {
                        var tooltip = document.createElement('div');
                        tooltip.innerHTML = this.title;
                        tooltip.classList.add('tooltip');
                        document.body.appendChild(tooltip);
                        this.tooltip = tooltip;
                        return tooltip;
                    }
                    return this.tooltip;
                }
            }]);

            return Tooltip;
        }();

        Tooltip.bind('[title]');
    })();
});