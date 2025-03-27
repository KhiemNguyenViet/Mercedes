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
                    <div class="flex flex-hozi-center relative"><a href="javascript:;" onclick="clickEventDropDown(this,'expand_more')" class="toggle-dropdown fs-21 inline-flex" bind="drop-down-oc-{id}"><span class="material-icons-round">expand_more</span></a>
                        <div id="drop-down-oc-{id}" class="dropdown-option bg-black">
                            <div class="edit_reply" reply_id="{id}"><span class="material-icons-round margin-0-5">edit</span>Sửa</div>
                            <div class="hide_reply" reply_id="{id}"><span class="material-icons-round margin-0-5">hide_source</span>Ẩn</div>
                        </div>
                    </div>
                </div>
                <div class="content">{noidung}</div>
                <div class="flex fs-12"> <a href="javascript:void(0)" class="margin-r-5 reply_sub_comment" comment_main="{reply}" comment_id="{id}" comment_name="{name}">Trả lời</a>
                    <div> {date_post} </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="feedback_{id}" class="frame-reply-comments"></div>
<div id="toggle_frame_comment_{id}"></div>