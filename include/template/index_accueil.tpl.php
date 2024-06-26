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
		<div id="page_content_middle" class="col-12">
		<?php include PATH_TEMPLATE."/page/$this->ref.tpl.php"; ?>
		</div>
	</div>

	<footer>
		<div id="page_content_right" class="row"><div class="offset-5 col-4">
		<?php if (!empty($this->ref_right)) { ?>
			<?php include PATH_TEMPLATE."/right/$this->ref_right.tpl.php"; ?>
		<?php } ?>
		</div></div>
		<div id="page_footer" class="row">
			<div class="herisson"><a href="javascript:;"><img src="/img/herisson.png" alt="Hérisson" /></a></div>
		</div>
		<div id="page_footer_actu">
			<?php include PATH_TEMPLATE."/inc/footer_actu.tpl.php"; ?>
		</div>
</main>
<div class="container">
	<div id="page_mentions">
		<div class="row">
			<div class="col-12 col-lg-3">
				<?php echo FOOTER_CONTACT_INFO; ?>
			</div>
			<div class="col-12 col-lg-3">
				<?php echo FOOTER_CONTACT_INFO2; ?>
			</div>
			<div class="col-12 col-lg-6" style="text-align:right;">
				<?php echo page()->get(8)->link(); ?> |
				<?php echo page()->get(10)->link(); ?> |
				<?php echo page()->get(18)->link(); ?> |
				<?php echo page()->get(5)->link(); ?>
			</div>
		</div>
	</div>
</div>
<div id="fb-root"></div>
<?php include PATH_TEMPLATE."/inc/footer_js.tpl.php"; ?>
</body>
</html>

