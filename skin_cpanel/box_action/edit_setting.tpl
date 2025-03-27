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
    forced_root_block : false,
    entity_encoding : "raw",
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
		    <h1 class="undefined">Sửa cài đặt</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<div class="col_50">
	      <div class="form_group">
	        <label for="">Mục</label>
	        <input type="text" class="form_control" name="name" value="{name}" disabled="disabled">
	      </div>
		</div>
		<div class="col_50">
		</div>
		<div style="clear: both;"></div>
		<div class="col_100">
	      <div class="form_group">
	        <label for="">Giá trị</label>
	        <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập nội dung..." style="width: 100%;height: 250px;">{value}</textarea>
	      </div>
		</div>
		<div style="clear: both;"></div>
		<div class="form_group">
			<input type="hidden" name="id" value="{name}">
			<button class="button_all" name="edit_setting"> Hoàn thành </button>
		</div>
  	</div>
  </div>
</div>