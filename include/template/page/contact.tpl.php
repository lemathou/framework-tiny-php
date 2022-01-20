<div class="text_debut">
<?php echo $text_debut; ?>
</div>

<p class="plan_acces"><span>Survolez la carte pour zoomer</span><img src="/img/contact/plan-acces.jpg" alt="Plan d'accès Ardèche Miniatures" width="100%" /></p>

<div class="text_milieu">
<?php echo $text_milieu; ?>
</div>

<iframe width="630" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?ie=UTF8&amp;f=d&amp;daddr=Ard%C3%A8che+Miniatures,+1230+Route+de+N%C3%AEmes,+07130+Soyons&amp;geocode=Ccurj3Ef6doBFfu9rAIdvetJACEM_CqFBC4jCw&amp;gl=FR&amp;hl=fr&amp;t=m&amp;ll=44.875259,4.844477&amp;spn=0.006295,0.008883&amp;output=embed"></iframe><br /><small><a href="https://maps.google.fr/maps?ie=UTF8&amp;f=d&amp;daddr=Ard%C3%A8che+Miniatures,+1230+Route+de+N%C3%AEmes,+07130+Soyons&amp;geocode=Ccurj3Ef6doBFfu9rAIdvetJACEM_CqFBC4jCw&amp;gl=FR&amp;hl=fr&amp;t=m&amp;ll=44.875259,4.844477&amp;spn=0.006295,0.008883&amp;source=embed" style="color:#0000FF;text-align:left">Agrandir le plan</a></small>

<!--
<div class="form">
<form method="post">
<h3>Nous contacter</h3>
<?php if (isset($form["_submitted"])) { ?>
<input type="hidden" name="submitted" />
<?php } ?>
<table cellspacing="0" cellpadding="0">
<tr>
	<td width="160" class="label">Nom *</td>
	<td width="20"></td>
	<td class="label">Prénom *</td>
	</tr>
<tr>
	<td><input name="nom" class="required" value="<?php echo $form["nom"]; ?>" /></td>
	<td></td>
	<td colspan="2"><input name="prenom" class="required" value="<?php echo $form["prenom"]; ?>" /></td>
	</tr>
<tr>
	<td class="label">Adresse</td>
</tr>
<tr>
	<td colspan="4"><input name="adresse" value="<?php echo $form["adresse"]; ?>" /></td>
</tr>
<tr>
	<td class="label">Code postal</td>
	<td width="20"></td>
	<td colspan="2" class="label">Ville *</td>
</tr>
<tr>
	<td><input name="cp" value="<?php echo $form["cp"]; ?>" /></td>
	<td></td>
	<td colspan="2"><input name="ville" value="<?php echo $form["ville"]; ?>" /></td>
</tr>
<tr>
	<td class="label">Tél. *</td>
	<td></td>
	<td colspan="2" class="label">eMail *</td>
</tr>
<tr>
	<td><input name="tel" class="required" value="<?php echo $form["tel"]; ?>" /></td>
	<td></td>
	<td colspan="2"><input name="email" class="required" value="<?php echo $form["email"]; ?>" /></td>
</tr>
<tr>
	<td class="label">Objet du message *</td>
</tr>
<tr>
	<td colspan="4"><input name="objet" class="required" value="<?php echo $form["objet"]; ?>" /></td>
</tr>
<tr>
	<td class="label">Votre message *</td>
</tr>
<tr>
	<td colspan="4"><textarea name="message" class="required"><?php echo $form["message"]; ?></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="label">Code de sécurité :</td>
	<td></td>
	<td style="height: 30px;"><img src="/images/captcha.jpg" alt="CAPTCHA" /></td>
</tr>
<tr>
	<td class="label">Recopiez le code * :</td>
	<td></td>
	<td><input class="captcha" name="_captcha" class="required empty" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><i>* champs requis</i></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right"><input class="submit" type="submit" name="_contact" value="Envoyer" onclick="return form_contact_submit()" /></td>
</tr>
</table>
<?php if (isset($form["_message"])) { ?>
<p class="message"><?php echo $form["_message"]; ?></p>
<?php } ?>
</form>
</div>
-->
