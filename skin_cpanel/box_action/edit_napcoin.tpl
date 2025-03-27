<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa nạp coin</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tài khoản</label>
                    <input type="text" class="form_control" name="username" value="{user_id}" disabled="" placeholder="Nhập ID Tài khoản...">
                </div>             
                <div class="form_group">
                    <label for="">Thêm coin</label>
                    <input type="text" class="form_control price_format" name="coin" value="{coin}" placeholder="Nhập số coin...">
                </div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <input type="text" class="form_control" name="noidung" value="{noidung}" placeholder="Nhập nội dung...">
                </div>
                <div class="form_group">
                    <label for="">Tình trạng</label>
                    <select class="form_control" name="status">
                        <option value="0">Chọn tình trạng</option>
                        <option value="1">Hoàn thành</option>
                        <option value="99">Chờ duyệt</option>
                        <option value="2">Sai mệnh giá</option>
                        <option value="3">Thẻ không đúng</option>
                        <option value="0">Lỗi không xác định</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_napcoin" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    $('select[name=status]').val({status});
</script>