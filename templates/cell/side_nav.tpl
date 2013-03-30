<ul class="nav_buttons">
    <li>
        <a href="/"><div class="nbutton main {if $pageName == "main"}active{/if}" title="Главная страница"></div></a>
    </li>
    <li>
        <a href="/news/"><div class="nbutton news {if $pageName == "news" || $pageName == "news_page"}active{/if}" title="Все новости проекта"></div></a>
    </li>
    <li>
        <a href="/stats/"><div class="nbutton stats {if $pageName == "stats"}active{/if}" title="Состояние миров"></div></a>
    </li>
    <li>
        <a href="/rules/"><div class="nbutton rules {if $pageName == "rules"}active{/if}" title="Правила сервера"></div></a>
    </li>
    <li>
        <a href="http://lk.riverrise.net/"><div class="nbutton tools {if $pageName == "tools"}active{/if}" title="Личный кабинет"></div></a>
    </li>
</ul>