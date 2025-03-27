<div id="comment_{id}" class="user-comment relative">
    <div class="flex bg-comment">
        <div class="left" onclick="initViewProfile(3386)">
            <div class="avatar"> <img src="{avatar}" onerror="this.src='https://ui-avatars.com/api/?background=random&name={name}'"></div>
        </div>
        <div class="right">
            <div class="flex flex-column">
                <div class="flex flex-space-auto">
                    <div class="flex flex-hozi-center">
                        <div class="nickname">{name}&nbsp;</div>
                        <!-- <div class="color-red fw-700 fs-12" style="color:#f193c0"> {level} </div> -->
                    </div>
                </div>
                <div class="content">{noidung}</div>
                <div class="flex fs-12">
                    <a href="javascript:;" class="margin-r-5 reply_comment" comment_id="{id}" comment_name="{name}">Trả lời</a>
                    <div> {date_post} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="feedback_{id}" class="frame-reply-comments">{list_sub_comment}</div>
<div id="toggle_frame_comment_{id}"></div>