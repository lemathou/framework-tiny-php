<div class="left_list left_partenaire">
<h3><?php echo page()->get('partenaire_index')->link(); ?></h3>
<?php
$sql = 'SELECT DISTINCT c.id
	FROM cat c
	JOIN partenaire p ON p.cat_id=c.id
	WHERE p.active=1';
$q = mysql_query($sql);
$cats = array();
while(list($i)=mysql_fetch_row($q))
	$cats[] = $i;
$page = page()->get('partenaire_cat');
?>
<ul>
<?php foreach (cat()->select('id IN ('.implode(', ', $cats).')') as $cat) { ?>
<li><?php echo $page->link($cat->id); ?></li>
<?php } ?>
</ul>
</div>

