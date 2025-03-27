<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: center;" class="hide_mobile"><img src="{minh_hoa}" width="120" onerror="this.src='/images/no-images.jpg';"></td>
	<td style="text-align: left;">{tieu_de}</td>
	<td style="text-align: center;">{tap_moi}</td>
<!-- 	<td style="text-align: center;" class="hide_mobile">{luot_xem}</td> -->
	<td style="text-align: center;">
		<!-- <a href="/admincp/add-chap-auto?truyen={id}" class="edit bg_blue in_line"><i class="fa fa-plus"></i> Thêm chap auto</a> -->
		<a href="/admincp/add-tap?phim={id}" class="edit bg_orange in_line"><i class="fa fa-plus"></i> Thêm tập</a>
		<a href="/admincp/add-tap-nhanh?phim={id}" class="edit bg_gradient in_line"><i class="fa fa-plus"></i> Thêm tập nhanh</a>
		<a href="/admincp/list-tap?phim={id}" class="edit bg_violet in_line"><i class="fa fa-list"></i> List tập</a>
		<a href="/admincp/edit-phim?id={id}" class="edit in_line">Sửa</a>
		<a href="javascript:;" onclick="del('phim','{id}')" class="del in_line">Xóa</a>
	</td>
</tr>