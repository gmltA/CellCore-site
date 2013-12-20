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
          <a class="navbar-brand" href="/">{$site.app_descr}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/"><span class="glyphicon glyphicon-home"></span> Главная</a></li>
            <li><a href="/about/"><span class="glyphicon glyphicon-question-sign"></span> О проекте</a></li>
            <li class="active"><a href="/catalog/"><span class="glyphicon glyphicon-book"></span> Каталог</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
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
			 <li><a href="/">Home</a></li>
			 <li><a href="/catalog/">Catalog</a></li>
			 <li class="active">Add new catalog item</li>
			</ol>
		  </div>
		  {if $result == 'success'}
		  <div class="row">
			  <div class="col-lg-offset-4 col-lg-4 alert alert-success">
				New item added succesfuly!
			  </div>
		  </div>
		  {/if}
			<form action="/additem/" enctype="application/x-www-form-urlencoded" method="post" id="add_form" class="form-horizontal" role="form">
				<div class="form-group">
					<label for="data-title" class="col-lg-offset-3 col-lg-2 control-label">Title</label>
					<div class="col-lg-3">
						<input type="text" name="data[title]" class="form-control input-sm" placeholder="Title" id="data-title">
					</div>
				</div>
				<div class="form-group">
					<label for="data-image" class="col-lg-offset-3 col-lg-2 control-label">Image URL</label>
					<div class="col-lg-3">
						<input type="text" name="data[image]" class="form-control input-sm" placeholder="No image" id="data-image">
					</div>
				</div>
				<div class="form-group">
					<label for="data-thumbnail" class="col-lg-offset-3 col-lg-2 control-label">Thumbnail URL</label>
					<div class="col-lg-3">
						<input type="text" name="data[thumbnail]" class="form-control input-sm" placeholder="No image" id="data-thumbnail">
					</div>
				</div>
				<div class="form-group">
					<label for="data-category" class="col-lg-offset-3 col-lg-2 control-label">Category</label>
					<div class="col-lg-3">
						<input type="text" name="data[category]" class="form-control input-sm" placeholder="Category" id="data-category">
					</div>
				</div>
				<div class="form-group">
					<label for="data-material" class="col-lg-offset-3 col-lg-2 control-label">Material</label>
					<div class="col-lg-3">
						<input type="text" name="data[material]" class="form-control input-sm" placeholder="Material" id="data-material">
					</div>
				</div>
				<div class="form-group">
					<label for="data-region" class="col-lg-offset-3 col-lg-2 control-label">Region</label>
					<div class="col-lg-3">
						<input type="text" name="data[region]" class="form-control input-sm" placeholder="Region" id="data-region">
					</div>
				</div>
				<div class="form-group">
					<label for="data-district" class="col-lg-offset-3 col-lg-2 control-label">District</label>
					<div class="col-lg-3">
						<input type="text" name="data[district]" class="form-control input-sm" placeholder="District" id="data-district">
					</div>
				</div>
				<div class="form-group">
					<label for="data-town" class="col-lg-offset-3 col-lg-2 control-label">Town</label>
					<div class="col-lg-3">
						<input type="text" name="data[town]" class="form-control input-sm" placeholder="Town" id="data-town">
					</div>
				</div>
				<div class="form-group">
					<label for="data-digging" class="col-lg-offset-3 col-lg-2 control-label">Digging</label>
					<div class="col-lg-3">
						<input type="text" name="data[digging]" class="form-control input-sm" placeholder="Digging" id="data-digging">
					</div>
				</div>
				<div class="form-group">
					<label for="data-layer" class="col-lg-offset-3 col-lg-2 control-label">Layer</label>
					<div class="col-lg-3">
						<input type="text" name="data[layer]" class="form-control input-sm" placeholder="Layer" id="data-layer">
					</div>
				</div>
				<div class="form-group">
					<label for="data-square" class="col-lg-offset-3 col-lg-2 control-label">Square</label>
					<div class="col-lg-3">
						<input type="text" name="data[square]" class="form-control input-sm" placeholder="Sqaure" id="data-square">
					</div>
				</div>
				<div class="form-group">
					<label for="data-field" class="col-lg-offset-3 col-lg-2 control-label">Field number</label>
					<div class="col-lg-3">
						<input type="text" name="data[fieldNumber]" class="form-control input-sm" placeholder="Field number" id="data-field">
					</div>
				</div>
				<div class="form-group">
					<label for="data-area" class="col-lg-offset-3 col-lg-2 control-label">Area</label>
					<div class="col-lg-3">
						<input type="text" name="data[area]" class="form-control input-sm" placeholder="Area" id="data-area">
					</div>
				</div>
				<div class="form-group">
					<label for="data-homestead" class="col-lg-offset-3 col-lg-2 control-label">Homestead</label>
					<div class="col-lg-3">
						<input type="text" name="data[homestead]" class="form-control input-sm" placeholder="Homestead" id="data-homestead">
					</div>
				</div>
				<div class="form-group">
					<label for="data-gps" class="col-lg-offset-3 col-lg-2 control-label">GPS coordinates</label>
					<div class="col-lg-3">
						<input type="text" name="data[gps]" class="form-control input-sm" placeholder="GPS coordinates" id="data-gps">
					</div>
				</div>
				<div class="form-group">
					<label for="data-year" class="col-lg-offset-3 col-lg-2 control-label">Year</label>
					<div class="col-lg-3">
						<input type="text" name="data[year]" class="form-control input-sm" placeholder="Year" id="data-year">
					</div>
				</div>
				<div class="form-group">
					<label for="data-description" class="col-lg-offset-3 col-lg-2 control-label">Description WIP</label>
					<div class="col-lg-3">
						<input type="text" name="data[description]" class="form-control input-sm" placeholder="Description" id="data-description">
					</div>
				</div>
				<div class="form-group">
					<label for="data-dating" class="col-lg-offset-3 col-lg-2 control-label">Dating</label>
					<div class="col-lg-3">
						<input type="text" name="data[dating]" class="form-control input-sm" placeholder="Dating" id="data-dating">
					</div>
				</div>
				<div class="form-group">
					<label for="data-storage" class="col-lg-offset-3 col-lg-2 control-label">Storage</label>
					<div class="col-lg-3">
						<input type="text" name="data[storagePlace]" class="form-control input-sm" placeholder="Storage" id="data-storage">
					</div>
				</div>
				<div class="form-group">
					<label for="data-notes" class="col-lg-offset-3 col-lg-2 control-label">Notes WIP</label>
					<div class="col-lg-3">
						<input type="text" name="data[notes]" class="form-control input-sm" placeholder="Notes" id="data-notes">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-4">
						<div class="btn-group">
							<button type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-plus"></span> Add item
							</button>
						</div>
					</div>
				</div>
			</form>
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
