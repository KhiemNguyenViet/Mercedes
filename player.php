<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex" />
    <base href="/" />
    <title>Đại Vương Tha Mạng Tập 15 Vietsub Thuyết Minh HD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/hhplayer/netflix.css">
    <script src="/hhplayer/jwplayer.js"></script>
    <script src="/hhplayer/vast.js"></script>
    <script src="/hhplayer/hls.min.js"></script>
    <script src="/hhplayer/jwplayer.hlsjs.min.js"></script>
    <script src="/hhplayer/tvc.js"></script>
    <style type="text/css">
        html,
        body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
        
        #player-embed,
        iframe {
            width: 100%;
            height: 100%;
        }
    </style>
<style type="text/css">
    /* Thêm đoạn mã CSS sau để thay đổi kích thước của nút tải xuống */
    div[button="download-video-button"]{
      height: 50px !important;
      width: 100px !important;
    }
  div[button="download-video-button"] .jw-button-image {
      /* Thêm các thuộc tính CSS theo ý muốn của bạn */
      width: 100%;
      height: 100%;
  }
</style>
    <script type="text/javascript">
        jwplayer.key = "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=";
    </script>
</head>
<body marginwidth="0" marginheight="0">
    <div id="player-fake"></div>
    <script>
        var wap = navigator.userAgent.match(/iPad|iPhone|Android|Linux|iPod/i) != null;
        var playerInstance = jwplayer('player-fake');
        playerInstance.setup({
            file: '/uploadvideo/uploads/2/playlist.m3u8',
            width: '100%',
            height: '100%',
            primary: 'html5',
            controls: true,
            tracks: [{
                "file": "",
                "kind": "captions",
                label: "US",
                default: "true"
            }],
            playbackRateControls: [0.5, 0.75, 1, 1.5, 2],
            logo: {
                file: "",
                logoBar: "",
                link: "https://phimhh.net",
                position: "top-left"
            },
            skin: {
                name: "netflix"
            },
            sharing: true,
            displaytitle: true,
            displaydescription: true,
            abouttext: "Powered by phimhh.net",
            aboutlink: "https://phimhh.net",
            image: '',
            autostart: false,
            // aspectratio: '16:9',

            "intl": {
                "en": {
                    "errors": {
                        "cantPlayVideo": "An error occurred while loading the video, please try reloading the page or choose another server to watch!"
                    }
                }
            }
        });
        playerInstance.on("ready", function() {
            const buttonId ="download-video-button";
            const iconPath ="https://phimhh.net/skin/css/images/logo.png";
            const tooltipText = "PHIMHH.NET";

            // Call the player's `addButton` API method to add the custom button
            playerInstance.addButton(iconPath, tooltipText, buttonClickAction, buttonId);

            // This function is executed when the button is clicked
            function buttonClickAction() {
                const playlistItem = playerInstance.getPlaylistItem();
                const anchor = document.createElement("a");
                const fileUrl = playlistItem.file;
                anchor.setAttribute("hef", fileUrl);
                const downloadName = playlistItem.file.split("/").pop();
                anchor.setAttribute("download", downloadName);
                anchor.style.display = "none";
                document.body.appendChild(anchor);
                anchor.click();
                document.body.removeChild(anchor);
            }

            // Move the timeslider in-line with other controls
            const playerContainer = playerInstance.getContainer();
            const buttonContainer = playerContainer.querySelector(".jw-button-container");
            const spacer = buttonContainer.querySelector(".jw-spacer");
            const timeSlider = playerContainer.querySelector(".jw-slider-time");


            // Detect adblock
            playerInstance.on("adBlock", () => {
                const modal = document.querySelector("div.modal");
                modal.style.display = "flex";

                document
                    .getElementById("close")
                    .addEventListener("click", () => location.reload());
            });

            // Forward 10 seconds
            const rewindContainer = playerContainer.querySelector(
                ".jw-display-icon-rewind"
            );
            const forwardContainer = rewindContainer.cloneNode(true);
            const forwardDisplayButton = forwardContainer.querySelector(
                ".jw-icon-rewind"
            );
            forwardDisplayButton.style.transform = "scaleX(-1)";
            forwardDisplayButton.ariaLabel = "Forward 10 Seconds";
            const nextContainer = playerContainer.querySelector(".jw-display-icon-next");
            nextContainer.parentNode.insertBefore(forwardContainer, nextContainer);

            // control bar icon
            playerContainer.querySelector(".jw-display-icon-next").style.display = "none"; // hide next button
            const rewindControlBarButton = buttonContainer.querySelector(
                ".jw-icon-rewind"
            );
            const forwardControlBarButton = rewindControlBarButton.cloneNode(true);
            forwardControlBarButton.style.transform = "scaleX(-1)";
            forwardControlBarButton.ariaLabel = "Forward 10 Seconds";
            rewindControlBarButton.parentNode.insertBefore(
                forwardControlBarButton,
                rewindControlBarButton.nextElementSibling
            );

            // add onclick handlers
            [forwardDisplayButton, forwardControlBarButton].forEach((button) => {
                button.onclick = () => {
                    playerInstance.seek(playerInstance.getPosition() + 10);
                };
            });
        });
    </script>
</body>

</html>