<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa menu</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">kiểu menu</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="loai" value="link" checked="checked">Liên kết ngoài  <input type="radio" name="loai" value="category"> Thể loại  <input type="radio" name="loai" value="page"> Trang <input type="radio" name="loai" value="post"> Bài viết
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Vi trị</label>
                    <select class="form_control" name="vi_tri">
                        <option value="top">Menu chính</option>
                        <option value="page">Menu Page</option>
                        <option value="tag">Menu footer</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Thuộc menu</label>
                    <select class="form_control" name="main_id">
                        <option value="0">Menu chính</option>
                        {option_main}
                    </select>
                </div>
                <div class="form_group" style="display: block;" id="select_col">
                    <label for="">Số cột sub</label>
                    <select class="form_control" name="col">
                        <option value="1">1 cột</option>
                        <option value="2">2 cột</option>
                        <option value="3">3 cột</option>
                        <option value="4">4 cột</option>
                        <option value="5">5 cột</option>
                    </select>
                </div> 
                <div class="form_group" style="display: none;" id="select_category">
                    <label for="">Chọn thể loại</label>
                    <select class="form_control" name="category">
                        <option>Chọn thể loại</option>
                    	{option_category}
                    </select>
                </div>
                <div class="form_group" style="display: none;" id="select_page">
                    <label for="">Chọn trang</label>
                    <select class="form_control" name="page">
                        <option value="/truyen-hoan-thanh.html">Truyện full</option>
                        <option value="/truyen-tranh-moi.html">Truyện mới</option>
                        <option value="/truyen-moi-cap-nhat.html">Truyện mới cập nhật</option>
                        <option value="/truyen-tranh-hot.html">Truyện hot</option>
                        <option value="/top-ngay.html">Top ngày</option>
                        <option value="/top-tuan.html">Top tuần</option>
                        <option value="/top-thang.html">Top tháng</option>
                        <option value="/top-nam.html">Top năm</option>
                    </select>
                </div> 
                <div class="form_group" style="display: none;" id="select_post">
                    <label for="">Chọn bài viết</label>
                    <select class="form_control" name="post">
                        <option>Chọn bài viết</option>
                        {option_post}
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{menu_tieude}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group" id="input_link">
                    <label for="">Link</label>
                    <input type="text" class="form_control" name="link" value="{menu_link}" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mở</label>
                    <select class="form_control" name="target">
                        <option value="">Cửa sổ hiện tại</option>
                        <option value="_blank">Cửa sổ mới</option>
                    </select>
                </div>               
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{menu_thutu}" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{menu_id}">
                <button name="edit_menu" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var loai ='{menu_loai}';
    var menu_cat='{menu_cat}';
    var menu_link='{menu_link}';
    var menu_vitri='{menu_vitri}';
    var menu_col='{menu_col}';
    var target = '{menu_target}';
    if(loai=='link'){
        $('#select_category').hide();
        $('#select_page').hide();
        $('#select_post').hide();
        $('#input_link').show();
    }else if(loai=='category'){
        $('#select_category').show();
        $('#select_page').hide();
        $('#select_post').hide();
        $('#input_link').hide();
        $('select[name=category]').val(menu_cat);            
    }else if(loai=='page'){
        $('#select_category').hide();
        $('#select_page').show();
        $('#select_post').hide();
        $('#input_link').hide();
        $('select[name=page]').val(menu_link);
    }else if(loai=='post'){
        $('#select_category').hide();
        $('#select_page').hide();
        $('#select_post').show();
        $('#input_link').hide();
        $('select[name=page]').val(menu_link);
    }else{
        $('#select_category').hide();
        $('#select_page').hide();
        $('#select_post').hide();
        $('#input_link').show();
    }
    $('select[name=target]').val(target);
    $('select[name=col]').val(menu_col);
    $('select[name=vi_tri]').val(menu_vitri);
    $("input[name=loai][value=" + loai + "]").prop('checked', true);
</script>