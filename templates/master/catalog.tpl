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
			<p>По вашему запросу найдено {$items|@count} предмет.</p>
		{else}
			<p>В нашей базе данных уже 100500 предметов.</p>
		{/if}
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">
			<form action="/search/" enctype="application/x-www-form-urlencoded" method="post" id="filter_form">       
			<div class="row">
				<div class="col-md-2">
					<div class="input-group max">
						<select name="filter_category" class="form-control " >
						  <option disabled selected >Category</option>
						  <option value="2">Амулет</option>
						  <option>Пункт 2</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group max">
						<select name="filter_material" class="form-control " >
						  <option disabled selected >Material</option>
						  <option value="Stone">Stone</option>
						  <option value="Lether">Lether</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group max">
						<select name="filter_mem" class="form-control">
						  <option disabled selected >Памятник</option>
						  <option>Пункт 1</option>
						  <option>Пункт 2</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group max">
						<select name="filter_dig" class="form-control">
						  <option disabled selected >Раскоп</option>
						  <option>Пункт 1</option>
						  <option>Пункт 2</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group max">
						<input type="text" name="filter_year" class="form-control" placeholder="Year">
					</div>
				</div>
				<div class="col-md-2">
					<div class="input-group max">
						<input type="text" name="filter_title" class="form-control" placeholder="Title">
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="btn-group pull-right">
						<button type="submit" class="btn btn-success">
							<span class="glyphicon glyphicon-filter"></span> Filter
						</button>
						<a class="btn btn-danger" id="filter-reset">
							<span class="glyphicon glyphicon-remove"></span> Clear
						</a>
					</div>
				</div>
			</div>
			</form>
		  </div>

		  <!-- Table -->
		  <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Изображение</th>
              <th>Категория</th>
              <th>Материал</th>
              <th>Памятник</th>
              <th>Раскоп</th>
              <th>Год</th>
              <th>Наименование</th>
              <th>Код</th>
            </tr>
          </thead>
          <tbody>
		  {foreach from=$items item=itemEntry}
            <tr>
              <td>{$itemEntry.id}</td>
              <td><a href="{$itemEntry.image}"><img class="catalog-thumbnail" src="{$itemEntry.thumbnail}" height="100"></a></td>
              <td>{$itemEntry.category}</td>
              <td>{$itemEntry.material}</td>
              <td>{$itemEntry.monument}</td>
              <td>{$itemEntry.digging}</td>
              <td>{$itemEntry.year}</td>
              <td>{$itemEntry.title}</td>
              <td><a href="/catalog/object/{$itemEntry.id}">{$itemEntry.code}</td>
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
				$('#filter_form')[0].reset();
				$('#filter_form').submit();
			});
		});
	  </script>
	</body>
</html>
