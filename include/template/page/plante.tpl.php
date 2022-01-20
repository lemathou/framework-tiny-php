<?php $plante = plante()->get($plante_id); ?>
<div class="plante">
<h1><?php echo $plante->titre; ?></h1>


<div class="text richtext">
<?php echo $plante->texte; ?>
</div>

<?php if ($plante->img) { ?>
<div class="img">
<img src="/<?php echo $plante->img('img', 1280); ?>" />
</div>
<?php } ?>

<div class="social" style="margin-top: 20px;">
	<div style="float: right;"><div class="g-plusone" data-annotation="inline" data-width="300"></div></div>
	<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-numposts="5" data-colorscheme="light"></div>
</div>
</div>
