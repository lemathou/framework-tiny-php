<div class="bandeau">
<div class="logo"><a href="/"><img src="/images/Bandeau/logo-pole-promotion.png" alt="D2P Développement Patrimoine Partenariat" /></a></div>
<div class="login">
<form method="post">
	<h3>Espace client</h3>
	<?php if (isset($_SESSION["account_id"])) { ?>
	<input type="hidden" name="_logout" />
	<p><?php echo $_SESSION["account_name"]; ?></p>
	<p><input type="submit" value="Déconnexion" /></p>
	<?php if ($_SESSION["account_type"]=="admin") { ?><p><a href="/admin/">Administration</a></p><?php } ?>
	<?php } else { ?>
	<input type="hidden" name="_login" />
	<p><input type="text" name="username" value="identifiant" /></p>
	<p><input type="hidden" name="password" value="" /><input type="password" name="password_bis" value="********" /> <input type="submit" value="OK" class="ok" /></p>
	<p class="oublie"><?php echo page()->get_ref('password')->link(); ?></p>
	<?php } ?>
</form>
</div>
</div>

<?php $menu_nb = count($this->menutop); ?>
<div class="menu" style="margin-left: <?php echo round((959-(130*$menu_nb))/2); ?>px;"><table cellspacing="0" cellpadding="0"><tr>
<?php

foreach($this->menutop as $id=>$row)
{
	//var_dump($row); die();
	if (!$row['page_id'] || !($p=page()->get($row["page_id"])))
		continue;
	
	echo "<td><div class=\""."menu_".$p->ref.(($this->page->id==$p->id)?" on":" dis")."\">";
	echo "<h3>".$p->link($row['params'])."</h3>";
	//echo "<img src=\"images/Menu/menu-".$j["ref"]."-".(($page_id==$j["id"])?"2":"1").".gif\" alt=\"".$j["titre"]."\" />";
	if (isset($row["smenu"]) && count($row["smenu"]))
	{
		echo "<div class=\"ssmenu\">";
		foreach($row["smenu"] as $row2)
		{
			if (!$row2['page_id'] || !($p2=page()->get($row2["page_id"])))
				continue;
			//var_dump($row2['params']);
			$param_id = count($row2['params']) ?current($row2['params']) :null;
			echo "<h4 class=\"".(($this->page->id==$p2->id && (!$param_id || $param_id==$this->page->param_id))?"on":"dis")."\">".$p2->link($param_id)."</h4>";
		}
		echo "</div>";
	}
	echo "</div></td>\n";
}
?>
</tr></table></div>
