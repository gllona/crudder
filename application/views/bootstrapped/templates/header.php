<?php CI_Controller::get_instance()->load->view(strtolower(Crudderconfig::DEFAULT_PAGES_SET) . '/' . 'templates/avoid_cache'); ?>

<!DOCTYPE html>
<html>
    
<head>
  <title>Crudder: CRUD library for CodeIgniter</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Crudder-specific; this avoids bootstrapping the main app application by default if the constant PAGES_SET is not set for BOOTSTRAPPED -->
  <?php if (defined("PAGES_SET") && PAGES_SET == "BOOTSTRAPPED" || ! defined("PAGES_SET")) { ?>
  
  <!-- Bootstrap -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
  
  <!-- plugins-specific -->
  <!-- (none) -->

  <?php } ?>
  
</head>
  
<body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type='text/javascript' src="/js/jquery.min.js"></script>

<!-- Bootstrap -->
<script type='text/javascript' src="/js/bootstrap.min.js"></script>
    
<!-- Other plugins -->
<!-- (none) -->

<!-- desde aqui el contenido visible del header -->

<div class="container">

<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td><h1>Entidades político-territoriales de la<br> República Bolivariana de Venezuela</h1></td>
        <td rowspan="2" align="right" valign="middle"><a href="http://www.venetur.gob.ve/" target="_blank"><img width="192" src="/images/venezuela_flag.jpg" class="img-responsive, img-rounded" alt="Venezuela" /></a></td>
    </tr>
    <tr>
        <td><h2>Administrative territories of the<br>Bolivarian Republic of Venezuela</h2></td>
    </tr>
</table>
    
<hr>

<!-- hasta aqui el header -->

