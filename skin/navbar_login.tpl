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
<div class="note_top">
    <div class="content_note">
        <div class="avatar_note">
            <img src="/images/index.svg">
        </div>
        <div class="info_note">
            <div class="name_note"></div>
            <div class="text_note"></div>
        </div>
        <div class="close_note">
            <i class="fa fa-close"></i>
        </div>
    </div>
</div>
<div id="navbar">
    <div>
        <div class="search-bar flex flex-1 margin-0-10 padding-10">
            <a class="logo" style="padding: 0px 15px;margin-top: auto;" href="/"><img src="/skin/css/images/logo.png" alt="logo animehay" /></a>
            <form onsubmit="handlingSearch();return false" class="flex" id="form-search" action="/tim-kiem.html">
                <input type="text" placeholder="Từ khóa tìm kiếm..." class="padding-10 bg-black color-gray" style="width: 100%;height: 18px;" name="keyword">
                <button type="submit" class="flex h-38 flex-hozi-center bg-black color-gray">
                    <span class="material-icons-round">search</span>
                </button>
            </form>
<!--             <a href="javascript:;" id="toggle-notification" class="toggle-dropdown bg-black padding-0-10 h-38 episode_latest flex flex-hozi-center fw-700 load-notification relative" bind="drop-down-3">
                <span class="material-icons-round material-icons-menu">notifications</span>
            </a> -->
        </div>
    </div>
    <div>
        <div id="MenuHeader" class="w-100-percent flex-column">
            <div class="tab-links flex-1" style="width: 100%;height: 100%;" id="menu_mobile">
                <a href="javascript:;" class="toggle-dropdown" bind="tab-cate">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        category
                    </span>
                    <div class="item-label">Thể loại</div>
                </a>
                <a href="javascript:;" class="toggle-dropdown" bind="tab-years">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        auto_awesome
                    </span>
                    <div class="item-label">Năm</div>
                </a>
                <a href="/loc-phim.html" class="item-tab-link"><span class="material-icons-round material-icons-menu margin-0-5">
                        filter_alt
                    </span>
                    <div class="item-label">Lọc</div>
                </a>
                <a href="javascript:;" onclick="clickEventDropDown(this,'account_circle','Hồ Sơ');" class="toggle-dropdown" bind="drop-down-2">
                    <span class="material-icons-round material-icons-menu">account_circle</span>
                    <div class="item-label">Hồ Sơ</div>
                </a>
            </div>
            <div class="tab-links flex-1" style="width: 100%;height: 100%;" id="menu_laptop">
                <a href="javascript:;" class="toggle-dropdown" bind="tab-cate">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        category
                    </span>
                    <div class="item-label">Thể loại</div>
                </a>
                <a href="javascript:;" class="toggle-dropdown" bind="tab-years">
                    <span class="material-icons-round material-icons-menu margin-0-5">
                        auto_awesome
                    </span>
                    <div class="item-label">Năm</div>
                </a>
                <a href="/loc-phim.html" class="item-tab-link"><span class="material-icons-round material-icons-menu margin-0-5">
                        filter_alt
                    </span>
                    <div class="item-label">Lọc Phim</div>
                </a>
                <a href="/theo-doi.html"><span class="material-icons-round material-icons-menu">
                        bookmarks
                    </span>
                    <div class="item-label">Lưu</div>
                </a>
                <a href="/lich-su.html"><span class="material-icons-round material-icons-menu">
                        history
                    </span>
                    <div class="item-label">Lịch Sử</div>
                </a>
                <a href="javascript:;" onclick="clickEventDropDown(this,'account_circle','Hồ Sơ');" class="toggle-dropdown" bind="drop-down-2">
                    <span class="material-icons-round material-icons-menu">account_circle</span>
                    <div class="item-label">Hồ Sơ</div>
                </a>
            </div>
            <div class="tab-content">
                <div id="tab-cate" class="item-tab-content">
                    <div class="flex flex-wrap">
                        {list_theloai}
                    </div>
                </div>
                <div id="tab-years" class="item-tab-content">
                    <div class="flex flex-wrap">
                        {list_nam}
                    </div>
                </div>
            </div>
            <div id="drop-down-2" class="dropdown-menu bg-black flex-column">
                <div class="row-1 flex flex-column flex-hozi-center">
                    <div class="avatar">
                        <img src="{avatar}" alt="Hình đại diện" onerror="this.src='/images/no-images.jpg';">
                    </div>
                    <div class="nickname fs-17 fw-700 margin-t-10 color-yellow">{name}</div>
                </div>
                <a href="/tai-khoan.html" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">account_box</span> Thông tin</a>
                <a href="/theo-doi.html" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">bookmarks</span> Theo dõi</a>
                <a href="/lich-su.html" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">history</span> Lịch sử</a>
                <a href="/doi-mat-khau.html" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">password</span>Thay đổi mật khẩu</a>
                <a href="/dang-xuat.html" class="flex flex-hozi-center"><span class="material-icons-round margin-0-5">logout</span>Đăng xuất</a>
            </div>
            <div id="drop-down-3" class="dropdown-menu bg-black flex-column">
                <div class="fw-500 margin-10 flex flex-hozi-center">
                    <div class="flex-1 fs-19">Thông Báo</div>
                    <div>
                        <a href="/thong-bao">Xem tất cả</a>
                    </div>
                </div>
                <div id="list-item-notification" class="scroll-bar"></div>
            </div>
        </div>
    </div>
</div>
<script>
function clickEventDropDown(this_dropdown, icon_default = "Null", NameLabel = "") {
    $('#MenuHeader .tab-links a').not(this).removeClass('active');
    $('#tab-cate').removeClass('display-block');
    $('#tab-years').removeClass('display-block');
    var _name = this_dropdown.getAttribute("bind");
    var _dropdown_menu = document.getElementById(_name);
    var screenWidth = $(window).width();
    if (!_dropdown_menu.style.display || _dropdown_menu.style.display === "none") {
        this_dropdown.innerHTML = `<span class="material-icons-round material-icons-menu">highlight_off</span>`;
        if (icon_default !== "expand_more") {
            this_dropdown.style.backgroundColor = "#ab3e3e";
        }
        _dropdown_menu.style.display = "flex";
        if(screenWidth>768){
            if(_name=='drop-down-2'){
                _dropdown_menu.style.width = "calc(100%/6)";
            }
        }else{

        }
        setTimeout(function() {
            _dropdown_menu.style.transform = "scale(1)";
        }, 50)
    } else {
        _dropdown_menu.style = null;
        this_dropdown.style = null;
        setTimeout(function() {
            $(`#${_name}`).removeClass("display-block");
            $(this_dropdown).removeClass("active");
        }, 50);
        this_dropdown.innerHTML = `<span class="material-icons-round material-icons-menu">${icon_default}</span><div class="item-label">${NameLabel}</div>`;
    }
}
</script>