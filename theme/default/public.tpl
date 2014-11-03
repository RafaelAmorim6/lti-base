<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="description" content="" var="description" />
  <meta name="keywords" content="" var="keywords" />
  <meta name="author" content="www.tropotek.com" />

  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

  <!-- Include JS -->
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/jquery-ui/jquery-ui.min.js"></script>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script src="https://github.com/scottjehl/Respond/blob/master/respond.min.js"></script>
  <![endif]-->

  <!-- Include CSS -->
  <link rel="stylesheet" href="js/jquery-ui/themes/base/jquery-ui.min.css"/>
  <link rel="stylesheet" href="less/public/public.less"/>

  <title>ttek-theme/default Theme</title>


</head>
<body>
<div var="_pageTop_"></div>
<a id="t-top"></a>


<div role="navigation" class="navbar navbar-default navbar-fixed-top user-public">
  <div class="container">
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/index.html" var="__home__" class="navbar-brand"><b>Company</b></a>
    </div>
    <div class="navbar-collapse collapse" var="_topNav1_">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/index.html">Home</a></li>
        <li><a href="/about.html">About</a></li>
        <li><a href="/contact.html">Contact</a></li>
        <li><a href="/login.html">Login</a></li>
        <li class="dropdown" choice="hide">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right" choice="__logged-in__">
        <li class="dropdown">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">@<span var="__username__">user</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/user/index.html"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
            <li><a href="/user/profile.html"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
            <li><a href="/user/password.html"><span class="glyphicon glyphicon-random"></span> Change Password</a></li>
            <li><a href="/logout.html"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
          </ul>
        </li>
      </ul>

      <div class="pull-right" style="margin: 5px 0px;">
        <module class="Mod_Module_ThemeSelect"></module>
      </div>
    </div>
    <!--/.nav-collapse -->
  </div>
</div>






<div var="_header_"></div>

<div class="container content">
  <div var="_contentHead_"></div>
  <div var="_content_"></div>
  <div var="_contentFoot_"></div>
</div>






<div class="container">
  <div class="footer" var="_footer_">
    <div class="pull-left">&copy; Tropotek 2013</div>
  </div>
</div>


<div var="_pageBottom_"></div>
</body>
</html>