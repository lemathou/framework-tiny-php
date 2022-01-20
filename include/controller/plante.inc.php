<?php

class plante_controller extends controller{

function param_url($id){

$plante = plante()->get($id);
return $plante ?$plante->url.'-'.$id :'';

}

function param_title($id){

$plante = plante()->get($id);
return $plante ?$plante->titre :'';

}

public function view()
{

$plante = plante()->get($this->params['plante_id']);

if (empty($plante))
	$this->error404();

$page = page('plante');
$url = (SSL ?"https" :"http")."://".DOMAIN."/".$page->url($plante->id);

$this->header['title'] = $plante->titre.' : Plante';
$this->header['description'] = header_desc_format($plante->resume.' : Plante : '.SITE_NAME);
$this->header['meta'] = array(
	"og:title"=>"$plante->titre",
	"og:url"=>$url,
	"og:site_name"=>SITE_NAME,
	"og:type"=>"article",
	"og:image"=>(SSL ?"https" :"http")."://".DOMAIN."/img2/300/plante/$plante->img",
	"og:description"=>$plante->resume,
);

}

}

