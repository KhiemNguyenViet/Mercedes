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
                <h1 class="undefined">Chỉnh sửa gói premium</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tên gói</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tên gói...">
                </div>
                <div class="form_group">
                    <label for="">Số ngày premium</label>
                    <input type="text" class="form_control" name="expired" value="{expired}" placeholder="Nhập số ngày premium...">
                </div>
                <div class="form_group">
                    <label for="">Giá gói</label>
                    <input type="text" class="form_control" name="price" value="{price}" placeholder="Nhập giá gói premium...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" value="{id}" name="id">
                <button class="button_all" name="edit_premium"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>