	{include file="$header"}

    <body>
    {include file="bricks/static/chromeframe.tpl"}

    {include file="navbar.tpl"}

	<div class="jumbotron small">
		<div class="container">
			<div class="site-logo small pull-left"></div>
			<p>{$lang.title_catalog_add}</p>
		</div>
	</div>

    <div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<ol class="breadcrumb heading">
						<li><a href="/">{$lang.main_page}</a></li>
						<li><a href="/catalog/">{$lang.title_catalog}</a></li>
						<li class="active">{$lang.title_catalog_add}</li>
					</ol>
				</div>

				{if $result == 'success'}
					<div class="row">
						<div class="col-lg-offset-4 col-lg-4 alert alert-success">
							{$lang.item_add_success}
						</div>
					</div>
				{elseif $result == 'fail'}
					<div class="row">
						<div class="col-lg-offset-4 col-lg-4 alert alert-danger">
							{$lang.item_add_fail}
						</div>
					</div>
				{/if}
				<form action="/additem/" enctype="application/x-www-form-urlencoded" method="post" id="add_form" class="form-horizontal" role="form">
					<div class="form-group">
						<label for="data-title" class="col-lg-offset-3 col-lg-2 control-label">{$lang.title}</label>
						<div class="col-lg-3">
							<input type="text" name="data[title]" class="form-control input-sm" placeholder="{$lang.title}" id="data-title">
						</div>
					</div>
					<div class="form-group">
						<label for="data-image" class="col-lg-offset-3 col-lg-2 control-label">{$lang.image_URL}</label>
						<div class="col-lg-3">
							<input type="text" name="data[image]" class="form-control input-sm" placeholder="{$lang.no_image}" id="data-image">
						</div>
					</div>
					<div class="form-group">
						<label for="data-thumbnail" class="col-lg-offset-3 col-lg-2 control-label">{$lang.thumbnail_URL}</label>
						<div class="col-lg-3">
							<input type="text" name="data[thumbnail]" class="form-control input-sm" placeholder="{$lang.no_image}" id="data-thumbnail">
						</div>
					</div>
					<div class="form-group">
						<label for="data-category" class="col-lg-offset-3 col-lg-2 control-label">{$lang.category}</label>
						<div class="col-lg-3">
							<input type="text" name="data[category]" class="form-control input-sm" placeholder="{$lang.category}" id="data-category">
						</div>
					</div>
					<div class="form-group">
						<label for="data-material" class="col-lg-offset-3 col-lg-2 control-label">{$lang.material}</label>
						<div class="col-lg-3">
							<input type="text" name="data[material]" class="form-control input-sm" placeholder="{$lang.material}" id="data-material">
						</div>
					</div>
					<div class="form-group">
						<label for="data-region" class="col-lg-offset-3 col-lg-2 control-label">{$lang.region}</label>
						<div class="col-lg-3">
							<input type="text" name="data[region]" class="form-control input-sm" placeholder="{$lang.region}" id="data-region">
						</div>
					</div>
					<div class="form-group">
						<label for="data-district" class="col-lg-offset-3 col-lg-2 control-label">{$lang.district}</label>
						<div class="col-lg-3">
							<input type="text" name="data[district]" class="form-control input-sm" placeholder="{$lang.district}" id="data-district">
						</div>
					</div>
					<div class="form-group">
						<label for="data-town" class="col-lg-offset-3 col-lg-2 control-label">{$lang.town}</label>
						<div class="col-lg-3">
							<input type="text" name="data[town]" class="form-control input-sm" placeholder="{$lang.town}" id="data-town">
						</div>
					</div>
					<div class="form-group">
						<label for="data-digging" class="col-lg-offset-3 col-lg-2 control-label">{$lang.digging}</label>
						<div class="col-lg-3">
							<input type="text" name="data[digging]" class="form-control input-sm" placeholder="{$lang.digging}" id="data-digging">
						</div>
					</div>
					<div class="form-group">
						<label for="data-layer" class="col-lg-offset-3 col-lg-2 control-label">{$lang.layer}</label>
						<div class="col-lg-3">
							<input type="text" name="data[layer]" class="form-control input-sm" placeholder="{$lang.layer}" id="data-layer">
						</div>
					</div>
					<div class="form-group">
						<label for="data-square" class="col-lg-offset-3 col-lg-2 control-label">{$lang.square}</label>
						<div class="col-lg-3">
							<input type="text" name="data[square]" class="form-control input-sm" placeholder="{$lang.square}" id="data-square">
						</div>
					</div>
					<div class="form-group">
						<label for="data-field" class="col-lg-offset-3 col-lg-2 control-label">{$lang.field_number}</label>
						<div class="col-lg-3">
							<input type="text" name="data[fieldNumber]" class="form-control input-sm" placeholder="{$lang.field_number}" id="data-field">
						</div>
					</div>
					<div class="form-group">
						<label for="data-area" class="col-lg-offset-3 col-lg-2 control-label">{$lang.area}</label>
						<div class="col-lg-3">
							<input type="text" name="data[area]" class="form-control input-sm" placeholder="{$lang.area}" id="data-area">
						</div>
					</div>
					<div class="form-group">
						<label for="data-homestead" class="col-lg-offset-3 col-lg-2 control-label">{$lang.homestead}</label>
						<div class="col-lg-3">
							<input type="text" name="data[homestead]" class="form-control input-sm" placeholder="{$lang.homestead}" id="data-homestead">
						</div>
					</div>
					<div class="form-group">
						<label for="data-gps" class="col-lg-offset-3 col-lg-2 control-label">{$lang.gps_coordinates}</label>
						<div class="col-lg-3">
							<input type="text" name="data[gps]" class="form-control input-sm" placeholder="{$lang.gps_coordinates}" id="data-gps">
						</div>
					</div>
					<div class="form-group">
						<label for="data-year" class="col-lg-offset-3 col-lg-2 control-label">{$lang.year}</label>
						<div class="col-lg-3">
							<input type="text" name="data[year]" class="form-control input-sm" placeholder="{$lang.year}" id="data-year">
						</div>
					</div>
					<div class="form-group">
						<label for="data-description" class="col-lg-offset-3 col-lg-2 control-label">{$lang.description}</label>
						<div class="col-lg-3">
							<textarea rows="2" cols="10" name="data[description]" class="form-control input-sm" placeholder="{$lang.description}" id="data-description"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="data-dating" class="col-lg-offset-3 col-lg-2 control-label">{$lang.dating}</label>
						<div class="col-lg-3">
							<input type="text" name="data[dating]" class="form-control input-sm" placeholder="{$lang.dating}" id="data-dating">
						</div>
					</div>
					<div class="form-group">
						<label for="data-storage" class="col-lg-offset-3 col-lg-2 control-label">{$lang.storage}</label>
						<div class="col-lg-3">
							<input type="text" name="data[storagePlace]" class="form-control input-sm" placeholder="{$lang.storage}" id="data-storage">
						</div>
					</div>
					<div class="form-group">
						<label for="data-notes" class="col-lg-offset-3 col-lg-2 control-label">{$lang.notes}</label>
						<div class="col-lg-3">
							<textarea rows="2" cols="10" name="data[notes]" class="form-control input-sm" placeholder="{$lang.notes}" id="data-notes"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-success">
									<span class="glyphicon glyphicon-plus"></span> {$lang.add_item}
								</button>
							</div>
						</div>
					</div>
				</form>
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
