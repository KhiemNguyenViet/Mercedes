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
                        <h3 class="section-title"><span>Đăng ký thành viên</span></h3>
                    </div>
                </div>
                <div class="ah-form flex flex-column flex-hozi-center ah-frame-bg">
                    <div class="box_form">
                        <div>
                            <label>Tài khoản</label>
                            <input type="text" placeholder="Nhập tài khoản,viết liền,không dấu" value="" name="username">
                        </div>
                        <div>
                            <label>Địa Chỉ Email</label>
                            <input type="email" placeholder="Nhập Email của bạn" value="" name="email">
                        </div>
                        <div>
                            <label>Mật khẩu</label>
                            <input type="password" placeholder="Nhập mật khẩu của bạn" name="password">
                        </div>
                        <div>
                            <label>Nhập Lại Mật khẩu</label>
                            <input type="password" placeholder="Nhập Lại mật khẩu của bạn" name="re_password">
                        </div>
                        <div id="message-line"> </div>
                        <div class="flex flex-hozi-center flex-column">
                            <div class="flex flex-hozi-center">
                                <button type="button" class="button-default color-white bg-red" id="button_register">Đăng Ký</button>
                                <b style="padding: 10px;">Hoặc</b>
                                <a href="/dang-nhap.html" class="button-default bg-green margin-5-0 padding-10-20">Đăng Nhập</a>
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