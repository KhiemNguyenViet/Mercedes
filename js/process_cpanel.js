function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}
function readURL(input,id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+id).attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}
function confirm_del(action, loai, title, id) {
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action', action);
    $('#button_thuchien').attr('post_id', id);
    $('#button_thuchien').attr('loai', loai);
    $('#box_pop_confirm').show();
}

function confirm_action(action, title, id) {
    $('#box_pop_confirm_action .title_confirm').html(title);
    $('#button_thuchien_action').attr('action', action);
    $('#button_ok').attr('class', action);
    $('#button_thuchien_action').attr('post_id', id);
    $('#box_pop_confirm_action').show();
}
function check_link(){
    link=$('.link_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/admincp/process.php",
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
            url: "/admincp/process.php",
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
function tuchoi(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "tuchoi",
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
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function confirm_success(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "confirm_success",
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
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function del(loai,id){
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            $('.load_process').hide();
            $('.load_note').html('Hệ thống đang xử lý');
            $('.load_overlay').hide();
            if (info.ok == 1) {
                $('#tr_'+id).remove();
            } else {

            }
        }

    });
}
function block_user(user_id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "block_user",
            user_id: user_id
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
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function del_all(user_id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "del_all",
            user_id: user_id
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
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function huy(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "huy",
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
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
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
$(document).ready(function() {
    setTimeout(function(){
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    },300);
    /////////////////////////////
    $('.box_right_content').on('click','.del_server',function(){
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click','.add_server',function(){
        $('.list_server').append('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" autocomplete="off" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link video</label><input type="text" class="form_control" name="nguon" value="" autocomplete="off" placeholder="Nhập link video..."></div><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    /////////////////////////////
    $('.mh').click(function(){
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
      readURL(this,'preview-minhhoa');
    });
    $('body').on('paste','.block_server input[name=nguon]', function(event) {
        var input=$(this);
        var link_nguon='';
        setTimeout(function(){
            link_nguon=input.val();
            if(link_nguon.indexOf('iframe')!=-1){
                var startIndex = link_nguon.indexOf('src="') + 5;
                var endIndex = link_nguon.indexOf('"', startIndex);
                var srcValue = link_nguon.substring(startIndex, endIndex);
                input.val(srcValue);
            }
            if(link_nguon.indexOf('ok.ru')!=-1){
                input.parent().parent().find('input[name=server]').val('OK');
            }else if(link_nguon.indexOf('dai.ly')!=-1){
                input.parent().parent().find('input[name=server]').val('DL');
            }else if(link_nguon.indexOf('dailymotion')!=-1){
                input.parent().parent().find('input[name=server]').val('DL');
            }else if(link_nguon.indexOf('youtube')!=-1){
                input.parent().parent().find('input[name=server]').val('YT');
            }else if(link_nguon.indexOf('xfast')!=-1){
                input.parent().parent().find('input[name=server]').val('XF');
            }else if(link_nguon.indexOf('short.ink')!=-1){
                input.parent().parent().find('input[name=server]').val('HH');
            }else if(link_nguon.indexOf('obeywish.com')!=-1){
                input.parent().parent().find('input[name=server]').val('SW');
            }else if(link_nguon.indexOf('d0o0d.com')!=-1){
                input.parent().parent().find('input[name=server]').val('DO');
            }else if(link_nguon.indexOf('doodstream.com')!=-1){
                input.parent().parent().find('input[name=server]').val('DO');
            }else if(link_nguon.indexOf('helvid.com')!=-1){
                input.parent().parent().find('input[name=server]').val('HEL');
            }else{
                input.parent().parent().find('input[name=server]').val('OT');
            }
        },50);
    });
    //////////////////
    $('.list_link').on('paste', function(event) {
        setTimeout(function(){
            var movieList = $('.list_link').val();
            if(movieList.indexOf('short.ink')!=-1){
                var jsonData = JSON.parse('['+movieList+']');
                i=0;
                jsonData.forEach(function (item) {
                    i++;
					var match = item.tieu_de.match(/[Tập|tập] (\d+)/);
					if (match) {
						var soTap = match[1];
					}else{
						var soTap='';
					}
                    var episodeDiv='<div>'+i+': '+item.tieu_de+'</div><div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" value="'+soTap+'" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" value="'+soTap+'" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="'+item.link+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
                    $('.list_server').append(episodeDiv);
                });

            }else if(movieList.indexOf('d0o0d.com')!=-1){
                var jsonData = JSON.parse('['+movieList+']');
                i=0;
                jsonData.forEach(function (item) {
                    i++;
                    var match = item.tieu_de.match(/[Tập|tập] (\d+)/);
                    if (match) {
                        var soTap = match[1];
                    }else{
                        var soTap='';
                    }
                    var episodeDiv='<div>'+i+': '+item.tieu_de+'</div><div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" value="'+soTap+'" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" value="'+soTap+'" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="'+item.link+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
                    $('.list_server').append(episodeDiv);
                });

            }else if(movieList.indexOf('obeywish.com')!=-1){
                var jsonData = JSON.parse('['+movieList+']');
                i=0;
                jsonData.forEach(function (item) {
                    i++;
                    var match = item.tieu_de.match(/[Tập|tập] (\d+)/);
                    if (match) {
                        var soTap = match[1];
                    }else{
                        var soTap='';
                    }
                    var episodeDiv='<div>'+i+': '+item.tieu_de+'</div><div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" value="'+soTap+'" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" value="'+soTap+'" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="'+item.link+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
                    $('.list_server').append(episodeDiv);
                });

            }else if(movieList.indexOf('youtube.com')!=-1){
                var jsonData = JSON.parse('['+movieList+']');
                i=0;
                jsonData.forEach(function (item) {
                    i++;
                    var match = item.tieu_de.match(/[Tập|tập] (\d+)/);
                    if (match) {
                        var soTap = match[1];
                    }else{
                        var soTap='';
                    }
                    var match_v = item.link.match(/v=([^&]+)/);;
                    if (match_v) {
                        var code_v = match_v[1];
                    }else{
                        var code_v='';
                    }
                    var episodeDiv='<div>'+i+': '+item.tieu_de+'</div><div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" value="'+soTap+'" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" value="'+soTap+'" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="https://www.youtube.com/watch?v='+code_v+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
                    $('.list_server').append(episodeDiv);
                });

            }else{
                var jsonData = JSON.parse('['+movieList+']');
                i=0;
                jsonData.forEach(function (item) {
                    i++;
                    var match = item.tieu_de.match(/[Tập|tập] (\d+)/);
                    if (match) {
                        var soTap = match[1];
                    }else{
                        var soTap='';
                    }
                    var episodeDiv='<div>'+i+': '+item.tieu_de+'</div><div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" value="'+soTap+'" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" value="'+soTap+'" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="'+item.link+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
                    $('.list_server').append(episodeDiv);
                });
/*                var episodes = movieList.split('\n');
                for (var i = 0; i < episodes.length; i++) {
                    if (episodes[i].trim() !== '') {
                        var episodeDiv = $('<div class="li_input_server"><div class="input_name"><input type="text" name="tieu_de" placeholder="Nhập tên tập" autocomplete="off"></div><div class="input_thutu"><input type="text" name="thu_tu" autocomplete="off" placeholder="Nhập thứ tự"></div><div class="input_link"><input type="text" name="link_video" value="'+episodes[i]+'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>');
                        $('.list_server').append(episodeDiv);
                    }
                }*/
            }
        },100);
    });
    //////////////////
    $('.tieude_seo').on('paste', function(event) {
        if($(this).hasClass('uncheck_blank')){
        }else{
            setTimeout(function(){
                check_blank();
            },1000);
        }
    });
    $('input[name=goiy_phim]').on('keyup',function(){
        keyword=$(this).val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "goiy_phim",
                keyword:keyword
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.goi_y').html(info.list);
            }

        });
    });
    $('body').on('click','.goiy_phim',function(){
        tieu_de=$(this).html();
        phim=$(this).attr('phim');
        $('.list_phim').append('<div class="li_phim" phim="'+phim+'"><span><i class="fa fa-close"></i></span><span>'+tieu_de+'</span></div>');
        $('input[name=goiy_phim]').val('');
        $('.goi_y').html('');
    });
    $('body').on('click','.li_phim .fa-close',function(){
        $(this).parent().parent().remove();
    });
    /////////////////////////////
    $('button[name=edit_lichchieu]').on('click', function() {
        if($('.li_phim').length==0){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Thất bại! Chưa thêm phim nào!');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else if($('.li_input input[name^=thu]:checked').length==0){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Thất bại! Chưa chọn ngày chiếu!');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else{
            var list_thu = [];
            $('.li_input input[name^=thu]:checked').each(function() {
                list_thu.push($(this).val());
            });
            list_thu = list_thu.toString();
            var list_phim = [];
            $('.list_phim .li_phim').each(function() {
                list_phim.push($(this).attr('phim'));
            });
            an=$('.li_input input[name=an]:checked').val();
            list_phim = list_phim.toString();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_lichchieu",
                    list_thu: list_thu,
                    list_phim: list_phim,
                    an:an
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
                        window.location.href='/admincp/list-lich';
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_lichchieu]').on('click', function() {
        if($('.li_phim').length==0){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Thất bại! Chưa thêm phim nào!');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else if($('.li_input input[name^=thu]:checked').length==0){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Thất bại! Chưa chọn ngày chiếu!');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else{
            var list_thu = [];
            $('.li_input input[name^=thu]:checked').each(function() {
                list_thu.push($(this).val());
            });
            list_thu = list_thu.toString();
            var list_phim = [];
            $('.list_phim .li_phim').each(function() {
                list_phim.push($(this).attr('phim'));
            });
            list_phim = list_phim.toString();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_lichchieu",
                    list_thu: list_thu,
                    list_phim: list_phim
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
                        $('.list_phim').html('');
                        $('.li_input input[name^=thu]').prop('checked',false);
                    }, 3000);
                }

            });
        }
    });
    $('input[name=slug]').on('keyup',function(){
        slug=$(this).val();
        id=$('input[name=id]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.check_slug').html(info.thongbao);
            }

        });
    });
    /////////////////////////////
    $('.list_tab a').on('click',function(){
        $('.list_tab a').removeClass('active');
        $(this).addClass('active');
        id=$(this).attr('id');
        $('.box_profile').hide();
        $('#'+id+'_content').show();
        user_id=$('input[name=id]').val();
        if(id=='tab_napcoin'){
            if($('#tab_napcoin_content .list_baiviet tr').length>1){
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "load_napcoin",
                        user_id: user_id,
                        page: 1
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('#tab_napcoin_content .list_baiviet .th').after(info.list);
                            $('#tab_napcoin_content .phantrang').html(info.phantrang);
                        }, 1000);
                    }
                });  
            }          
        }else if(id=='tab_donate'){
            if($('#tab_donate_content .list_baiviet tr').length>1){
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "load_donate",
                        user_id: user_id,
                        page: 1
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('#tab_donate_content .list_baiviet .th').after(info.list);
                            $('#tab_donate_content .phantrang').html(info.phantrang);
                        }, 1000);
                    }
                });  
            }          
        }else if(id=='tab_muachap'){
            if($('#tab_muachap_content .list_baiviet tr').length>1){
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "load_muachap",
                        user_id: user_id,
                        page: 1
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('#tab_muachap_content .list_baiviet .th').after(info.list);
                            $('#tab_muachap_content .phantrang').html(info.phantrang);
                        }, 1000);
                    }
                });  
            }          
        }else if(id=='tab_history'){
            if($('#tab_history_content .list_baiviet tr').length>1){
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "load_history",
                        user_id: user_id,
                        page: 1
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('#tab_history_content .list_baiviet .th').after(info.list);
                            $('#tab_history_content .phantrang').html(info.phantrang);
                        }, 1000);
                    }
                });  
            }          
        }else if(id=='tab_report'){
            if($('#tab_report_content .list_baiviet tr').length>1){
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "load_report",
                        user_id: user_id,
                        page: 1
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('#tab_report_content .list_baiviet .th').after(info.list);
                            $('#tab_report_content .phantrang').html(info.phantrang);
                        }, 1000);
                    }
                });  
            }          
        }
    });
    /////////////////////////////
    $('.phantrang').on('click','button',function(){
        id=$(this).parent().parent().attr('id');
        user_id=$('input[name=id]').val();
        page=$(this).attr('page');
        if(id=='tab_napcoin_content'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_napcoin",
                    user_id: user_id,
                    page: page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('#tab_napcoin_content .list_baiviet tr:last').after(info.list);
                        $('#tab_napcoin_content .phantrang').html(info.phantrang);
                    }, 1000);
                }
            });
        }else if(id=='tab_donate_content'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_donate",
                    user_id: user_id,
                    page: page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('#tab_donate_content .list_baiviet tr:last').after(info.list);
                        $('#tab_donate_content .phantrang').html(info.phantrang);
                    }, 1000);
                }
            });
        }else if(id=='tab_muachap_content'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_muachap",
                    user_id: user_id,
                    page: page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('#tab_muachap_content .list_baiviet tr:last').after(info.list);
                        $('#tab_muachap_content .phantrang').html(info.phantrang);
                    }, 1000);
                }
            });
        }else if(id=='tab_history_content'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_history",
                    user_id: user_id,
                    page: page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('#tab_history_content .list_baiviet tr:last').after(info.list);
                        $('#tab_history_content .phantrang').html(info.phantrang);
                    }, 1000);
                }
            });
        }else if(id=='tab_report_content'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_report",
                    user_id: user_id,
                    page: page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('#tab_report_content .list_baiviet tr:last').after(info.list);
                        $('#tab_report_content .phantrang').html(info.phantrang);
                    }, 1000);
                }
            });
        }
    });
    /////////////////////////////
    $('#cat_auto').on('change',function(){
        cat_auto = $( "#cat_auto option:selected" ).text();
        text = cat_auto.replace(/[-]/g, "");
        link_copy='https://www.clipzui.com/search?k='+text.replace(/\s/g,'+');
        $('input[name=tieu_de]').val(text);
        $('input[name=link_copy]').val(link_copy);

    });
    /////////////////////////////
    $('.drop_down').on('click',function(){
        $('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).find('.drop_menu').is(':visible')) {
            $(this).find('.drop_menu').slideUp('300');
        } else {
            $(this).find('.drop_menu').slideDown('300');
        }
    });
    /////////////////////////////
    $(document).mouseup(function(e) {
        var dr = $(".drop_menu");
        if (!dr.is(e.target) && dr.has(e.target).length === 0) {
            $('.drop_menu').slideUp('300');
        }
    });
    $('input[name=input_search]').keypress(function(e) {
        if (e.which == 13) {
            key=$('input[name=input_search]').val();
            if(key.length<2){
                $('input[name=input_search]').focus();
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url:'/admincp/process.php',
                    type:'post',
                    data:{
                        action:'timkiem',
                        key:key
                    },
                    success: function(kq){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        var info=JSON.parse(kq);
                        $('.list_baiviet').html(info.list);
                        $('.pagination').hide();
                    }
                });
            }
            return false;
        }
    });
    $('input[name=input_search_member]').keypress(function(e) {
        if (e.which == 13) {
            key=$('input[name=input_search_member]').val();
            if(key.length<2){
                $('input[name=input_search_member]').focus();
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url:'/admincp/process.php',
                    type:'post',
                    data:{
                        action:'timkiem_member',
                        key:key
                    },
                    success: function(kq){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        var info=JSON.parse(kq);
                        $('.list_baiviet').html(info.list);
                        $('.pagination').hide();
                    }
                });
            }
            return false;
        }
    });
    $('input[name=input_search_chap]').keypress(function(e) {
        if (e.which == 13) {
            key=$('input[name=input_search_chap]').val();
            truyen=$('input[name=input_search_chap]').attr('truyen');
            if(key.length<1){
                $('input[name=input_search_chap]').focus();
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url:'/admincp/process.php',
                    type:'post',
                    data:{
                        action:'timkiem_chap',
                        truyen:truyen,
                        key:key
                    },
                    success: function(kq){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        var info=JSON.parse(kq);
                        $('.list_baiviet').html(info.list);
                        $('.pagination').hide();
                    }
                });
            }
            return false;
        }
    });
    /////////////////////////////
    $('#ckOk').on('click', function() {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function(e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////
    $('#btnSearch').on('click', function() {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function() {
        var t = $(this);
        var p = $(this).parent().find('.panel-collapse');
        if (t.hasClass("active-panel")) {
            $(this).parent().find('.panel-collapse').slideUp();
        } else {
            $(this).parent().find('.panel-collapse').slideDown();
        }
        /*		if(p.hasClass("active-panel")){
        			setTimeout(function(){
        				$(this).parent().find('.panel-collapse').removeClass('in');
        			},1000);
        		}else{
        			setTimeout(function(){
        				$(this).parent().find('.panel-collapse').addClass('in');
        			},1000);
        		}*/
        $(this).toggleClass('active-panel');

    });
    /////////////////////////////
    $('.item-cat a').on('click', function() {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('.box_profile').on('click','.button_select_photo',function(){
        $('#photo-add').click();
        $('.block_server').removeClass('active');
        $(this).parent().addClass('active');
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
            url: '/admincp/process.php',
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
                        $('.block_server.active textarea[name=noidung]').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('.box_profile').on('click','.select_audio',function(){
        $('#audio-add').click();
    });
    $('#audio-add').on('change', function() {
        truyen=$('input[name=truyen]').val();
        var form_data = new FormData();
        form_data.append('action', 'upload');
        form_data.append('truyen', truyen);
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: 'https://cdn.beatchuan.com/process.php',
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
                        console.log(info.list);
                        $('.list_add_audio').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click','button[name=add_upload_audio]',function(){
        var list_server= [];
        var list='';
        s=0;
        audio_length=$('.li_add_audio').length;
        truyen=$('input[name=truyen]').val();
        if(audio_length>0){
            $('.li_add_audio').each(function(){
                s++;
                name=$(this).find('input[name=tieu_de]').val();
                link=$(this).find('input[name=link]').val();
                thu_tu=$(this).find('input[name=thu_tu]').val();
                if(s==audio_length){
                    list+= '{"name":"'+name+'","link":"'+link+'","thu_tu":"'+thu_tu+'"}';
                }else{
                    list+= '{"name":"'+name+'","link":"'+link+'","thu_tu":"'+thu_tu+'"},';
                }
            });
            var list_audio='['+list+']';
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_upload_audio",
                    truyen:truyen,
                    list_audio:list_audio
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
                            $('.list_add_audio').html('');
                            $('.list_baiviet').html(info.list);
                        }
                    }, 3000);
                }

            });
        }else{
            setTimeout(function() {
                $('.load_note').html('Thất bại! Không có audio nào!');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }
    });
    /////////////////////////////
    $('.remember').on('click',function(){
        value=$(this).attr('value');
        if(value=='on'){
            $('.remember i').removeClass('fa-check-circle-o');
            $('.remember i').addClass('fa-circle-o');
            $(this).attr('value','off');
        }else{
            $('.remember i').removeClass('fa-circle-o');
            $('.remember i').addClass('fa-check-circle-o');
            $(this).attr('value','on');
        }

    });
    /////////////////////////////
    $('button[name=edit_setting]').on('click', function() {
        name = $('input[name=id]').val();
        noidung = tinyMCE.activeEditor.getContent();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
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
                        window.location.href='/admincp/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_coin]').on('click', function() {
        user_id = $('input[name=user_id]').val();
        coin = $('input[name=coin]').val();
        noidung = $('input[name=noidung]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_coin",
                user_id: user_id,
                coin:coin,
                noidung: noidung
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('#select_chap').on('change',function(){
        text=$('#select_chap option:selected').text();
        $('input[name=tieu_de]').val(text);
    });

    /////////////////////////////
    $('#box_pop_confirm .button_cancel').on('click', function() {
        $('#title_confirm').html('');
        $('#button_thuchien').attr('action', '');
        $('#button_thuchien').attr('post_id', '');
        $('#button_thuchien').attr('loai', '');
        $('#box_pop_confirm').hide();
    });
    /////////////////////////////
    $('#box_pop_confirm_action .button_cancel').on('click', function() {
        $('#box_pop_confirm_action .title_confirm').html('');
        $('#button_thuchien_action').attr('action', '');
        $('#button_thuchien_action').attr('post_id', '');
        $('#button_thuchien_action').attr('loai', '');
        $('#box_pop_confirm_action').hide();
    });
    /////////////////////////////
    $('#button_thuchien').click(function() {
        id = $('#button_thuchien').attr('post_id');
        loai = $('#button_thuchien').attr('loai');
        action = $('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: action,
                loai: loai,
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
                    if (info.ok == 1) {
                        $('#tr_' + id).remove();
                        if (info.reload == 1) {
                            window.location.reload();
                        }
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('#button_thuchien_action').click(function() {
        $('#button_ok').click();
    });
    /////////////////////////////
    $('button[name=add_video').on('click', function() {
        truyen=$('input[name=truyen]').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        thu_tu=$('input[name=thu_tu]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_video",
                truyen: truyen,
                tieu_de:tieu_de,
                link:link,
                thu_tu:thu_tu
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
                    if (info.ok == 1) {
                        $('input[name=tieu_de]').val('');
                        $('input[name=thu_tu]').val('');
                        $('input[name=link]').val('');
                        $('.list_baiviet').html(info.list);
                    } else {

                    }
                }, 1000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_video').on('click', function() {
        truyen=$('input[name=truyen]').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        thu_tu=$('input[name=thu_tu]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_video",
                truyen: truyen,
                tieu_de:tieu_de,
                link:link,
                thu_tu:thu_tu,
                id:id
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
                        window.location.href='/admincp/list-video?truyen='+truyen;
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_audio').on('click', function() {
        truyen=$('input[name=truyen]').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        thu_tu=$('input[name=thu_tu]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_audio",
                truyen: truyen,
                tieu_de:tieu_de,
                link:link,
                thu_tu:thu_tu
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
                    if (info.ok == 1) {
                        $('input[name=tieu_de]').val('');
                        $('input[name=thu_tu]').val('');
                        $('input[name=link]').val('');
                        $('.list_baiviet').html(info.list);
                    } else {

                    }
                }, 1000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_audio').on('click', function() {
        truyen=$('input[name=truyen]').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        thu_tu=$('input[name=thu_tu]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_audio",
                truyen: truyen,
                tieu_de:tieu_de,
                link:link,
                thu_tu:thu_tu,
                id:id
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
                        window.location.href='/admincp/list-audio?truyen='+truyen;
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_block]').on('click', function() {
        ip_address = $('input[name=ip_address]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_block",
                ip_address: ip_address
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_napcoin]').on('click', function() {
        username = $('input[name=username]').val();
        coin = $('input[name=coin]').val();
        noidung = $('input[name=noidung]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_napcoin",
                username: username,
                coin:coin,
                noidung: noidung
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_napcoin]').on('click', function() {
        username = $('input[name=username]').val();
        coin = $('input[name=coin]').val();
        noidung = $('input[name=noidung]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_napcoin",
                username: username,
                coin:coin,
                noidung: noidung,
                id:id
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_report]').on('click', function() {
        tinh_trang = $('select[name=tinh_trang]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_report",
                tinh_trang: tinh_trang,
                id:id
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('input[name=loai]').click(function(){
        loai =$('input[name=loai]:checked').val();
        if(loai=='link'){
            $('#select_post').hide();
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        }else if(loai=='category'){
            $('#select_post').hide();
            $('#select_category').show();
            $('#select_page').hide();
            $('#input_link').hide();            
        }else if(loai=='page'){
            $('#select_post').hide();
            $('#select_category').hide();
            $('#select_page').show();
            $('#input_link').hide();
        }else if(loai=='post'){
            $('#select_category').hide();
            $('#select_post').show();
            $('#select_page').hide();
            $('#input_link').hide();
        }else{
            $('#select_post').hide();
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        }
    });
    /////////////////////////////
    $('#select_category select').on('change',function(){
        text=$('#select_category select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_page select').on('change',function(){
        text=$('#select_page select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('button[name=add_menu]').click(function(){
        loai =$('input[name=loai]:checked').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        vi_tri=$('select[name=vi_tri]').val();
        main_id=$('select[name=main_id]').val();
        col=$('select[name=col]').val();
        category=$('select[name=category]').val();
        page=$('select[name=page]').val();
        post=$('select[name=post]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else if(loai=='link' && link==''){
            $('input[name=link]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_menu",
                    loai:loai,
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu,
                    main_id:main_id,
                    vi_tri:vi_tri,
                    col:col,
                    category:category,
                    page:page,
                    post:post
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

        }
    });
    /////////////////////////////
    $('button[name=edit_menu]').click(function(){
        loai =$('input[name=loai]:checked').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        post=$('select[name=post]').val();
        vi_tri=$('select[name=vi_tri]').val();
        main_id=$('select[name=main_id]').val();
        col=$('select[name=col]').val();
        category=$('select[name=category]').val();
        page=$('select[name=page]').val();
        id=$('input[name=id]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else if(loai=='link' && link==''){
            $('input[name=link]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_menu",
                    loai:loai,
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu,
                    vi_tri:vi_tri,
                    post:post,
                    main_id:main_id,
                    col:col,
                    category:category,
                    page:page,
                    id:id
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
                            window.location.href='/admincp/list-menu';
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=edit_theloai]').on('click', function() {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank=$('input[name=cat_blank]').val();
        cat_thutu=$('input[name=cat_thutu]').val();
        cat_title=$('input[name=cat_title]').val();
        link_old=$('input[name=link_old]').val();
        cat_description=$('textarea[name=cat_description]').val();
        cat_id=$('input[name=id]').val();
        cat_main=$('select[name=cat_main]').val();
        if(cat_tieude.length<2){
            $('input[name=cat_tieude]').focus();
        }else if(cat_thutu==''){
            $('input[name=cat_thutu]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank:cat_blank,
                    cat_title:cat_title,
                    cat_description:cat_description,
                    cat_thutu:cat_thutu,
                    cat_main:cat_main,
                    link_old:link_old,
                    cat_id:cat_id
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
                            window.location.href='/admincp/list-theloai';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_theloai]').on('click', function() {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu=$('input[name=cat_thutu]').val();
        cat_title=$('input[name=cat_title]').val();
        cat_description=$('textarea[name=cat_description]').val();
        cat_main=$('select[name=cat_main]').val();
        if(cat_tieude.length<2){
            $('input[name=cat_tieude]').focus();
        }else if(cat_thutu==''){
            $('input[name=cat_thutu]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank:cat_blank,
                    cat_title:cat_title,
                    cat_description:cat_description,
                    cat_main:cat_main,
                    cat_thutu:cat_thutu
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_tacgia]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        thu_tu=$('input[name=thu_tu]').val();
        noidung = tinyMCE.activeEditor.getContent();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'add_tacgia');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('thu_tu', thu_tu);
        form_data.append('noidung', noidung);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_tacgia]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        link_old=$('input[name=link_old]').val();
        thu_tu=$('input[name=thu_tu]').val();
        noidung = tinyMCE.activeEditor.getContent();
        id=$('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_tacgia');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('link_old', link_old);
        form_data.append('thu_tu', thu_tu);
        form_data.append('noidung', noidung);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_thanhvien]').on('click',function() {
        name=$('input[name=name]').val();
        coin=$('input[name=coin]').val();
        active=$('select[name=active]').val();
        id=$('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_thanhvien');
        form_data.append('file', file_data);
        form_data.append('name', name);
        form_data.append('coin', coin);
        form_data.append('active', active);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=login]').on('click', function() {
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        remember=$('.remember').attr('value');
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "dangnhap",
                    username: username,
                    password: password,
                    remember:remember
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
                            window.location.href='/admincp/dashboard';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=forgot_password]').on('click', function() {
        email= $('input[name=email]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "forgot_password",
                email: email
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
                }, 3000);
                setTimeout(function(){
                    if (info.ok == 1) {
                        window.location.href='/forgot-password?step=2';
                    } else {

                    }
                },3500);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function() {
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_profile",
                    name: name,
                    mobile: mobile
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            //window.location.reload();
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
    /////////////////////////////
    $('.button_change_avatar').click(function(){
    	$('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function(){
    	$('#file_cover').click();
    });
    /////////////////////////////
    $('button[name=add_post]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        noidung = tinyMCE.activeEditor.getContent();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'add_post');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('title', title);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_post]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        noidung = tinyMCE.activeEditor.getContent();
        id=$('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_post');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('title', title);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_password]').on('click', function() {
        old_pass = $('input[name=password_old]').val();
        new_pass = $('input[name=password]').val();
        confirm = $('input[name=confirm]').val();
        if (old_pass.length < 6) {
            $('input[name=password_old]').focus();
        } else if (new_pass.length < 6) {
            $('input[name=password]').focus();
        } else if (new_pass != confirm) {
            $('input[name=confirm]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
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
                            $('input[name=password_old]').val('');
                            $('input[name=password]').val('');
                            $('input[name=confirm]').val('');
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('button[name=edit_phim').on('click', function() {
        noidung = tinyMCE.activeEditor.getContent();
        tieu_de = $('input[name=tieu_de]').val();
        ten_khac = $('input[name=ten_khac]').val();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        link_copy = $('input[name=link_copy]').val();
        thoi_luong = $('input[name=thoi_luong]').val();
        nam = $('input[name=nam]').val();
        nguon = $('input[name=nguon]').val();
        title=$('input[name=title]').val();
        hot =$('input[name=hot]:checked').val();
        moi =$('input[name=moi]:checked').val();
        full =$('input[name=full]:checked').val();
        loai_hinh =$('input[name=loai_hinh]:checked').val();
        description=$('textarea[name=description]').val();
        tags=$('textarea[name=tags]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat=list_cat.toString();
        id=$('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        }else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_phim');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('ten_khac', ten_khac);
            form_data.append('category', list_cat);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('link_copy', link_copy);
            form_data.append('thoi_luong', thoi_luong);
            form_data.append('nam', nam);
            form_data.append('nguon', nguon);
            form_data.append('tags', tags);
            form_data.append('hot', hot);
            form_data.append('full', full);
            form_data.append('loai_hinh', loai_hinh);
            form_data.append('moi', moi);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('tags', tags);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    /////////////////////////////
    $('button[name=add_phim').on('click', function() {
        noidung = tinyMCE.activeEditor.getContent();
        tieu_de = $('input[name=tieu_de]').val();
        ten_khac = $('input[name=ten_khac]').val();
        link = $('input[name=link]').val();
        link_copy = $('input[name=link_copy]').val();
        thoi_luong = $('input[name=thoi_luong]').val();
        nam = $('input[name=nam]').val();
        nguon = $('input[name=nguon]').val();
        title=$('input[name=title]').val();
        hot =$('input[name=hot]:checked').val();
        full =$('input[name=full]:checked').val();
        loai_hinh =$('input[name=loai_hinh]:checked').val();
        moi =$('input[name=moi]:checked').val();
        description=$('textarea[name=description]').val();
        tags=$('textarea[name=tags]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat=list_cat.toString();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        }else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_phim');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('ten_khac', ten_khac);
            form_data.append('category', list_cat);
            form_data.append('link', link);
            form_data.append('link_copy', link_copy);
            form_data.append('thoi_luong', thoi_luong);
            form_data.append('nam', nam);
            form_data.append('nguon', nguon);
            form_data.append('tags', tags);
            form_data.append('hot', hot);
            form_data.append('full', full);
            form_data.append('loai_hinh', loai_hinh);
            form_data.append('moi', moi);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('tags', tags);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    /////////////////////////////
    $('button[name=edit_tap').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        phim = $('input[name=phim]').val();
        id = $('input[name=id]').val();
        thu_tu = $('input[name=thu_tu]').val();
        var list_server='';
        var m=0;
        $('.block_server').each(function() {
            if($(this).find('input[name=server]').length>0){
                server= $(this).find('input[name=server]').val();
            }else{
                server='';
            }
            if($(this).find('input[name=nguon]').length>0){
                nguon= $(this).find('input[name=nguon]').val();
            }else{
                nguon='';
            }
            if (nguon!= '') {
                m++;
                if(m==1){
                    list_server += '{"server":"'+server+'","nguon":"'+nguon+'"}';
                }else{
                    list_server += ',{"server":"'+server+'","nguon":"'+nguon+'"}';
                }
            }
        });
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        }else {
            var form_data = new FormData();
            form_data.append('action', 'edit_tap');
            form_data.append('tieu_de', tieu_de);
            form_data.append('list_server', list_server);
            form_data.append('thu_tu', thu_tu);
            form_data.append('phim', phim);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            window.location.href='/admincp/list-tap?phim='+phim;
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
    /////////////////////////////
    $('body').on('keyup','.li_input_server input[name=tieu_de]',function(){
        var input=$(this);
        setTimeout(function(){
            tieu_de=input.val();
            thu_tu=parseInt(tieu_de);
            input.parent().parent().find('input[name=thu_tu]').val(thu_tu);
        },100);
    });
    /////////////////////////////
    $('button[name=add_tap_nhanh').on('click', function() {
        phim = $('input[name=phim]').val();
        var list_tap='';
        var m=0;
        $('.list_server .li_input_server').each(function() {
            if($(this).find('input[name=tieu_de]').length>0){
                tieu_de= $(this).find('input[name=tieu_de]').val();
            }else{
                tieu_de='';
            }
            if($(this).find('input[name=thu_tu]').length>0){
                thu_tu= $(this).find('input[name=thu_tu]').val();
            }else{
                thu_tu='';
            }
            if($(this).find('input[name=link_video]').length>0){
                link_video= $(this).find('input[name=link_video]').val();
            }else{
                link_video='';
            }
            if (link_video!= '' && tieu_de!='') {
                m++;
                if(m==1){
                    list_tap += '{"tieu_de":"'+tieu_de+'","thu_tu":"'+thu_tu+'","link_video":"'+link_video+'"}';
                }else{
                    list_tap += ',{"tieu_de":"'+tieu_de+'","thu_tu":"'+thu_tu+'","link_video":"'+link_video+'"}';
                }
            }
        });
        if (list_tap.length < 1) {
            $('textarea[name=list_link]').focus();
        }else {
            var form_data = new FormData();
            form_data.append('action', 'add_tap_nhanh');
            form_data.append('list_tap', list_tap);
            form_data.append('phim', phim);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('textarea[name=list_link]').val('');
                        $('.list_server').html('');
                    } else {

                    }
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 1000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_tap').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        phim = $('input[name=phim]').val();
        thu_tu = $('input[name=thu_tu]').val();
        var list_server='';
        var m=0;
        $('.block_server').each(function() {
            if($(this).find('input[name=server]').length>0){
                server= $(this).find('input[name=server]').val();
            }else{
                server='';
            }
            if($(this).find('input[name=nguon]').length>0){
                nguon= $(this).find('input[name=nguon]').val();
            }else{
                nguon='';
            }
            if (nguon!= '') {
                m++;
                if(m==1){
                    list_server += '{"server":"'+server+'","nguon":"'+nguon+'"}';
                }else{
                    list_server += ',{"server":"'+server+'","nguon":"'+nguon+'"}';
                }
            }
        });
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        }else {
            var form_data = new FormData();
            form_data.append('action', 'add_tap');
            form_data.append('tieu_de', tieu_de);
            form_data.append('list_server', list_server);
            form_data.append('thu_tu', thu_tu);
            form_data.append('phim', phim);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('input[name=tieu_de]').val('');
                        $('input[name=thu_tu]').val('');
                        $('.block_server').each(function() {
                            if($(this).find('input[name=server]').length>0){
                                $(this).find('input[name=server]').val('');
                            }
                            if($(this).find('input[name=nguon]').length>0){
                                $(this).find('input[name=nguon]').val('');
                            }
                        });
                    } else {

                    }
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 1000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=get_folder]',function(){
        folder=$('input[name=folder]').val();
        domain=$('select[name=domain]').val();
        taikhoan=$('select[name=taikhoan]').val();
        page=$('select[name=page]').val();
        limit=$('select[name=limit]').val();
        if(folder.length<2){
            $('input[name=folder]').focus();
        }else{
            $('button[name=get_folder]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "get_folder",
                    folder:folder,
                    domain:domain,
                    taikhoan:taikhoan,
                    limit:limit,
                    page:page
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.list_server').html(info.list);
                    $('button[name=get_folder]').html('Bắt đầu Get');
                }

            });

        }

    });
    /////////////////////////////
    $('body').on('click','.list_server .li_input_server .input_del button',function(){
        $(this).parent().parent().remove();
    });
    /////////////////////////////
    $('button[name=copy_audio]').click(function(){
        link_copy=$('input[name=link_copy]').val();
        truyen=$('input[name=truyen]').val();
        if(link_copy.length<5){
            $('input[name=link_copy]').focus();
        }else{
            $('button[name=copy_audio]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "copy_audio",
                    link: link_copy,
                    truyen:truyen
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.list_baiviet').html(info.list);
                    $('button[name=copy_audio]').html('Copy audio');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=loc_audio]').click(function(){
        code_audio=$('textarea[name=code_audio]').val();
        truyen=$('input[name=truyen]').val();
        if(code_audio.length<5){
            $('textarea[name=code_audio]').focus();
        }else{
            $('button[name=loc_audio]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "loc_audio",
                    code_audio: code_audio,
                    truyen:truyen
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.list_baiviet').html(info.list);
                    $('button[name=loc_audio]').html('Lọc audio');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=crawl_mp]').click(function(){
        code_audio=$('textarea[name=code_audio]').val();
        if(code_audio.length<5){
            $('textarea[name=code_audio]').focus();
        }else{
            $('button[name=crawl_mp]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "crawl_mp",
                    code_audio: code_audio,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.ketqua').html(info.list);
                    $('button[name=crawl_mp]').html('Lọc mp3');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=update_audio]').click(function(){
        link_old=$('input[name=link_old]').val();
        link_new=$('input[name=link_new]').val();
        if(link_old.length<5){
            $('input[name=link_old]').val();
        }else if(link_new.length<5){
            $('input[name=link_new]').val();
        }else{
            $('button[name=update_audio]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "update_audio",
                    link_old: link_old,
                    link_new: link_new,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.ketqua').html(info.list);
                    $('button[name=update_audio]').html('Cập nhật audio');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=copy_video]').click(function(){
        link_copy=$('input[name=link_copy]').val();
        truyen=$('input[name=truyen]').val();
        if(link_copy.length<5){
            $('input[name=link_copy]').focus();
        }else{
            $('button[name=copy_video]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "copy_video",
                    link: link_copy,
                    truyen:truyen
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('input[name=link]').val(info.link);
                    $('input[name=link_copy]').val('');
                    $('button[name=copy_video]').html('Copy video');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=copy_category]').click(function(){
        link_copy=$('input[name=link_copy]').val();
        if(link_copy.length<5){
            $('input[name=link_copy]').focus();
        }else{
            $('button[name=copy_truyen]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "copy_category",
                    link_copy: link_copy
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        alert(info.thongbao);
                        $('input[name=link_copy]').val('');
                    }else{
                        $('input[name=cat_tieude]').val(info.tieu_de);
                        $('input[name=cat_title]').val(info.title);
                        $('input[name=cat_blank]').val(info.link_xem);
                        $('textarea[name=cat_description]').val(info.description);
                    }
                    $('button[name=copy_category]').html('Copy thể loại');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=copy_truyen]').click(function(){
        link_copy=$('input[name=link_copy]').val();
        if(link_copy.length<5){
            $('input[name=link_copy]').focus();
        }else{
            $('button[name=copy_truyen]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "copy_truyen",
                    link_copy: link_copy
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        alert(info.thongbao);
                        $('input[name=link_copy]').val('');
                    }else{
                        $('input[name=tieu_de]').val(info.tieu_de);
                        $('input[name=title]').val(info.title);
                        $('input[name=link]').val(info.link_xem);
                        $('textarea[name=description]').val(info.description);
                        $('.mh img').attr('src',info.img);
                        //$('input[name=minh_hoa]').val(info.img);
                        tinyMCE.activeEditor.setContent(info.noidung);
                        check_link();
                    }
                    $('button[name=copy_truyen]').html('Copy truyện');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=copy_chap]').click(function(){
        link_copy=$('input[name=link_copy]').val();
        if(link_copy.length<5){
            $('input[name=link_copy]').focus();
        }else{
            $('button[name=copy_chap]').html('Đang xử lý...');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "copy_chap",
                    link_copy: link_copy
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        alert(info.thongbao);
                        $('input[name=link_copy]').val('');
                    }else{
                        $('input[name=tieu_de]').val(info.tieu_de);
                        tinyMCE.activeEditor.setContent(info.noidung);
                    }
                    $('button[name=copy_chap]').html('Copy chap');
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=crawl_audio]').click(function(){
        $('button[name=crawl_audio]').html('Đang xử lý...');
        link=$('input[name=link_copy]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "crawl_audio",
                link:link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.ketqua').html(info.list+'<br>'+info.list_mp3);
                $('button[name=crawl_audio]').html('Copy audio');
            }
        });

    });
    /////////////////////////////
    $('button[name=add_chap_auto]').click(function(){
        $('button[name=add_chap_auto]').html('Đang xử lý...');
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_chap_auto"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.ketqua').prepend(info.list);
                if(info.tiep==0){
                    $('button[name=add_chap_auto]').html('Bắt đầu');
                }else{
                    $('button[name=add_chap_auto]').click();
                }
            }
        });

    });
    /////////////////////////////
    $('button[name=add_link_auto]').click(function(){
        $('button[name=add_link_auto]').html('Đang xử lý...');
        truyen=$('input[name=truyen]').val();
        link=$('input[name=link_next]').val();
        page=$('input[name=page]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_link_auto",
                truyen:truyen,
                link:link,
                page:page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.ketqua').html(info.list);
                $('input[name=truyen]').val(info.truyen);
                $('input[name=page]').val(info.page);
                $('input[name=link_next]').val(info.link_next);
                if(info.tiep==0){
                    $('button[name=add_link_auto]').html('Bắt đầu');
                }else{
                    $('button[name=add_link_auto]').click();
                }
            }
        });

    });
    /////////////////////////////
    $('button[name=add_paste_auto]').click(function(){
        $('button[name=add_paste_auto]').html('Đang xử lý...');
        truyen=$('input[name=truyen]').val();
        link=$('input[name=nguon]').val();
        noidung=$('textarea[name=noidung]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_paste_chap",
                truyen:truyen,
                link:link,
                noidung:noidung
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.ketqua').html(info.list);
                $('textarea[name=noidung]').val('');
                $('button[name=add_paste_auto]').html('Bắt đầu');
            }
        });

    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup',function(){
        tieu_de=$(this).val();
        cat=$('select[name=category]').val();
        if(tieu_de.length<2){
        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat:cat,
                    tieu_de: tieu_de
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.khung_goi_y ul').html(info.list);
                    if(info.list.length>10){
                        $('.khung_goi_y').show();
                    }else{
                        $('.khung_goi_y').hide();

                    }
                }

            });

        }
        e.stopPropagation();
    });
    /////////////////////////////
    $('.khung_sanpham').on('click','ul li i',function(){
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click','ul li',function(e){
        text=$(this).find('span').text();
        id=$(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="'+id+'"><i class="icon icofont-close-circled"></i><span>'+text+'</span></li>');
        e.stopPropagation();
    });
    /////////////////////////////
    $(document).click(function(){
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});