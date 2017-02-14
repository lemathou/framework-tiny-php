<div class="actualite">
<?php $actualite = actualite()->get($actualite_id); ?>
<p style="margin: 0; color: gray;"><?php echo date_mysql($actualite->datetime); ?></p>
<h1><?php echo $actualite->titre; ?></h1>


<div class="text richtext">
<?php echo $actualite->texte; ?>
</div>

<div class="img">
<img src="/<?php echo $actualite->img('img', 660); ?>" style="max-width:660px;" />
</div>

<div class="social" style="margin-top: 20px;">
	<div style="float: right;"><div class="g-plusone" data-annotation="inline" data-width="300"></div></div>
	<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-numposts="5" data-colorscheme="light"></div>
</div>
</div>
