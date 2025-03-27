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
                <h1 class="undefined">Thêm phim mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Link copy</label>
                    <input type="text" class="form_control" name="link_copy" value="" placeholder="Nhập link copy phim...">
                </div>
                <div class="form_group">
                    <button class="button_all" name="copy_truyen"> Copy truyện </button>
                </div>
                <div class="form_group">
                    <label for="">Tên phim</label>
                    <input type="text" class="form_control tieude_seo" name="tieu_de" onkeyup="check_blank();" value="" placeholder="Nhập tên phim...">
                </div>
                <div class="form_group">
                    <label for="">Tên khác</label>
                    <input type="text" class="form_control" name="ten_khac" value="" placeholder="Nhập tên khác (nếu có)...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="link" onkeyup="check_link();" value="" placeholder="Nhập link xem...">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Thời lượng</label>
                    <input type="text" class="form_control" name="thoi_luong" value="" placeholder="Nhập thời lượng...">
                </div>
                <div class="form_group">
                    <label for="">Năm sản xuất</label>
                    <input type="text" class="form_control" name="nam" value="" placeholder="Nhập năm sản xuất...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="/images/no-images.jpg" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Danh mục</label>
                    <div style="clear: both;"></div>
                    {option_category}
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <label for="">Chi tiết</label>
                    <textarea name="content" class="form_control" id="edit_textarea" placeholder="Nhập chi tiết phim" style="width: 100%;height: 250px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="title" value="" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="description" class="form_control" placeholder="Nhập mô tả phim" style="width: 100%;height: 95px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Tags</label>
                    <textarea name="tags" class="form_control" placeholder="Nhập từ khóa tìm kiếm, mỗi từ khóa cách nhau bằng dấu phẩy" style="width: 100%;height: 95px;"></textarea>
                </div>
                <div class="form_group">
                    <label for="">Phim Full</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="full" value="1"> Đã full <input type="radio" name="full" value="0" checked=""> Chưa full
                </div> 
                <div class="form_group">
                    <label for="">Phim Hot</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="hot" value="1"> Có <input type="radio" name="hot" value="0" checked=""> không
                </div>
                <div class="form_group">
                    <label for="">Phim Mới</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="moi" value="1"> Có <input type="radio" name="moi" value="0" checked=""> không
                </div>
                <div class="form_group">
                    <label for="">Loại hình</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="loai_hinh" value="2D"> 2D <input type="radio" name="loai_hinh" value="3D" checked=""> 3D <input type="radio" name="loai_hinh" value="Movie" checked=""> Movie
                </div> 
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button class="button_all" name="add_phim"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>