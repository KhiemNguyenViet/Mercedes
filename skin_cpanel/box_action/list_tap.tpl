<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title page_title_2" style="margin-top: 20px;">
			<div class="box_search"><input type="text" name="input_search_chap" truyen="{truyen}" placeholder="Nhập từ khóa tìm kiếm và bấm enter"></div>
		</div>
		<div style="clear: both;"></div>
		<div class="page_title" style="margin-top: 40px;">
		    <h1 class="undefined">Danh sách tập <span class="color_green">{tieu_de}</span></h1><a href="/admincp/add-tap?phim={phim}"><button><i class="fa fa-plus"></i> Thêm tập mới</button></a>
		    <div class="line"></div>
		    <hr>
		</div>
		<style type="text/css">
			.list_baiviet i{
				font-size: 35px;
			}
		</style>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
				<th style="text-align: left;">Tiêu đề</th>
				<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
				<th style="text-align: center;width: 100px;">Hành động</th>
			</tr>
			{list_tap}
		</table>
		{phantrang}
  	</div>
  </div>
</div>