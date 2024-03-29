﻿(function ($) {
    $.fn.lazyload = function (options) {
        var settings = {
            threshold: 0,
            failurelimit: 0,
            event: "scroll",
            effect: "show"
        };
        if (options) {
            $.extend(settings, options)
        }
        var elements = this;
        if ("scroll" == settings.event) {
            $(window).bind("scroll", function (event) {
                var counter = 0;
                elements.each(function () {
                    if (!$.belowthefold(this, settings) && !$.rightoffold(this, settings)) {
                        $(this).trigger("appear")
                    } else {
                        if (counter++>settings.failurelimit) {
                            return false
                        }
                    }
                });
                var temp = $.grep(elements, function (element) {
                    return !element.loaded
                });
                elements = $(temp)
            })
        }
        return this.each(function () {
            var self = this;
            $(self).attr("original", $(self).attr("src"));
            if ("scroll" != settings.event || $.belowthefold(self, settings) || $.rightoffold(self, settings)) {
                if (settings.placeholder) {
                    $(self).attr("src", settings.placeholder)
                } else {
                    $(self).removeAttr("src")
                }
                self.loaded = false
            } else {
                self.loaded = true
            }
            $(self).one("appear", function () {
                if (!this.loaded) {
                    $("<img>").attr("src", $(self).attr("original")).bind("load", function () {
                        $(self).hide().attr("src", $(self).attr("original"))[settings.effect](settings.effectspeed);
                        self.loaded = true
                    })
                }
            });
            if ("scroll" != settings.event) {
                $(self).bind(settings.event, function (event) {
                    if (!self.loaded) {
                        $(self).trigger("appear")
                    }
                })
            }
        })
    };
    $.belowthefold = function (element, settings) {
        var fold = $(window).height() + $(window).scrollTop();
        return fold <= $(element).offset().top - settings.threshold
    };
    $.rightoffold = function (element, settings) {
        var fold = $(window).width() + $(window).scrollLeft();
        return fold <= $(element).offset().left - settings.threshold
    };
    $.extend($.expr[':'], {
        "below-the-fold": "$.belowthefold(a, {threshold : 0})",
        "above-the-fold": "!$.belowthefold(a, {threshold : 0})",
        "right-of-fold": "$.rightoffold(a, {threshold : 0})",
        "left-of-fold": "!$.rightoffold(a, {threshold : 0})"
    })
})(jQuery);