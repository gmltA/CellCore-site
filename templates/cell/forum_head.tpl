<header>
    <div class="branding">
        <div class="header_bar clearfix">
            <div class="main_width">
                <div class="info user">
                    {if $user->IsLoggedIn() != true}
                        <a href="{$panelURL}" onclick="openLogin()">Авторизация</a>
                        <span class="spacer">|</span>
                    {/if}
                    {$userName}
                </div>
            </div>
        </div>
        <div class="main_width">
            <div class="logo">
                <a href='http://forum.riverrise.net' title='Перейти к списку форумов' rel="forum">
                    <img src='http://forum.riverrise.net/public/style_images/{if $forumSkin == "riverrise"}CS{else}{$forumSkin}{/if}/logo.png' alt='Логотип'/>
                </a>
            </div>
            <!--<a href="http://www.w3.org/html/logo/" class="right clearfix" style="opacity: 0.7;">
                <img src="{$MainTemplateDir}/images/html5-badge-v-css3-semantics.png" width="35" height="130" alt="HTML5 Powered with CSS3 / Styling, and Semantics" title="HTML5 Powered with CSS3 / Styling, and Semantics">
            </a>-->
        </div>
    </div>
    <nav class="clearfix">
        <div class="main_width">
            <a href="http://riverrise.net" title="Перейти на сайт" rel="home" class="left active">RiverRise.net</a>
            <a href="http://forum.riverrise.net" title="Перейти к списку форумов" rel="forum" class="left">Форумы</a>
            <a href="http://forum.riverrise.net/index.php?app=members" title="Перейти к списку пользователей" class="left">Пользователи</a>
            <a href="http://forum.riverrise.net/index.php?app=tracker" title="Перейти к BugTracker'у" class="left">Ошибки</a>
            <a href="http://forum.riverrise.net/index.php?app=gallery" title="Перейти к галереи" class="left">Галерея</a>
            <a href="http://forum.riverrise.net/index.php?app=blog" title="Перейти к блогам" class="left">Блоги</a>
            <a href="http://forum.riverrise.net/index.php?app=jawards" title="Перейти к списку наград" class="left">Награды</a>
            <a href="http://data.riverrise.net/" title="Перейти к базе знаний" class="right">База знаний WoW</a>
        </div>
    </nav>
</header>