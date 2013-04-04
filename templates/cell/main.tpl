{include file="$header"}

<body class="{$forumSkin}" lang="ru">
	<div class="content">
		{include file="forum_head.tpl"}

		<div class="wrapper">
			<aside>
				{include file="side_nav.tpl"}
			</aside>
			<div class="right_column">
				<a href="http://forum.riverrise.net/topic/45746/">
					<div class="top_banner lighter_fast"></div>
				</a>
				
				{if $mainBlock}
					{include file="bricks/main.tpl"}
				{/if}
				
				{foreach from=$newsList item=newsEntry}
					{include file="bricks/news.tpl"}
				{/foreach}
			</div>
			{if $newsLoader}
				<div id="loader" class="content_loader">
					{if $pagination}
						<div class="pagination">{$pagination}</div>
					{else}
						<a href="/news/{if $pageName != "main"}page/{if $nextPage}{$nextPage}{else}2{/if}{/if}" onclick="nextPage()">
							<span>&#8595;</span> Остальные новости <span>&#8595;</span>
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
</body>
</html>
