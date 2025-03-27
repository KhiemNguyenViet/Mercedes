<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .li_ketqua {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 5px;
    }

    .process {
      width: 0;
      height: 20px;
      background-color: #4CAF50;
      color: white;
      text-align: center;
      line-height: 20px;
    }
  </style>
</head>
<body>
<?php echo $maxFileSize = ini_get('upload_max_filesize');?>
<input type="file" id="files" multiple />
<div id="ketqua"></div>

<script>
  const filesInput = document.getElementById('files');
  const ketquaDiv = document.getElementById('ketqua');

  filesInput.addEventListener('change', handleFileSelect);

  async function handleFileSelect(event) {
    const files = Array.from(event.target.files);

    if (files.length > 0) {
      // Append files to the result list
      updateFileList(files);

      // Start uploading files
      await uploadFiles(files);
    }
  }

  function updateFileList(files) {
    files.forEach(file => {
      const liKetqua = document.createElement('div');
      liKetqua.className = 'li_ketqua';

      const processDiv = document.createElement('div');
      processDiv.className = 'process';
      processDiv.innerHTML = '0%';

      const nameDiv = document.createElement('div');
      nameDiv.className = 'name';
      nameDiv.innerHTML = file.name;

      liKetqua.appendChild(processDiv);
      liKetqua.appendChild(nameDiv);
      ketquaDiv.appendChild(liKetqua);
    });
  }

  async function uploadFiles(files) {
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const progressDiv = ketquaDiv.children[i].querySelector('.process');

      try {
        await uploadFile(file, progressDiv);
        console.log(`Upload of ${file.name} completed`);
        updateProcessStatus(progressDiv, '100%');
      } catch (error) {
        console.error(`Error during upload of ${file.name}`);
        updateProcessStatus(progressDiv, 'Error');
      }
    }
  }

  async function uploadFile(file, progressDiv) {
    const formData = new FormData();
    formData.append('file', file);

    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();

      xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
          const percentCompleted = Math.round((event.loaded / event.total) * 100);
          updateProcessStatus(progressDiv, percentCompleted + '%');
        }
      });

      xhr.onload = function() {
        if (xhr.status === 200) {
          resolve();
        } else {
          reject('Upload failed');
        }
      };

      xhr.onerror = function() {
        reject('Error during upload');
      };

      xhr.open('POST', '/process_upload.php', true);
      xhr.send(formData);
    });
  }

  function updateProcessStatus(progressDiv, status) {
    progressDiv.style.width = status;
    progressDiv.innerHTML = status;
  }
</script>

</body>
</html>
