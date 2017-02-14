<form class="logout" method="post"><input type="submit" name="_logout" value="Déconnexion" /></form>
<h1>Administration <?php echo SITE_NAME; ?></h1>
<p class="menu"><?php

foreach($admin_menu_list as $i=>$j) if (in_array($_SESSION["account_type"], $j['perms']))
{
	if ($menu_ref==$i)
		echo "<a href=\"$i.php\" class=\"selected\">".$j['label']."</a> ";
	else
		echo "<a href=\"$i.php\">".$j['label']."</a> ";
}

?></p>
<hr style="clear: both;" />
