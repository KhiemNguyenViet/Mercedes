<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chặn ip mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Địa chỉ ip</label>
                    <input type="text" class="form_control" name="ip_address" value="" placeholder="Nhập địa chỉ ip...">
                </div>             
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_block" class="button_all"> Hoàn thành </button>
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