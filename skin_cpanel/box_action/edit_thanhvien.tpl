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
        <div class="list_tab">
            <a href="javascript:;" class="active" id="tab_thongtin">Thông tin</a><a href="javascript:;" id="tab_napcoin">Lịch sử nạp coin</a><a href="javascript:;" id="tab_donate">Lịch sử donate</a><a href="javascript:;" id="tab_muachap">Lịch sử mua chap</a><a href="javascript:;" id="tab_history">Lịch sử đọc truyện</a><a href="javascript:;" id="tab_report">Lịch sử báo lỗi</a>
        </div>
        <div class="box_profile" id="tab_thongtin_content">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa thành viên</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tài khoản</label>
                    <input type="text" class="form_control" name="username" value="{username}" disabled="" placeholder="Tài khoản...">
                </div>
                <div class="form_group">
                    <label for="">Email</label>
                    <input type="text" class="form_control" name="email" value="{email}" disabled="" placeholder="Nhập email...">
                </div>
                <div class="form_group">
                    <label for="">Họ và tên</label>
                    <input type="text" class="form_control" name="name" value="{name}" placeholder="Nhập họ và tên...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <div class="mh" style="cursor: pointer;">
                        <img src="{avatar}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                    </div>
                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                </div>
                <div class="form_group">
                    <label for="">Coin</label>
                    <input type="text" class="form_control price_format" name="coin" value="{user_money}" placeholder="Số coin hiện có...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tình trạng</label>
                    <select class="form_control" name="active">
                        <option value="1">Bình thường</option>
                        <option value="2">Tạm khóa</option>
                        <option value="3">Khóa vĩnh viễn</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{user_id}">
                <button class="button_all" name="edit_thanhvien"> Lưu lại </button>
            </div>
        </div>
        <div class="box_profile" id="tab_napcoin_content" style="width: 100%;padding: 10px;display: none;">
            <div class="page_title">
                <h1 class="undefined">Danh sách nạp coin</h1>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
                .list_baiviet i{
                    font-size: 35px;
                }
            </style>
            <table class="list_baiviet">
                <tr class="th">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Coin</th>
                    <th style="text-align: left;" class="hide_mobile">Nội dung</th>
                    <th style="text-align: center;" class="hide_mobile">Thời gian</th>
                    <th style="text-align: center;width: 100px;">Hành động</th>
                </tr>
            </table>
            <div class="phantrang"></div>
        </div>
        <div class="box_profile" id="tab_donate_content" style="width: 100%;padding: 10px;display: none;">
            <div class="page_title">
                <h1 class="undefined">Danh sách donate</h1>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
                .list_baiviet i{
                    font-size: 35px;
                }
            </style>
            <table class="list_baiviet">
                <tr class="th">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tài khoản nhận</th>
                    <th style="text-align: left;">Coin</th>
                    <th style="text-align: left;" class="hide_mobile">Truyện</th>
                    <th style="text-align: center;" class="hide_mobile">Thời gian</th>
                    <th style="text-align: center;width: 100px;">Hành động</th>
                </tr>
            </table>
            <div class="phantrang"></div>
        </div>
        <div class="box_profile" id="tab_muachap_content" style="width: 100%;padding: 10px;display: none;">
            <div class="page_title">
                <h1 class="undefined">Danh sách mua chap</h1>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
                .list_baiviet i{
                    font-size: 35px;
                }
            </style>
            <table class="list_baiviet">
                <tr class="th">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Truyện</th>
                    <th style="text-align: left;">Coin</th>
                    <th style="text-align: center;" class="hide_mobile">Thời gian</th>
                    <th style="text-align: center;width: 100px;">Hành động</th>
                </tr>
            </table>
            <div class="phantrang"></div>
        </div>
        <div class="box_profile" id="tab_history_content" style="width: 100%;padding: 10px;display: none;">
            <div class="page_title">
                <h1 class="undefined">Danh sách đọc truyện</h1>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
                .list_baiviet i{
                    font-size: 35px;
                }
            </style>
            <table class="list_baiviet">
                <tr class="th">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Truyện</th>
                    <th style="text-align: left;" class="hide_mobile">Thời gian</th>
                    <th style="text-align: left;" class="hide_mobile">Bắt đầu</th>
                    <th style="text-align: left;" class="hide_mobile">Kết thúc</th>
                    <th style="text-align: left;" class="hide_mobile">Ip address</th>
                    <th style="text-align: center;width: 100px;">Hành động</th>
                </tr>
            </table>
            <div class="phantrang"></div>
        </div>
        <div class="box_profile" id="tab_report_content" style="width: 100%;padding: 10px;display: none;">
            <div class="page_title">
                <h1 class="undefined">Danh sách báo lỗi</h1>
                <div class="line"></div>
                <hr>
            </div>
            <style type="text/css">
                .list_baiviet i{
                    font-size: 35px;
                }
            </style>
            <table class="list_baiviet">
                <tr class="th">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Truyện</th>
                    <th style="text-align: left;" class="hide_mobile">Lỗi</th>
                    <th style="text-align: left;" class="hide_mobile">Mô tả</th>
                    <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                    <th style="text-align: center;width: 100px;">Hành động</th>
                </tr>
            </table>
            <div class="phantrang"></div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    var active='{active}';
	    $('select[name=active]').val(active); 
        var loai='{loai}';
        $('select[name=loai]').val(loai); 

	});
</script>