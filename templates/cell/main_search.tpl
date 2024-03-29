{include file="$header"}

<body class="{$forumSkin} search" lang="ru" dir="ltr">
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
				<div class="standardbox search">
					<div class="topbar">
						<div class="leftcorner"></div>
						<div class="rightcorner"></div>
						<div class="middle">
							<div class="rightfade"></div>
								<h2 class="title">{$lang.search}</h2>
							<time class="date">{$newsEntry.date}</time>
						</div>
					</div>
					<div class="middlebar">
						<div class="line">
							<article>
								{$lang.search_result_1} <i>'{$query}'</i> {$lang.search_result_2} <b>{$newsList|sizeof}</b> {$newsList|sizeof|declension:$lang.records:false:ru}
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
				
				{if $newsList|sizeof == 0}
					{include file="bricks/main.tpl"}
				{else}
					{foreach from=$newsList item=newsEntry}
						{include file="bricks/news.tpl"}
					{/foreach}
				{/if}
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	{include file='footer.tpl'}
	<div id="blackout"></div>
	<div class="login_errors_box" id="login_errors"></div>
	<div class="embed_login"></div>
</body>
</html>
