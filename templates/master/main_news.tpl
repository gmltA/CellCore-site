	{include file="$header"}

	<body>
		{include file="bricks/static/chromeframe.tpl"}
		
		{include file="navbar.tpl"}

		<div class="jumbotron small">
			<div class="container">
				<div class="site-logo small pull-left"></div>
				<p><h2>{$newsEntry.title}</h2></p>
			</div>
		</div>

		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<ol class="breadcrumb heading">
						<li><a href="/">Home</a></li>
						<li class="active">{$newsEntry.title}</li>
					</ol>
				</div>
				<div class="panel-body">
					<p>{$newsEntry.content}</p>
				</div>
			</div>
			
			<hr>

		{include file='footer.tpl'}
	</body>
</html>
