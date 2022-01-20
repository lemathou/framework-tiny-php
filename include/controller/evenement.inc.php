<?php

class evenement_controller extends controller {

public function param_title($id){
	if (is_numeric($id) && ($evenement=evenement()->get($id)))
		return $evenement->titre;
}

public function param_url($id){
	if (is_numeric($id) && ($evenement=evenement()->get($id)))
		return $evenement->url.'-'.$id;
}

public function view()
{

$evenement = evenement()->get($this->params['evenement_id']);

if (empty($evenement))
	$this->error404();

$page = page('evenement');
$url = "http://www.ardeche-miniatures.com".$page->url($evenement->id);

$this->header['title'] = $evenement->titre;
$this->header['description'] = header_desc_format($evenement->resume.' : Evénement au parc Ardèche Miniatures');
$this->header['meta'] = array(
	"og:title"=>str_replace('"', "'", $evenement->titre),
	"og:url"=>$url,
	"og:site_name"=>"Ardèche Miniatures",
	"og:type"=>"article",
	"og:image"=>"http://www.ardeche-miniatures.com/img2/300/evenement/$evenement->img",
	"og:description"=>str_replace('"', "'", $evenement->resume),
);

}

}

