<?php

class societe_index_controller extends controller{

function view(){

header('Location: '.page()->get(12)->url());
die('Redirection...');

}

}

