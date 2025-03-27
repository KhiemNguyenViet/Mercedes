var xhrPool = [];
if (!String.repeat) { String.prototype.repeat = function(l) { return new Array(l + 1).join(this); } }
(function($) {
    var deTube = {
        init: function() { $("body").fitVids();
            deTube.xhrPool;
            deTube.onbeforeunloadAbort();
            deTube.placeHolder();
            deTube.loopViewSwitcher();
            deTube.masonry();
            $('#main-nav .menu').deSelectMenu({});
            $('.orderby-select').change(function() { location.href = this.options[this.selectedIndex].value; }); },
        xhrPool: function() { $(document).ajaxSend(function(e, jqXHR, options) { xhrPool.push(jqXHR); });
            $(document).ajaxComplete(function(e, jqXHR, options) { xhrPool = $.grep(xhrPool, function(x) { return x != jqXHR }); }); },
        connectedControl: function(carouselStage, carouselNav) {
            if (jQuery().jcarousel === undefined)
                return;
            carouselNav.jcarousel('items').each(function() { var item = $(this),
                    target = carouselStage.jcarousel('items').eq(item.index());
                item.on('click', function() { if (carouselStage.data('jcarouselautoscroll') == 'stopped') { carouselStage.jcarouselAutoscroll('start');
                        carouselStage.data('jcarouselautoscroll', true); } }).on('active.jcarouselcontrol', function() { carouselNav.jcarousel('scrollIntoView', this);
                    item.addClass('active'); }).on('inactive.jcarouselcontrol', function() { item.removeClass('active'); }).jcarouselControl({ target: target, carousel: carouselStage }); });
        },
        clickAjax: function(link, stage, carousel) {
            if (!stage.data('ajaxload'))
                return false;
            $(link).on('click', function(e) {
                e.preventDefault();
                if (carousel.data('jcarouselautoscroll'))
                    carousel.jcarouselAutoscroll('stop').data('jcarouselautoscroll', 'stopped');
                deTube.ajaxVideo(this);
                return false;
            });
        },
        abortAll: function() { $.each(xhrPool, function(idx, jqXHR) { jqXHR.abort(); }); },
        stageSetup: function(stage) {
            stage.find('.item-video').each(function() {
                if ($(this).find('.video').length)
                    $(this).find('.thumb, .caption').hide();
            });
        },
        autoScroll: function(stage) { var interval = stage.data('autoscroll-interval'); if (interval > 0) { stage.jcarouselAutoscroll({ 'interval': interval, 'autostart': true }); } },
        targetedStage: function(carousel) { carousel.on('itemtargetin.jcarousel', '.item', function(event, carousel) { var item = $(this);
                item.find('.thumb').show();
                item.find('.caption').show();
                item.siblings('.item').find('.video').remove();
                item.parents('.wall').find('.entry-header').hide();
                item.parents('.wall').find('.entry-header[data-id="' + item.data('id') + '"]').fadeIn(); }).on('itemtargetout.jcarousel', '.item', function(event, carousel) { var item = $(this); }); },
        prevNextControl: function(carousel) { $('.prev-stage').on('inactive.jcarouselcontrol', function() { $(this).addClass('inactive'); }).on('active.jcarouselcontrol', function() { $(this).removeClass('inactive'); }).jcarouselControl({ target: '-=1', carousel: carousel });
            $('.next-stage').on('inactive.jcarouselcontrol', function() { $(this).addClass('inactive'); }).on('active.jcarouselcontrol', function() { $(this).removeClass('inactive'); }).jcarouselControl({ target: '+=1', carousel: carousel }); },
        loopViewSwitcher: function() {
            $('.loop-actions .view a').on('click', function(e) {
                e.preventDefault();
                var viewType = $(this).attr('data-type'),
                    loop = $('.switchable-view'),
                    loopView = loop.attr('data-view');
                if (viewType == loopView)
                    return false;
                $(this).addClass('current').siblings('a').removeClass('current');
                loop.stop().fadeOut(100, function() {
                    if (loopView)
                        loop.removeClass(loopView);
                    $(this).fadeIn().attr('data-view', viewType).addClass(viewType);
                });
                $('.loop-content .video').remove();
                $('.loop-content .thumb').show();
                $.cookie('loop_view', viewType, { path: '/', expires: 999 });
                return false;
            });
        },
        placeHolder: function() {
            $('input[type="text"]').each(function() {
                var placeholder = $(this).attr('placeholder');
                $(this).on('focus', function() {
                    if ($(this).attr('value') == '')
                        $(this).attr('value', '').attr('placeholder', '');
                }).on('blur', function() {
                    if ($(this).attr('value') == '')
                        $(this).attr('placeholder', placeholder);
                });
            });
        },
        onbeforeunloadAbort: function() {
            var oldbeforeunload = window.onbeforeunload;
            window.onbeforeunload = function() {
                var r = oldbeforeunload ? oldbeforeunload() : undefined;
                if (r == undefined) { deTube.abortAll(); }
                return r;
            }
        },
        masonry: function() {
            if (!$.isFunction($.fn.masonry))
                return false;
            var sidebar = $('#sidebar');
            if (sidebar.hasClass('masonry')) {
                var sidebarMasonry = function() { sidebar.imagesLoaded(function() { sidebar.masonry({ itemSelector: '.widget', columnWidth: 300, gutterWidth: 20, isRTL: $('body').is('.rtl') }); }); }
                if (sidebar.find('iframe').length) { sidebar.find('iframe').load(function() { sidebarMasonry(); }); } else { sidebarMasonry(); }
            }
            var footbar = $('#footbar-inner');
            if (footbar.hasClass('masonry')) {
                var footbarMasonry = function() { footbar.imagesLoaded(function() { var itemSelector = $('#footbar').data('layout') == 'c4s1' ? '.widget-col' : '.widget';
                        footbar.masonry({ itemSelector: itemSelector, columnWidth: 60, gutterWidth: 20, isRTL: $('body').is('.rtl') }); }); }
                if (footbar.find('iframe').length) { footbar.find('iframe').load(function() { footbarMasonry(); }); } else { footbarMasonry(); }
            }
        }
    }
    $(document).ready(function() { deTube.init(); });
    $(window).on('load resize', function() { $('.fcarousel-5').deCarousel();
        $('.fcarousel-6').deCarousel(); });
    $(function() { if ($('.loop-content').data('ajaxload')) { $('.item-video .thumb a').on('click', function(e) { if ($(this).parents('.list-large').length) { e.preventDefault();
                    $('.list-large .video').remove();
                    $('.list-large .thumb').show().removeClass('loading');
                    deTube.ajaxVideo(this); return false; } }); } });
    $(function() { var stage = $('.home-featured-full .stage'),
            carouselStage = stage.find('.carousel');
        deTube.stageSetup(stage); if (jQuery().jcarousel) { carouselStage.jcarousel({ wrap: 'circular' });
            deTube.autoScroll(carouselStage);
            deTube.targetedStage(carouselStage); var carouselNav = $('.fcarousel-6').deCarousel();
            deTube.connectedControl(carouselStage, carouselNav);
            deTube.clickAjax('.home-featured-full .stage .item-video .thumb a', stage, carouselStage); } });
    $(function() {
        var stage = $('.home-featured .stage');
        var carouselStage = stage.find('.carousel');
        deTube.stageSetup(stage);
        if (jQuery().jcarousel) { carouselStage.jcarousel({ wrap: 'circular' });
            deTube.autoScroll(carouselStage);
            deTube.targetedStage(carouselStage); var carouselNav = $('.home-featured .nav .carousel-clip').jcarousel({ vertical: true, wrap: 'circular' });
            $('.home-featured .carousel-prev').jcarouselControl({ target: '-=4' });
            $('.home-featured .carousel-next').jcarouselControl({ target: '+=4' });
            deTube.connectedControl(carouselStage, carouselNav); }
        deTube.clickAjax('.home-featured .stage .item-video .thumb a', stage, carouselStage);
    });
}(jQuery));