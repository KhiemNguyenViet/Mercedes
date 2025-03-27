<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm menu mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">kiểu menu</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="loai" value="link" checked="checked">Liên kết ngoài  <input type="radio" name="loai" value="category"> Thể loại truyện <input type="radio" name="loai" value="page"> Trang <input type="radio" name="loai" value="post"> Bài viết
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
                    <input type="text" class="form_control" name="tieu_de" value="" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group" id="input_link">
                    <label for="">Link</label>
                    <input type="text" class="form_control" name="link" value="" placeholder="Nhập title...">
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
                    <input type="text" class="form_control" name="thu_tu" value="" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_menu" class="button_all"> Thêm </button>
            </div>
        </div>
    </div>
</div>