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
            <div class="watching-movie">
                <div id="intro-vip" class="display-none">
                    <div>Chức Năng Này Đang Được Phát Triển</div>
                </div>
                <div id="settings-while-watching" class="display-none">
                    <div class="flex flex-ver-center flex-hozi-center flex-column align-center">
                        <div class="fs-17 fw-500 color-yellow">
                            Chỉ áp dụng cho server </div>
                        <div class="padding-5 fw-500">Tự động chuyển tập mới ở mốc thời gian :</div>
                        <label class="switch">
                            <input type="checkbox" class="auto-open-next-ep" onchange="aoneEvent(event)"><span class="slider round"></span></label>
                        <div class="padding-5">
                            <div class="aone-on display-none flex-hozi-center">
                                <input name="aone-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneMin(event)" type="number" />
                                <b class="fs-19 margin-0-5">:</b>
                                <input name="aone-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneSec(event)" type="number" />
                            </div>
                        </div>
                        <div class="padding-5 fw-500">Tự động Bỏ Qua Openning :</div>
                        <label class="switch">
                            <input type="checkbox" class="skip-op" onchange="skipOpEvent(event)"><span class="slider round"></span></label>
                        <div class="padding-5">
                            <div class="turn-on-skip-op display-none flex-hozi-center">
                                <input name="skip-op-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpMin(event)" type="number" />
                                <b class="fs-19 margin-0-5">:</b>
                                <input name="skip-op-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpSec(event)" type="number" />
                            </div>
                        </div>
                        <div class="padding-5 fw-500">Tự động bật chế độ Night(<b class="color-red-2">VIP</b>)</div>
                        <div>
                            <label class="switch"><input type="checkbox" class="auto-turn-on-night-mode" onchange="atonmEvent(event)"><span class="slider round"></span></label>
                        </div>
                        <div class="padding-5 fw-500">Tự động phóng to khi ấn nút Play</div>
                        <div>
                            <label class="switch"><input type="checkbox" class="auto-full-screen" onchange="afsEvent(event)"><span class="slider round"></span></label>
                        </div>
                    </div>
                </div>
                <div class="ah-frame-bg fw-700 margin-10-0 bg-black">
                    <a href="/thong-tin-phim/{link}-{phim}.html" class="fs-16 flex flex-hozi-center color-yellow border-style-1"><span class="material-icons-round margin-0-5">
                            movie
                        </span>{ten_phim}</a>
                    <div class="flex flex-space-auto">
                        <span>Đang xem {ten_tap}</span>
                    </div>
                </div>
                <div class="control-bar flex flex-space-between bg-cod-gray">
                    <div class="bg-black flex flex-hozi-center fw-500 fs-17 padding-0-10 height-50 border-l-b-t">
                        <div class="margin-10-0 bg-brown flex flex-space-auto">
                            <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">{ten_tap} </div>
                        </div>
                    </div>
                    <div class="bg-black flex flex-hozi-center fs-17 padding-0-10 height-50 border-r-b-t">
                        <a href="javascript:void(0);" title="Theo dõi phim này" id="toggle_follow" class="button-default padding-5 bg-primary fs-21" title="Theo Dõi">
                            <span class="material-icons-round material-icons-menu">bookmark_add</span>
                        </a>
                        <a href="/thong-tin-phim/{link}-{phim}.html" class="button-default padding-5 bg-brown fs-21" title="Thông tin phim"><span class="material-icons-round">
                                info
                            </span>
                        </a>
                        <button id="report_error" class="button-default padding-5 bg-red fs-21 color-white"><span class="material-icons-round">
                                report_problem
                            </span>
                        </button>
                    </div>
                </div>
                <link rel="stylesheet" href="/hhplayer/netflix.css">
                <script src="/hhplayer/jwplayer.js"></script>
                <script src="/hhplayer/vast.js"></script>
                <script src="/hhplayer/hls.min.js"></script>
                <script src="/hhplayer/jwplayer.hlsjs.min.js"></script>
                <script src="/hhplayer/tvc.js"></script>
                <script type="text/javascript">
                jwplayer.key = "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=";
                </script>
                <div id="video-player">
                    <div class="loading" style="text-align: center;margin-bottom: 15px;"><div><img src="/images/index.svg" alt="" width="100px" height="100px;"></div><b>Đang tải player vui lòng chờ...</b></div>
                </div>
                <div class="js_player"></div>
                <div id="list_sv"><span>Server: </span><div>{list_server}</div></div>
                <div class="flex flex-ver-center margin-10">
<!--                     <div class="button-default flex flex-hozi-center fw-700 bg-lochinvar" onclick="middleBoxScreen({title:'Cài đặt tính năng xem phim',elem:getElem('settings-while-watching')})">
                        <span class="material-icons-round ">
                            settings
                        </span>
                    </div>
                    <div class="button-default flex flex-hozi-center fw-700 bg-blue" id="toggle-light">
                        <span class="material-icons-round ">
                            nightlight
                        </span>Night
                    </div>
                    <div class="button-default flex flex-hozi-center fw-700 bg-red" onclick="middleBoxScreen({title:'Giới thiệu tính năng VIP',elem:getElem('intro-vip')})">
                        <span class="material-icons-round ">
                            block
                        </span>Ads
                    </div> -->
                    <div>
                        <a href="javascript:;" class="button-default padding-10-20 flex flex-hozi-center fw-700 prev_ep"> <span class="material-icons-round ">
                                arrow_back_ios
                            </span>Tập trước</a>
                    </div>
                    <div>
                        <a href="javascript:;" class="button-default padding-10-20 flex flex-hozi-center fw-700 next_ep">Tập tiếp<span class="material-icons-round ">
                                arrow_forward_ios
                            </span></a>
                    </div>
                </div>
                <div id="PlayerAds" style="text-align: center;"></div>
                <div class="ah-frame-bg">
                    <div class="heading flex flex-hozi-center fw-700 color-red-2">
                        <span class="material-icons-round margin-0-5">
                            note
                        </span>Ghi chú
                    </div>
                    <div>
                        <p><strong></strong></p>
                        <p><strong><span style="color:#FFA500">{text_lich}</span></strong></p>
                        <p></p>
                    </div>
                </div>
                <div class="list_episode ah-frame-bg" id="list-episode">
                    <div class="heading flex flex-space-auto fw-700">
                        <span>Danh sách tập</span>
                        <span id="newest-ep-is-readed" class="fs-13"></span>
                    </div>
                    <div class="list-item-episode scroll-bar">{list_tap}</div>
                </div>
                <div class="ah-frame-bg bind_movie">
                    <div>
                        <h2 class="heading">Từ Khóa</h2>
                    </div>
                    <div class="scroll-bar">
                        {list_tags}
                    </div>
                </div>
                {box_comment}
            </div>
            <div class="opacity">
                {list_h}
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