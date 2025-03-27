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
                <a href="/dang-nhap.html" class="item-tab-link"><span class="material-icons-round material-icons-menu margin-0-5">login</span>
                    <div class="item-label">Login</div>
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
                <a href="/dang-nhap.html" class="item-tab-link"><span class="material-icons-round material-icons-menu margin-0-5">login</span>
                    <div class="item-label">Đăng Nhập</div>
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
        </div>
    </div>
</div>