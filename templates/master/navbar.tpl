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
				<li {if $pageName == 'main'}class="active"{/if}><a href="/"><span class="glyphicon glyphicon-home"></span> {$lang.main_page}</a></li>
				<li {if $pageName == 'about'}class="active"{/if}><a href="/about/"><span class="glyphicon glyphicon-question-sign"></span> {$lang.title_about}</a></li>
				<li {if $pageName == 'catalog' || $pageName == 'catalog_entry' || $pageName == 'catalog_page' || $pageName == 'catalog_search' || $pageName == 'catalog_item'}class="active"{/if}><a href="/catalog/"><span class="glyphicon glyphicon-book"></span> {$lang.title_catalog}</a></li>
			</ul>
		</div>
	</div>
</div>