<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include PATH_TEMPLATE."/inc/head.tpl.php"; ?>
</head>

<body>
<main id="page" class="container page_<?php echo $this->ref; ?>">
	<header id="page_header" class="row">
		<?php include PATH_TEMPLATE."/inc/header.tpl.php"; ?>
	</header>

	<div id="page_content" class="row">
		<div id="page_content_middle" class="col-12 offset-lg-1 col-lg-10 offset-xxl-2 col-xxl-8">
		<?php include PATH_TEMPLATE."/page/$this->ref.tpl.php"; ?>
		</div>
	</div>

	<footer>
		<div id="page_content_right" class="row"><div class="offset-5 col-4">
		<?php if (!empty($this->ref_right)) { ?>
			<?php include PATH_TEMPLATE."/right/$this->ref_right.tpl.php"; ?>
		<?php } else { echo '&nbsp;'; } ?>
		</div></div>
		<div id="page_footer" class="row">
			<div class="herisson"><a href="javascript:;"><img src="/img/herisson.png" alt="Hérisson" /></a></div>
		</div>
		<?php if (!empty($this->ref_footer)) { ?>
		<div id="page_footer_actu">
			<?php include PATH_TEMPLATE."/inc/$this->ref_footer.tpl.php"; ?>
		</div>
		<?php } ?>
	</footer>
</main>
<div class="container">
	<div id="page_mentions">
		<?php include PATH_TEMPLATE."/inc/footer_mentions.tpl.php"; ?>
	</div>
</div>
<div id="fb-root"></div>
<?php include PATH_TEMPLATE."/inc/footer_js.tpl.php"; ?>
</body>
</html>

