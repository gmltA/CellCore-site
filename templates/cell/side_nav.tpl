<ul class="nav_buttons">
    <li>
        <a href="/"><div class="nbutton main {if $pageName == "main"}active{/if}" title="Главная страница" role="button"></div></a>
    </li>
    <li>
        <a href="/news/"><div class="nbutton news {if $pageName == "news" || $pageName == "news_page" || $pageName == "news_search"}active{/if}" title="Все новости проекта" role="button"></div></a>
    </li>
    <li>
        <a href="/stats/"><div class="nbutton stats {if $pageName == "stats"}active{/if}" title="Состояние миров" role="button"></div></a>
    </li>
    <li>
        <a href="/rules/"><div class="nbutton rules {if $pageName == "rules"}active{/if}" title="Правила сервера" role="button"></div></a>
    </li>
    <li>
        <a href="http://lk.riverrise.net/"><div class="nbutton tools {if $pageName == "tools"}active{/if}" title="Личный кабинет" role="button"></div></a>
    </li>
</ul>