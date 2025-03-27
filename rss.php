<?php
header("Content-type: text/xml; charset=UTF-8");
function xml_entities($string) {
	return str_replace(
		array("&", "<", ">", '"', "'"), array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;"), $string
	);
}
$conn = mysqli_connect("localhost", "nguoiketruyen", "Qaz!@#123", "nguoiketruyen") or die("Khong the ket noi CSDL");
mysqli_set_charset($conn, "utf8");
$thongtin = mysqli_query($conn, "SELECT * FROM truyen ORDER BY truyen_id DESC LIMIT 500");
$items = '';
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$items .= '<item>';
	$items .= "<title>" . xml_entities($r_tt['truyen_tieude']) . "</title>";
	$items .= "<link>" . xml_entities("https://nguoiketruyen.com/truyen/{$r_tt['truyen_link']}.html") . "</link>";
	$items .= "<description>" . xml_entities($r_tt['truyen_description']) . "</description>";
	$items .= "<guid>" . xml_entities("https://nguoiketruyen.com/truyen/{$r_tt['truyen_link']}.html") . "</guid>";
	$items .= '</item>';
}
echo '<?xml version="1.0"?>
<rss version="2.0">
    <channel>
        <title>' . xml_entities('Website Đọc Truyện Mới Nhất Truyện Online Hay Nhất Cập Nhật Nhanh Nhất') . '</title>
        <link>' . xml_entities('https://nguoiketruyen.com') . '</link>
        <description>' . xml_entities('Truyện Full - Đọc truyện online, đọc truyện chữ, truyện hay. Website luôn cập nhật những bộ truyện mới thuộc các thể loại đặc sắc như truyện tiên hiệp, truyện kiếm hiệp, hay truyện ngôn tình một cách nhanh nhất. Hỗ trợ mọi thiết bị như di động và máy tính bảng.') . ' </description>
        <language>vi_VN</language>
        ' . $items . '
    </channel>
</rss>';