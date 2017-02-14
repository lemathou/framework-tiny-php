<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include PATH_TEMPLATE."/inc/head.tpl.php"; ?>
</head>

<body>
<div id="page">
<div id="page_header">
<?php include PATH_TEMPLATE."/inc/header.tpl.php"; ?>
</div>

<div id="page_content">
<?php if (!empty($this->ref_left)) { ?>
<div id="page_content_left">
<?php include PATH_TEMPLATE."/left/$this->ref_left.tpl.php"; ?>
</div>
<?php } ?>
<?php if (!empty($this->ref_right)) { ?>
<div id="page_content_right">
<?php include PATH_TEMPLATE."/right/$this->ref_right.tpl.php"; ?>
</div>
<?php } ?>
<div id="page_content_middle">
<?php include PATH_TEMPLATE."/page/$this->ref.tpl.php"; ?>
</div>
<p class="clear"></p>
</div>

<div id="page_footer">
<div class="herisson"><a href="javascript:;"><img src="/img/herisson.png" alt="Hérisson" /></a></div>
</div>
<div id="page_footer_suite">
<?php include PATH_TEMPLATE."/inc/footer_actu.tpl.php"; ?>
</div>

</div>
<div id="page_mentions">
<p style="float:right;margin: 0;">
	<?php echo page()->get(8)->link(); ?> |
	<?php echo page()->get(10)->link(); ?> |
	<?php echo page()->get(18)->link(); ?> |
	<?php echo page()->get(5)->link(); ?>
</p>
<div class=""><?php echo FOOTER_CONTACT_INFO; ?></div>
</div>
<div id="fb-root"></div>
<?php include PATH_TEMPLATE."/inc/footer_js.tpl.php"; ?>
</body>
</html>

