<?php

class societe_controller extends controller{

public function view()
{

$this->params['ref'] = $this->page->ref;
$this->params['titre'] = $this->page->titre;

}

}

