	{include file="$header"}

	<body>
		{include file="bricks/static/chromeframe.tpl"}

		{include file="navbar.tpl"}

		{include file="bricks/static/jumbotron.tpl"}

		<div class="container">
			<div class="row">
				{foreach from=$newsList item=newsEntry}
					{include file="bricks/news.tpl"}
				{/foreach}
			</div>

		{include file='footer.tpl'}
	</body>
</html>
