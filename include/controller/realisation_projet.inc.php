<?php

class realisation_projet_controller extends controller{

function param_url($id){

$realisation = realisation()->get($id);
return $realisation->url.'-'.$id;

}

function param_title($id){

$realisation = realisation()->get($id);
return $realisation->titre;

}

}

