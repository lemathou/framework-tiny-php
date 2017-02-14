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

$page = page('miniature');
$url = "http://www.ardeche-miniatures.com".$page->url($miniature->id);

$this->header['title'] = $miniature->titre.' : Miniature';
$this->header['description'] = header_desc_format($miniature->resume.' : Miniature du parc Ardèche Miniatures');
$this->header['meta'] = array(
	"og:title"=>"$miniature->titre",
	"og:url"=>$url,
	"og:site_name"=>"Ardèche Miniatures",
	"og:type"=>"article",
	"og:image"=>"http://www.ardeche-miniatures.com/img2/300/miniature/$miniature->img",
	"og:description"=>$miniature->resume,
);

}

}

