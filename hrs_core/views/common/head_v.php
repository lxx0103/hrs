<!DOCTYPE html>
<html lang="en">
<head>
<title>后台管理系统</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/assets/css/datepicker.css" />
<link rel="stylesheet" href="/assets/css/matrix-style.css" />
<link rel="stylesheet" href="/assets/css/matrix-media.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/assets/css/bootstrap-multiselect.css" />
<link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="#">考勤管理系统</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="#"><i class="icon icon-user"></i>  <span class="text"><?=$user['username']?>(<?=$user['role_name']?>)</span></a></li>
    <li class=""><a title="" href="/auth/logout"><i class="icon icon-share-alt"></i><span class="text">退出登录</span></a></li>
  </ul>
</div>


<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i>Tables</a>
  <ul>
    <?php foreach ($menus as $menu):?>
    <?php if(isset($menu['child'])):?>
    <li class="submenu <?=$menu['id']==$current_menu['parent_id']?' open':''?>">
      <a href="javascript:(void)">
        <i class="icon icon-th-list"></i>
        <span><?=$menu['name']?></span>
        <i class="icon icon-chevron-<?=$menu['id']==$current_menu['parent_id']?'down':'left'?>" style='float: right;'></i>
      </a>
      <ul>
        <?php foreach ($menu['child'] as $submenu):?>
        <li <?=$submenu['id']==$current_menu['id']?'class="active"':''?>>
          <a href="<?=$submenu['dir']==''?'':'/'.$submenu['dir']?><?=$submenu['controller']==''?'':'/'.$submenu['controller']?><?=$submenu['method']==''?'':'/'.$submenu['method']?>">
            <i class="icon icon-bookmark"></i>
            <span><?=$submenu['name']?></span>
          </a> 
        </li>
        <?php endforeach;?>
      </ul>
    </li>
    <?php else:?>
    <li <?=$menu['id']==$current_menu['id']?'class="active"':''?>>
      <a href="<?=$menu['dir']==''?'':'/'.$menu['dir']?><?=$menu['controller']==''?'':'/'.$menu['controller']?><?=$menu['method']==''?'':'/'.$menu['method']?>">
        <i class="icon icon-th-list"></i>
        <span><?=$menu['name']?></span>
      </a>
    </li>
    <?php endif;?> 
    <?php endforeach;?>
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <?php if($current_menu['parent_id'] != 0):?>
      <a href="javascript:(void)" title="<?=$menus[$current_menu['parent_id']]['name']?>" class="tip-bottom"><i class="icon-home"></i><?=$menus[$current_menu['parent_id']]['name']?></a> 
      <?php endif;?>
      <a href="javascript:(void)" class="current"><?=$current_menu['name']?></a> 
    </div>
  </div>