﻿;
(function ($) {
    var $scrollTo = $.scrollTo = function (target, duration, settings) {
        $scrollTo.window().scrollTo(target, duration, settings)
    };
    $scrollTo.defaults = {
        axis: 'y',
        duration: 1
    };
    $scrollTo.window = function () {
        return $($.browser.safari ? 'body' : 'html')
    };
    $.fn.scrollTo = function (target, duration, settings) {
        if (typeof duration == 'object') {
            settings = duration;
            duration = 0
        }
        settings = $.extend({},
        $scrollTo.defaults, settings);
        duration = duration || settings.speed || settings.duration;
        settings.queue = settings.queue && settings.axis.length > 1;
        if (settings.queue) duration /= 2;
        settings.offset = both(settings.offset);
        settings.over = both(settings.over);
        return this.each(function () {
            var elem = this,
                $elem = $(elem),
                t = target,
                toff, attr = {},
                win = $elem.is('html,body');
            switch (typeof t) {
            case 'number':
            case 'string':
                if (/^([+-]=)?\d+(px)?$/.test(t)) {
                    t = both(t);
                    break
                }
                t = $(t, this);
            case 'object':
                if (t.is || t.style) toff = (t = $(t)).offset()
            }
            $.each(settings.axis.split(''), function (i, axis) {
                var Pos = axis == 'x' ? 'Left' : 'Top',
                pos = Pos.toLowerCase(),
                key = 'scroll' + Pos,
                act = elem[key],
                Dim = axis == 'x' ? 'Width' : 'Height',
                dim = Dim.toLowerCase();
                if (toff) {
                    attr[key] = toff[pos] + (win ? 0 : act - $elem.offset()[pos]);
                    if (settings.margin) {
                        attr[key] -= parseInt(t.css('margin' + Pos)) || 0;
                        attr[key] -= parseInt(t.css('border' + Pos + 'Width')) || 0
                    }
                    attr[key] += settings.offset[pos] || 0;
                    if (settings.over[pos]) attr[key] += t[dim]() * settings.over[pos]
                } else attr[key] = t[pos];
                if (/^\d+$/.test(attr[key])) attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max(Dim));
                if (!i && settings.queue) {
                    if (act != attr[key]) animate(settings.onAfterFirst);
                    delete attr[key]
                }
            });
            animate(settings.onAfter);



            function animate(callback) {
                $elem.animate(attr, duration, settings.easing, callback &&
                function () {
                    callback.call(this, target)
                })
            };



            function max(Dim) {
                var el = win ? $.browser.opera ? document.body : document.documentElement : elem;
                return el['scroll' + Dim] - el['client' + Dim]
            }
        })
    };



    function both(val) {
        return typeof val == 'object' ? val : {
            top: val,
            left: val
        }
    }
})(jQuery);
$(document).ready(function () {
    var url = "http://labs.cloudream.name/google/chart/api.html";
    var $window = $(window);
    var $wrap = $("#wrap");
    var maxWidth = 760;
    var contents = "";
    $("div.section h4:has(a)").each(function () {
        var $childrenAname = $(this).children("a:first").attr("name");
        contents += '<li><a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '">' + $(this).text() + '</a>';
        var $childrenH5 = $(this).next("div.scrap").children("h5:has(a)");
        if ($childrenH5.length) {
            contents += ' <span class="switch">+</span><ul>';
            $childrenH5.each(function () {
                var $childrenAname = $(this).children("a:first").attr("name");
                contents += '<li><a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '">' + $(this).text() + '</a></li>'
            });
            contents += '</ul>'
        }
        contents += '</li>'
    }).css("cursor", "pointer").click(function () {
        $(this).next("div.scrap").slideToggle("fast")
    });
    contents = '<ol>' + contents + '</ol>';
    $("#content").html(contents);
    $("#content span.switch").css("cursor", "pointer").toggle(function () {
        $(this).text("-")
    },
    function () {
        $(this).text("+")
    }).click(function () {
        $(this).next("ul").toggle()
    });
    $('img').lazyload({
        placeholder: "grey.gif",
        effect: "fadeIn"
    });
    var backtocontent = '<p class="backToTop">';
    backtocontent += '<a href="' + url + '#contents" scrollto="contents">a?‘è?”?????????</a>';
    backtocontent += '</p>';
    $("h5,h6").before(backtocontent);
    $("div.scrap").append(backtocontent);
    var $history_list = $("#history_list");
    var history_i = 0;
    jQuery.fn.bindScroll = function (f) {
        return this.click(function () {
            $.scrollTo("a[name=" + $(this).attr("scrollto") + "]", {
                speed: 500,
                axis: 'y',
                offset: {
                    top: -24,
                    left: 0
                }
            });
            return false
        })
    };
    $("a[scrollto!=]").each(function () {
        $(this).bindScroll().click(function () {
            var $thisScrollTo = $(this).attr('scrollto');
            if (history_panel.length && $thisScrollTo != 'contents') {
                $('<a href="#' + $thisScrollTo + '" scrollto="' + $thisScrollTo + '">' + $(this).text() + '</a>').bindScroll().prependTo($history_list).wrapAll('<tr><td></td></tr>');
                history_i++;
                if (history_i > 7) {
                    $history_list.children("tr:last-child").remove()
                }
            }
        })
    });
    $("a:not([href^=http://labs.cloudream.name/])").attr("target", "_blank");
    var history_panel = $("#history_panel");
    if (history_panel.length && $.browser.msie && $.browser.version < 7) {
        history_panel.css("position", "absolute");
        $window.scroll(function () {
            history_panel.css("top", $window.scrollTop() + 20)
        })
    }
    $window.resize(function () {
        $wrap.width(Math.min($window.width(), maxWidth));
        if (history_panel.length) {
            history_panel.css("left", ($window.width() + maxWidth) / 2 + 2)
        }
    }).resize();
    $.getScript("http://www.google-analytics.com/urchin.js", function () {
        _uacct = "UA-3179915-1";
        urchinTracker()
    })
});