<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="fr-fr" />

<title><?php echo $this->header["title"]; ?></title>
<meta name="description" content="<?php echo $this->header["description"]; ?>" />
<meta name="author" content="Ardèche Miniatures" />
<meta name="robots" content="index, follow" />
<?php if (isset($this->header["meta"]) && is_array($this->header["meta"])) foreach($this->header["meta"] as $i=>$j) { ?>
<meta name="<?php echo $i; ?>" content="<?php echo $j; ?>" />
<?php } ?>

<link rel="icon" type="image/png" href="/img/logo/ardeche-miniatures-icon-16.png"/>
<link rel="shortcut icon" href="/img/logo/ardeche-miniatures-icon-16.ico" />
<link rel="publisher" href="https://plus.google.com/+Ardeche-miniatures" />
<link rel='canonical' href='<?php echo (SSL ?'https' :'http').'://'.DOMAIN.$this->header["url"]; ?>' />

<link rel="stylesheet" type="text/css" href="/css/common.css" media="all"/>
<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css" media="all"/>
<link rel="stylesheet" type="text/css" href="/css/jcarousel.basic.css" media="all"/>
<?php if (isset($this->header["css"]) && is_array($this->header["css"])) foreach($this->header["css"] as $i) if ($i) { ?>
<link rel="stylesheet" type="text/css"  href="/css/<?php echo $i; ?>.css"/>
<?php } ?>

