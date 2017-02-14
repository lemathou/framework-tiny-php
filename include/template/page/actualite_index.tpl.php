<h1><?php echo $this->page->titre; ?></h1>

<?php $page = page()->get(9); ?>
<div class="actualite_list content_list">
<?php foreach (actualite()->select('active=1', 10, 'datetime desc') as $actualite){ ?>
<div class="actualite content_link">
<div class="share" style="float: right">
	<div class="fb-like" data-href="<?php echo 'http://'.DOMAIN.$page->url($actualite->id) ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<h3 style="margin-right: 200px;"><?php echo $page->link($actualite->id); ?></h3>
<p style="margin: 0; color: gray;"><?php echo date_mysql($actualite->datetime); ?></p>
<div><?php echo $actualite->resume; ?></div>
</div>
<?php } ?>
</div>

