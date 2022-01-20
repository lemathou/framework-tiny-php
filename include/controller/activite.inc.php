<?php

class activite_controller extends controller{

function param_url($id){

$activite = activite()->get($id);
return $activite ?$activite->url.'-'.$id :'';

}

function param_title($id){

$activite = activite()->get($id);
return $activite ?$activite->titre :'';

}

public function view()
{

$activite = activite()->get($this->params['activite_id']);

if (empty($activite))
	$this->error404();

$page = page('activite');
$url = "http://www.ardeche-miniatures.com".$page->url($activite->id);

$this->header['title'] = $activite->titre.' : Activité';
$this->header['description'] = header_desc_format($activite->titre.' : Activité au parc Ardèche Miniatures');
$this->header['meta'] = array(
	"og:title"=>str_replace('"', "'", $activite->titre),
	"og:url"=>$url,
	"og:site_name"=>"Ardèche Miniatures",
	"og:type"=>"article",
	"og:image"=>"http://www.ardeche-miniatures.com/img2/300/activites/$activite->img",
	"og:description"=>str_replace('"', "'", $activite->resume),
);

}

}

