{include file="$header"}

<body class="{$forumSkin} news" lang="ru">
	<div class="content">
		{include file="forum_head.tpl"}

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
							<time class="date">{$newsEntry.date}</time>
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
	<div class="login_errors_box" id="login_errors"></div>
	<div class="embed_login"></div>
</body>
</html>
