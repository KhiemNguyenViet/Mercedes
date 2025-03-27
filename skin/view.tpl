{header}

<body class="scroll-bar">
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
            <div id="top-banner-pc">
                <zone id="kyl30cr3"></zone>
            </div>
            <div id="top-banner-mb">
                <zone id="kyl3axj2"></zone>
            </div>
            <div class="info-movie">
                <div id="modal" class="modal" style="display:none;">
                    <div>
                        <div>Đánh giá phim</div>
                        <a href="javascript:;"><span class="material-icons-round margin-0-5">
                                close
                            </span></a>
                    </div>
                    <div>
                        <div class="rated-star flex flex-hozi-center flex-ver-center">
                            <span rate='1'><span class="material-icons-round">star</span></span><span rate='2'><span class="material-icons-round">star</span></span><span rate='3'><span class="material-icons-round">star</span></span><span rate='4'><span class="material-icons-round">star</span></span><span rate='5'><span class="material-icons-round">star</span></span><span rate='6'><span class="material-icons-round">star</span></span><span rate='7'><span class="material-icons-round">star</span></span><span rate='8'><span class="material-icons-round">star</span></span><span rate='9'><span class="material-icons-round">star</span></span>
                        </div>
                    </div>
                </div>
                <h1 class="heading_movie">{tieu_de}</h1>
                <div class="head ah-frame-bg">
                    <div class="first" style="position: relative;">
                        <img onclick="location.href = '/xem-phim/{link}-episode-id-{tap_moi}.html'" src="{minh_hoa}" alt="{tieu_de}" />
                    </div>
                    <div class="last">
                        <div class="list_cate">
                            <div>Thể loại</div>
                            <div>
                                {list_cat}
                            </div>
                        </div>
                        <div class="name_other">
                            <div>Tên khác</div>
                            <div>{ten_khac}</div>
                        </div>
                        <div class="status">
                            <div>Trạng thái</div>
                            <div>{status}</div>
                        </div>
<!--                         <div class="score">
                            <div>Điểm</div>
                            <div>{rate} || {rate_number} đánh giá </div>
                        </div> -->
                        <div class="update_time">
                            <div>Phát hành</div>
                            <div>{nam}</div>
                        </div>
                        <div class="duration">
                            <div>Thời lượng</div>
                            <div>{thoi_luong}</div>
                        </div>
<!--                         <div class="duration">
                            <div>Lượt Xem</div>
                            <div>{view}</div>
                        </div> -->
                    </div>
                </div>
                <div class="flex ah-frame-bg flex-wrap">
                    <div class="flex flex-wrap flex-1 list_action_left">
                        <input type="hidden" name="phim" value="{phim}">
                        <a href="/xem-phim/{link}-episode-id-{tap_moi}.html" class="padding-5-15 button-default fw-500 flex flex-hozi-center bg-lochinvar button_xemphim" title="Xem Ngay">
                            <span class="material-icons-round">play_circle_outline</span><span>xem phim</span>
                        </a>
                        {button_follow}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={link_xem}" style="background-color: #2374e1;" class="padding-5-15 button-default fw-500 flex flex-hozi-center" title="Chia Sẻ Lên Facebook" target="_blank"><span class="material-icons-round">share</span></a>
                    </div>
                    <div class="last">
<!--                         <div id="rated" class="bg-orange padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center"><span class="material-icons-round">
                                stars
                            </span></div> -->
                    </div>
                </div>
                <div class="body">
                    <div class="list_episode ah-frame-bg">
                        <div class="heading flex flex-space-auto fw-700">
                            <span>Danh sách tập</span>
                            <span id="newest-ep-is-readed" class="fs-13"></span>
                        </div>
                        <div class="list-item-episode scroll-bar">
                            {list_tap}
                        </div>
                    </div>
                    <div class="desc ah-frame-bg list_episode">
                        <div>
                            <h2 class="heading">
                                Nội dung
                            </h2>
                        </div>
                        <div class="list-item-episode scroll-bar" style="line-height: 22px;">
                            <p>
                                {content}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ah-frame-bg bind_movie">
                    <div>
                        <h2 class="heading">Tags Phim</h2>
                    </div>
                    <div class="scroll-bar">
                        {list_tags}
                    </div>
                </div>
                {box_comment}
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