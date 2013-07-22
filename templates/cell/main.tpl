{include file="$header"}

<body class="{$forumSkin}" lang="ru" dir="ltr">
	<div class="content">
		{include file="forum_head.tpl"}

		<div class="wrapper">
			<aside>
				{include file="side_nav.tpl"}
			</aside>
			{if $site.banner_top}
				{include file="bricks/banner.tpl"}
			{/if}
			<div class="right_column">
				{if $mainBlock}
					{include file="bricks/main.tpl"}
				{/if}
				
				{foreach from=$newsList item=newsEntry}
					{include file="bricks/news.tpl"}
				{/foreach}
			</div>
			{if $newsLoader && $newsList|@sizeof > 2}
				<div id="loader" class="content_loader">
					{if $pagination}
						<div class="pagination">{$pagination}</div>
					{else}
						<a href="/news/{if $pageName != "main"}page/{if $nextPage}{$nextPage}{else}2{/if}{/if}" onclick="nextPage()">
							<span>&#8595;</span> {$lang.other_news} <span>&#8595;</span>
						</a>
					{/if}
				</div>
			{/if}
			<div class="clearfix"></div>
		</div>
	</div>
	{include file='footer.tpl'}
	<div id="blackout"></div>
	<div class="login_errors_box" id="login_errors"></div>
	<div class="embed_login"></div>
	<div class="scroll_manager"><span id="to_top">▲ {$lang.nav_up}</span><span id="to_bottom">▼ {$lang.nav_back}</span></div>
</body>
</html>
