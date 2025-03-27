<?php
/*include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$link='https://abyss.to/dashboard/manager?page=2&folder=UVUAFj-3U';
$xxx=$check->getpage($link,$link);
echo $xxx;*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <title>Get Episode Numbers</title>
</head>
<body>

<script>
  $(document).ready(function() {
    // Đoạn mã JSON
    var json = [
      {"tieu_de":"Tân Phàm Nhân Tu Tiên Tập 21 Vietsub 12 Thuyết Minh HD.mp4","link":"https://short.ink/xc8jkVISF"},
      {"tieu_de":"Tân Phàm Nhân Tu Tiên Vietsub 12 Thuyết Minh HD.mp4","link":"https://short.ink/xc8jkVISF"},
      {"tieu_de":"Tân Phàm Nhân Tu Tiên Tập 20 Vietsub Thuyết Minh HD.mp4","link":"https://short.ink/sWSfAkQwd"},
      // ... (Các tập khác)
    ];

    // Lặp qua từng tập và trích xuất số tập từ tiêu đề
    $.each(json, function(index, episode) {
      var tieuDe = episode.tieu_de;
      var match = tieuDe.match(/Tập (\d+)/);

      if (match) {
        var soTap = match[1];
        console.log("Số tập của tập " + (index + 1) + ": " + soTap);
      }
    });
  });
</script>

</body>
</html>
