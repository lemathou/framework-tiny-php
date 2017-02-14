<?php

class accueil_controller extends controller{

function view(){

$activite_list = activite()->select(null, null, "pos");
//var_dump($activite_list);

$img_list = array(
	'amenagement', 'batiment', 'conseil', 'management'
);

global $activite_list, $img_list;

}

}

