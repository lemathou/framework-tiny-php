<?php

class partenaire_controller extends controller {

public function param_title($id){
	return partenaire()->get($id)->nom;
}

public function param_url($id){
	return partenaire()->get($id)->url.'-'.$id;
}

public function view()
{

$partenaire = partenaire()->get($this->params['partenaire_id']);

$this->header['title'] = $partenaire->titre.' : Partenaire';
$this->header['description'] = header_desc_format($partenaire->titre.' : Partenaire du parc Ardèche Miniatures');

}

}

