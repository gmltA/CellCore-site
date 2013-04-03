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
				
				{if $pageName != "news" && $pageName != "news_page"}
					<div class="standardbox">
						<div class="topbar">
							<div class="leftcorner"></div>
							<div class="rightcorner"></div>
							<div class="middle">
								<div class="rightfade"></div>
								<h1 class="title">{if $title}{$title}{else}{$site.app_descr}{/if}</h1>
							</div>
						</div>
						<div class="middlebar">
							<div class="backgroundhex main" id="hex_main"></div>
							<div class="backgroundhex news" id="hex_news"></div>
							<div class="backgroundhex stats" id="hex_stats"></div>
							<div class="backgroundhex rules" id="hex_rules"></div>
							<div class="backgroundhex tools" id="hex_tools"></div>
							<div class="line">
								<article>
									{include file="bricks/$bodyContent.tpl"}
								</article>
							</div>
						</div>
						<div class="bottombar">
							<div class="middle">
								<div class="leftcorner"></div>
								<div class="rightcorner"></div>
							</div>
						</div>
						<div class="shadowbar">
							<div class="line"></div>
							<div class="shadow"></div>
						</div>
					</div>
				{/if}
				
				{foreach from=$newsList item=newsEntry}
					{include file="bricks/news.tpl"}
				{/foreach}
			</div>
			{if $pageName == "news_page" || $pageName == "news" || $pageName == "main"}
				<div id="loader" class="content_loader">
					<a href="/news/{if $pageName != "main"}page/{if $nextPage}{$nextPage}{else}2{/if}{/if}" onclick="nextPage()">
						<span>&#8595;</span> Остальные новости <span>&#8595;</span>
					</a>
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
