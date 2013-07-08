{include file="$header"}

<body class="{$forumSkin} news" lang="ru" dir="ltr">
	<div class="content">
		{include file="forum_head.tpl"}

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
													<span itemprop="title">Главная</span>
												</a>
											</div>
											<div class="arrowsm"></div>
											<div class="text"><h2>{$errorTitle}</h2></div>
										</div>
									</div>
								</div>
								<div class="right"></div>
							</div>
						</div>
					</div>
					<div class="middlebar">
						<div class="line">
							<article class="{$errorClass}">
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
