<div id="slider-wrapper">
	<div id="slider" class="nivoSlider">
		{foreach from=$sliderContent item=entry}
			{if $entry.link}
				<a href="{$entry.link}">
			{/if}
					<img src="/{$contentDir}/images/{$entry.contentImage}" alt="" title="#description_{$entry.id}" />
			{if $entry.link}
				</a>
			{/if}
		{/foreach}
	</div>
	{foreach from=$sliderContent item=entry}
		<div id="description_{$entry.id}" class="nivo-html-caption">
			{$entry.description}
		</div>
	{/foreach}
</div>
