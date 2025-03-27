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
            <div class="login-page">
                <div class="margin-10-0 bg-black2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Thông tin tài khoản</span></h3>
                    </div>
                </div>
                <div class="ah-form flex flex-column flex-hozi-center ah-frame-bg">
                    <div class="box_form">
                        <div>
                            <div class="box_avatar">
                                <img src="{avatar}" alt="Hình đại diện" id="preview-minhhoa" onerror="this.src='/images/no-images.jpg';">
                            </div>
                            <div class="change_avatar">Chọn ảnh khác</div>
                            <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                        </div>
                        <div>
                            <label>Họ và tên</label>
                            <input type="text" placeholder="Nhập họ và tên hiển thị" value="{name}" name="name">
                        </div>
                        <div>
                            <label>Tài khoản</label>
                            <input type="text" placeholder="Nhập tài khoản,viết liền,không dấu" disabled="disabled" value="{username}" name="username">
                        </div>
                        <div>
                            <label>Linh thạch</label>
                            <input type="text" placeholder="Linh thạch của bạn" disabled="disabled" value="{user_money}" name="user_money">
                        </div>
                        <div>
                            <label>Địa Chỉ Email</label>
                            <input type="email" placeholder="Nhập Email của bạn" value="{email}" disabled="disabled" name="email">
                        </div>
                        <div id="message-line"> </div>
                        <div class="flex flex-hozi-center flex-column">
                            <div class="flex flex-hozi-center">
                                <button type="button" class="button-default color-white bg-red" name="button_profile"><span class="material-icons-round margin-0-5">save</span>Lưu</button>
                            </div>
                        </div>
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