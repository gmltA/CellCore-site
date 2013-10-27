{include file="$header"}

<body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/"><span class="glyphicon glyphicon-home"></span> Главная</a></li>
            <li><a href="#about"><span class="glyphicon glyphicon-question-sign"></span> О проекте</a></li>
            <li><a href="/catalog/"><span class="glyphicon glyphicon-book"></span> Каталог</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="jumbotron small">
      <div class="container">
        <div class="site-logo small pull-left"></div>
        <p><h2>{$newsEntry.title}</h2></p>
      </div>
    </div>

    <div class="container">
	<ol class="breadcrumb">
	  <li><a href="/">Home</a></li>
	  <li class="active">{$newsEntry.title}</li>
	</ol>
      <div class="row">
        <div class="col-lg-12">
			<p>{$newsEntry.content}</p>
		</div>
      </div>
	
	  <hr>

	{include file='footer.tpl'}
	</body>
</html>
