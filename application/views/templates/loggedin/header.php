<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title;?></title>

	<meta charset="utf-8">
  <meta name="google" value="notranslate">
	<!-- IE Bootstrap Support -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href=<?php echo base_url()."assets/css/styles.css";?> />

  <!-- 1. Load platform.js for polyfill support. -->
  <script src= <?php echo base_url()."assets/components/platform/platform.js";?> /></script>

  <!-- 2. Use an HTML Import to bring in the element. -->
  <link rel="import" type="text/html" href= <?php echo base_url()."assets/components/paper-ripple/paper-ripple.html";?> />
  <link rel="import" type="text/html" href= <?php echo base_url()."assets/components/paper-checkbox/paper-checkbox.html";?> />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
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
      <a class="navbar-brand sitename notranslate" href="<?php echo base_url(); ?>" style="color:#555">Anuvaad</a>
    </div>

		<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar_links">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Play <span class="caret"></span>
          <paper-ripple fit class="header-ripple" ></paper-ripple>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url().'play/index/compete';?>">Compete
            </a></li>
            <li><a href="<?php echo base_url().'play/index/practice';?>">Practice
            </a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Contribute <span class="caret"></span>
          <paper-ripple fit class="header-ripple"></paper-ripple>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url().'contribute/comicstrip';?>">Comic Strip
            </a></li>
            <li><a href="<?php echo base_url().'contribute/quotes';?>">Quotes
            </a></li>
            <li><a href="<?php echo base_url().'contribute/storyline';?>">Storyline
            </a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Speak <span class="caret"></span>
          <paper-ripple fit class="header-ripple"></paper-ripple>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a href="<?php echo base_url().'feedback';?>">
              Feedback
              </a>
            </li>
            <li><a href="<?php echo base_url().'comment';?>">
                Comment
                </a>
            </li>
          </ul>
        </li>
        <li><a href="<?php echo base_url().'rules';?>">
              Rules
            </a>
        </li>
        <li><a href="<?php echo base_url().'leaderboard';?>">
              LeaderBoard
            </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle user_image_dd" data-toggle="dropdown">
            <img src="<?php echo $user_image;?>" alt="Profile Menu" class="img-circle user_image_sm">
            <paper-ripple fit class="header-ripple"></paper-ripple>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url().'profile';?>">Profile</a></li>
            <li><a href="<?php echo base_url().'stats';?>">Stats</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url().'?logout'?>">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div> <!--container-fluid-->
</nav>