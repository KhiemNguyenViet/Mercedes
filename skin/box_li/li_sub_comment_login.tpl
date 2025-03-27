<div id="reply_{id}" class="user-comment relative">
    <div class="flex bg-comment">
        <div class="left">
            <div class="avatar"> <img src="{avatar}" onerror="this.src='https://ui-avatars.com/api/?background=random&name={name}'"></div>
        </div>
        <div class="right">
            <div class="flex flex-column">
                <div class="flex flex-space-auto">
                    <div class="flex flex-hozi-center">
                        <div class="nickname">{name}</div>
                        <!-- <div class="color-red fw-700 fs-12" style="color:#ededed"> {level} </div> -->
                    </div>
                </div>
                <div class="content">{noidung}</div>
                <div class="flex fs-12"> <a href="javascript:;" class="margin-r-5 reply_sub_comment" comment_main="{reply}" comment_id="{id}" comment_name="{name}">Trả lời</a>
                    <div> {date_post} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="feedback_{id}" class="frame-reply-comments"></div>
<div id="toggle_frame_comment_{id}"></div>