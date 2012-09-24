<?php

include "config.inc.php";
include INCLUDE_DIR."/common.inc.php";

$nb_lettre = 6;
$font_size = 12;

$Captcha = new captcha('PNG');
$Captcha->setStringLenght($nb_lettre);
$Captcha->setFont(INCLUDE_DIR.'/font/'.CAPTCHA_FONT , $font_size);
$Captcha->setBorderColor(0,0,0);
$Captcha->setBorderWidth(0);
$Captcha->setBackgroundColor(255,255,255);
//$Captcha -> setImageWidth(150);
$Captcha -> setImageHeight(24);
$Captcha -> setTextColor(0, 0, 0);
$Captcha -> setTextAngle(0);
$Captcha -> setMarginFromBorder(6);
$Captcha -> setShadow(-5,-5);
$Captcha -> setShadowColor(230, 230, 230);

$_SESSION["_captcha"] = $Captcha->getRandString();
$Captcha->getImage();

?>