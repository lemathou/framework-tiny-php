<h1><?php echo $this->page->titre; ?></h1>

<?php echo $edito; ?>

<?php if (count($list = evenement()->select('date_fin>=DATE(NOW()) AND active=1', null, 'date_debut'))) { ?>
<h2>Evénements en cours et à venir :</h2>
<div class="evenement_list content_list">
<?php $page = page()->get(13); ?>
<?php foreach ($list as $evenement){ ?>
<div class="evenement content_link">
<div class="share" style="float: right">
	<div class="fb-like" data-href="<?php echo 'http://'.DOMAIN.$page->url($evenement->id) ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<h3><?php echo $page->link($evenement->id); ?></h3>
<p class="light"><?php echo $evenement->dates; ?></p>
<?php if ($evenement->cat_id) { ?>
<h4><?php echo $evenement->cat(); ?></h4>
<?php } ?>
<div><?php echo $evenement->resume; ?></div>
<p class="clear"></p>
</div>
<?php } ?>
</div>
<?php } ?>

<?php if (count($list = evenement()->select('date_fin<DATE(NOW()) AND active=1', null, 'date_fin DESC'))) { ?>
<h2>Evénements passés :</h2>
<div class="evenement_list content_list">
<?php $page = page()->get(13); ?>
<?php foreach ($list as $evenement){ ?>
<div class="evenement content_link">
<div class="share" style="float: right">
	<div class="fb-like" data-href="<?php echo 'http://'.DOMAIN.$page->url($evenement->id) ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<h3><?php echo $page->link($evenement->id); ?></h3>
<p class="light"><?php echo $evenement->dates; ?></p>
<?php if ($evenement->cat_id) { ?>
<h4><?php echo $evenement->cat(); ?></h4>
<?php } ?>
<div><?php echo $evenement->resume; ?></div>
<p class="clear"></p>
</div>
<?php } ?>
</div>
<?php } ?>

