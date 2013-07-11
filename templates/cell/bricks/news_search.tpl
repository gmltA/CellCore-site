{if !empty($newsList)}
	<div id="search_result">
		{foreach from=$newsList item=newsEntry}
			<a href="{$newsEntry.link}">
			<section>
				<span>{$newsEntry.title}</span>
				<p>
					{$newsEntry.short}
				</p>
			</section>
			</a>
		{/foreach}
	</div>
	{if $newsList|@sizeof >= 5}
		<div class="all_search_results">
			<a rel="search">{$lang.other_news}</a>
		</div>
	{/if}
{/if}
