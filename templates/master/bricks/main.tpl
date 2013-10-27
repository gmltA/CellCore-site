<div class="standardbox">
	<div class="topbar">
		<div class="leftcorner"></div>
		<div class="rightcorner"></div>
		<div class="middle">
			<div class="rightfade"></div>
			<h1 class="title">{if $title}{$title}{else}{$site.app_descr}{/if}</h1>
		</div>
	</div>
	<div class="middlebar">
		<div class="backgroundhex main" id="hex_main"></div>
		<div class="backgroundhex news" id="hex_news"></div>
		<div class="backgroundhex stats" id="hex_stats"></div>
		<div class="backgroundhex rules" id="hex_rules"></div>
		<div class="backgroundhex tools" id="hex_tools"></div>
		<div class="line">
			<article>
				{include file="bricks/$bodyContent.tpl"}
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
