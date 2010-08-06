<?php
/************************************************************
* FILE_NAME : cp.php   
* FILE_PATH : D:\AppServ\www\ucflash\cp.php
* 头像入口文件
*
* @copyright Copyright (c) 2009 - 2010 www.buynow.com.cn 
* @author BUYNOW项目组 deck
* 
* @version Mon Jul 05 17:36:19 CST 2010
**************************************************************/
require_once('configs.global.php');
require_once('config.Smarty.php');

require_once('avatar.php');
$objAvatar = new Avatar();

$_SESSION['v5_user_id'] = 1;
//头像
$tpl->assign('avatar', $objAvatar->avatar_show($_SESSION['v5_user_id'],'big'));
	
$uc_avatarflash = $objAvatar->uc_avatar(1, (empty($_SCONFIG['avatarreal'])?'virtual':'real'));

$tpl->assign('uc_avatarflash',$uc_avatarflash);

$tpl->display('index.html');
?>