<div class="activite">
<?php $activite = activite()->get($activite_id); ?>
<h1><?php echo $activite->titre; ?></h1>


<div class="text richtext">
<?php echo $activite->texte; ?>
</div>

<?php if ($activite->img) { ?>
<div class="img">
<img src="/<?php echo $activite->img('img', 660); ?>" style="max-width:660px;" />
</div>
<?php } ?>

<div class="social" style="margin-top: 20px;">
	<div style="float: right;"><div class="g-plusone" data-annotation="inline" data-width="300"></div></div>
	<div class="fb-like" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-numposts="5" data-colorscheme="light"></div>
</div>
</div>
