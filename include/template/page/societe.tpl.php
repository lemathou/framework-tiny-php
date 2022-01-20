<?php if (file_exists($filename="img/societe/".$ref.".jpg")) { ?>
<div class="img">
<img src="/<?php echo $filename; ?>" style="max-width: 333px;" />
</div>
<?php } ?>

<!--<h1 class="titre" style="background-image:url('/images/ssmenu/bandeau-titre-<?php echo $bandeau; ?>.gif');"><?php echo $titre; ?></h1>-->
<h1 class="titre"><?php echo $titre; ?></h1>

<div class="texte">
<?php echo str_replace(['<img', '</iframe>', '<iframe'], ['<img class="img-fluid"', '</iframe></div>', '<div class="embed-responsive"><iframe'], $texte); ?>
</div>

<?php
if (is_dir($dir='img/societe/'.$ref)) {
	if ($dh = opendir($dir)) {
		$file_list = array();
		while (($file = readdir($dh)) !== false) {
			$file_list[] = $file;
		}
		closedir($dh);
		if ($file_nb=count($file_list)) {
?>
<div class="jcarousel-wrapper">
	<div class="jcarousel">
		<ul>
		<?php foreach($file_list as $i) { ?>
			<li><img alt="" src="/img2/600x/societe/<?php echo $ref.'/'.$i; ?>" width="600" /></li>
		<?php } ?>
		</ul>
	</div>
	<a class="jcarousel-control-prev" href="#">&lsaquo;</a> <a class="jcarousel-control-next" href="#">&rsaquo;</a>
	<p class="jcarousel-pagination">&nbsp;</p>
</div>
<?php
		}
	}
}

?>
