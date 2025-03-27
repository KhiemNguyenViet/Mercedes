<?php
$videoPath = 'video.mp4';  // Đường dẫn đến file video.mp4
$outputPath = 'video/';    // Thư mục đầu ra cho file m3u8

// Kiểm tra nếu thư mục đầu ra không tồn tại, tạo mới
if (!file_exists($outputPath)) {
    mkdir($outputPath, 0777, true);
}

// Lệnh FFmpeg để tạo file m3u8
//$ffmpegCommand = "ffmpeg -i {$videoPath} -c:v libx264 -c:a aac -strict -2 -f hls -hls_time 10 -hls_list_size 0 {$outputPath}video.m3u8";

// Thực thi lệnh FFmpeg
//exec($ffmpegCommand);

// Đường dẫn đến file m3u8
$m3u8FilePath = $outputPath . 'video.m3u8';

// Đọc nội dung của file m3u8
$m3u8Content = file_get_contents($m3u8FilePath);

// Tìm và thay thế đuôi .ts thành .png trong nội dung
$m3u8Content = str_replace('.ts', '.png', $m3u8Content);

// Ghi nội dung mới vào file m3u8

// Lấy danh sách tệp tin trong thư mục
$files = scandir($outputPath);

// Duyệt qua từng tệp tin
foreach ($files as $filename) {
    $oldFilePath = $outputPath . "/" . $filename;

    // Kiểm tra nếu là tệp tin .ts
    if (pathinfo($filename, PATHINFO_EXTENSION) === "ts") {
        // Đổi tên tệp tin từ .ts thành .png
        $newFilePath = $outputPath . "/" . pathinfo($filename, PATHINFO_FILENAME) . ".png";
        
        // Thực hiện đổi tên
        rename($oldFilePath, $newFilePath);
        
        echo "Đã đổi tên: $oldFilePath thành $newFilePath<br>";
    }
}

?>

echo 'Đã đổi đuôi .ts thành .png và định dạng lại tên file cho các file trong m3u8!';
?>
