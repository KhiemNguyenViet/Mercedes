{header}
<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        {navbar}
        <div class="ah_content">
            {box_top}
            <div id="filter-page">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Chức năng lọc phim</span></h3>
                    </div>
                </div>
                <div id="filter-movie">
                    <div class="li_select">
                        <select name="cat">
                            <option value="">Chọn thể loại</option>
                            <option value="all">Tất cả</option>
                            {option_theloai}
                        </select>
                    </div>
                    <div class="li_select">
                        <select name="nam">
                            <option value="">Chọn năm</option>
                            <option value="all">Tất cả</option>
                            {option_nam}
                        </select>
                    </div>
                    <div class="li_select">
                        <select name="loai_phim">
                            <option value="">Loại phim</option>
                            <option value="all">Tất cả</option>
                            <option value="3D">Phim 3D</option>
                            <option value="2D">Phim 2D</option>
                        </select>
                    </div>
                    <div class="li_select">
                        <select name="full">
                            <option value="">Trạng thái</option>
                            <option value="all">Tất cả</option>
                            <option value="1">Hoàn thành</option>
                            <option value="0">Đang cập nhật</option>
                        </select>
                    </div>
                    <div class="li_select">
                        <button id="loc_phim">Lọc phim</button>
                    </div>
                </div>
                <div class="movies-list">
                    {list_phim}
                </div>
                <div class="pagination">
                    <div>{phantrang}</div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('select[name=loai_phim]').val('{loai}');
                $('select[name=full]').val('{full}');
                $('select[name=nam]').val('{nam}');
                $('select[name=cat]').val('{cat_blank}');
            });
        </script>
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
        });
        </script>
        <script src="/carousel/owl.carousel.min.js"></script>
        {footer}
    </div>
</body>

</html>