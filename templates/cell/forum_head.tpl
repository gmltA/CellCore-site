<header>
	<div class="branding">
		<div class="header_bar clearfix">
			<div class="main_width">
				<div style="display: inline-block;">
					<div class="search_dropdown">
					</div>
					<div class="info user">
						{if !$user->isLoggedIn()}
							<a href="{$site.panel_url}" onclick="openLogin()">{$lang.auth}</a>
							<span class="spacer">|</span>
						{/if}
						{$user->getDisplayName()}
					</div>
					<form action="/search/"  enctype="application/x-www-form-urlencoded" method="post" id="search_form" class="right clearfix">
						<span class="search_wrapper">
							<input type="text" id="search" name="search_query" placeholder="{$lang.search}">
							<input type="submit" value="">
						</span>
					</form>
				</div>
			</div>
		</div>
		<div class="main_width">
			<div class="logo">
				<a href='http://forum.riverrise.net/' title='{$lang.to_forum}'>
					<img src='http://forum.riverrise.net/public/style_images/{if $forumSkin == "riverrise"}CS{else}{$forumSkin}{/if}/logo.png' alt='Logo'/>
				</a>
			</div>
			<!--<a href="http://www.w3.org/html/logo/" class="right clearfix" style="opacity: 0.7;">
				<img src="{$MainTemplateDir}/images/html5-badge-v-css3-semantics.png" width="35" height="130" alt="HTML5 Powered with CSS3 / Styling, and Semantics" title="HTML5 Powered with CSS3 / Styling, and Semantics">
			</a>-->
		</div>
	</div>
	<nav class="clearfix">
		<div class="main_width">
			<a href="{$site.main_url}" title="{$lang.to_site}" rel="home" class="left active">RiverRise.net</a>
			<a href="http://forum.riverrise.net/" title="{$lang.to_forum}" class="left">{$lang.forum}</a>
			<a href="http://forum.riverrise.net/index.php?app=members" title="{$lang.to_users}" class="left">{$lang.users}</a>
			<a href="http://forum.riverrise.net/index.php?app=tracker" title="{$lang.to_tracker}" class="left">{$lang.tracker}</a>
			<a href="http://forum.riverrise.net/index.php?app=gallery" title="{$lang.to_gallery}" class="left">{$lang.gallery}</a>
			<a href="http://forum.riverrise.net/index.php?app=blog" title="{$lang.to_blogs}" class="left">{$lang.blogs}</a>
			<a href="http://forum.riverrise.net/index.php?app=jawards" title="{$lang.to_awards}" class="left">{$lang.awards}</a>
			<a href="http://data.riverrise.net/" title="{$lang.to_db}" class="right">{$lang.db}</a>
		</div>
	</nav>
</header>
