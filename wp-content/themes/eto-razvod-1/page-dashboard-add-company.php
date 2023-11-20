<?php
set_query_var( 'dashboard_type', 'dashboard_addcompany' );
set_query_var( 'dashboard_breadcrumb_name', 'Добавление компании' );
$current_user = wp_get_current_user();
$user_id      = $current_user->data->ID;
set_query_var( 'user_id', $user_id );
wp_localize_script( 'jquery', 'dashboard_var', array( '1', '1' ) );
if ( ! ( is_user_logged_in() ) ) {
	wp_redirect( '/' );
	exit;
}
acf_form_head();
get_header();
?>
<?php if ( is_user_logged_in() ) {
	echo print_css_links( 'user_page' );
	echo print_js_links()['user_page'];
	echo print_css_links( 'user_form' );
	echo '<div class="page_content page_container background_light review_container_about visible">';
	echo '    <div class="wrap justify-content-space-between wrap-no-padding-top dashboadmain">';

	echo '            <div class="profile-wrapper__left">';
	$current_user = wp_get_current_user();
	$user_id      = $current_user->data->ID;
	$counters     = profile_stats_count( $user_id );
	echo user_menu( $current_user, $user_id, 'dashboard' );
	echo '			</div>';
	echo '            <div class="profile-wrapper__center dashboard_page_center">';
	echo '<div class="breadcrumbs_dashboard isdesctop">';


	if ( function_exists( 'show_breadcrumbs' ) ) {
		echo show_breadcrumbs();
	}

	echo '</div>';

	echo '<div class="bg_add_company">';
	if ( ! ( $_GET['company'] ) ) {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$message      = '';
		$class_type   = 'reviewgetcompany';
		if ( $class_type == 'reviewgetcompany' ) {
			$class_type = 'review';
		}

		echo '<div class="popup_container1" id="popup_link_outside_' . $class_type . '" data-form-type="' . 'reviewgetcompany' . '">';
		echo '<div class="popup_window1">';
		echo '<div class="popup_close_button pointer"></div>';
		$i = 1;
		if ( ! ( $_GET['company_sidebar'] ) ) {
			echo '<div class="p_30 flex flex_column">';
			if ( 'reviewgetcompany' == 'abuse' ) {
				echo '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новая жалоба на компанию', 'er_theme' ) . '</div>';
			} elseif ( 'reviewgetcompany' == 'review' ) {
				echo '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новый отзыв о компании', 'er_theme' ) . '</div>';
			} elseif ( 'reviewgetcompany' == 'reviewgetcompany' ) {
				echo '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Добавить компанию', 'er_theme' ) . '</div>';
			}

			echo '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
			echo '<input name="autocomplete_text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"  type="text" value="" placeholder="' . __( 'Введите название компании', 'er_theme' ) . '" />';
			echo '<input name="autocomplete_result" type="hidden" value="" />';
			echo '<div class="autocomplete_icon_search"></div>';
			echo '<div class="autocomplete_icon_close"></div>';
			echo '<div class="autocomplete_search_results"></div>';
			echo '</div>';
			echo '<div class="outside_form_container"></div>';
			echo '</div>';
		} else {
			echo '<div class="p_30 flex flex_column"><div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Добавить компанию</div><div class="autocomplete_container active_search" data-type="search_companies" id="popup_search_companies"><input name="autocomplete_text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text" value="' . get_field( 'company_name', intval( $_GET['company_sidebar'] ) ) . '" placeholder="' . get_field( 'company_name', intval( $_GET['company_sidebar'] ) ) . '"><input name="autocomplete_result" type="hidden" value="' . intval( $_GET['company_sidebar'] ) . '"><div class="autocomplete_icon_search"></div><div class="autocomplete_icon_close"></div><div class="autocomplete_search_results"></div></div><div class="outside_form_container"><span class="review_connect_company font_small color_dark_gray">Вы хотите привязать компанию ' . get_field( 'company_name', intval( $_GET['company_sidebar'] ) ) . ' к вашему аккаунту?</span><div class="review_connect_company_btn button button_violet font_small font_bold pointer">Привязать компанию</div></div></div>';
		}

		echo '</div>';
		echo '</div>';
	}
	if ( $_GET['company'] ) {
		echo '<style>.text_1st_step_addcomp p {display: none}</style>';
		$comp_id      = $_GET['company'];
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		if ( get_post( $comp_id )->post_author == $user_id ) {

			if ( get_field( 'company_edited', $comp_id ) != 'yes' ) {
				if ( $_GET['updated'] == 'true' ) {

					update_field( 'company_edited', 'yes', $comp_id );
					$arr_temp = [ 'company_user' => $comp_id, 'status' => 'moderation' ];
					add_row( 'comp_statuses', $arr_temp, 'user_' . $user_id );
				}
			} else {
//400 5
			}

			if ( get_field( 'company_edited', $comp_id ) != 'yes' ) {

				$term_slug = get_term( get_field( 'company_type', $comp_id ), 'companytypes' )->name;
				if ( in_array( $term_slug, array( 'bi' ) ) ) {
					$table_id = 57424;
				} elseif ( in_array( $term_slug, array( 'fond' ) ) ) {
					$table_id = 57418;
				} elseif ( in_array( $term_slug, array( 'crm' ) ) ) {
					$table_id = 79235;
				} elseif ( in_array( $term_slug, array( 'wallet' ) ) ) {
					$table_id = 148898;
				} elseif ( in_array( $term_slug, array( 'accounting' ) ) ) {
					$table_id = 151015;
				} elseif ( in_array( $term_slug, array( 'tour' ) ) ) {
					$table_id = 151012;
				} elseif ( in_array( $term_slug, array( 'audit' ) ) ) {
					$table_id = 147972;
				} elseif ( in_array( $term_slug, array( 'boards' ) ) ) {
					$table_id = 148003;
				} elseif ( in_array( $term_slug, array( 'dental' ) ) ) {
					$table_id = 147998;
				} elseif ( in_array( $term_slug, array( 'consult' ) ) ) {
					$table_id = 146909;
				} elseif ( in_array( $term_slug, array( 'marketing' ) ) ) {
					$table_id = 146052;
				} elseif ( in_array( $term_slug, array( 'bloggers' ) ) ) {
					$table_id = 146273;
				} elseif ( in_array( $term_slug, array( 'cashbox' ) ) ) {
					$table_id = 150015;
				} elseif ( in_array( $term_slug, array( 'sanatorium' ) ) ) {
					$table_id = 150052;
				} elseif ( in_array( $term_slug, array( 'sitebuild' ) ) ) {
					$table_id = 143500;
				} elseif ( in_array( $term_slug, array( 'sitebuilder' ) ) ) {
					$table_id = 143500;
				} elseif ( in_array( $term_slug, array( 'analytics' ) ) ) {
					$table_id = 144556;
				} elseif ( in_array( $term_slug, array( 'legal' ) ) ) {
					$table_id = 144593;
				} elseif ( in_array( $term_slug, array( 'program' ) ) ) {
					$table_id = 143544;
				} elseif ( in_array( $term_slug, array( 'vpn' ) ) ) {
					$table_id = 143128;
				} elseif ( in_array( $term_slug, array( 'bookingtravel' ) ) ) {
					$table_id = 142996;
				} elseif ( in_array( $term_slug, array( 'edo' ) ) ) {
					$table_id = 79290;
				} elseif ( in_array( $term_slug, array( 'exchange' ) ) ) {
					$table_id = 57409;
				} elseif ( in_array( $term_slug, array( 'mfo' ) ) ) {
					$table_id = 57403;
				} elseif ( in_array( $term_slug, array( 'credit' ) ) ) {
					$table_id = 57400;
				} elseif ( in_array( $term_slug, array( 'fx', 'cfd' ) ) ) {
					$table_id = 57406;
				} elseif ( in_array( $term_slug, array( 'invest' ) ) ) {
					$table_id = 57412;
				} elseif ( in_array( $term_slug, array( 'crypto' ) ) ) {
					$table_id = 57415;
				} elseif ( in_array( $term_slug, array( 'bet' ) ) ) {
					$table_id = 57421;
				} elseif ( in_array( $term_slug, array( 'creditcard' ) ) ) {
					$table_id = 57427;
				} elseif ( in_array( $term_slug, array( 'debitcard' ) ) ) {
					$table_id = 57430;
				} elseif ( in_array( $term_slug, array( 'insurance' ) ) ) {
					$table_id = 57433;
				} elseif ( in_array( $term_slug, array( 'rko' ) ) ) {
					$table_id = 57436;
				} elseif ( in_array( $term_slug, array( 'cardealer' ) ) ) {
					$table_id = 113284;
				} elseif ( in_array( $term_slug, array( 'forbusiness' ) ) ) {
					$table_id = 57439;
				} elseif ( in_array( $term_slug, array( 'shop' ) ) ) {
					$table_id = 59202;
				} elseif ( in_array( $term_slug, array( 'game' ) ) ) {
					$table_id = 57442;
				} elseif ( in_array( $term_slug, array( 'payment' ) ) ) {
					$table_id = 57445;
				} elseif ( in_array( $term_slug, array( 'creditrating' ) ) ) {
					$table_id = 57451;
				} elseif ( in_array( $term_slug, array( 'creditservis' ) ) ) {
					$table_id = 57454;
				} elseif ( in_array( $term_slug, array( 'cardbitcoin' ) ) ) {
					$table_id = 57457;
				} elseif ( in_array( $term_slug, array( 'deliveryfood' ) ) ) {
					$table_id = 57460;
				} elseif ( in_array( $term_slug, array( 'job' ) ) ) {
					$table_id = 57463;
				} elseif ( in_array( $term_slug, array( 'learn' ) ) ) {
					$table_id = 59944;
//} elseif(in_array($term_slug, array('learn2'))) {
					//$table_id = 59944;
				} elseif ( in_array( $term_slug, array( 'hosting' ) ) ) {
					$table_id = 57469;
				} elseif ( in_array( $term_slug, array( 'domains' ) ) ) {
					$table_id = 57472;
				} elseif ( in_array( $term_slug, array( 'providers' ) ) ) {
					$table_id = 57475;
				} elseif ( in_array( $term_slug, array( 'medservice' ) ) ) {
					$table_id = 57478;
				} elseif ( in_array( $term_slug, array( 'dating' ) ) ) {
					$table_id = 57481;
				} elseif ( in_array( $term_slug, array( 'bookingtickets' ) ) ) {
					$table_id = 57484;
				} elseif ( in_array( $term_slug, array( 'bookinghotel' ) ) ) {
					$table_id = 57487;
				} elseif ( in_array( $term_slug, array( 'avia' ) ) ) {
					$table_id = 120110;
				} elseif ( in_array( $term_slug, array( 'carrent' ) ) ) {
					$table_id = 57493;
				} elseif ( in_array( $term_slug, array( 'smmtools' ) ) ) {
					$table_id = 57499;
				} elseif ( in_array( $term_slug, array( 'antivirus' ) ) ) {
					$table_id = 130138;
				} elseif ( in_array( $term_slug, array( 'seo' ) ) ) {
					$table_id = 130479;
				} elseif ( in_array( $term_slug, array( 'advert' ) ) ) {
					$table_id = 57502;
				} elseif ( in_array( $term_slug, array( 'product' ) ) ) {
					$table_id = 57505;
				} elseif ( in_array( $term_slug, array( 'cryptobot' ) ) ) {
					$table_id = 57508;
				} elseif ( in_array( $term_slug, array( 'pharmacy' ) ) ) {
					$table_id = 57511;
				} elseif ( in_array( $term_slug, array( 'cpanetworks' ) ) ) {
					$table_id = 57515;
				} elseif ( in_array( $term_slug, array( 'chatbot' ) ) ) {
					$table_id = 57528;
				} elseif ( in_array( $term_slug, array( 'charg' ) ) ) {
					$table_id = 58553;
				} elseif ( in_array( $term_slug, array( 'developer' ) ) ) {
					$table_id = 103607;
				} elseif(in_array($term_slug, array('courses'))) {
					$table_id = 204536;
				} elseif(in_array($term_slug, array('onlinecasino'))) {
					$table_id = 220016;
				} elseif ( in_array( $term_slug, array( 'default' ) ) ) {
					$table_id = 58556;
				} else {
					$table_id = 58556;
				}
				//print_r(get_field_object( 120110 ));

				$array_to_upd = [];
				//$array_temp   = get_field_objects( 151011 );

				$array_temp = acf_get_fields_by_id( 57393 );

				//print_r($array_temp);
				foreach ( $array_temp as $item ) {
					$var = preg_split( "/_(.*)_/", $item['key'] );
					if ( count( $var ) == 2 ) {
						$array_to_upd[] = $var[0] . '_' . $var[1];
					} else {
						$array_to_upd[] = $item['key'];
					}

				}

				$array_temp = acf_get_fields_by_id( $table_id );

				//print_r($array_temp);
				foreach ( $array_temp as $item ) {
					$var = preg_split( "/_(.*)_/", $item['key'] );
					if ( count( $var ) == 2 ) {
						$array_to_upd[] = $var[0] . '_' . $var[1];
					} else {
						$array_to_upd[] = $item['key'];
					}

				}


				//$field_additional_information     = get_field_object( 'additional_information', 151011 );
				//$field_additional_information_key = $field_additional_information['key'];

				$arr_del = [
					'field_5ec3c271989da',
					'field_5eaac22ec64d0',
					'field_5e4039fc1efce', //тип компании
					'field_5ece31913b442', //Site Affilate URL
					'field_5ece31b13b443', //Redirect Key
					'field_60357e303c3e7', //Текст кнопки
					'field_5ece31dd3b445',
					'field_5ece32003b446',
					'field_6038ba4c3352b',
					'field_5ece31d43b444',
					'field_601d2c084ac67'

				];
				foreach ( $arr_del as $item ) {
					if ( ( $key = array_search( $item, $array_to_upd ) ) !== false ) {
						unset( $array_to_upd[ $key ] );
					}
				}


				$acf_form_settings = array(
					'post_id'      => $comp_id,
					'post_title'   => false,
					'post_content' => false,
					'fields'       => $array_to_upd,
					'submit_value' => __( 'Отправить на модерацию' ),
				);

				echo '<div class="text_2st_step_addcomp"><p>Для прохождения успешной модерации заполните максимальное количество полей. Поля, помеченные звездочкой (*), являются обязательными для заполнения.
</p>
<div class="select_contact" style="margin-left: 30px;margin-right: 30px;margin-top: 10px;">
    <span class="add_company_title" style="display: block;font-weight: bold;padding: 0;">Оставьте свой контакт для связи<span class="acf_star_m">*</span></span>
    <div class="select_contact_inside" style="margin-bottom: 0;">
    <select name="select_contact" class="select_big m_b_10 border_radius_4px select_arrow">
		<option selected="selected">Мессенджер для связи</option>
		<option value="telegram">Telegram</option>
		<option value="skype">Skype</option>
		<option value="email">E-mail</option>
		<option value="whatsapp">WhatsApp</option>
		<option value="viber">Viber</option>
		</select>
<input type="text" name="contact_name" placeholder="Логин" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">
</div>
</div>
</div>';

				acf_form( $acf_form_settings );
				echo '<span class="back_btn_to_start button button_gray font_small font_bold pointer">Вернуться назад</span>';
			} else {
				echo '<style>.text_1st_step_addcomp {display: none;}</style>';
				echo '<div id="message" class="updated"><p>Компания отправлена на модерацию</p></div>';
			}
		}
	}

	?>


	<div class="text_1st_step_addcomp">
		<div class="manager_info">
			<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Менеджер</div>
			<ul class="manager_info_ul">
				<li class="manager_telegram"><a href="https://t.me/HelennWorobey" rel="nofollow">@HelennWorobey</a></li>
				<li class="manager_mail"><a href="mailto:sale@eto-razvod.ru">sale@eto-razvod.ru</a></li>
			</ul>
		</div>
		<p>Начните процедуру привязки компании к вашему аккаунту, если компания есть на нашем сайте, или добавьте новую
			компанию на сайт, если ее еще нет.</p>
		<p>Чтобы понять, есть ли ваша компания на нашем сайте, начните вводить ее название в форме поиска компаний,
			которая расположена выше. Выберите компанию из списка и продолжите процедуру ее привязки к вашему
			аккаунту.</p>
		<p>Если вашей компании на сайте нет, нажмите на кнопку «Добавить новую компанию». Для того, чтобы добавить
			компанию на сайт, выберите категорию компании и заполните таблицу с данными, представленную на следующем
			шаге, максимально полно.</p>
	</div>
	<?php
	echo '</div>';
	if ( $_GET['add_new_company'] ) { ?>
		<div class="bg_add_company_temp" style="display: none;">
			<div class="text_1st_step_addcomp">
				<div class="manager_info">
					<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Менеджер</div>
					<ul class="manager_info_ul">
						<li class="manager_telegram"><a href="https://t.me/ivan_liora" rel="nofollow">@ivan_liora</a></li>
						<li class="manager_mail"><a href="mailto:sale@eto-razvod.ru">sale@eto-razvod.ru</a></li>
					</ul>
				</div>
				<p>Начните процедуру привязки компании к вашему аккаунту, если компания есть на нашем сайте, или
					добавьте новую компанию на сайт, если ее еще нет.</p>
				<p>Чтобы понять, есть ли ваша компания на нашем сайте, начните вводить ее название в форме поиска
					компаний, которая расположена выше. Выберите компанию из списка и продолжите процедуру ее привязки к
					вашему аккаунту.</p>
				<p>Если вашей компании на сайте нет, нажмите на кнопку «Добавить новую компанию». Для того, чтобы
					добавить компанию на сайт, выберите категорию компании и заполните таблицу с данными, представленную
					на следующем шаге, максимально полно.</p>
			</div>
			<div class="bg_add_company_insert">
				<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Добавление
					компании
				</div>
				<span
					class="not_founded_company"><?php echo get_field( 'company_name', intval( $_GET['add_new_company'] ) ); ?></span>
				<div class="get_cat_add_company">
					<div class="autocomplete_container" data-type="filter_ratings_comp_type"
						 id="ratings_all_filter_autocomplete_skills"><input name="autocomplete_text" type="text"
																			value=""
																			placeholder="Укажите категорию вашей компании"
																			autocomplete="off" autocorrect="off"
																			autocapitalize="off"
																			spellcheck="false"><input
							name="autocomplete_result" type="hidden" value="">
						<div class="autocomplete_icon_search"></div>
						<div class="autocomplete_icon_close"></div>
						<div class="autocomplete_search_results"></div>
						<form id="filter_form_ratings_all_filter_autocomplete_skills" class="outside_tags"
							  action="https://etorazvod.ru/wp-admin/admin-ajax.php" method="post"><input type="hidden"
																										  name="action"
																										  value="resort_news_tags"><input
								type="hidden" name="sort" value="date">
							<ul></ul>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php }
	echo '</div>';
	echo '            <div class="profile-wrapper__right profile-wrapper__right_dashboard">' . my_posts_profile( $user_id ) . fast_links_profile( $user_id, 'normal', [
			[
				'/dashboard/services/pro/',
				'Включить аккаунт PRO'
			],
			[ '/advices/', 'Полезные советы' ],
			[ '/user-edit/', 'Как заполнить аккаунт' ],
			[ '/user-help/', 'Помощь' ]
		] ) . user_subscribe_data_dashboard( $user_id, 'dashboard', true ) . menu_footer_links( true ) . '</div>';
	//echo  '        </div>';
	echo '    </div>';
	echo '</div>';

	echo print_css_links( 'profile_top' );
} ?>

<?php
get_footer( 'profile' );;
?>