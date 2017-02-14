<h1><?php echo $this->page->titre; ?></h1>

<?php $page = page()->get(11); ?>
<div class="activite_list content_list">
<?php foreach (activite()->select('active=1', 10) as $activite){ ?>
<div class="activite content_link">
<div class="share" style="float: right">
	<div class="fb-like" data-href="<?php echo 'http://'.DOMAIN.$page->url($activite->id) ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<h3 style="margin-right: 200px;"><?php echo $page->link($activite->id); ?></h3>
<div><?php echo $activite->resume; ?></div>
</div>
<?php } ?>
</div>
