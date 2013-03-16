<div class="standardbox">
    <div class="topbar">
        <div class="leftcorner"></div>
        <div class="rightcorner"></div>
        <div class="middle">
            <div class="rightfade"></div>
            <h2 class="title">{$newsEntry.title}</h2>
            <span class="date">{$newsEntry.date}</span>
        </div>
    </div>
    <div class="middlebar">
        <div class="line">
            <article>
                {$newsEntry.content}
            </article>
            <div class="news_cut">
                <a href="{$newsEntry.link}">
                    Новость целиком
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