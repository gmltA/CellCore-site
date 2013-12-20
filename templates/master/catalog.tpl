	{include file="$header"}

	<body>
		{include file="bricks/static/chromeframe.tpl"}

		{include file="navbar.tpl"}


		<div class="jumbotron small">
			<div class="container">
			<div class="site-logo small pull-left"></div>
			<p>{$lang.catalog_welcome}</p>
			{if $searchResult}
				<p>{$lang.on_your_request} {$items|@count|declension:$lang.found:false:$lang.id} {$items|@count|declension:$lang.item_decl:true:$lang.id}.</p>
			{else}
				<p>{$lang.there_are_items} {$dbSize|declension:$lang.item_decl:true:$lang.id}.</p>
			{/if}
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="panel panel-default">
				<div class="panel-heading">
				<form action="/search/" enctype="application/x-www-form-urlencoded" method="post" id="filter_form" class="form-horizontal" role="form">
					<div id="filter-inputs" {if $isFilterApplied != true}hidden{/if}>
						<div class="form-group {if $filterTokens.category}has-success{/if}">
							<label for="filter-category" class="col-lg-offset-3 col-lg-2 control-label">{$lang.category}</label>
							<div class="col-lg-3">
								<select name="filter_category" class="form-control input-sm" id="filter-category">
									<option disabled {if !$filterTokens.category}selected{/if}>{$lang.category}</option>
									{foreach from=$filterContent.category item=category}
										<option value="{$category.category}" {if $category.category == $filterTokens.category}selected{/if}>{$category.category}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group {if $filterTokens.material}has-success{/if}">
							<label for="filter-material" class="col-lg-offset-3 col-lg-2 control-label">{$lang.material}</label>
							<div class="col-lg-3">
								<select name="filter_material" class="form-control input-sm" id="filter-material">
									<option disabled {if !$filterTokens.material}selected{/if}>{$lang.material}</option>
									{foreach from=$filterContent.material item=material}
										<option value="{$material.material}" {if $material.material == $filterTokens.material}selected{/if}>{$material.material}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group {if $filterTokens.district}has-success{/if}">
							<label for="filter-district" class="col-lg-offset-3 col-lg-2 control-label">{$lang.district}</label>
							<div class="col-lg-3">
								<select name="filter_district" class="form-control input-sm" id="filter-district">
									<option disabled {if !$filterTokens.district}selected{/if}>{$lang.district}</option>
									{foreach from=$filterContent.district item=district}
										<option value="{$district.district}" {if $district.district == $filterTokens.district}selected{/if}>{$district.district}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group {if $filterTokens.town}has-success{/if}">
							<label for="filter-town" class="col-lg-offset-3 col-lg-2 control-label">{$lang.town}</label>
							<div class="col-lg-3">
								<select name="filter_town" class="form-control input-sm" id="filter-town">
									<option disabled {if !$filterTokens.town}selected{/if}>{$lang.town}</option>
									{foreach from=$filterContent.town item=town}
										<option value="{$town.town}" {if $town.town == $filterTokens.town}selected{/if}>{$town.town}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group {if $filterTokens.digging}has-success{/if}">
							<label for="filter-dig" class="col-lg-offset-3 col-lg-2 control-label">{$lang.digging}</label>
							<div class="col-lg-3">
								<select name="filter_dig" class="form-control input-sm" id="filter-dig">
									<option disabled {if !$filterTokens.digging}selected{/if}>{$lang.digging}</option>
									{foreach from=$filterContent.digging item=digging}
										<option value="{$digging.digging}" {if $digging.digging == $filterTokens.digging}selected{/if}>{$digging.digging}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group {if $filterTokens.year}has-success{/if}">
							<label for="filter-year" class="col-lg-offset-3 col-lg-2 control-label">{$lang.year}</label>
							<div class="col-lg-3">
								<input type="text" name="filter_year" class="form-control input-sm" placeholder="{$lang.year}" id="filter-year" {if $filterTokens.year}value="{$filterTokens.year}"{/if}}>
							</div>
						</div>
						<div class="form-group {if $filterTokens.title}has-success{/if}">
							<label for="filter-title" class="col-lg-offset-3 col-lg-2 control-label">{$lang.title}</label>
							<div class="col-lg-3">
								<input type="text" name="filter_title" class="form-control input-sm" placeholder="{$lang.title}" id="filter-title" {if $filterTokens.title}value="{$filterTokens.title}"{/if}>
							</div>
						</div>
					</div>
					<div class="form-group" id="filter-buttons" {if $isFilterApplied != true}hidden{/if}>
						<div class="col-lg-offset-4 col-lg-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-success">
									<span class="glyphicon glyphicon-filter"></span> {$lang.filter}
								</button>
								<a class="btn btn-danger" id="filter-reset">
									<span class="glyphicon glyphicon-remove"></span> {$lang.clear}
								</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-4" {if $isFilterApplied == true}hidden{/if}>
							<div class="btn btn-primary btn-block" id="filter-show">
								<span class="glyphicon glyphicon-arrow-down"></span> {$lang.show_filter} <span class="glyphicon glyphicon-arrow-down"></span>
							</div>
						</div>
					</div>
				</form>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th><span class="glyphicon glyphicon-picture glyphicon-gray"></span> {$lang.image}</th>
							<th><span class="glyphicon glyphicon-barcode glyphicon-gray"></span> {$lang.category}</th>
							<th><span class="glyphicon glyphicon-leaf glyphicon-gray"></span> {$lang.material}</th>
							<th><span class="glyphicon glyphicon-map-marker glyphicon-gray"></span> {$lang.district}</th>
							<th><span class="glyphicon glyphicon-screenshot glyphicon-gray"></span> {$lang.town}</th>
							<th><span class="glyphicon glyphicon-flag glyphicon-gray"></span> {$lang.digging}</th>
							<th><span class="glyphicon glyphicon-calendar glyphicon-gray"></span> {$lang.year}</th>
							<th><span class="glyphicon glyphicon-header glyphicon-gray"></span> {$lang.title}</th>
							<th><span class="glyphicon glyphicon-list-alt glyphicon-gray"></span> {$lang.details}</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$items item=itemEntry}
							<tr id="{$itemEntry.id}">
							<td>{$itemEntry.id}</td>
							<td><a href="{$itemEntry.image}"><img class="catalog-thumbnail" src="{$itemEntry.thumbnail}" height="100"></a></td>
							<td>{$itemEntry.category}</td>
							<td>{$itemEntry.material}</td>
							<td>{$itemEntry.district}</td>
							<td>{$itemEntry.town}</td>
							<td>{$itemEntry.digging}</td>
							<td>{$itemEntry.year}</td>
							<td>{$itemEntry.title}</td>
							<td><a class="btn btn-primary btn-more-info" href="/catalog/object/{$itemEntry.id}">{$lang.show_detailed_info}</a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				</div>
			</div>
			
			{$pagination}
			
			<hr>

		{include file='footer.tpl'}
		<script>
			$(function()
			{
				$('#filter-reset').click(function()
				{
					window.location.href = '/catalog/';
				});

				$('#filter-show').on("click", function()
				{
					$('#filter-buttons, #filter-inputs, #filter-show').slideToggle();
				});

				$('.btn-more-info').on("click", function(event)
				{
					event.preventDefault();
					var id = $(this).parent().parent().attr("id");

					$.ajax({
						url: "/ajax/",
						data: "action=get_item_details&itemId="+id,
						type: "POST",
						cache: false,
						beforeSend: function()
						{
							$('#myModal').find('.modal-body').html('');
						},
						success: function(response)
						{
							$('#myModal').find('.modal-body').html(response);
						},
						error:function (xhr, ajaxOptions, thrownError)
						{
						}
					});

					$('#myModal').modal('show');
				});
			});
		</script>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{$lang.detailed_info}</h4>
					</div>
					<div class="modal-body">
					...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{$lang.close}</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
