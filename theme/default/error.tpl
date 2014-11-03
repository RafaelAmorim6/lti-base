<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


  <!-- Include JS -->
  <script src="{themeUrl}/js/jquery-1.11.1.min.js"></script>
  <script src="{themeUrl}/js/jquery-ui/jquery-ui.min.js"></script>
  <script src="{themeUrl}/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script src="https://github.com/scottjehl/Respond/blob/master/respond.min.js"></script>
  <![endif]-->

  <!-- Include CSS -->
  <link rel="stylesheet" href="{themeUrl}/bootstrap/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="{themeUrl}/bootstrap/dist/css/bootstrap-theme.min.css"/>
  <link rel="stylesheet" href="{themeUrl}/js/jquery-ui/themes/base/jquery-ui.min.css" />

  <title>{statusCode} {title} - {siteTitle}</title>


<style>
  body.error-page {
    background: #E9E9E9;
    margin: 0;
  }


  /* ---------------------------------- */
  /* @Error Wrapper */

  #error-wrapper {
    width: 80%;
    max-width: 500px;
    text-align: center;

    margin: 0 auto;
  }

  #error-wrapper h1 {
    font-size: 100px;
    margin-bottom: .55em;
  }


  /* ---------------------------------- */
  /* @Error Code */

  #error-code {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: .5em;
  }


  /* ---------------------------------- */
  /* @Error Message */

  #error-message {
    font-size: 15px;
    margin-bottom: 2em;
  }


  /* ---------------------------------- */
  /* @Error header*/

  #error-header {
    background: #333;
    width: 100%;
    padding: 9px 0 2px 0;
    margin-bottom: 4em;
  }

  #error-header a {
    /*background: url(../images/logo_small.png) no-repeat 0 0;*/
    width: 146px;
    height: 31px;
    color: #FFF;
    font-weight: bold;
    font-size: 1.3em;
    display: block;
    margin: 0 auto;
    position: relative;
    left: 10px;
    overflow: hidden;
  }

  pre.error-dump {
    text-align: left;
    width: 70%;
    margin: 20px auto;
    overflow: auto;
  }
</style>
</head>
<body class="error-page">

<div id="error-header">
  <a href="{siteUrl}/index.html">{siteTitle}</a>
</div>

<div id="error-wrapper" class="clearfix">

  <h1>Oops!</h1>

  <div id="error-code">{statusCode} {title}</div>

  <div id="error-message">{message}</div>


  <div id="error-actions" class="clearfix">
    <a href="{siteUrl}/index.html" onclick="history.back();return false;" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
  </div>

</div>

<div class="">
  {dump}
</div>


</body>
</html>

