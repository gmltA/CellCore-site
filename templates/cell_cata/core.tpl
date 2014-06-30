{include file='header_dynamic.tpl'}

<body>
	<div class="core_logo"></div>
	<div class="middle_plate" style="margin-top: 200px;">
		<div class="wrapper">
			<div class="middle_placeholder" style="min-height: 750px;">
				<div class="breadcrumb">
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
								<div class="text">О ядре</div>
							</div>
						</div>
					</div>
					<div class="right"></div>
				</div>
				<div class="content">
					<div class="about_p_core"></div>
					<div class="sub_">
						<div class="tweeter_container">
						{literal}
						<a class="twitter-timeline" width="300" height="300" href="https://twitter.com/CellCoreProject" data-chrome="nofooter" data-tweet-limit="3" data-widget-id="354855554008625153">Tweets by @CellCoreProject</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

							{/literal}
						</div>
						<b>CellCore</b> - проект, представляющий собой модифицированный и доработанный эмулятор TrinityCore и модифицированную базу данных, основанную на слиянии YTDB и TDB.
						Основными особенностями ядра являются:
						<ul>
						<li><b>Работоспособность</b> заклинаний\квестов\подземелий\праздников значительно выше по сравнению с TrinityCore и некоторыми другими модификациями этого ядра
						<li><b>Уникальность</b> скриптов квестов\праздников\подземелий, которая позволит Вам испытать то, что Вы никогда не сможете опробовать на других проектах
						<li><b>Стабильность</b> значительно выше, по сравнению с другими ядрами такого уровня модификации
						<li><b>Защищённость</b> ядра обеспечивает 2 Античит-системы вкупе с различными уникальными доработками, включая используемый на официальном сервере клиент Warden
						</ul>
					</div>
				</div>
			</div>
		</div>
		{include file='footer.tpl'}
	</div>
</body>
</html>
