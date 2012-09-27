<h1>Administration D2P</h1>
<form class="logout" method="post"><input type="submit" name="_logout" value="Déconnexion" /></form>
<p class="menu"><?php

foreach($admin_menu_list as $i=>$j)
{
	if ($menu_ref==$i)
		echo "<a href=\"$i.php\" class=\"selected\">$j</a>";
	else
		echo "<a href=\"$i.php\">$j</a>";
}

?></p>
<hr style="clear: both;" />
