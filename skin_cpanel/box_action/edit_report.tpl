<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa báo lỗi</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">Thời gian</label>
                    <input type="text" class="form_control" name="date_post" value="{date_post}" disabled="" placeholder="Thời gian...">
                </div>
                <div class="form_group">
                    <label for="">Tài khoản</label>
                    <input type="text" class="form_control" name="username" value="{username}" disabled="" placeholder="Nhập Tài khoản...">
                </div>             
                <div class="form_group">
                    <label for="">Truyện</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" disabled="" placeholder="Tên truyện...">
                </div>
                <div class="form_group">
                    <label for="">Lỗi</label>
                    <input type="text" class="form_control" name="loi" value="{loi}" disabled="" placeholder="Lỗi...">
                </div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <textarea class="form_control" cols="30" rows="20">{noidung}</textarea>
                </div>
                <div class="form_group">
                    <label for="">Tình trạng</label>
                    <select class="form_control" name="tinh_trang">
                        <option value="1">Đã xác nhận</option>
                        <option value="2">Đã fix</option>
                        <option value="3">Báo sai</option>
                        <option value="0">Mới</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_report" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var tinh_trang='{tinh_trang}';
        $('select[name=tinh_trang]').val(tinh_trang);  

    });
</script>