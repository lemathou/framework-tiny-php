<?php

class realisation_index_controller extends controller{

function view(){

$activites = activite()->select('home_visible=1 AND pos=1');
$activite = array_pop($activites);

header('Location: '.page()->get(23)->url($activite->id));
die('Redirection...');

}

}

