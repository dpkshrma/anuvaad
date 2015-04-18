<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title;?></title>

	<meta charset="utf-8">
	<!-- IE Bootstrap Support -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href=<?php echo base_url()."assets/css/styles.css";?> />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script src= <?php echo base_url()."assets/components/platform/platform.js";?> /></script>
  <link rel="import" type="text/html" href= <?php echo base_url()."assets/components/paper-ripple/paper-ripple.html";?> />
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">
		
		<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_links">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand sitename" href="#">Anuvaad</a>
    </div>

		<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar_links">
      <ul class="nav navbar-nav">
        <li><a href="#">About</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">Speak<span class="caret"></span>
          <paper-ripple fit class="header-ripple" ></paper-ripple>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Feedback</a></li>
            <li><a href="#">Comment</a></li>
          </ul>
        </li>
        <li><a href="#">Rules</a></li>
        <li><a href="#">LeaderBoard</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url().'gsignin';?>"><img src="<?php echo base_url().'assets/images/gsignin.png'?>" id="gsignin"></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div> <!--container-fluid-->
</nav>