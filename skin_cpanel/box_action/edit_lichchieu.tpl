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
                <h1 class="undefined">Sửa lịch chiếu phim</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Phim</label>
                    <div class="list_phim">
                        {list_phim}
                    </div>
                </div>
                <div class="form_group">
                    <label for="">Ngày chiếu</label>
                    <div style="clear: both;"></div>
                    {list_thu}
                </div>
                <div class="form_group">
                    <label for="">Hiển thị</label>
                    <div style="clear: both;"></div>
                    <div class="li_input" id="input_2"><input type="radio" name="an" value="0"> <span>Có</span></div>
                    <div class="li_input" id="input_3"><input type="radio" name="an" value="1"> <span>Không</span></div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="edit_lichchieu"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var an='{an}';
        $("input[name=an][value=" + an + "]").prop('checked', true);
    })
</script>