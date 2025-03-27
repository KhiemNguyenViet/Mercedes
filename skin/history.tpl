{header}
<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        {navbar}
        <div class="ah_content">
            {box_top}
            <div id="top-banner-pc">
                <zone id="kyl30cr3"></zone>
            </div>
            <div id="top-banner-mb">
                <zone id="kyl3axj2"></zone>
            </div>
            <div class="history">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Lịch Sử Xem</span></h3>
                    </div>
                </div>
                <div class="display_axios">
                    <div class="ah_loading" style="display: none;">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="watch-history ah-frame-bg">
                        {list_history}
                    </div>
                    <div class="pagination">
                        <div>{phantrang}</div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 500)
                    $('#top-up').fadeIn(400);
                else
                    $('#top-up').fadeOut(100);
            });
            $("#top-up").click(function() {
                $("html, body").animate({
                    scrollTop: 0
                }, {
                    duration: 300
                })
            });
        });
        </script>
        <div title="Về đầu trang" id="top-up">
            <span class="material-icons-round">
                north
            </span>
        </div>
        <div class="ah_content">
            <div id="bot-banner-pc">
                <zone id="kyl31w6h"></zone>
            </div>
            <div id="bot-banner-mb">
                <zone id="kyl31w6h"></zone>
            </div>
        </div>
        <div id="ad-floating-left">
            <zone id="kyl318cb"></zone>
        </div>
        <div id="ad-floating-right">
            <zone id="kyl31w6h"></zone>
        </div>
        <div id="popup" class="display-none">
            <zone id="ktimvs9i"></zone>
        </div>
        <div id="sponsor-balloon" class=""></div>
        <script type="text/javascript">
        let item = 4;
        let documentWidth = $(document).width();
        (documentWidth < 768) ? item = 2: null;
        // (documentWidth > 768 && documentWidth < 1000) ? item = 4: null;
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items: item,
                lazyLoad: true,
                center: true,
                loop: true,
                responsiveClass: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                stagePadding: 50,
            });
            $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [100])
            })
            $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
            })
        });
        </script>
        <script src="/carousel/owl.carousel.min.js"></script>
        {footer}
    </div>
</body>

</html>