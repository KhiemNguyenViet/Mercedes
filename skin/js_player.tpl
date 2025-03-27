<script>
    var wap = navigator.userAgent.match(/iPad|iPhone|Android|Linux|iPod/i) != null;
    var playerInstance = jwplayer('video-player');
    playerInstance.setup({
        file: 'https://api.cloudbeta.win/file/play/92a70ea0-b161-4740-9165-af1582fd1b16.m3u8',
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
            link: "https://knvc.vn",
            position: "top-left"
        },
        skin: {
            name: "netflix"
        },
        repeat: true,
        sharing: true,
        displaytitle: true,
        displaydescription: true,
        abouttext: "Powered by PHIMHH.NET",
        aboutlink: "https://phimhh.net",
        image: '/images/knvc.vn.jpg',
        //autostart: true,
        aspectratio: '16:9',

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