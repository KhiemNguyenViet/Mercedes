<div class="ah-frame-bg">
    <div class="flex flex-space-auto">
        <div class="fw-700 fs-16 color-yellow-2 flex flex-hozi-center">
            <span class="material-icons-round margin-0-5"></span>Bình luận <span class="total_comment"></span>
        </div>
        <div id="refresh-comments" class="cursor-pointer"><span class="material-icons-round fs-35">refresh</span></div>
    </div>
    <div id="frame-comment">
        <div class="comment-editor relative flex flex-column margin-t-10">
            <textarea class="content-of-comment" placeholder="Nhập bình luận của bạn tại đây" rows="3" maxlength="5000"></textarea>
            <div class="tool-bar flex flex-space-auto">
                <div>
                </div>
                <div>
                    <div class="add-comment add_main_comment button-default bg-red color-white">Gửi bình luận</div>
                </div>
            </div>
        </div>
    </div>
    <div id="comments" class="margin-t-10">
        <div class="ah_loading">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</div>