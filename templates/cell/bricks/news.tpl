<div class="standardbox">
	<div class="topbar">
		<div class="leftcorner"></div>
		<div class="rightcorner"></div>
		<div class="middle">
			<div class="rightfade"></div>
			<a href="{$newsEntry.link}">
				<h2 class="title">{$newsEntry.title}</h2>
			</a>
			<time class="date">{$newsEntry.date}</time>
		</div>
	</div>
	<div class="middlebar">
		<div class="line">
			<article>
				{$newsEntry.content}
			</article>
			<div class="article_bottom">
				{$lang.views}: {$newsEntry.views}{if $newsEntry.commentsEnabled} | <a href="{$newsEntry.link}#comments">{$lang.comments}: {$newsEntry.commentsNumber}</a>{/if}
				<a href="{$newsEntry.link}" class="news_cut clearfix">
					{$lang.full_news}
				</a>
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