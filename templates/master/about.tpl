{include file="$header"}

    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">{$site.app_descr}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/"><span class="glyphicon glyphicon-home"></span> Главная</a></li>
            <li class="active"><a href="/about/"><span class="glyphicon glyphicon-question-sign"></span> О проекте</a></li>
            <li><a href="/catalog/"><span class="glyphicon glyphicon-book"></span> Каталог</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <div class="site-logo pull-left"></div>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a href="/catalog/" class="btn btn-primary btn-lg">Перейти к каталогу &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="panel panel-default">
			<div class="panel-heading">О нашем проекте</div>
			<div class="panel-body">
				<p>На историческом факультете созданы условия, позволяющие раскрыть научно-исследовательский потенциал студентов, реализовать их способности к самостоятельной научно-исследовательской работе.</p>
				<p>Тематика курсовых и дипломных работ позволяет выполнять оригинальные исследования, основанные на архивных и краеведческих материалах. Регулярно проводятся научно-практические конференции, которые дают студентам возможность апробировать результаты своих исследований.</p>
				<p>Студенты исторического факультета участвуют в научных мероприятиях, которые проводятся в Минске, Гродно, Мозыре, Полоцке, Витебске, а также за пределами республики – в России (Москва), Польше (Белосток, Вроцлав, Краков), Украине (Луцк), Германии (Франкфурт-на-Одере).</p>
				<p>Наиболее интересные исследования, построенные на использовании архивных и полевых материалов, принимают участие в республиканских конкурсах научных студенческих работ. Многие работы удостоены высокой оценки, а их авторы получили премии Специального фонда Президента Республики Беларусь по социальной поддержке одаренных учащихся и студентов.</p>
				<p>В 2010 г. работа студентки 5 курса Борисюк Татьяны (научный руководитель к.ф.н. Н.П. Галимова) была удостоена дипломом Второй степени в VIРеспубликанском конкурсе творческих работ учащихся и студентов по социально-гуманитарным наукам «Вялікая перамога ў нашай памяці жыве», посвященной 65-й годовщине Победы советского народа в Великой Отечественной войне.</p>
				<p>На историческом факультете издается сборник студенческих работ «Моладзь Берасцейшчыны», сборник научных трудов «Берасцейскі хранограф», а так же материалы научных конференций. Под руководством преподавателей факультета действуют Студенческое научное общество и студенческие научно-исследовательские группы по изучению различных проблем отечественной и мировой истории и культуры.</p>
			</div>
		</div>
      </div>

	{include file='footer.tpl'}
	</body>
</html>
