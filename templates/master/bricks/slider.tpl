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

{literal}
<script type="text/javascript">
$('#slider').nivoSlider({
		effect: 'sliceDown',
		slices: 35,
		animSpeed: 200,
		pauseTime: 5000,
		startSlide: 0,
		directionNav: true,
		directionNavHide: true,
		controlNav: true,
		controlNavThumbs: false,
		controlNavThumbsFromRel: false,
		controlNavThumbsSearch: '.jpg',
		controlNavThumbsReplace: '_thumb.jpg',
		keyboardNav: false,
		pauseOnHover: true,
		manualAdvance: false,
		captionOpacity: 0.8
	});
</script>
{/literal}
