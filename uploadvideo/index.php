<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Upload with Progress</title>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    .li_file {
      margin-bottom: 10px;
    }
    .progress-bar {
      width: 0;
      background-color: #4caf50;
      height: 20px;
    }
    .name {
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <h1>Video Upload with Progress</h1>
  <form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="file" id="fileInput" accept="video/*" multiple>
    <button type="button" onclick="uploadFiles()">Upload</button>
  </form>
  <div id="fileList"></div>

  <script>
    $("#fileInput").change(function () {
      const files = Array.from($(this)[0].files); // Convert FileList to array
      for (const file of files) {
        const listItem = createFileListItem(file);
        $("#fileList").append(listItem);
      }
    });

    function createFileListItem(file) {
      const listItem = $("<div>").addClass("li_file");
      const progressBar = $("<div>").addClass("progress-bar");
      const nameDiv = $("<div>").addClass("name").text(file.name);

      listItem.append(progressBar, nameDiv);
      return listItem;
    }

    async function uploadFiles() {
      const files = Array.from($("#fileInput")[0].files); // Convert FileList to array

      if (files.length > 0) {
        for (const file of files) {
          const progressBar = $("#fileList").find(".progress-bar").eq(files.indexOf(file));
          await uploadFile(file, progressBar);
        }
      } else {
        console.error("No files selected");
      }
    }

    function uploadFile(file, progressBar) {
      return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append("file", file);

        $.ajax({
          type: "POST",
          url: "upload.php", // Replace with the actual path to your upload.php
          data: formData,
          processData: false,
          contentType: false,
          xhr: function () {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (event) {
              if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBar.width(`${percentComplete}%`);
              }
            });
            return xhr;
          },
          success: function (response) {
            progressBar.width("100%"); // Upload complete
            console.log("File uploaded successfully:", response);

            // Trigger conversion to m3u8
            convertToM3U8(file.name, resolve, reject);
          },
          error: function (error) {
            console.error("Upload failed:", error);
            reject("Upload failed");
          }
        });
      });
    }

    function convertToM3U8(fileName, resolve, reject) {
      $.ajax({
        type: "POST",
        url: "convert.php", // Replace with the actual path to your convert.php
        data: { fileName: fileName },
        success: function (response) {
          console.log("Conversion to m3u8 successful:", response);
          resolve("Conversion successful");
        },
        error: function (error) {
          console.error("Conversion to m3u8 failed:", error);
          reject("Conversion failed");
        }
      });
    }
  </script>
</body>
</html>
