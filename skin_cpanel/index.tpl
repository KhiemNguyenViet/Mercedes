{header}
<body>
  <div class="loadpage">
    <div class="content_loadpage">
      <div class="logox">
        <img src="/skin/css/images/logo.png" alt="logo">
      </div>
      <div class="loadx"></div>
    </div>
  </div>
  <div class="page_body">
    <div class="logo_mobile">
      <img src="/skin/css/images/logo.png" alt="logo">
    </div>
    <div class="menu_top">
      <div class="menu_top_left">
        <div class="drop_down">
          <button><i class="icon icon-list"></i> MENU</button>
          <div class="drop_menu">
            {box_menu}
          </div>
        </div>
        <div class="title_action"><i class="fa fa-th"></i> {title_action}</div>
      </div>
      <div class="menu_top_right">
        <div class="drop_down">
          <button>{fullname} <i class="fa fa-angle-down ml-1"></i></button>
          <div class="drop_menu" style="width: 200px;">
            <div class="drop_item"><b>{fullname}</b>
                <div class="text_muted">{email}</div>
            </div>
            <div class="line"></div>
            <a class="drop_item" href="/admincp/profile"><i class="icon icon-profile"></i> Profile</a>
            <div class="line"></div>
            <a class="drop_item text_danger" href="/admincp/logout"><i class="mr-3 icon icon-switch"></i> Đăng xuất</a>
          </div>
        </div>
      </div>
    </div>
    <div class="box_left">
      <div class="box_menu_left scroll">
        <div class="logo">
          <img src="/skin/css/images/logo.png" alt="logo">
        </div>
        <div class="box_left_content">
          {box_menu}
          <div class="hr"></div>
          <div class="menu_text_center">Administrator Panel</div>
        </div>
      </div>
    </div>
    {box_right}
  </div>
  {box_script_footer}
</body>
</html>