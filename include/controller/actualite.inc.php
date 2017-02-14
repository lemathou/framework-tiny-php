<?php

class actualite_controller extends controller {

public function param_title($id){
	return actualite()->get($id)->titre;
}

public function param_url($id){
	return actualite()->get($id)->url.'-'.$id;
}

public function view()
{

$actualite = actualite()->get($this->params['actualite_id']);

$page = page('actualite');
$url = "http://www.ardeche-miniatures.com".$page->url($actualite->id);

$this->header['title'] = $actualite->titre.' : Actualité';
$this->header['description'] = header_desc_format($actualite->titre.' : Actualité au parc Ardèche Miniatures');
$this->header['meta'] = array(
	"og:title"=>str_replace('"', "'", $actualite->titre),
	"og:url"=>$url,
	"og:site_name"=>"Ardèche Miniatures",
	"og:type"=>"article",
	"og:image"=>"http://www.ardeche-miniatures.com/img2/300/actualites/$actualite->img",
	"og:description"=>str_replace('"', "'", $actualite->resume),
);

}

}

