<?php $miniature = miniature()->get($miniature_id); ?>
<div class="miniature">
<h1><?php echo $miniature->titre; ?></h1>


<div class="text richtext">
<?php echo $miniature->texte; ?>
</div>

<?php if ($miniature->img) { ?>
<div class="img">
<img src="/<?php echo $miniature->img('img', 1280); ?>" />
</div>
<?php } ?>

<div class="social" style="margin-top: 20px;">
	<div style="float: right;"><div class="g-plusone" data-annotation="inline" data-width="300"></div></div>
	<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-numposts="5" data-colorscheme="light"></div>
</div>
</div>
