<?php

class realisation_controller extends controller{

function param_url($id){

$activite = activite()->get($id);
return $activite->url.'-'.$id;

}

function param_title($id){

$activite = activite()->get($id);
return $activite->titre;

}

}

