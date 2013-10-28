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
          <a class="navbar-brand" href="#">{$site.app_descr}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/"><span class="glyphicon glyphicon-home"></span> Главная</a></li>
            <li><a href="#about"><span class="glyphicon glyphicon-question-sign"></span> О проекте</a></li>
            <li class="active"><a href="/catalog/"><span class="glyphicon glyphicon-book"></span> Каталог</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron small">
      <div class="container">
        <div class="site-logo small pull-left"></div>
        <p>Добро пожаловать в наш супер-пупер мега каталог.</p>
		{if $searchResult}
			<p>По вашему запросу {$items|@count|declension:'найден;найдено;найдено':false:$lang.id} {$items|@count|declension:' предмет; предмета; предметов':true:$lang.id}.</p>
		{else}
			<p>В нашей базе данных уже {$dbSize|declension:' предмет; предмета; предметов':true:$lang.id}.</p>
		{/if}
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">
			<form action="/search/" enctype="application/x-www-form-urlencoded" method="post" id="filter_form" class="form-horizontal" role="form">
				<div id="filter-inputs" hidden>
					<div class="form-group">
						<label for="filter-category" class="col-lg-offset-3 col-lg-2 control-label">Category</label>
						<div class="col-lg-3">
								<select name="filter_category" class="form-control input-sm" id="filter-category">
								  <option disabled selected >Category</option>
								  {foreach from=$filterContent.category item=category}
									<option value="{$category.category}">{$category.category}</option>
								  {/foreach}
								</select>
						</div>
					</div>
					<div class="form-group">
						<label for="filter-material" class="col-lg-offset-3 col-lg-2 control-label">Material</label>
						<div class="col-lg-3">
							<select name="filter_material" class="form-control input-sm" id="filter-material">
							  <option disabled selected >Material</option>
							  {foreach from=$filterContent.material item=material}
								<option value="{$material.material}">{$material.material}</option>
							  {/foreach}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="filter-district" class="col-lg-offset-3 col-lg-2 control-label">District</label>
						<div class="col-lg-3">
							<select name="filter_district" class="form-control input-sm" id="filter-district">
							  <option disabled selected>Район</option>
							  {foreach from=$filterContent.district item=district}
								<option value="{$district.district}">{$district.district}</option>
							  {/foreach}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="filter-town" class="col-lg-offset-3 col-lg-2 control-label">Town</label>
						<div class="col-lg-3">
							<select name="filter_town" class="form-control input-sm" id="filter-town">
							  <option disabled selected>Населенный пункт</option>
							  {foreach from=$filterContent.town item=town}
								<option value="{$town.town}">{$town.town}</option>
							  {/foreach}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="filter-dig" class="col-lg-offset-3 col-lg-2 control-label">Digging</label>
						<div class="col-lg-3">
							<select name="filter_dig" class="form-control input-sm" id="filter-dig">
							  <option disabled selected >Раскоп</option>
							  {foreach from=$filterContent.digging item=digging}
								<option value="{$digging.digging}">{$digging.digging}</option>
							  {/foreach}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="filter-year" class="col-lg-offset-3 col-lg-2 control-label">Year</label>
						<div class="col-lg-3">
							<input type="text" name="filter_year" class="form-control input-sm" placeholder="Year" id="filter-year">
						</div>
					</div>
					<div class="form-group">
						<label for="filter-title" class="col-lg-offset-3 col-lg-2 control-label">Title</label>
						<div class="col-lg-3">
							<input type="text" name="filter_title" class="form-control input-sm" placeholder="Title" id="filter-title">
						</div>
					</div>
				</div>
				<div class="form-group" id="filter-buttons" hidden>
					<div class="col-lg-offset-5 col-lg-4">
						<div class="btn-group">
							<button type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-filter"></span> Filter
							</button>
							<a class="btn btn-danger" id="filter-reset">
								<span class="glyphicon glyphicon-remove"></span> Clear
							</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-4 col-lg-4">
						<div class="btn btn-primary btn-block" id="filter-show">
						<span class="glyphicon glyphicon-arrow-down"></span> Show filter <span class="glyphicon glyphicon-arrow-down"></span>
						</div>
					</div>
				</div>
			</form>
		  </div>

		  <!-- Table -->
		  <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th><span class="glyphicon glyphicon-picture glyphicon-gray"></span> Изображение</th>
              <th><span class="glyphicon glyphicon-barcode glyphicon-gray"></span> Категория</th>
              <th><span class="glyphicon glyphicon-leaf glyphicon-gray"></span> Материал</th>
              <th><span class="glyphicon glyphicon-map-marker glyphicon-gray"></span> Район</th>
              <th><span class="glyphicon glyphicon-screenshot glyphicon-gray"></span> Населенный пункт</th>
              <th><span class="glyphicon glyphicon-flag glyphicon-gray"></span> Раскоп</th>
              <th><span class="glyphicon glyphicon-calendar glyphicon-gray"></span> Год</th>
              <th><span class="glyphicon glyphicon-header glyphicon-gray"></span> Наименование</th>
              <th><span class="glyphicon glyphicon-list-alt glyphicon-gray"></span> Подробнее</th>
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
              <td><a class="btn btn-primary btn-more-info" href="/catalog/object/{$itemEntry.id}">Подробнее &raquo;</a></td>
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
					url: "./?ajax&action=get_item_details",
					data: "&itemId="+id,
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
	<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
	</body>
</html>
