<?php

class cat_controller extends controller {

public function param_title($id){
	return cat()->get($id)->titre;
}

public function param_url($id){
	return cat()->get($id)->url.'-'.$id;
}

public function view()
{

$cat = cat()->get($this->params['cat_id']);

$this->header['title'] = $cat->titre;
$this->header['description'] = header_desc_format($cat->resume);

}

}

