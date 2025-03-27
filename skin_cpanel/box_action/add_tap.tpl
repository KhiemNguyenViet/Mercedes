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
                <label for="">Copy nội dung</label>
                <input type="text" class="form_control" name="link_copy" value="" placeholder="Nhập link copy tập...">
            </div>
            <div class="form_group">
                <button class="button_all" name="copy_tap"> Copy tập </button>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Tên tập</label>
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tên chap...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="list_server">
                <div class="col_100 block_server">
                    <div class="form_group">
                        <label for="">Tên server</label>
                        <input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server...">
                    </div>
                    <div class="form_group">
                        <label for="">Link video</label>
                        <input type="text" class="form_control" name="nguon" value="" placeholder="Nhập link video...">
                    </div>
                    <button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <div class="col_100 block_bottom">
                <div class="form_group">
                    <button class="add_server"><i class="fa fa-plus"></i> Thêm server</button>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự hiển thị...">
                    <input type="hidden" name="phim" value="{id}">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="add_tap"> Hoàn thành </button>
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