	{include file="$header"}

	<body>
		{include file="bricks/static/chromeframe.tpl"}

		{include file="navbar.tpl"}

		{include file="bricks/static/jumbotron.tpl"}

		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">{$lang.title_about_ext}</div>
					<div class="panel-body">
						{include file="bricks/static/about.tpl"}
					</div>
				</div>
			</div>

		{include file='footer.tpl'}
	</body>
</html>
