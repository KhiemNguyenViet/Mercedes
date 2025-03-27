{header}
<body class="scroll-bar animethemes">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <style>
            .material-icons-menu {
                display: grid;
                font-size: 20px;
                text-align: center;
            }

            .fa-search {
                top: 9px;
                font-size: 20px;
                color: #666;
                right: 0;
            }
        </style>
        {navbar}
        <div class="ah_content">
            {box_top}
            <div class="ah-carousel">
                <div class="margin-10-0 bg-black2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Phim Đề Cử</span></h3>
                    </div>
                </div>
                <div class="ah-frame-bg owl-carousel owl-theme">
                    {list_phim_decu}
                </div>
            </div>
            <div class="margin-10-0 bg-black2 flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    <h3 class="section-title"><span>Mới cập nhật</span></h3>
                </div>
                <div class="margin-r-5 fw-500">
<!--                     <a href="/loc-phim.html?loai=2D" class="bg-red padding-5-10 border-default border-radius-5">Phim 2D</a>
                    <a href="/loc-phim.html?loai=3D" class="bg-blue padding-5-10 border-default border-radius-5">Phim 3D</a> -->
                </div>
            </div>
            <div class="movies-list ah-frame-bg">
                {list_phim}
            </div>
            <div class="margin-10-0 bg-black2 flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    <h3 class="section-title"><span>Lịch Chiếu Phim</span></h3>
                </div>
            </div>
            <div class="bg-black w-100-percent flex-column">
                <div class="tab-lichchieu flex-1">
                    <a href="javascript:;" class="lichchieu" id="thu-2" thu="2">
                        <div class="item-label">Thứ 2</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-3" thu="3">
                        <div class="item-label">Thứ 3</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-4" thu="4">
                        <div class="item-label">Thứ 4</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-5" thu="5">
                        <div class="item-label">Thứ 5</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-6" thu="6">
                        <div class="item-label">Thứ 6</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-7" thu="7">
                        <div class="item-label">Thứ 7</div>
                    </a><a href="javascript:;" class="lichchieu" id="thu-8" thu="8">
                        <div class="item-label">CN</div>
                    </a>
                </div>
            </div>
            <div class="movies-list ah-frame-bg" id="LichChieuPhim">
                {lich_chieu}
                <div style="display:block;"></div>
            </div>
            <style>
                .my-rank-profile {
                    max-width: 100%;
                    word-break: break-all;
                    background-color: #333333;
                    border-radius: 15px;
                }
            </style>
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
            $('#thu-{thu}').addClass('active');
        });
        </script>
        <script src="/carousel/owl.carousel.min.js"></script>
        {footer}
    </div>
</body>

</html>