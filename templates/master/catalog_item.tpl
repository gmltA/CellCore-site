	{include file="$header"}

    <body>
	
    {include file="bricks/static/chromeframe.tpl"}
	
    {include file="navbar.tpl"}


    <div class="jumbotron small">
		<div class="container">
			<div class="site-logo small pull-left"></div>
			<p>{$item.title}</p>
		</div>
	</div>

    <div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<ol class="breadcrumb heading">
						<li><a href="/">{$lang.main_page}</a></li>
						<li><a href="/catalog/">{$lang.title_catalog}</a></li>
						<li class="active">{$item.title}</li>
					</ol>
				</div>
				<img src="{$item.image}">
				{include file="bricks\catalog_item_data.tpl"}
			</div>
		</div>

		<hr>

		{include file='footer.tpl'}
		<script>
		  $(function()
			{
				$('#filter-reset').click(function()
				{
					$('#filter_form')[0].reset();
					$('#filter_form').submit();
				});
			});
		</script>
	</body>
</html>
