<?php

get_header();


if ( have_posts() ) :
	while ( have_posts() ) : the_post();

		//the_content();
		?>

		<div class="myb_heading">
			<div class="wrap">
				<h1 class="font_bigger line_big font_bold">Реклама</h1>
			</div>
			<div class="wrap">

				<div class="manager_info">
					<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Менеджер</div>
					<ul class="manager_info_ul">
						<li class="manager_telegram"><a href="https://t.me/HelennWorobey" rel="nofollow">@HelennWorobey</a></li>
						<li class="manager_mail"><a href="mailto:sale@eto-razvod.ru">sale@eto-razvod.ru</a></li>

					</ul>
				</div>
			</div>
		</div>
		<?php if (get_locale() == 'ru_RU') { ?>
		<div class="wrap">
			<div class="myb_wrap">
				<div class="column_main"><span class="title_column_main">Статус<br/>«Подтвержденная компания»</span>
					<img src="/wp-content/themes/eto-razvod-1/img/status_this.png" alt=""/>
					<p></p>
					<ul>
                        <li>Личный кабинет компании.</li>
                        <li>Доступ к бесплатному редактированию информации о компании в течение месяца (с помощью менеджера).</li>
                        <li>Доступ к приватному урегулированию споров с пользователями, оставляющими отзывы и жалобы через внутренний мессенджер на нашем сайте в течение месяца.</li>
                        <li>Доступ к ответам на отзывы и жалобы от лица компании.</li>
					</ul>
					<div class="bonus_wrapper_column"><span class="sub_title_main_column">+ Бонус</span>
						<p></p>
						<ul class="sub_bonus_main_column">
							<li>Месяц размещения баннера на вашем профайле в Сайдбаре</li>
							<li>Месяц показа Pop-Up, на вашем профайле, который будет показываться читателям на 30-й
								секунде.
							</li>
						</ul>
					</div>
					<p><span class="bonus_wrapper_column_price">4990 рублей<br/>Единовременный платеж </span> <a
							class="button font_bold button_green link_no_underline button_nopadding select_pricing_2 add_company"
							href="/feedback/" rel="nofollow">Отправить заявку</a></p>
				</div>
				<div class="column_main_second">
					<div class="sub_column"><span class="title_sub_column">Тарифы размещения компании на сайте</span><br/><img
							src="/wp-content/themes/eto-razvod-1/img/driver_license.png" alt=""/><br/>

						<ul class="ul_menu_a">
							<li><span class="pricelisted">Тариф «Минимум»</span> — публикация только таблицы компании — <span class="pricelisted_price">6000 рублей</span>.</li>
							<li><span class="pricelisted">Тариф «Максимум»</span> — публикация таблицы с обзором. Обзор присылает компания - <span class="pricelisted_price">8000 рублей</span>.</li>
							<li><span class="pricelisted">Тариф «Максимум+»</span> — публикация таблицы с обзором. Обзор пишем мы сами — <span class="pricelisted_price">10000 рублей</span>.</li>
							<li>Публикация только обзора к уже имеющейся таблице. Если обзор пишем мы, стоимость составляет <span class="pricelisted_price">6000 рублей</span>. <br><br>Если обзор присылает компания, стоимость публикации составляет <span class="pricelisted_price">4000 рублей</span>.</li>

						</ul>

						<br/><a
							class="button font_bold button_green link_no_underline button_nopadding select_pricing_2 add_obzor"
							href="/feedback/" rel="nofollow">Перейти</a></div>
					<div class="sub_column"><span class="title_sub_column">Предложить<br/>свой вариант</span><br/><img
							src="/wp-content/themes/eto-razvod-1/img/discuss.png" alt=""/><a
							class="button font_bold button_green link_no_underline button_nopadding select_pricing_2"
							href="/feedback/" rel="nofollow">Связаться с нами</a></div>
				</div>
			</div>
		</div>
		<div class="wrap flex-direction-column auditoria-v-wrap">
			<span class="title_stats">Аудитория</span>
			<div class="auditoria-v">
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/users-svgrepo-com.svg" alt=""><span>Более 10 000 уникальных пользователей в день</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/a-block.svg" alt=""><span>87% посетителей сайта не блокируют рекламу</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/search-block.svg" alt=""><span>88% посетителей приходят на сайт из поиска</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/money-svgrepo-com.svg" alt=""><span>25 - 45 лет - ядро аудитории</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/kremlin-russia-svgrepo-com.svg" alt=""><span>82% посетителей сайта из России</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/comment-svgrepo-com.svg" alt=""><span>50 отзывов в среднем ежедневно оставляют люди на сайте</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/iphone-svgrepo-com.svg" alt=""><span>64% пользователей смотрят сайт со смартфонов</span></div>
				<div class="auditoria-v-inside"><img src="/wp-content/uploads/2022/12/rating-svgrepo-com.svg" alt=""><span>77 рейтингов компаний, основанных на аналитике и статистике, а также мнениях пользователей ресурса</span></div>
			</div>
		</div>

		<div class="wrapper-text  wrap">
			<div class="w-text">
				<span class="title-a-text">Работа с отзывами</span>

				<p>Ежедневно на нашем сайте появляются десятки отзывов и жалоб на разные компании. Наш проект помогает не только пользователям, которые ищут отзывы о разных компаниях, но и самим компаниям, которые заинтересованы в обратной связи от клиентов и готовы решать возникшие вопросы. За 2022 год мы значительно улучшили сервис:</p>

				<ul class="ul_menuer">
					<li>У <a href="/reliable-review/">каждого отзыва теперь есть статус</a>, который позволяет пользователю судить о достоверности написанного</li>
					<li>Каждый отзыв тщательно модерируется на предмет нарушения правил сайта и законодательства РФ</li>
					<li>Каждый отзыв имеет оценку, благодаря которой формируется средняя оценка компании</li>
					<li>Помимо текста самого отзыва, каждый пользователь может также написать плюсы и минусы компании или услуги</li>
				</ul>

				<span class="title-a-text-d">Подтверждение компании</span>

				<p>Репутация компании напрямую зависит от того, что о ней пишут в интернете. Благодаря нашему проекту, каждая компания может урегулировать спор с недовольным клиентом, отработать негатив или ответить благодарностью на позитивные комментарии. Сделать это можно с помощью услуги “Подтвержденная компания”, благодаря которой карточка компании привязывается к определенному аккаунту на сайте.</p>

				<p>Это выделит вас среди конкурентов в общем рейтинге, благодаря отметке в виде зеленой галочки.</p>

				<img src="/wp-content/uploads/2022/12/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA-%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0-2022-12-18-%D0%B2-00.13.02.png" alt="">

				<p>В самой карточке компания также будет выделяться зеленым цветом.</p>

				<img src="/wp-content/uploads/2022/12/Снимок-экрана-2022-12-18-в-00.13.26.png" alt="">

				<p>В ответах на отзывы к профилю будет привязан фиолетовый значок.
				</p>
				<img src="/wp-content/uploads/2022/12/Снимок-экрана-2022-12-18-в-00.13.48.png" alt="">
				<p>Внутри профиля вы сможете видеть статистику компании по отзывам, жалобам и рейтингу, а также быстро отвечать на отзывы не только публично, но и лично, например, для уточнения данных по заказу.
				</p>
				<a class="button font_bold button_green link_no_underline button_nopadding select_pricing_2 islogclick gotodashboard" href="#" rel="nofollow">Подключить услугу за 4990 рублей</a>

				<span class="title-a-text-d">Бонусы за подключение услуги «Подтвержденная компания»</span>


				<ul class="ul_text_a"><li>Месяц бесплатного размещения баннера на вашем профайле в Сайдбаре</li>
					<li>Месяц бесплатного показа Pop-Up, на вашем профайле, который будет показываться читателям на 30-й секунде</li></ul>


				<span class="title-a-text">Форматы сотрудничества</span>

				<p>
					Мы уже 7 лет работаем в сфере партнерского маркетинга и понимаем, что у каждой ниши есть своя специфика, которую нужно учитывать. Поэтому для каждой вертикали у нас был разработан свой шаблон таблицы и обзора. Для наших партнеров мы разработали несколько форм сотрудничества для усиления трафика. Мы предлагаем:
				</p>

				<ul  class="ul_menuer">
					<li>Публикацию новостей в блоге на сайте и в наших социальных сетях. Ссылки на новости также публикуются на страницах компании.</li>
					<img src="/wp-content/uploads/2022/12/Снимок-экрана-2022-12-18-в-00.14.29.png" alt="" class="w300">
					<li>Публикацию экспертных статей и/или статей с использованием экспертного мнения от компании.
						<br>Пример: <a href="https://etorazvod.ru/choosing-online-schools/">https://etorazvod.ru/choosing-online-schools/</a></li>

					<li>Публикацию дополнительных страниц в карточке компании. Пример:</li>
					<img src="/wp-content/uploads/2022/12/Снимок-экрана-2022-12-18-в-00.14.48.png" alt="">
					<li>Публикацию статей на основе личного опыта.
						<br>Пример: <a href="https://etorazvod.ru/pass-exam/">https://etorazvod.ru/pass-exam/</a></li>

					<li>Мы также находимся в поиске новых форм сотрудничества с компаниями.</li>
				</ul>

				<a class="button font_bold button_green link_no_underline button_nopadding select_pricing_2" href="/feedback/" rel="nofollow">Связаться с нами</a>

				<span class="title-a-text">С нами работают</span>

				<p>С нами сотрудничают крупные компании в разных сферах бизнеса</p>


				<?php
					$arr = [
						212997,
						173783,
						158858,
						145735,
						144199,
						128370,
						127797,
						106161,
						105647,
						101901,
						101186,
						98579,
						81541,
						80425,
						69013,
						58484,
						58285,
						57588,
						56677,
						55820,
						55454,
						54729,
						54509,
						54310,
						53059,
						50320,
						43408,
						42609,
						41383,
						41140,
						37638,
						36488,
						35947,
						35923,
						35276,
						35126,
						34821,
						29255,
					];
					echo '<div class="logos_co_wrap">';
					foreach ($arr  as $item ) {
						if (!empty(get_field('company_logo',$item)['url'])) {
							echo '<a href="'.get_the_permalink($item).'"><img src="'.get_field('company_logo',$item)['url'].'" alt="" /></a>';
						}
					}
					echo '</div>';
				?>
				<p>Напишите нам, и мы ответим на все возникающие вопросы и сопроводим вас на всех этапах сотрудничества.</p>
				<span class="title-a-text">Контакты</span>
				<?=do_shortcode('[contact-form-7 id="33393" title="Обратная связь"]');?>
			</div>
		</div>
		<?php } ?>

		<!--<div class="wrap">
			<div class="stats"><span class="title_stats"> Статистика визитов на сайт </span> <span
					class="title_stats_type">По возрасту</span>
				<p></p>
				<div class="diagramm_wrapper">
					<div class="diagramm">
						<svg width="442" height="442" viewBox="0 0 442 442" fill="none"
							 xmlns="http://www.w3.org/2000/svg">
							<path
								d="M219.803 63.0371C248.938 63.0371 277.505 70.7719 302.341 86.0031C327.178 101.234 347.316 123.041 360.526 149.009C373.737 174.977 379.504 204.094 377.189 233.138C374.875 262.181 364.57 290.017 347.414 313.566L264.977 253.507C271.05 245.171 274.698 235.317 275.517 225.036C276.337 214.755 274.295 204.447 269.619 195.254C264.942 186.062 257.813 178.342 249.021 172.95C240.229 167.558 230.117 164.267 219.803 164.267L219.803 63.0371Z"
								fill="#FF0000" fill-opacity="0.68"/>
							<path
								d="M347.54 313.82C324.511 345.406 291.364 364.09 253.104 372.102C214.844 380.114 174.972 373.649 141.204 353.956L192.827 265.819C204.958 272.894 218.623 275.966 232.369 273.087C246.114 270.209 258.304 262.333 266.577 250.985L347.54 313.82Z"
								fill="#9D7DF9"/>
							<path
								d="M141.751 354.443C118.471 340.899 99.042 321.625 85.3127 298.454C71.5834 275.282 64.0098 248.984 63.3123 222.06L165.309 219.417C165.555 228.942 168.235 238.246 173.092 246.443C177.949 254.641 184.822 261.459 193.058 266.251L141.751 354.443Z"
								fill="#21B67C"/>
							<path
								d="M63.5171 222.061C63.3024 198.821 68.2211 175.82 77.922 154.7C87.6228 133.581 101.867 114.863 119.637 99.8839L185.16 177.614C178.832 182.949 173.76 189.614 170.305 197.135C166.851 204.655 165.099 212.846 165.176 221.122L63.5171 222.061Z"
								fill="#C1635D"/>
							<path
								d="M119.808 99.8056C138.702 84.0298 161.023 72.8901 184.989 67.2759L208.133 166.075C199.57 168.081 191.595 172.061 184.844 177.698L119.808 99.8056Z"
								fill="#6321B6"/>
							<path
								d="M184.394 67.3318C196.085 64.5509 208.054 63.1137 220.071 63.048L220.625 164.52C216.332 164.544 212.055 165.057 207.878 166.051L184.394 67.3318Z"
								fill="#C4C4C4"/>
						</svg>
					</div>
					<div class="diagramm_legend">
						<ul class="diagramm_legend_lines">
							<li>25- 34 ГОДА <span class="percents">35.4%</span><span class="color_FF5252">1</span></li>
							<li>35-44 ГОДА <span class="percents">23.3%</span><span class="color_9D7DF9">1</span></li>
							<li>18-24 ГОДА <span class="percents">16.2%</span><span class="color_21B67C">1</span></li>
							<li>45-54 ГОДА <span class="percents">14%</span><span class="color_C1635D">1</span></li>
							<li>55 ЛЕТ И СТАРШЕ <span class="percents">7.41%</span><span class="color_6321B6">1</span>
							</li>
							<li>ОСТАЛЬНЫЕ <span class="percents">3.63%</span><span class="color_C4C4C4">1</span></li>
						</ul>
					</div>
				</div>
				<div class="stats_two_columns">
					<div class="stats_column_main"><span class="title_stats_type">Страна</span>
						<p></p>
						<ul class="stats_column_main_ul">
							<li>РОССИЯ 86.5%</li>
							<li>УКРАИНА 3.56%</li>
							<li>БЕЛАРУСЬ 3.05%</li>
							<li>КАЗАХСТАН 1.9%</li>
							<li>ГЕРМАНИЯ 0.66%</li>
							<li>ОСТАЛЬНЫЕ 4.31%</li>
						</ul>
					</div>
					<div class="stats_column_main_second"><span class="title_stats_type">Пол</span>
						<p></p>
						<div class="column_s">
							<div class="column_pol"><span>60.5%</span></div>
							<div class="column_pol"><span>39.5%</span></div>
						</div>
						<div class="title_pol"><span class="title_pol_ins"><span class="color_t1">1</span>МУЖЧИНЫ</span><span
								class="title_pol_ins"><span class="color_t2">1</span>ЖЕНЩИНЫ</span></div>
					</div>
				</div>
			</div>
		</div>-->


	<?php
	endwhile;
endif;


get_footer();

?>