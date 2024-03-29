{include file="$header"}

<body class="{$forumSkin} news" lang="ru" dir="ltr">
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
							<div class="title breadcrumb">
								<div class="left"></div>
								<div class="center">
									<div class="ref">
										<div class="contents">
											<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="link">
												<a href="/" itemprop="url">
													<span itemprop="title">{$lang.main_page}</span>
												</a>
											</div>
											<div class="arrowsm"></div>
											<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="link">
												<a href="/news/" itemprop="url">
													<span itemprop="title">{$lang.news_page}</span>
												</a>
											</div>
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
								{$lang.views}: <span id="views">{$newsEntry.views}</span>
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
				{if $newsEntry.commentsEnabled && ($newsEntry.comments|@sizeof > 0 || $user->isLoggedIn())}
				<div class="standardbox" id="comments">
					<div class="topbar">
						<div class="leftcorner"></div>
						<div class="rightcorner"></div>
						<div class="middle">
							<div class="rightfade"></div>
								<h2 class="title">{$lang.comments} ({$newsEntry.comments|@sizeof})</h2>
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
							<span class="new_comment_header">{$lang.new_comment}</span>
							<section class="comment new">
								<input type="hidden" id="topicId" value="0">
								<div id="progressbar">
									<div class="loading_text">{$lang.posting_comment}</div>
									<div class="loading"></div>
								</div>
								<div class="header">
									<h3>{$user->getDisplayName()}</h3>
									<span class="subject" hidden>to <a href="#comment_{$subjId}"><b></b></a><span class="subject_clear">×</span></span>
								</div>
								<div class="body editor" contenteditable="true"></div>
							</section>
							<span class="button" id="post_comment">{$lang.post_comment}</span>
							<span class="button" id="preview_comment">
								<span id="preview_caption">{$lang.preview_comment}</span>
								<span id="edit_caption" hidden>{$lang.edit_comment}</span>
							</span>
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
