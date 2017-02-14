<h1><?php echo $this->page->titre; ?></h1>

<h2>Renvoi de mot votre de passe :</h2>

<?php if ($form["form_aff"]) { ?>
<?php echo $info; ?>
<form method="post">
<table cellspacing="0" cellpadding="0" style="margin-top: 10px;">
<tr>
	<td width="250">Adresse électronique / Identifiant :</td>
	<td width="400"><input name="email" style="width: 100%;" value="<?php echo $form["email"]; ?>" /></td>
</tr>
<tr>
	<td>Code de sécurité :</td>
	<td><input name="_captcha" size="6" /> &lt; recopiez le texte suivant <img src="/images/captcha.jpg" alt="" align="right" /></td>
	<td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="_password" value="Me renvoyer mon mot de passe" /></td>
</tr>
</table>
</form>
<?php } ?>
<?php if ($form["message"]) { ?>
<div style="margin-top: 10px;">
<p style="color: red;"><?php echo $form["message"]; ?></p>
</div>
<?php } ?>
