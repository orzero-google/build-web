<?php /* Smarty version 2.6.9, created on 2010-07-05 17:34:13
         compiled from index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>头像测试</title>
<script type="text/javascript">
function updateavatar() {
	window.location.reload();
}
</script>
</head>

<body>
------------------------------当前头像-------------------------------------------<br />
<?php echo $this->_tpl_vars['avatar']; ?>

<br />
----------------------------上传新头像--------------------------------------------<br />
<?php echo $this->_tpl_vars['uc_avatarflash']; ?>

</body>
</html>