function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookies() {
    var c = document.cookie,
        v = 0,
        cookies = {};
    if (document.cookie.match(/^\s*\$Version=(?:"1"|1);\s*(.*)/)) {
        c = RegExp.$1;
        v = 1;
    }
    if (v === 0) {
        c.split(/[,;]/).map(function(cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function($0, $1) {
            var name = $0,
                value = $1.charAt(0) === '"' ?
                $1.substr(1, -1).replace(/\\(.)/g, "$1") :
                $1;
            cookies[name] = value;
        });
    }
    return cookies;
}

function get_cookie(name) {
    return getCookies()[name];
}

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $('#' + id).animate({
        scrollTop: div.scrollHeight - div.clientHeight
    }, 200);
}
function check_link(){
    link=$('.link_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function check_blank(){
    link=$('.tieude_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function confirm_del(action,id){
    if(action=='del_chap'){
        title='Xóa chap truyện';
    }else if(action=='del_truyen'){
        title='Xóa truyện';
    }else{
        title='Xóa dữ liệu';
    }
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action',action);
    $('#button_thuchien').attr('post_id',id);
    $('#box_pop_confirm').show();
}
// Hàm hiển thị và ẩn
function showAndHideNote(secon) {
    $(".note_top").fadeIn();
    // Ẩn div sau 3 giây (tổng cộng 6 giây)
    setTimeout(function() {
        $(".note_top").fadeOut();
    }, secon);
}
$(document).ready(function() {
    $('body').on('click','.close_note',function(){
        $('.note_top').fadeOut();
    });
    if($('.list_chat').length>0){
        scrollSmoothToBottom('list_chat');
    }
    $('.change_avatar').click(function() {
        $('#minh_hoa').click();
    });
    $('#preview-minhhoa').click(function() {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
        readURL(this, 'preview-minhhoa');
    });
    /////////////////////////////
    $('body').on('click','#loc_phim',function(){
        cat=$('#filter-movie select[name=cat]').val();
        nam=$('#filter-movie select[name=nam]').val();
        loai=$('#filter-movie select[name=loai_phim]').val();
        full=$('#filter-movie select[name=full]').val();
        window.location.href='/loc-phim.html?cat='+cat+'&nam='+nam+'&loai='+loai+'&full='+full;
    });
    /////////////////////////////
    $('body').on('click','#loc_phim_category',function(){
        nam=$('#filter-movie select[name=nam]').val();
        loai=$('#filter-movie select[name=loai_phim]').val();
        full=$('#filter-movie select[name=full]').val();
        var currentUrl = window.location.href;
        var urlWithoutQuery = currentUrl.split('?')[0];
        window.location.href=urlWithoutQuery+'?nam='+nam+'&loai='+loai+'&full='+full;
    });
    /////////////////////////////
    $('body').on('click','#MenuHeader .tab-links .toggle-dropdown',function(){
        tab=$(this).attr('bind');
        if(tab=='tab-cate'){
            $('#MenuHeader .tab-links a').not(this).removeClass('active');
            $(this).toggleClass('active');
            $('#drop-down-2').removeAttr('style');
            $('#MenuHeader .tab-links a[bind=drop-down-2]').removeAttr('style');
            setTimeout(function() {
                $('#drop-down-2').removeClass("display-block");
                $('#MenuHeader .tab-links a[bind=drop-down-2]').removeClass("active");
            }, 50);
            $('#MenuHeader .tab-links a[bind=drop-down-2]').html('<span class="material-icons-round material-icons-menu">account_circle</span><div class="item-label">Hồ sơ</div>');
            $('#tab-years').removeClass('display-block');
            $('#tab-cate').toggleClass('display-block');
        }else if(tab=='tab-years'){
            $('#MenuHeader .tab-links a').not(this).removeClass('active');
            $(this).toggleClass('active');
            $('#drop-down-2').removeAttr('style');
            $('#MenuHeader .tab-links a[bind=drop-down-2]').removeAttr('style');
            setTimeout(function() {
                $('#drop-down-2').removeClass("display-block");
                $('#MenuHeader .tab-links a[bind=drop-down-2]').removeClass("active");
            }, 50);
            $('#MenuHeader .tab-links a[bind=drop-down-2]').html('<span class="material-icons-round material-icons-menu">account_circle</span><div class="item-label">Hồ sơ</div>');
            $('#tab-cate').removeClass('display-block');
            $('#tab-years').toggleClass('display-block');
        }

    });
    /////////////////////////////
    $('.loc_anh').on('click',function(){
        content=$('textarea[name=content]').val();
        $('.content_img').html(content);
        var list='';
        var i=0;
        $('.content_img img').each(function() {
            i++;
            if(i==1){
                list+=$(this).attr('src');
            }else{
                list+="\n"+$(this).attr('src');
            }
        });
        if(i>0){
            $('textarea[name=content]').val(list);
        }
        
    });
    ///////////////////////////////
    $('body').on('click','#refresh-comments',function(){
        $('.note_top .name_note').html('Thông báo hệ thống');
        $('.note_top .text_note').html('Hệ thống đang tải dữ liệu...');
        $('.note_top').fadeIn();
        if($('.watching-movie').length>0){
            phim=$('.list-item-episode a[active]').attr('phim');
            tap=$('.list-item-episode a[active]').attr('tap');
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_comment',
                    phim:phim,
                    tap:tap,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        $('.total_comment').html(info.total_comment);
                        $('#comments').html(info.list);
                    },2000);
                }
            });
        }else if($('.info-movie').length>0){
            phim=$('input[name=phim]').val();
            tap=0;
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_comment',
                    phim:phim,
                    tap:tap,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        $('.total_comment').html(info.total_comment);
                        $('#comments').html(info.list);
                    },2000);
                }
            });
        }else{
            setTimeout(function(){
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('');
                $('.note_top .text_note').html('');
            },2000);
        }
    });
    ///////////////////////////////
    if($('.watching-movie').length>0){
        setTimeout(function(){
            phim=$('.list-item-episode a[active]').attr('phim');
            tap=$('.list-item-episode a[active]').attr('tap');
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_comment',
                    phim:phim,
                    tap:tap,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.total_comment').html(info.total_comment);
                    $('#comments').html(info.list);

                }
            });
        },3000);
    }else if($('.info-movie').length>0){
        setTimeout(function(){
            phim=$('input[name=phim]').val();
            tap=0;
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_comment',
                    phim:phim,
                    tap:tap,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.total_comment').html(info.total_comment);
                    $('#comments').html(info.list);

                }
            });
        },3000);
    }else{
    }
    $('body').on('click','.load_more_sub_comment',function(){
        var div=$(this);
        page=$(this).attr('page');
        reply=$(this).attr('reply');
        page++;
        $('.note_top .name_note').html('Thông báo hệ thống');
        $('.note_top .text_note').html('Hệ thống đang tải dữ liệu...');
        $('.note_top').fadeIn();
        $(this).attr('page',page);
        if($('.watching-movie').length>0){
            phim=$('.list-item-episode a[active]').attr('phim');
            tap=$('.list-item-episode a[active]').attr('tap');
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_more_sub_comment',
                    phim:phim,
                    tap:tap,
                    reply:reply,
                    page:page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        if(info.button_more==''){
                            div.remove();
                        }
                        $('#feedback_'+reply).append(info.list);
                    },2000)
                }
            });
        }else if($('.info-movie').length>0){
            phim=$('input[name=phim]').val();
            tap=0;
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_more_sub_comment',
                    phim:phim,
                    tap:tap,
                    reply:reply,
                    page:page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        if(info.button_more==''){
                            div.remove();
                        }
                        $('#feedback_'+reply).append(info.list);
                    },2000)

                }
            });
        }else{
        }
    });
    $('body').on('click','.load_more_comment',function(){
        page=$(this).attr('page');
        page++;
        $(this).attr('page',page);
        $('.note_top .name_note').html('Thông báo hệ thống');
        $('.note_top .text_note').html('Hệ thống đang tải dữ liệu...');
        $('.note_top').fadeIn();
        if($('.watching-movie').length>0){
            phim=$('.list-item-episode a[active]').attr('phim');
            tap=$('.list-item-episode a[active]').attr('tap');
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_more_comment',
                    phim:phim,
                    tap:tap,
                    page:page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        $('.total_comment').html(info.total_comment);
                        if(info.button_more=='' && $('.load_more_comment').length>0){
                            $('.load_more_comment').remove();
                        }
                        $('#comments').append(info.list);
                    },2000);
                }
            });
        }else if($('.info-movie').length>0){
            phim=$('input[name=phim]').val();
            tap=0;
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'load_more_comment',
                    phim:phim,
                    tap:tap,
                    page:page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function(){
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('');
                        $('.note_top .text_note').html('');
                        $('.total_comment').html(info.total_comment);
                        if(info.button_more=='' && $('.load_more_comment').length>0){
                            $('.load_more_comment').remove();
                        }
                        $('#comments').append(info.list);
                    },2000);

                }
            });
        }else{
        }
    });
    if($('#video-player').length>0){
        setTimeout(function(){
            phim=$('.list-item-episode a[active]').attr('phim');
            tap=$('.list-item-episode a[active]').attr('tap');
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'update_view',
                    phim:phim,
                    tap:tap
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                }
            });
        },60000);
        if(get_cookie('user_id')){
            setTimeout(function(){
                phim=$('.list-item-episode a[active]').attr('phim');
                tap=$('.list-item-episode a[active]').attr('tap');
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_history',
                        phim:phim,
                        tap:tap
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                    }
                });
            },1000);
        }else{
        }
    }
    /////////////////////////////
    $('body').on('click','.add_main_comment',function(){
        var div=$(this);
        noidung=div.parent().parent().parent().find('textarea.content-of-comment').val();
        if(noidung.length<10){
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Thất bại! Vui lòng nhập nội dung...');
            $('.note_top').fadeIn();
            setTimeout(function() {
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('');
            }, 3000);
        }else{
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Đang gửi bình luận...');
            $('.note_top').fadeIn();
            if($('.watching-movie').length>0){
                phim=$('.list-item-episode a[active]').attr('phim');
                tap=$('.list-item-episode a[active]').attr('tap');
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_comment',
                        phim:phim,
                        tap:tap,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            div.parent().parent().parent().find('textarea.content-of-comment').val('');
                            $('.total_comment').html(info.total_comment);
                            $('#comments').prepend(info.list);
                        }, 2000);
                    }
                });
            }else if($('.info-movie').length>0){
                phim=$('input[name=phim]').val();
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_comment',
                        phim:phim,
                        tap:0,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            div.parent().parent().parent().find('textarea.content-of-comment').val('');
                            $('.total_comment').html(info.total_comment);
                            $('#comments').prepend(info.list);
                        }, 2000);
                    }
                });
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html('Thất bại! Không thể thực hiện');
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        }

    });
    /////////////////////////////
    $('body').on('click','.reply_comment',function(){
        comment_id=$(this).attr('comment_id');
        comment_name=$(this).attr('comment_name');
        $('#toggle_frame_comment_'+comment_id).html('<div class="comment-editor relative flex flex-column margin-t-10"><textarea class="content-of-comment" placeholder="Nhập bình luận của bạn tại đây" rows="3" maxlength="5000">@'+comment_name+': </textarea><div class="tool-bar flex flex-space-auto"><div></div><div><div class="add-comment add_sub_comment button-default bg-red color-white" comment_id="'+comment_id+'">Gửi trả lời</div></div></div></div>');
    });
    /////////////////////////////
    $('body').on('click','.reply_sub_comment',function(){
        comment_id=$(this).attr('comment_id');
        comment_main=$(this).attr('comment_main');
        comment_name=$(this).attr('comment_name');
        $('#toggle_frame_comment_'+comment_id).html('<div class="comment-editor relative flex flex-column margin-t-10"><textarea class="content-of-comment" placeholder="Nhập bình luận của bạn tại đây" rows="3" maxlength="5000">@'+comment_name+': </textarea><div class="tool-bar flex flex-space-auto"><div></div><div><div class="add-comment add_reply_sub_comment button-default bg-red color-white" comment_id="'+comment_id+'" comment_main="'+comment_main+'">Gửi trả lời</div></div></div></div>');
    });
    /////////////////////////////
    $('body').on('click','.edit_comment',function(){
        var div=$(this);
        comment_id=$(this).attr('comment_id');
        noidung=$('#comment_'+comment_id+' .content').html();
        $(this).parent().parent().find('a').click();
        $('#comment_'+comment_id).hide();
        $('#feedback_'+comment_id).before('<div class="comment-editor comment-editor-'+comment_id+' relative flex flex-column margin-t-10"><textarea class="content-of-comment" placeholder="Nhập bình luận của bạn tại đây" rows="3" maxlength="5000">'+noidung+'</textarea><div class="tool-bar flex flex-space-auto"><div></div><div><div class="button-default color-white huy_edit_comment" comment_id="'+comment_id+'">Huỷ</div><div class="add-comment save_edit_comment button-default bg-blue color-white" comment_id="'+comment_id+'">Lưu</div></div></div></div>');
    });
    /////////////////////////////
    $('body').on('click','.huy_edit_comment',function(){
        comment_id=$(this).attr('comment_id');
        $('.comment-editor-'+comment_id).remove();
        $('#comment_'+comment_id).show();
    });
    /////////////////////////////
    $('body').on('click','.save_edit_comment',function(){
        var div=$(this);
        comment_id=$(this).attr('comment_id');
        noidung=$('.comment-editor-'+comment_id).find('textarea.content-of-comment').val();
        if(noidung.length<10){
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Thất bại! Vui lòng nhập nội dung...');
            $('.note_top').fadeIn();
            setTimeout(function() {
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('');
            }, 3000);
        }else{
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Đang lưu bình luận...');
            $('.note_top').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'edit_comment',
                    comment_id:comment_id,
                    noidung:noidung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('Thông báo hệ thống');
                        $('.note_top .text_note').html('');
                        $('.comment-editor-'+comment_id).remove();
                        $('#comment_'+comment_id+' .content').html(noidung);
                        $('#comment_'+comment_id).show();
                    }, 2000);
                }
            });
        }

    });
    /////////////////////////////
    $('body').on('click','.edit_reply',function(){
        var div=$(this);
        reply_id=$(this).attr('reply_id');
        noidung=$('#reply_'+reply_id+' .content').html();
        $(this).parent().parent().find('a').click();
        $('#reply_'+reply_id).hide();
        $('#feedback_'+reply_id).before('<div class="comment-editor comment-editor-'+reply_id+' relative flex flex-column margin-t-10"><textarea class="content-of-comment" placeholder="Nhập bình luận của bạn tại đây" rows="3" maxlength="5000">'+noidung+'</textarea><div class="tool-bar flex flex-space-auto"><div></div><div><div class="button-default color-white huy_edit_sub_comment" comment_id="'+reply_id+'">Huỷ</div><div class="add-comment save_edit_sub_comment button-default bg-blue color-white" comment_id="'+reply_id+'">Lưu</div></div></div></div>');
    });
    /////////////////////////////
    $('body').on('click','.save_edit_sub_comment',function(){
        var div=$(this);
        comment_id=$(this).attr('comment_id');
        noidung=$('.comment-editor-'+comment_id).find('textarea.content-of-comment').val();
        if(noidung.length<10){
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Thất bại! Vui lòng nhập nội dung...');
            $('.note_top').fadeIn();
            setTimeout(function() {
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('');
            }, 3000);
        }else{
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Đang lưu bình luận...');
            $('.note_top').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'edit_comment',
                    comment_id:comment_id,
                    noidung:noidung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.note_top').fadeOut();
                        $('.note_top .name_note').html('Thông báo hệ thống');
                        $('.note_top .text_note').html('');
                        $('.comment-editor-'+comment_id).remove();
                        $('#reply_'+comment_id+' .content').html(noidung);
                        $('#reply_'+comment_id).show();
                    }, 2000);
                }
            });
        }

    });
    /////////////////////////////
    $('body').on('click','.huy_edit_sub_comment',function(){
        comment_id=$(this).attr('comment_id');
        $('.comment-editor-'+comment_id).remove();
        $('#reply_'+comment_id).show();
    });
    /////////////////////////////
    $('body').on('click','.add_sub_comment',function(){
        var div=$(this);
        noidung=div.parent().parent().parent().find('textarea.content-of-comment').val();
        comment_id=$(this).attr('comment_id');
        if(noidung.length<10){
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Thất bại! Vui lòng nhập nội dung...');
            $('.note_top').fadeIn();
            setTimeout(function() {
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('');
            }, 3000);
        }else{
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Đang gửi bình luận...');
            $('.note_top').fadeIn();
            if($('.watching-movie').length>0){
                phim=$('.list-item-episode a[active]').attr('phim');
                tap=$('.list-item-episode a[active]').attr('tap');
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_sub_comment',
                        phim:phim,
                        tap:tap,
                        comment_id:comment_id,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            $('#toggle_frame_comment_'+comment_id).html('');
                            $('.total_comment').html(info.total_comment);
                            $('#feedback_'+comment_id).append(info.list);
                        }, 2000);
                    }
                });
            }else if($('.info-movie').length>0){
                phim=$('input[name=phim]').val();
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_sub_comment',
                        phim:phim,
                        tap:0,
                        comment_id:comment_id,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            $('#toggle_frame_comment_'+comment_id).html('');
                            $('.total_comment').html(info.total_comment);
                            $('#feedback_'+comment_id).append(info.list);
                        }, 2000);
                    }
                });
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html('Thất bại! Không thể thực hiện');
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        }

    });
    /////////////////////////////
    $('body').on('click','.add_reply_sub_comment',function(){
        var div=$(this);
        noidung=div.parent().parent().parent().find('textarea.content-of-comment').val();
        comment_id=$(this).attr('comment_id');
        comment_main=$(this).attr('comment_main');
        if(noidung.length<10){
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Thất bại! Vui lòng nhập nội dung...');
            $('.note_top').fadeIn();
            setTimeout(function() {
                $('.note_top').fadeOut();
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('');
            }, 3000);
        }else{
            $('.note_top .name_note').html('Thông báo hệ thống');
            $('.note_top .text_note').html('Đang gửi bình luận...');
            $('.note_top').fadeIn();
            if($('.watching-movie').length>0){
                phim=$('.list-item-episode a[active]').attr('phim');
                tap=$('.list-item-episode a[active]').attr('tap');
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_sub_comment',
                        phim:phim,
                        tap:tap,
                        comment_id:comment_main,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            $('#toggle_frame_comment_'+comment_id).html('');
                            $('.total_comment').html(info.total_comment);
                            $('#feedback_'+comment_main).append(info.list);
                        }, 2000);
                    }
                });
            }else if($('.info-movie').length>0){
                phim=$('input[name=phim]').val();
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'add_sub_comment',
                        phim:phim,
                        tap:0,
                        comment_id:comment_main,
                        noidung:noidung
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.note_top').fadeOut();
                            $('.note_top .name_note').html('Thông báo hệ thống');
                            $('.note_top .text_note').html('');
                            $('#toggle_frame_comment_'+comment_id).html('');
                            $('.total_comment').html(info.total_comment);
                            $('#feedback_'+comment_main).append(info.list);
                        }, 2000);
                    }
                });
            }else{
                $('.note_top .name_note').html('Thông báo hệ thống');
                $('.note_top .text_note').html('Thất bại! Hành động không được thực hiện...');
                $('.note_top').fadeIn();
                setTimeout(function() {
                    $('.note_top').fadeOut();
                    $('.note_top .name_note').html('Thông báo hệ thống');
                    $('.note_top .text_note').html('');
                }, 3000);
            }
        }

    });
    /////////////////////////////
    $('body').on('click','.next_ep',function(){
        var currentEpisode = $(".list-item-episode a[active]");
        var nextEpisode = currentEpisode.prev(".list-item-episode a");
        // Nếu không có tập kế tiếp, chọn tập đầu tiên
        if (nextEpisode.length === 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Không có tập tiếp theo');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else{
            window.location.href=nextEpisode.attr('href');
        }
    });
    /////////////////////////////
    $('body').on('click','.prev_ep',function(){
        var currentEpisode = $(".list-item-episode a[active]");
        var prevEpisode = currentEpisode.next(".list-item-episode a");
        // Nếu không có tập kế tiếp, chọn tập đầu tiên
        if (prevEpisode.length === 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Không có tập trước');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else{
            window.location.href=prevEpisode.attr('href');
        }
    });
    /////////////////////////////
    $('#add_premium').click(function(){
        goi=$('select[name=goi]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'add_premium',
                goi: goi
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.list_follow .delete',function(){
        phim=$(this).parent().attr('movie-id');
        item=$(this).parent();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'del_follow',
                phim:phim
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                item.remove();
            }
        });
    });
    /////////////////////////////
    $('body').on('click','#toggle_follow',function(){
        phim=$('input[name=phim]').val();
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'add_follow',
                phim:phim
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        if(info.them==1){
                            $('#toggle_follow .material-icons-round').html('bookmark_remove');
                            $('#toggle_follow').css('background-color','rgb(125, 72, 72)');
                        }else{
                            $('#toggle_follow .material-icons-round').html('bookmark_add');
                            $('#toggle_follow').removeAttr('style');
                        }
                    }else{
                    }
                }, 2000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','#close_pop_add',function(){
        $('.box_pop_add').html('');
        $('.box_pop_add').hide();
    });
    /////////////////////////////
    $('body').on('click','.button_cancel',function(){
        $('.box_pop_add').html('');
        $('.box_pop_add').hide();
    });
    /////////////////////////////
    $('body').on('click','#report_error',function(){
        phim=$('.list-item-episode a[active]').attr('phim');
        tap=$('.list-item-episode a[active]').attr('tap');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'load_box_pop',
                loai:'box_pop_report',
                phim:phim,
                tap:tap
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').fadeIn();
            }
        });
    });
    /////////////////////////////
    $('body').on('click','#gui_report',function(){
        phim=$('.box_pop_add input[name=phim]').val();
        tap=$('.box_pop_add input[name=tap]').val();
        loi=$('.box_pop_add textarea[name=loi]').val();
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'report_error',
                phim:phim,
                tap:tap,
                loi:loi
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_pop_add').html('');
                    $('.box_pop_add').hide();
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('#button_thuchien').click(function(){
        id=$('#button_thuchien').attr('post_id');
        action=$('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: action,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.ok_men',function(){
        vi_tri=$(this).attr('vi_tri');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "click_ok",
                vi_tri:vi_tri
            },
            success: function(kq) {
                var info = JSON.parse(kq);
            }
        });
    });
    if($('#video-player').length>0){
        tap=$('#list_sv').find('.load_server.bg-green').attr('tap');
        server=$('#list_sv').find('.load_server.bg-green').text();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_server",
                server:server,
                tap:tap
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    setTimeout(function(){
                        if(info.loai=='js'){
                            $('.js_player').html(info.html);
                        }else{
                            $('#video-player').html(info.html);
                        }
                    },500);
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 1000);
                }
            }
        });
    }
    /////////////////////////////
    $('body').on('click','.load_server',function(){
        console.log('ddax lick');
        server=$(this).html();
        tap=$(this).attr('tap');
        $('#list_sv a').removeClass('bg-green');
        $(this).addClass('bg-green');
        $('#video-player').html('<div class="loading" style="text-align: center;margin-bottom: 15px;"><div><img src="/images/index.svg" alt="" width="100px" height="100px;"></div><b>Đang tải player vui lòng chờ...</b></div>');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_server",
                server:server,
                tap:tap
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    setTimeout(function(){
                        if(info.loai=='js'){
                            $('.js_player').html(info.html);
                        }else{
                            $('#video-player').html(info.html);
                        }
                    },500);
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 1000);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.tab-lichchieu .lichchieu',function(){
        thu=$(this).attr('thu');
        $('.tab-lichchieu .lichchieu').removeClass('active');
        $(this).addClass('active');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_lichchieu",
                thu:thu
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('#LichChieuPhim').html(info.list);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.content_diemdanh button',function(){
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "click_diemdanh",
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }
        });
    });
    //////////////////////////
    $('button[name=button_profile]').on('click', function() {
        name = $('.box_form input[name=name]').val();
        if (name.length < 4) {
            $('.box_form input[name=name]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Tên hiển thị quá ngắn...');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_profile');
            form_data.append('file', file_data);
            form_data.append('name', name);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } else {

                    }
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    //////////////////////
    $('button[name=button_password]').on('click', function() {
        password_old = $('.box_form input[name=password_old]').val();
        password_new = $('.box_form input[name=password_new]').val();
        re_password_new = $('.box_form input[name=re_password_new]').val();
        if (password_old.length < 6) {
            $('.box_form input[name=password_old]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Mật khẩu cũ không đúng...');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else if (password_new.length < 6) {
            $('.box_form input[name=password_new]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Mật khẩu mới phải dài từ 6 ký tự...');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else if (password_new != re_password_new) {
            $('.box_form input[name=re_password_new]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Nhập lại mật khẩu mới không khớp...');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            var form_data = new FormData();
            form_data.append('action', 'change_password');
            form_data.append('password_old', password_old);
            form_data.append('password_new', password_new);
            form_data.append('re_password_new', re_password_new);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('.box_form input[name=password_old]').val('');
                        $('.box_form input[name=password_new]').val('');
                        $('.box_form input[name=re_password_new]').val('');
                    }
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    //////////////////////
    $('.list_comment').on('click','.reply',function(){
        id=$(this).attr('id_comment');
        if($(this).parent().parent().find('.text_area_sub').length>0){
            $(this).parent().parent().find('.text_area_sub').remove();
        }else{
            $('.list_comment .text_area_sub').remove();
            $(this).parent().after('<div class="text_area_sub"><textarea class="sub_comment_text" placeholder="Nội dung bình luận..."></textarea><svg id="button_sub_comment" id_comment="'+id+'" class="svg-inline--fa fa-paper-plane fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"></path></svg></div>');
            if($(this).parent().find('.reply').length>0){
                var div=$(this);
                var form_data = new FormData();
                form_data.append('action', 'load_reply');
                form_data.append('id', id);
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        div.parent().parent().parent().find('.list_sub_comment').html(info.list);
                        div.parent().find('.show_reply').remove();
                    }
                });
            }
        }
    });
    //////////////////////
    $('.box_note .note_title i').on('click',function(){
        $('.box_note').hide();
        $('.box_note .note_content').html('');
    });
    //////////////////////
    $('.list_comment').on('click','.show_reply', function() {
        id = $(this).attr('id_comment');
        var div=$(this);
        var form_data = new FormData();
        form_data.append('action', 'load_reply');
        form_data.append('id', id);
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                div.parent().parent().parent().find('.list_sub_comment').html(info.list);
                div.remove();
            }
        });
    });
    //////////////////////
    $('.list_comment').on('click','.del_sub_comment', function() {
        id = $(this).attr('id_comment');
        var div=$(this);
        var form_data = new FormData();
        form_data.append('action', 'del_comment');
        form_data.append('id', id);
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    $('#li_sub_comment_'+id).fadeOut();
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                } 
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.chon_anh',function(){
        $('#photo-add').click();
    });
    $('#photo-add').on('change', function() {
        //var file_data = $('#photo-add').prop('files')[0];
        truyen=$('input[name=truyen]').val();
        var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        form_data.append('truyen', truyen);
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        $('textarea[name=content]').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    //////////////////////
    $('.list_comment').on('click','.del_comment', function() {
        id = $(this).attr('id_comment');
        var div=$(this);
        var form_data = new FormData();
        form_data.append('action', 'del_comment');
        form_data.append('id', id);
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    $('#li_comment_'+id).fadeOut();
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }
                
            }
        });
    });
    //////////////////////
    $('button[name=button_mxh]').on('click', function() {
        facebook = $('#tab_mxh_content input[name=facebook]').val();
        var form_data = new FormData();
        form_data.append('action', 'change_mxh');
        form_data.append('facebook', facebook);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('#button_muachap').on('click', function() {
        chap = $('input[name=chap]').val();
        truyen = $('input[name=truyen]').val();
        pass_chap = $('input[name=pass_chap]').val();
        var form_data = new FormData();
        form_data.append('action', 'muachap');
        form_data.append('chap', chap);
        form_data.append('truyen', truyen);
        form_data.append('pass_chap', pass_chap);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {}
                }, 3000);
            }
        });
    });
    //////////////////////
    $('#button_donate').on('click', function() {
        coin = $('#box_pop_donate input[name=coin]').val();
        truyen = $('#show_donate').attr('truyen');
        nhom = $('#show_donate').attr('nhom');
        var form_data = new FormData();
        form_data.append('action', 'donate');
        form_data.append('coin', coin);
        form_data.append('truyen', truyen);
        form_data.append('nhom', nhom);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#box_pop_donate #text_note span').html(info.text);
                    $('#box_pop_donate #text_note').show();
                    $('#box_pop_donate input[name=coin]').val('');
                } else {
                    $('#box_pop_donate #text_note').hide();
                    $('#box_pop_donate #text_note span').html('');
                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('#button_follow').on('click', function() {
        truyen = $('input[name=truyen]').val();
        var form_data = new FormData();
        form_data.append('action', 'follow');
        form_data.append('truyen', truyen);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('#button_follow').html(info.text);
                }, 2000);
            }

        });
    });
    //////////////////////
    $('.del_history').on('click', function() {
        id = $(this).attr('id');
        var form_data = new FormData();
        form_data.append('action', 'del_history');
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.follow_' + id).remove();
                    }
                }, 2000);
            }

        });
    });
    //////////////////////
    $('button[name=button_block]').on('click', function() {
        var form_data = new FormData();
        form_data.append('action', 'block_account');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('#forgot_password').on('click', function() {
        email = $('#box_pop_password input[name=email]').val();
        var form_data = new FormData();
        form_data.append('action', 'forgot_password');
        form_data.append('email', email);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('button[name=button_check_email]').on('click', function() {
        email = $('#tab_email_content input[name=email]').val();
        var form_data = new FormData();
        form_data.append('action', 'check_email');
        form_data.append('email', email);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        $('#li_check_email').hide();
                        $('#tab_email_content input[name=email]').attr('disabled', 'disabled');
                        $('#li_text').show();
                        $('#li_text .text').html(info.text);
                        $('#li_code').show();
                        $('#li_update_email').show();
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('button[name=button_update_email]').on('click', function() {
        email = $('#tab_email_content input[name=email]').val();
        code = $('#tab_email_content input[name=code]').val();
        var form_data = new FormData();
        form_data.append('action', 'update_email');
        form_data.append('email', email);
        form_data.append('code', code);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        $('#li_del_email').show();
                        $('#tab_email_content input[name=email]').attr('disabled', 'disabled');
                        $('#li_text').hide();
                        $('#li_text .text').html(info.text);
                        $('#tab_email_content input[name=code]').val('');
                        $('#li_code').hide();
                        $('#li_update_email').hide();
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    //////////////////////
    $('button[name=button_del_email]').on('click', function() {
        email = $('#tab_email_content input[name=email]').val();
        code = $('#tab_email_content input[name=code]').val();
        step = $(this).attr('step');
        var form_data = new FormData();
        form_data.append('action', 'del_email');
        form_data.append('email', email);
        form_data.append('code', code);
        form_data.append('step', step);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    if (step == 1) {
                        setTimeout(function() {
                            $('button[name=button_del_email]').attr('step', '2');
                            $('#li_text').show();
                            $('#li_text .text').html(info.text);
                            $('#li_code').show();
                        }, 3000);
                    } else {
                        setTimeout(function() {
                            $('#li_del_email').hide();
                            $('button[name=button_del_email]').attr('step', '1');
                            $('#tab_email_content input[name=code]').val('');
                            $('#tab_email_content input[name=email]').removeAttr('disabled');
                            $('#tab_email_content input[name=email]').val('');
                            $('#li_text').hide();
                            $('#li_text .text').html('');
                            $('#li_code').hide();
                            $('#li_check_email').show();
                        }, 3000);

                    }
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    /////////////////
    $('.toggle_chat').on('click', function() {
        if ($('.toggle_chat .fa-plus-circle').length > 0) {
            $('.toggle_chat .fa').removeClass('fa-plus-circle');
            $('.toggle_chat .fa').addClass('fa-minus-circle');
            $('.content_box_chat').css('height', '500px');
        } else {
            $('.toggle_chat .fa').removeClass('fa-minus-circle');
            $('.toggle_chat .fa').addClass('fa-plus-circle');
            $('.content_box_chat').css('height', '267px');
        }
    });
    /////////////////
    $('.sound_chat').on('click', function() {
        if ($('.sound_chat .icon-volume-medium').length > 0) {
            $('.sound_chat .icon').removeClass('icon-volume-medium');
            $('.sound_chat .icon').addClass('icon-volume-mute2');
            setCookie('play_sound',2,30);
        } else {
            $('.sound_chat .icon').removeClass('icon-volume-mute2');
            $('.sound_chat .icon').addClass('icon-volume-medium');
            setCookie('play_sound',1,30);
        }
    });
    if($('.sound_chat').length>0){
        if(get_cookie('play_sound')==2){
            $('.sound_chat .icon').removeClass('icon-volume-medium');
            $('.sound_chat .icon').addClass('icon-volume-mute2');
        }else{
            $('.sound_chat .icon').removeClass('icon-volume-mute2');
            $('.sound_chat .icon').addClass('icon-volume-medium');
        }
    }
    var lastScrollTop = 0;
    $('.list_chat').scroll(function() {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {

        } else {
            load = $('input[name=load_chat]').val();
            loaded = $('input[name=load_chat]').attr('loaded');
            chat_id = $('.li_chat').first().attr('chat_id');
            if(st < 50 && loaded == 1 && load == 1) {
                $('.list_chat').prepend('<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
                $('input[name=load_chat]').attr('loaded','0');
                setTimeout(function(){
                    $.ajax({
                        url: "/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_room",
                            chat_id:chat_id
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_chat .li_load_chat').remove();
                            $('input[name=load_chat]').val(info.load_chat);
                            $('input[name=load_chat]').attr('loaded','1');
                            if(info.ok==1){
                                $('.list_chat').prepend(info.list);
                            }else{
                            }
                        }
                    });
                },1000);
            } else {

            }
        }
        lastScrollTop = st;

    });
    /////////////////
    $('.widget_right .load_more').on('click', function() {
        $(this).parent().find('ul').addClass('active');
        $(this).hide();
    });
    $('.widget_right .list_tab .tab').on('click', function() {
        if($(this).hasClass('active')){

        }else{
            id = $(this).attr('id');
            $(this).parent().find('.tab').removeClass('active');
            $(this).addClass('active');
            $(this).parent().parent().find('li').hide();
            $(this).parent().parent().find('li.' + id).show();
        }
    });
    ////////////////////////
    $('#show_pop_register').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_register').show();
    });
    ////////////////////////
    $('#show_pop_login').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_login').show();
    });
    $('.button_cancel').on('click', function() {
        $('.box_pop').fadeOut();
        $(this).parent().parent().parent().find('input').val('');
    });
    ////////////////////////
    $('.button_show_login').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_login').show();
    });
    ////////////////////////
    $('.button_show_register').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_register').show();
    });
    ////////////////////////
    $('#show_donate').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_donate').show();
    });
    ////////////////////////
    $('.block_content span').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_muachap').show();
    });
    ////////////////////////
    $('#show_report').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_report').show();
    });
    ////////////////////////
    $('.button_show_password').on('click', function() {
        $('.box_pop').hide();
        $('#box_pop_password').show();
    });
    ////////////////////////
    $('.member_info').on('click', function() {
        $('.control_list').toggle();
    });
    ////////////////////////
    $('.list_tab_profile .li_tab').on('click', function() {
        $('.list_tab_profile .li_tab').removeClass('active');
        $(this).addClass('active');
        id = $(this).attr('id');
        $('.tab_profile_content .box_tab').removeClass('active');
        $('.tab_profile_content #' + id + '_content').addClass('active');
    });
    ////////////////////////
    $('#button_register').on('click', function() {
        username = $('.box_form input[name=username]').val();
        email = $('.box_form input[name=email]').val();
        password = $('.box_form input[name=password]').val();
        re_password = $('.box_form input[name=re_password]').val();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
        } else if (email.length < 6) {
            $('.box_form input[name=email]').focus();
        } else if (password.length < 6) {
            $('.box_form input[name=password]').focus();
        } else if (password != re_password) {
            $('.box_form input[name=re_password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register",
                    username: username,
                    email:email,
                    password: password,
                    re_password: re_password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('.box_form input[name=username]').val('');
                        $('.box_form input[name=email]').val('');
                        $('.box_form input[name=password]').val('');
                        $('.box_form input[name=re_password]').val('');
                    }
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/dang-nhap.html'
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    ////////////////////////
    $('.button_logout').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process_logout.php",
            type: "post",
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/';
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ////////////////////////
    $('#button_login').on('click', function() {
        username = $('.box_form input[name=username]').val();
        password = $('.box_form input[name=password]').val();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
        } else if (password.length < 6) {
            $('.box_form input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process_login.php",
                type: "post",
                data: {
                    username: username,
                    password: password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/tai-khoan.html';
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    ////////////////////////
    $('input[name=input_search]').on('keyup', function() {
        key = $(this).val();
        if (key.length < 2) {
            $('.kq_search').hide();
        } else {
            $('.kq_search').show();
            $('.kq_search').html('<center><img src="/images/loading.gif"></center>');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'goi_y',
                    key: key
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.kq_search').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('input[name=input_search]').keypress(function(e) {
        if (e.which == 13) {
            key = $('input[name=input_search]').val();
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            if (key.length < 2) {
                $('input[name=input_search]').focus();
            } else {
                window.location.href = link;
            }
            return false;
        }
    });
    /////////////////////////////
    $('.box_search button').click(function() {
        key = $('input[name=input_search]').val();
        link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
        if (key.length < 2) {
            $('input[name=input_search]').focus();
        } else {
            window.location.href = link;
        }
    });
    $('.button_menu').click(function() {
        $('.box_search').hide();
        $('.box_logo_mobile').toggle();
        $('.box_menu').toggle();
    });
    /////////////////////
    $('.box_logo_mobile i').click(function() {
        $('.box_logo_mobile').toggle();
        $('.box_menu').toggle();
        $('.li_main i').addClass('fa-angle-down');
        $('.li_main i').removeClass('fa-angle-up');
        $('.sub_menu').hide();
    });
    /////////////////////
    $('.li_main i').click(function() {
        $(this).parent().find('.sub_menu').toggle();
        if ($(this).hasClass('fa-angle-down')) {
            $(this).removeClass('fa-angle-down');
            $(this).addClass('fa-angle-up');
        } else {
            $(this).addClass('fa-angle-down');
            $(this).removeClass('fa-angle-up');
        }

    });
    /////////////////////
    $('.button_search').click(function() {
        $('.box_search').toggle();
        $('.box_logo_mobile').hide();
        $('.box_menu').hide();
    });
    /////////////////////
    $('.select_chap').on('change', function() {
        value = $(this).val();
        window.location.href = value;
    });
    ////////////////////////
    $('.light-see').click(function() {
        $('body').toggleClass('chap_view');
        if ($('body').hasClass('chap_view')) {
            $('.light-see span').html(' Tắt đèn');
        } else {
            $('.light-see span').html(' Bật đèn');
        }
    });
    ////////////////////////
    $("body").keydown(function(e) {
        if ($('.content_view_chap').length > 0) {
            if (e.keyCode == 37) {
                if ($('.link-prev-chap').length > 0) {
                    link = $('.link-prev-chap').attr('href');
                    window.location.href = link;

                }
            } else if (e.keyCode == 39) {
                if ($('.link-next-chap').length > 0) {
                    link = $('.link-next-chap').attr('href');
                    window.location.href = link;
                }
            }
        } else {

        }
    });
    ////////////////////////
    $('.list_server').on('click', 'a', function() {
        $('.list_server a').removeClass('bg_green');
        $(this).addClass('bg_green');
        truyen = $(this).attr("truyen");
        chap = $(this).attr("chap");
        server = $(this).attr("server");
        $('.content_view_chap').html('<div class="load_content"></div>');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_img",
                truyen: truyen,
                server: server,
                chap: chap
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.content_view_chap').html(info.list_img);
                }, 500);
            }
        });
    });
    /////////////////////
    $('.play-button').click(function() {
        id = $('.video__channel').attr("id");
        server = $('.video__channel').attr("server");
        tap = $('.video__channel').attr("tap");
        $('#video-player-content').html('<div id="loading"> <div class="loading-container"> <div class="loading-ani"></div><div class="loading-text"> loading </div></div></div>');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_media",
                id: id,
                server: server,
                tap: tap
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.video-container').html(info.media);
                }, 500);
            }
        });

    });
});