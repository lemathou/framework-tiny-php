<?php

class miniature_controller extends controller{

function param_url($id){

$miniature = miniature()->get($id);
return $miniature ?$miniature->url.'-'.$id :'';

}

function param_title($id){

$miniature = miniature()->get($id);
return $miniature ?$miniature->titre :'';

}

public function view()
{

$miniature = miniature()->get($this->params['miniature_id']);

if (empty($miniature))
	$this->error404();

$page = page('miniature');
$url = (SSL ?"https" :"http")."://".DOMAIN.$page->url($miniature->id);

$this->header['title'] = $miniature->titre.' : Miniature';
$this->header['description'] = header_desc_format($miniature->resume.' : Miniature : '.SITE_NAME);
$this->header['meta'] = array(
	"og:title"=>"$miniature->titre",
	"og:url"=>$url,
	"og:site_name"=>SITE_NAME,
	"og:type"=>"article",
	"og:image"=>(SSL ?"https" :"http")."://".DOMAIN."/img2/300/miniature/$miniature->img",
	"og:description"=>$miniature->resume,
);

}

}

