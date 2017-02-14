<h1><?php echo $this->page->titre; ?></h1>
<?php
$sql = 'SELECT DISTINCT c.id
	FROM cat c
	JOIN partenaire p ON p.cat_id=c.id
	WHERE p.active=1';
$q = mysql_query($sql);
$cats = array();
while(list($cat_id)=mysql_fetch_row($q))
	$cats[] = $cat_id;
$page = page()->get('partenaire_cat');
?>
<div class="partenaire_list">
<?php foreach (cat()->select('id IN ('.implode(', ', $cats).')') as $cat) { ?>
<div class="cat">
<h3><?php echo $page->link($cat->id); ?></h3>
<div><?php echo $cat->description; ?></div>
<p class="clear"></p>
</div>
<?php } ?>
</div>

