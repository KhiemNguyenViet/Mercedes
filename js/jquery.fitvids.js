/*!
 * FitVids 1.0
 *
 * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 * Date: Thu Sept 01 18:00:00 2011 -0500
 */
(function($) {
    "use strict";
    $.fn.fitVids = function(options) {
        var settings = { customSelector: null };
        if (!document.getElementById('fit-vids-style')) { var div = document.createElement('div'),
                ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];
            div.className = 'fit-vids-style';
            div.id = 'fit-vids-style';
            div.style.display = 'none';
            div.innerHTML = '&shy;<style>         \
        .fluid-width-video-wrapper {        \
           width: 100%;                     \
           position: relative;              \
           padding: 0;                      \
        }                                   \
                                            \
        .fluid-width-video-wrapper iframe,  \
        .fluid-width-video-wrapper object,  \
        .fluid-width-video-wrapper embedd {  \
           position: absolute;              \
           top: 0;                          \
           left: 0;                         \
           width: 100%;                     \
           height: 100%;                    \
        }                                   \
      </style>';
            ref.parentNode.insertBefore(div, ref); }
        if (options) { $.extend(settings, options); }
        return this.each(function() {
            var selectors = ["iframe[src*='player.vimeo.com']", "iframe[src*='youtube.com']", "iframe[src*='youtube-nocookie.com']", "iframe[src*='kickstarter.com'][src*='video.html']", "iframe[src*='blip.tv/play'], iframe[src*='embed.ted.com']", "iframe[src*='dailymotion.com/embed/video/']", "iframe[src*='hulu.com/embed.html']", "object", "embed"];
            if (settings.customSelector) { selectors.push(settings.customSelector); }
            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not("object object");
            $allVideos.each(function() {
                var $this = $(this);
                if ((this.tagName.toLowerCase() === 'embed' && $this.parent('object').length) || ($this.parents('.fluid-width-video-wrapper').length) || (this.tagName.toLowerCase() === 'embed' && $this.attr('src').indexOf('blip.tv') >= 0) || $this.parents('.jwplayer').length || $this.parents('[id^="jwplayer"]').length || $this.parents('.flowplayer').length) { return; }
                var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if (!$this.attr('id')) { var videoID = 'fitvid' + Math.floor(Math.random() * 999999);
                    $this.attr('id', videoID); }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + "%");
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
    $(window).load(function() { $('embed').each(function() { var height = $(this).parents('.fluid-width-video-wrapper').outerHeight(false);
            $(this).height(height); }); });
})(jQuery);