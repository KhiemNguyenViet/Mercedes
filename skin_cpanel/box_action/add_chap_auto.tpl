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
                <h1 class="undefined">Thêm chap auto cho <span class="color_green">"{tieu_de}"</span></h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="form_group">
                <label for="">Copy nội dung</label>
                <input type="text" class="form_control" name="link_copy" value="" placeholder="Nhập link chap bắt đầu copy...">
            </div>
            <div class="form_group">
                <label for="">Số chap copy</label>
                <input type="text" class="form_control" name="chap_total" value="" placeholder="Nhập số chap sẽ copy...">
                <input type="hidden" name="chap" value="0">
                <input type="hidden" name="truyen" value="{id}">
                <input type="hidden" name="link_next" value="">
            </div>
            <div class="form_group">
                <label for="">Tên server</label>
                <input type="text" class="form_control" name="server" value="1" placeholder="Nhập tên server...">
            </div>
            <div class="form_group">
                <button class="button_all" name="copy_chap_auto"> Copy chap </button>
            </div>
            <div class="ketqua"></div>
        </div>
    </div>
</div>