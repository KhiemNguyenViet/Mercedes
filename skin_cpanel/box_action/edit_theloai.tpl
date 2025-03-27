<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa thể loại</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Link copy</label>
                    <input type="text" class="form_control" name="link_copy" value="" placeholder="Nhập link copy thể loại...">
                </div>
                <div class="form_group">
                    <button class="button_all" name="copy_category"> Copy thể loại </button>
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Danh mục mẹ</label>
                    <select class="form_control" name="cat_main">
                        <option value="0">Danh mục chính</option>
                        {option_main}
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control tieude_seo" name="cat_tieude" onkeyup="check_blank();" value="{cat_tieude}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Link xem</label>
                    <input type="text" class="form_control link_seo" name="cat_blank" onkeyup="check_link();" value="{cat_blank}" placeholder="Nhập link xem...">
                    <input type="hidden" name="link_old" id="link_old" value="{cat_blank}">
                    <div class="check_link"></div>
                </div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <textarea name="cat_noidung" class="form_control" placeholder="Nhập nội dung thể loại" style="width: 100%;height: 95px;">{cat_noidung}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Title</label>
                    <input type="text" class="form_control" name="cat_title" value="{cat_title}" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Description</label>
                    <textarea name="cat_description" class="form_control" placeholder="Nhập mô tả thể loại" style="width: 100%;height: 95px;">{cat_description}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="cat_thutu" value="{cat_thutu}" placeholder="Nhập thứ tự...">
                </div>
                <div class="form_group" style="display: none;">
                    <label for="">Icon</label>
                    <input type="text" class="form_control" name="cat_icon" value='{cat_icon}' placeholder="Nhập biểu tưởng...">
                </div>
                <div class="form_group">
                    <label for="">Hiện index</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="cat_index" value="1"> Có <input type="radio" name="cat_index" value="0" checked=""> không
                </div> 
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{cat_id}">
                <button name="edit_theloai" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var cat_index ='{cat_index}';
    $("input[name=cat_index][value=" + cat_index + "]").prop('checked', true);
</script>