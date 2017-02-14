<div class="evenement">
<?php $evenement = evenement()->get($evenement_id); ?>
<h1><?php echo (($cat=$evenement->cat()) ?$cat.' :<br />' :'').$evenement->titre; ?></h1>
<p class="light"><?php echo $evenement->dates; ?></p>

<div class="text richtext">
<?php echo $evenement->texte; ?>
</div>

<?php if ($evenement->img){ ?>
<div class="img">
<img src="/<?php echo $evenement->img('img', 660); ?>" style="max-width:660px;" />
</div>
<?php } ?>

<div class="social" style="margin-top: 20px;">
	<div style="float: right;"><div class="g-plusone" data-annotation="inline" data-width="300"></div></div>
	<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-href="<?php echo 'http://'.DOMAIN.$this->page->url(); ?>" data-numposts="5" data-colorscheme="light"></div>
</div>
</div>

