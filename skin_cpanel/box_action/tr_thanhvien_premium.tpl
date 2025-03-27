<tr id="tr_{user_id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;color: red;font-weight: 700;">{user_id}</td>
	<td style="text-align: left;">{username}</td>
	<td style="text-align: left;" class="hide_mobile">{name}</td>
	<td style="text-align: left;" class="hide_mobile">{email}</td>
	<td style="text-align: center;" class="hide_mobile">{user_money}</td>
	<td style="text-align: center;" class="hide_mobile">{loai}</td>
	<td style="text-align: center;" class="hide_mobile">{tinh_trang}</td>
	<td style="text-align: center;" class="hide_mobile">{date_vip}</td>
	<td style="text-align: center;">
		<a href="/admincp/add-coin?id={user_id}" class="edit bg_violet">Add coin</a><a href="/admincp/edit-thanhvien?id={user_id}" class="edit">Chi tiết</a><a href="javascript:;" onclick="del('thanhvien','{user_id}');" class="del">xóa</a>
	</td>
</tr>