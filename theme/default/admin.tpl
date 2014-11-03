<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="description" content="" var="description"/>
  <meta name="keywords" content="" var="keywords"/>
  <meta name="author" content="www.tropotek.com"/>

  <link rel="icon" type="image/x-icon" href="favicon.ico"/>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

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

  <title>Tk004 Template</title>


</head>
<body>
<div id="wrapper">


  <div var="_pageTop_"></div>
  <a id="t-top"></a>


  <!-- Sidebar -->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin/index.html" var="__siteTitle__">SB Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse" var="_topNav1_">
      <module class="\Ext\Module\Admin\SideNav"></module>

      <module class="\Ext\Module\Admin\TopNav"></module>
    </div>
    <!-- /.navbar-collapse -->
  </nav>

  <div id="page-wrapper">

    <div var="_header_"></div>

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1><span var="__pageTitle__">Dashboard</span>
            <small var=""></small>
          </h1>
          <div var="_crumbs_"></div>
        </div>
      </div>


      <div class="content">
        <div var="_contentHead_"></div>
        <div var="_content_"></div>
        <div var="_contentFoot_"></div>
      </div>


      <div var="_footer_"></div>
    </div>

    <div var="_pageBottom_"></div>
  </div>
</div>
</body>
</html>