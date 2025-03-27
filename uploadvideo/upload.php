<?php
$uploadDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetDir = $uploadDir . pathinfo($fileName, PATHINFO_FILENAME) . '/';
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the file is a valid video file
if ($videoFileType != "mp4" && $videoFileType != "mov" && $videoFileType != "avi") {
    echo "Sorry, only MP4, MOV, and AVI files are allowed.";
    $uploadOk = 0;
}

// Check if there are no errors
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // Create a directory for each file
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "File uploaded successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
