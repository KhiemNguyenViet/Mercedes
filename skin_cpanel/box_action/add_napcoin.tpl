<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm coin cho thành viên</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">User ID</label>
                    <input type="text" class="form_control" name="username" value="" placeholder="Nhập ID Tài khoản...">
                </div>             
                <div class="form_group">
                    <label for="">Thêm coin</label>
                    <input type="text" class="form_control price_format" name="coin" value="" placeholder="Nhập số coin...">
                </div>
                <div class="form_group">
                    <label for="">Nội dung</label>
                    <input type="text" class="form_control" name="noidung" value="" placeholder="Nhập nội dung...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_napcoin" class="button_all"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
    var loai ='{menu_loai}';
    var menu_cat='{menu_cat}';
    var menu_link='{menu_link}';
    var menu_col='{menu_col}';
    var target = '{menu_target}';
    if(loai=='link'){
        $('#select_category').hide();
        $('#select_page').hide();
        $('#input_link').show();
    }else if(loai=='category'){
        $('#select_category').show();
        $('#select_page').hide();
        $('#input_link').hide();
        $('select[name=category]').val(menu_cat);            
    }else if(loai=='page'){
        $('#select_category').hide();
        $('#select_page').show();
        $('#input_link').hide();
        $('select[name=page]').val(menu_link);
    }else{
        $('#select_category').hide();
        $('#select_page').hide();
        $('#input_link').show();
    }
    $('select[name=target]').val(target);
    $('select[name=col]').val(menu_col);
    $("input[name=loai][value=" + loai + "]").prop('checked', true);
</script>