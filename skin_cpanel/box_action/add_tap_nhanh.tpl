<script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script>
<script type="text/javascript">
var Notepad = Notepad || {};
tinymce.init({
    selector: '#edit_textarea',
    mode: "exact",
    theme: "modern",
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: ["advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace"],
    toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | bullist numlist | image searchreplace code | removeformat fullscreen",
    image_advtab: true,
    menubar: false,
    height: '250px',
    tabindex: 2,
    relative_urls: false,
    browser_spellcheck: true,
    forced_root_block: false,
    entity_encoding: "raw",
    setup: function(ed) {
        ed.on('init', function() { this.getDoc().body.style.fontSize = '14px'; });
        ed.on('keydown', function() {
            // viet lệnh ở đây
        });
    }
});
</script>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm tập mới cho <span class="color_green">"{tieu_de}"</span></h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="form_group">
                <label for="">Get Folder</label>
                <input type="text" class="form_control" name="folder" value="" placeholder="Nhập id folder...">
            </div>
            <div class="form_group">
                <div class="list_select">
                    <select name="limit">
                        <option value="10">Hiển thị</option>
                        <option value="10">10 kết quả</option>
                        <option value="20">20 kết quả</option>
                        <option value="30">30 kết quả</option>
                        <option value="40">40 kết quả</option>
                        <option value="50">50 kết quả</option>
                        <option value="100">100 kết quả</option>
                        <option value="150">150 kết quả</option>
                        <option value="200">200 kết quả</option>
                    </select>
                    <select name="page">
                        <option value="1">Chọn page</option>
                        <option value="1">Trang 1</option>
                        <option value="2">Trang 2</option>
                        <option value="3">Trang 3</option>
                        <option value="4">Trang 4</option>
                        <option value="5">Trang 5</option>
                        <option value="6">Trang 6</option>
                        <option value="7">Trang 7</option>
                        <option value="8">Trang 8</option>
                        <option value="9">Trang 9</option>
                        <option value="10">Trang 10</option>
                        <option value="11">Trang 11</option>
                        <option value="12">Trang 12</option>
                        <option value="13">Trang 13</option>
                        <option value="14">Trang 14</option>
                        <option value="15">Trang 15</option>
                    </select>
                    <select name="taikhoan">
                        <option value="">Chọn tài khoản</option>
                        <option value="docthaudem">docthaudem</option>
                        <option value="videofull">videofull</option>
                    </select>
                    <select name="domain">
                        <option value="">Chọn domain</option>
                        <option value="streamwish.com">streamwish.com</option>
                        <option value="doodstream.com">doodstream.com</option>
                    </select>
                </div>
            </div>
            <div class="form_group">
                <button class="button_all" name="get_folder"> Bắt đầu Get </button>
            </div>
            <div class="form_group">
                <label for="">Danh sách link video</label>
                <textarea name="list_link" class="list_link"></textarea>
            </div>
            <div style="clear: both;"></div>
            <div class="list_server"></div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="phim" value="{id}">
                <button class="button_all" name="add_tap_nhanh"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.11.0.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!--<div class="box_upload">
    <div class="title">Xử lý upload ảnh <i class="fa fa-close"></i></div>
    <div class="content_upload">
        <div class="list_upload"></div>
    </div>
</div>-->
<input type="file" id="photo-add" name="file" accept="image/*" multiple style="display: none;">
<script type="text/javascript">
    $( ".list_server" ).sortable();
</script>