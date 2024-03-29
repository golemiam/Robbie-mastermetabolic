<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta name="description" content="bootstrap admin template">
		<meta name="author" content="">
		<title>@yield('pagetitle') - <?php echo $title; ?></title>
		<link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
		<link rel="shortcut icon" href="/images/favicon.ico">
		<!-- Stylesheets -->
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-extend.min.css">
		<link rel="stylesheet" href="/css/site.min.css">
    	<link rel="stylesheet" href="/skins/<?php echo $color; ?>.min.css">
    	<link rel="stylesheet" href="/css/fithero-custom.css">
		<!-- Plugins -->
		<link rel="stylesheet" href="/vendor/animsition/animsition.css">
		<link rel="stylesheet" href="/vendor/asscrollable/asScrollable.css">
		<link rel="stylesheet" href="/vendor/switchery/switchery.css">
		<link rel="stylesheet" href="/vendor/intro-js/introjs.css">
		<link rel="stylesheet" href="/vendor/slidepanel/slidePanel.css">
		<link rel="stylesheet" href="/vendor/flag-icon-css/flag-icon.css">
		<link rel="stylesheet" href="/examples/css/pages/login.css">
		<!-- Fonts -->
		<link rel="stylesheet" href="/fonts/web-icons/web-icons.min.css">
		<link rel="stylesheet" href="/fonts/brand-icons/brand-icons.min.css">
		<link rel='stylesheet' href='http:/fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
		<!--[if lt IE 9]>
		<script src="/vendor/html5shiv/html5shiv.min.js"></script>
		<![endif]-->
		<!--[if lt IE 10]>
		<script src="/vendor/media-match/media.match.min.js"></script>
		<script src="/vendor/respond/respond.min.js"></script>
		<![endif]-->
		<!-- Scripts -->
		<script src="/vendor/modernizr/modernizr.js"></script>
		<script src="/vendor/breakpoints/breakpoints.js"></script>
		<script>
		Breakpoints();
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-77536001-2', 'auto');
		  ga('send', 'pageview');
		</script>
	</head>
<body class="page-login layout-full page-dark">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http:/browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="brand">
        <img class="brand-img" src="/images/logo.png" alt="...">
        <h2 class="brand-text">{{$title}}</h2>
      </div>
	  @yield('content')
      <footer class="page-copyright page-copyright-inverse">
        <p>© 2015. All RIGHT RESERVED.</p>
        <div class="social">
          <a href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a href="javascript:void(0)">
            <i class="icon bd-dribbble" aria-hidden="true"></i>
          </a>
        </div>
      </footer>
    </div>
  </div>
  <!-- End Page -->
  <!-- Core  -->
  <script src="/vendor/jquery/jquery.js"></script>
  <script src="/vendor/bootstrap/bootstrap.js"></script>
  <script src="/vendor/animsition/animsition.js"></script>
  <script src="/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
  <!-- Plugins -->
  <script src="/vendor/switchery/switchery.min.js"></script>
  <script src="/vendor/intro-js/intro.js"></script>
  <script src="/vendor/screenfull/screenfull.js"></script>
  <script src="/vendor/slidepanel/jquery-slidePanel.js"></script>
  <script src="/vendor/jquery-placeholder/jquery.placeholder.js"></script>
  <!-- Scripts -->
  <script src="/js/core.js"></script>
  <script src="/js/site.js"></script>
  <script src="/js/sections/menu.js"></script>
  <script src="/js/sections/menubar.js"></script>
  <script src="/js/sections/gridmenu.js"></script>
  <script src="/js/sections/sidebar.js"></script>
  <script src="/js/configs/config-colors.js"></script>
  <script src="/js/configs/config-tour.js"></script>
  <script src="/js/components/asscrollable.js"></script>
  <script src="/js/components/animsition.js"></script>
  <script src="/js/components/slidepanel.js"></script>
  <script src="/js/components/switchery.js"></script>
  <script src="/js/components/jquery-placeholder.js"></script>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
</body>
</html>