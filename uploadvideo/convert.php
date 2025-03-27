<?php
$fileName = $_POST["fileName"];
$inputFilePath = "uploads/" . pathinfo($fileName, PATHINFO_FILENAME) . '/' . $fileName;
$outputDir = "uploads/" . pathinfo($fileName, PATHINFO_FILENAME) . "/";
$outputPath = $outputDir . "playlist.m3u8";
$tsFileNamePattern = $outputDir . "%d.ts";

$ffmpegCommand = "ffmpeg -i $inputFilePath -c:v libx264 -hls_time 10 -hls_list_size 0 -c:a aac -strict -2 -start_number 1 -f hls -hls_segment_filename $tsFileNamePattern $outputPath";
//ffmpeg -i video.mp4 -c:v libx264 -hls_time 10 -hls_list_size 0 -c:a aac -strict -2 -start_number 1 -f hls -hls_segment_filename %d.ts playlist.m3u8
exec($ffmpegCommand, $output, $returnCode);

if ($returnCode == 0) {
    echo "Conversion to m3u8 successful.";
} else {
    echo "Error converting to m3u8.";
}
?>
