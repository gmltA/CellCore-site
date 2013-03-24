{include file="$header"}

<body class="{$forumSkin} news" lang="ru">
	<div class="content">
		{include file="forum_head.tpl"}
		
		{if $debug == '1'}
			<div align="center" style="margin-top: 100px;">
				<div class="result_box" style="margin: 0; padding: 0;" >
					<div class="result_content">
						<h3 style="color: red;">Access denied!</h3>
						<table width="100%" style="margin-top: 50px;">
							<tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Либо вам запрещён сюда доступ, либо очистите cookies и авторизируйтесь на форуме!</td></tr>
						</table>
					</div>
				</div>
			</div>
		{/if}
		<div class="wrapper">
			<div class="right_column">
				<a href="http://forum.riverrise.net/topic/45746/">
					<div class="top_banner lighter_fast"></div>
				</a>
				<div class="standardbox">
					<div class="topbar">
						<div class="leftcorner"></div>
						<div class="rightcorner"></div>
						<div class="middle">
							<div class="rightfade"></div>
							<div class="title breadcrumb breadcrumbsub">
								<div class="left"></div>
								<div class="center">
									<div class="ref">
										<div class="contents">
											<div class="link"><a href="/">Главная</a></div>
											<div class="arrowsm"></div>
											<div class="link"><a href="/news/">Новости</a></div>
											<div class="arrowsm"></div>
											<div class="text"><h2>{$newsEntry.title}</h2></div>
										</div>
									</div>
								</div>
								<div class="right"></div>
							</div>
							<span class="date">{$newsEntry.date}</span>
						</div>
					</div>
					<div class="middlebar">
						<div class="line">
							<article id="{$newsEntry.id}">
								{$newsEntry.content}
							</article>
							<div class="article_bottom">
								Просмотров: <span id="views">{$newsEntry.views}</span>
							</div>
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
			</div>
			<div class="clearfix" ></div>
		</div>
	</div>
	{include file='footer.tpl'}
	<div id="blackout"></div>
	<div class="embed_login"></div>

</body>
</html>
