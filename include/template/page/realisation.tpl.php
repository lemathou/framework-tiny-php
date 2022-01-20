<?php $activite = activite()->get($activite_id); ?>
<?php if (file_exists($filename="images/Metiers/realisations-".$activite->ref.".jpg")) { ?>
<div class="img">
<img src="/<?php echo $filename; ?>" />
</div>
<?php } ?>

<h1 style="background-image:url('/images/ssmenu/bandeau-titre-<?php echo $activite->bandeau; ?>.gif');"><?php echo $activite->titre; ?></h1>

<div class="texte">
<?php
echo $activite->texte_rea;
if (count($list=realisation()->select("activite_id='".$activite->id."' AND afficher=1")))
{
	echo "<h4>Réalisations &amp; Références</h4>";
	echo "<ul>";
	foreach($list as $rea)
	{
		echo "<li><a href=\"".page()->get(27)->url($rea->id)."\">".$rea->titre."</a></li>\n";
	}
	echo "</ul>";
}
?>
</div>
