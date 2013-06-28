{include file="$header"}

<body class="{$forumSkin} news" lang="ru">
	<div class="content">
		{include file="forum_head.tpl"}

		{if $site.banner_top}
			<div class="wrapper">
				{include file="bricks/banner.tpl"}
			</div>
		{/if}
		<div class="wrapper">
			<div class="right_column">
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
				{if $newsEntry.comments|@sizeof > 0}
				<div class="standardbox">
					<div class="topbar">
						<div class="leftcorner"></div>
						<div class="rightcorner"></div>
						<div class="middle">
							<div class="rightfade"></div>
							<h2 class="title">Комментарии ({$newsEntry.comments|@sizeof})</h2>
						</div>
					</div>
					<div class="middlebar">
						<div class="line" style="
							padding: 10px 0 10px 0;
						">
						<div id="comments_container">
							{include file="bricks/news_comment_list.tpl"}
						</div>
						{if $user->isLoggedIn()}
							<span class="new_comment_header">Новый комментарий</span>
							<section class="comment new">
								<input type="hidden" id="topicId" value="0">
								<div id="progressbar">
									<div class="loading_text">Отправка комментария</div>
									<div class="loading"></div>
								</div>
								<div class="header">
									<h3>{$user->getDisplayName()}</h3>
									<span class="subject" hidden>to <a href="#comment_{$subjId}"><b></b></a><span class="subject_clear">×</span></span>
								</div>
								<div class="body editor" contenteditable="true">
								</div>
							</section>
							<span class="button" id="post_comment">Оставить комментарий</span>
							<span class="button" id="preview_comment">Предпросмотр</span>
						{/if}
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
