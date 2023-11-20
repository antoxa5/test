<?php
if ( ! function_exists( 'get_more_fields_company' ) ) {
	function get_more_fields_company( $args = 0, $fields = 0 ) {
		foreach ( $fields as $field ) {
			$key = get_term( $field['key'], 'field_types' )->slug;
			if ( $key == 'free_demo' ) {
				$args['meta_query'][] = array(
					'key'     => 'free_demo_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//defi_farming
			} elseif ( $key == 'filter_date44' ) {
				$args['orderby'] = 'menu_order';
				$args['order'] = 'ASC';
			} elseif ( $key == 'filter_defi_farming' ) {
				$args['meta_query'][] = array(
					'key'     => 'defi_farming_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_cloud
			} elseif ( $key == 'filter_base_2_pay_in_credit' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_pay_in_credit_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//base_2_pay_in_credit
			} elseif ( $key == 'filter_med_booking_dms' ) {
				$args['meta_query'][] = array(
					'key'     => 'med_booking_dms_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//base_2_pay_in_credit
			} elseif ( $key == 'filter_med_booking_doctor' ) {
				$args['meta_query'][] = array(
					'key'     => 'med_booking_doctor_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//base_2_pay_in_credit
			} elseif ( $key == 'filter_online_consult' ) {
				$args['meta_query'][] = array(
					'key'     => 'online_consult_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//base_2_pay_in_credit
			} elseif ( $key == 'filter_base_2_antivirus_cloud' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_cloud_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_parents
			} elseif ( $key == 'filter_base_2_antivirus_parents' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_parents_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_spam
			} elseif ( $key == 'filter_base_2_antivirus_spam' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_spam_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_webcam
			} elseif ( $key == 'filter_base_2_antivirus_webcam' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_webcam_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_passwords
			} elseif ( $key == 'filter_base_2_antivirus_passwords' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_passwords_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_files
			} elseif ( $key == 'filter_base_2_antivirus_files' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_files_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_banking
			} elseif ( $key == 'filter_base_2_antivirus_banking' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_banking_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_mobile
			} elseif ( $key == 'filter_base_2_antivirus_mobile' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_mobile_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//base_2_antivirus_loaddisk
			} elseif ( $key == 'filter_base_2_antivirus_loaddisk' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_antivirus_loaddisk_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//sanatorium_profiles
			} elseif ( $key == 'filter_sanatorium_profiles' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_profiles',
					'value'   => get_term_by( 'name', $field['value'], 'deseases' )->term_id,
					'compare' => 'LIKE',
				);//sanatorium_profiles
			} elseif ( $key == 'filter_cources_categories' ) {
				$args['meta_query'][] = array(
					'key'     => 'cources_categories',
					'value'   => get_term_by( 'name', $field['value'], 'courcescategories' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_sanatorium_profiles' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_profiles',
					'value'   => get_term_by( 'name', $field['value'], 'deseases' )->term_id,
					'compare' => 'LIKE',
				);//sanatorium_profiles
			} elseif ( $key == 'filter_sanatorium_profiles_nervous_system' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'болезни нервной системы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'заболевания нервной системы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'заболевания сердечно-сосудистой и нервной системы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'лечение болезней нервной системы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
				);//заболевания кожи, кожные заболевания, лечение болезней кожи и подкожной клетчатки
			} elseif ( $key == 'filter_sanatorium_skin_diseases' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'заболевания кожи', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'кожные заболевания', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'лечение болезней кожи и подкожной клетчатки', 'deseases' )->term_id,
						'compare' => 'LIKE',
					)
				);//заболевания кожи, кожные заболевания, лечение болезней кожи и подкожной клетчатки
			} elseif ( $key == 'filter_sanatorium_otolaryngology' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'Лор органы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'ЛОР-заболевания', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'лечение болезней глаза, уха, горла, носа', 'deseases' )->term_id,
						'compare' => 'LIKE',
					)
				);//Лор органы, ЛОР-заболевания, лечение болезней глаза, уха, горла, носа
			} elseif ( $key == 'filter_sanatorium_profiles_digestive_organs' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'болезни органов пищеварения', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'заболевания желудочно-кишечного тракта', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'лечение болезней органов пищеварения', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'избыточный вес', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
				);//болезни органов пищеварения, заболевания желудочно-кишечного тракта, лечение болезней органов пищеварения, избыточный вес
			} elseif ( $key == 'filter_sanatorium_profiles_endocrine_system' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'болезни эндокринной системы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'заболевания щитовидной железы', 'deseases' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sanatorium_profiles',
						'value'   => get_term_by( 'name', 'Лечение болезней эндокринной системы, расстройства питания и нарушения обмена веществ', 'deseases' )->term_id,
						'compare' => 'LIKE',
					)
				);//болезни эндокринной системы, заболевания щитовидной железы, лечение болезней эндокринной системы расстройства питания и нарушения обмена веществ
			} elseif ( $key == 'filter_currency_how_to_get' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_how_to_get_$_text',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);//filter_currency_how_to_get_staking
			} elseif ( $key == 'filter_base_2_money_output_0_without_commision' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'base_2_money_output_0_from_percent',
						'value'   => '-1',
						'compare' => '=',
					),
					array(
						'key'     => 'base_2_money_output_0_to_percent',
						'value'   => '-1',
						'compare' => '=',
					)
				);
			} elseif ( $key == 'filter_currency_how_to_get_staking' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'currency_how_to_get_$_text',
						'value'   => 'стекинг',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'currency_how_to_get_$_text',
						'value'   => 'стейкинг',
						'compare' => 'LIKE',
					)
				);//filter_currency_how_to_get_staking
			} elseif ( $key == 'filter_defi_staking' ) {
				$args['meta_query'][] = array(
					'key'     => 'defi_staking_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//defi_landing
			} elseif ( $key == 'filter_defi_landing' ) {
				$args['meta_query'][] = array(
					'key'     => 'defi_landing_0_exist',
					'value'   => 1,
					'compare' => '=',
				);//currency_whitebook
			} elseif ( $key == 'filter_currency_whitebook_0_text' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_whitebook_0_text',
					'value'   => '',
					'compare' => '!=',
				);//
			} elseif ( $key == 'filter_currency_source_code_0_text' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_source_code_0_text',
					'value'   => '',
					'compare' => '!=',
				);//currency_growfactors
			} elseif ( $key == 'filter_sanatorium_sbor_0_exist' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sanatorium_sbor_0_exist',
						'value'   => '',
						'compare' => '==',
					),
					array(
						'key'     => 'sanatorium_sbor_0_exist',
						'value'   => 0,
						'compare' => '==',
					)
				);//sanatorium_sbor
			} elseif ( $key == 'filter_sanatorium_reg_24_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_reg_24_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//sanatorium_reg_24
			} elseif ( $key == 'filter_online_payment_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'online_payment_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//sanatorium_reg_24
			} elseif ( $key == 'filter_sanatorium_wifi_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_wifi_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_avia_transfers
			} elseif ( $key == 'filter_base_2_avia_transfers_0_exist_2' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_avia_transfers_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_avia_trasit_tourists
			} elseif ( $key == 'filter_bbase_2_avia_trasit_tourists_0_exist_2' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_avia_trasit_tourists_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_avia_trasit_tourists
			} elseif ( $key == 'filter_base_2_miles_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_miles_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_miles
			} elseif ( $key == 'filter_base_2_pay_credit_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_pay_credit_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_miles
			} elseif ( $key == 'filter_university_voennaya_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'university_voennaya_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_miles
			} elseif ( $key == 'filter_sanatorium_parking_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_parking_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_avia_luggage_online
			} elseif ( $key == 'filter_base_2_avia_luggage_online_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_avia_luggage_online_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//base_2_avia_luggage_online
			} elseif ( $key == 'filter_currency_growfactors' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_growfactors',
					'value'   => get_term_by( 'name', $field['value'], 'growfactors' )->term_id,
					'compare' => 'LIKE',
				);//base_2_aviatypes
			} elseif ( $key == 'filter_base_2_aviatypes' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_aviatypes',
					'value'   => get_term_by( 'name', $field['value'], 'aviatypes' )->term_id,
					'compare' => 'LIKE',
				);//base_2_aviatypes
			} elseif ( $key == 'filter_currency_growfactors_add_new_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'currency_growfactors',
						'value'   => get_term_by( 'name', 'внешнее инвестирование', 'growfactors' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'currency_growfactors',
						'value'   => get_term_by( 'name', 'инвестирование', 'growfactors' )->term_id,
						'compare' => 'LIKE',
					)
				);//currency_growfactors
			} elseif ( $key == 'filter_currency_growfactors_add_new_3' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'currency_growfactors',
						'value'   => get_term_by( 'name', 'безопасность торговли', 'growfactors' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'currency_growfactors',
						'value'   => get_term_by( 'name', 'высокий уровень безопасности', 'growfactors' )->term_id,
						'compare' => 'LIKE',
					)
				);//currency_growfactors
			} elseif ( $key == 'filter_regulator' ) {
				$args['meta_query'][] = array(
					'key'     => 'regulators_list_$_regulators',
					'value'   => $field['value'],
					'compare' => '=',
				);//rating_a
			} elseif ( $key == 'filter_rating_a' ) {
				$args['meta_query'][] = array(
					'key'     => 'rating_a',
					'value'   => get_term_by( 'name', $field['value'], 'ratingsafety' )->term_id,
					'compare' => '=',
				);//vpm_mobile_apps
			} elseif ( $key == 'filter_vpm_mobile_apps_ios_android' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'vpm_mobile_apps',
						'value'   => get_term_by( 'name', 'Anroid', 'device_types' )->term_id,
						'compare' => '=',
					),
					array(
						'key'     => 'vpm_mobile_apps',
						'value'   => get_term_by( 'name', 'iOS', 'device_types' )->term_id,
						'compare' => '=',
					)
				);//vpm_mobile_apps
			} elseif ( $key == 'filter_nft_categories_creative' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'nft_categories',
						'value'   => get_term_by( 'name', 'Коллекционные предметы', 'nftcategories' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'nft_categories',
						'value'   => get_term_by( 'name', 'коллекционные товары', 'nftcategories' )->term_id,
						'compare' => 'LIKE',
					)
				);//nft_categories
			} elseif ( $key == 'filter_nft_categories' ) {
				$args['meta_query'][] = array(
					'key'     => 'nft_categories',
					'value'   => get_term_by( 'name', $field['value'], 'nftcategories' )->term_id,
					'compare' => 'LIKE',
				);//
			} elseif ( $key == 'filter_vpn_same_time_connections' ) {
				$args['meta_query'][] = array(
					'key'     => 'vpn_same_time_connections',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);//vpn_protocol
			} elseif ( $key == 'filter_vpn_protocol' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'vpn_protocol',
						'value'   => get_term_by( 'name', 'OpenVPN-UDP', 'protocols' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'vpn_protocol',
						'value'   => get_term_by( 'name', 'OpenVPN', 'protocols' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'vpn_protocol',
						'value'   => get_term_by( 'name', 'OpenVPN-UDP', 'protocols' )->term_id,
						'compare' => 'LIKE',
					)
				);//vpn_tele_smart
			} elseif ( $key == 'filter_game_genre' ) {
				$args['meta_query'][] = array(
					'key'     => 'game_genre',
					'value'   => get_term_by( 'name', $field['value'], 'gamegenres' )->term_id,
					'compare' => 'LIKE',
				);//vpn_tele_smart
			} elseif ( $key == 'filter_vpn_tele_smart' ) {
				$args['meta_query'][] = array(
					'key'     => 'vpn_tele_smart',
					'value'   => '',
					'compare' => '!=',
				);//vpn_tele_smart_home
			} elseif ( $key == 'filter_university_acccreditations_0_number' ) {
				$args['meta_query'][] = array(
					'key'     => 'university_acccreditations_0_number',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_vpn_browsers' ) {
				$args['meta_query'][] = array(
					'key'     => 'vpn_browsers',
					'value'   => get_term_by( 'name', $field['value'], 'browsers' )->term_id,
					'compare' => 'LIKE',
				);//vpn_browsers
			} elseif ( $key == 'filter_vpn_tele_smart_home' ) {
				$args['meta_query'][] = array(
					'key'     => 'vpn_tele_smart_home',
					'value'   => '',
					'compare' => '!=',
				);//vpn_gamepads
			} elseif ( $key == 'filter_vpn_gamepads' ) {
				$args['meta_query'][] = array(
					'key'     => 'vpn_gamepads',
					'value'   => '',
					'compare' => '!=',
				);//currency_control_0_comment
			} elseif ( $key == 'filter_currency_control_0_comment' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_control_0_comment',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);//currency_control_0_comment
			} elseif ( $key == 'filter_game_type' ) {
				$args['meta_query'][] = array(
					'key'     => 'game_type',
					'value'   => get_term_by( 'name', $field['value'], 'gametypes' )->term_id,
					'compare' => 'LIKE',
				);//marketing_earn_types
			} elseif ( $key == 'filter_marketing_earn_types' ) {
				$args['meta_query'][] = array(
					'key'     => 'marketing_earn_types',
					'value'   => get_term_by( 'name', $field['value'], 'earntypes' )->term_id,
					'compare' => 'LIKE',
				);//marketing_earn_types
			} elseif ( $key == 'filter_marketing_earn_types_investing' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'инвестирование', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'инвестиции', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					)
				);//marketing_earn_types
			} elseif ( $key == 'filter_marketing_earn_types_exchange' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'выгодный обмен криптовалюты', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'выгодный обмен валют', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'обмен', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					)
				);//, обмен
			} elseif ( $key == 'filter_marketing_earn_types_trading' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'трейдинг', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'marketing_earn_types',
						'value'   => get_term_by( 'name', 'Высокочастотный трейдинг', 'earntypes' )->term_id,
						'compare' => 'LIKE',
					)
				);//marketing_earn_types
			} elseif ( $key == 'filter_number_of_cryptocurrencies_0_number' ) {
				$args['meta_query'][] = array(
					'key'     => 'number_of_cryptocurrencies_0_number',
					'value'   => 1000,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);// значения в БД <= value
			} elseif ( $key == 'filter_profitability_0_from_percent_and_profitability_0_to_percent' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'profitability_0_from_percent',
						'value'   => $field['value'],
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'profitability_0_to_percent',
						'value'   => $field['value'],
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
				);// значения в БД <= value
			} elseif ( $key == 'filter_profitability_0_from_percent' ) {
				$args['meta_query'][] = array(
					'key'     => 'profitability_0_from_percent',
					'value'   => $field['value'],
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);// значения в БД <= value
			} elseif ( $key == 'filter_profitability_0_to_percent' ) {
				$args['meta_query'][] = array(
					'key'     => 'profitability_0_to_percent',
					'value'   => $field['value'],
					'compare' => '<=',
					'type'    => 'NUMERIC',
				);// значения в БД <= value
			} elseif ( $key == 'filter_profitability_0_add' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'profitability_$_to_percent',
						'value'   => 49,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'profitability_$_from_percent',
						'value'   => 10,
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'profitability_$_to_percent',
						'value'   => '',
						'compare' => '!=',
					),
					array(
						'key'     => 'profitability_$_from_percent',
						'value'   => '',
						'compare' => '!=',
					)
				);// значения в БД <= value
			} elseif ( $key == 'filter_profitability_0_add_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'profitability_$_to_percent',
						'value'   => 10,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'profitability_$_from_percent',
						'value'   => 10,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'profitability_$_to_percent',
						'value'   => '',
						'compare' => '!=',
					),
					array(
						'key'     => 'profitability_$_from_percent',
						'value'   => '',
						'compare' => '!=',
					)
				);// значения в БД <= value
			} elseif ( $key == 'filter_base_2_bonuses_bonus_type' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_bonuses_$_bonus_type',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_carbooking_prices' ) {
				$args['meta_query'][] = array(
					'key'     => 'carbooking_prices_$_services_list',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_carrent_longterm' ) {
				$args['meta_query'][] = array(
					'key'     => 'carrent_longterm_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_carrent_points_0_number' ) {
				$args['meta_query'][] = array(
					'key'     => 'carrent_points_0_number',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_carrent_withdriver_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'carrent_withdriver_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_grace_period_0_from' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'grace_period_0_from',
						'value'   => 60,
						'compare' => '<=',
					),
					array(
						'key'     => 'grace_period_0_from',
						'value'   => '',
						'compare' => '!=',
					)
				);
			} elseif ( $key == 'filter_credit_limit_0_to' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'credit_limit_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'credit_limit_0_to',
						'value'   => '',
						'compare' => '!=',
					)
				);
			} elseif ( $key == 'filter_credit_limit_0_to_menshe' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'credit_limit_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'credit_limit_0_to',
						'value'   => '',
						'compare' => '!=',
					)
				);
			} elseif ( $key == 'filter_base_2_money_output_0' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_money_output_0_from_percent',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_mindep' ) {
				$args['meta_query'][] = array(
					'key'     => 'min_dep_0_from',
					'value'   => $field['value'],
					'compare' => '<=',
				);
			} elseif ( $key == 'filter_min_dep_0_from' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'min_dep_$_from',
						'value'   => 101,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					)
				);
			} elseif ( $key == 'filter_min_dep_owa' ) {

			} elseif ( $key == 'filter_bonuses' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_bonuses_0_bonus_type',
					//'value' => $field['value'],
					'compare' => 'EXISTS',
				);
			} elseif ( $key == 'filter_honest_broker' ) {
				$args['meta_query'][] = array(
					'key'     => 'total_score',
					'value'   => $field['value'],
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_language' ) {
				$args['meta_query'][] = array(
					'key'     => 'languages_list',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'languages' )->term_id ) ),
					'compare' => 'LIKE',
				);//cources_services_plus
			} elseif ( $key == 'filter_bank_cards' ) {
				$args['meta_query'][] = array(
					'key'     => 'payment_systems',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'paymentsystems' )->term_id ) ),
					'compare' => 'LIKE',
				);//cources_services_plus
			} elseif ( $key == 'filter_cources_services_plus' ) {
				$args['meta_query'][] = array(
					'key'     => 'cources_services_plus',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'businessservices' )->term_id ) ),
					'compare' => 'LIKE',
				);//cources_services_plus
			} elseif ( $key == 'filter_blogger_themes' ) {
				$args['meta_query'][] = array(
					'key'     => 'blogger_themes',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'boarrds_themes' )->term_id ) ),
					'compare' => 'LIKE',
				);//cources_services_plus
			} elseif ( $key == 'filter_blogger_themes_1' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'blogger_themes',
						'value'   => serialize( strval( get_term_by( 'name', 'Автомобили', 'boarrds_themes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_themes',
						'value'   => serialize( strval( get_term_by( 'name', 'Транспорт', 'boarrds_themes' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//cources_services_plus
			} elseif ( $key == 'filter_cources_services_plus_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'визовая поддержка', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'Оформление визы', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//трансфер, трансферы, индивидуальный трансфер
			} elseif ( $key == 'filter_cources_services_plus_3' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'трансфер', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'трансферы', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'индивидуальный трансфер', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//трансфер, трансферы, индивидуальный трансфер
			} elseif ( $key == 'filter_cources_services_plus_4' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'экскурсии', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'заказ экскурсий', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'cources_services_plus',
						'value'   => serialize( strval( get_term_by( 'name', 'Бронирование экскурсий и дополнительных услуг', 'businessservices' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//Дополнительные услуги (экскурсии, заказ экскурсий, Бронирование экскурсий и дополнительных услуг,
			} elseif ( $key == 'filter_tour_areas_types' ) {
				$args['meta_query'][] = array(
					'key'     => 'tour_areas_types',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'tourtypes' )->term_id ) ),
					'compare' => 'LIKE',
				);//Сфера туроператорской деятельности (Международный выездной туризм)
			} elseif ( $key == 'filter_tour_areas_types_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'tour_areas_types',
						'value'   => serialize( strval( get_term_by( 'name', 'Компания предлагает семейные туры на курорты с развитой инфраструктурой для детей', 'tourtypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'tour_areas_types',
						'value'   => serialize( strval( get_term_by( 'name', 'Компания организует детский и семейный отдых', 'tourtypes' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//,
			} elseif ( $key == 'filter_base_2_avia_on_board_children_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_avia_on_board_children',
						'value'   => serialize( strval( get_term_by( 'name', 'Компания предлагает семейные туры на курорты с развитой инфраструктурой для детей', 'aviaservices' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_avia_on_board_children',
						'value'   => serialize( strval( get_term_by( 'name', 'Компания организует детский и семейный отдых', 'aviaservices' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//,
			} elseif ( $key == 'filter_year' ) {
				$args['meta_query'][] = array(
					'key'     => 'company_established',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_demo' ) {
				$args['meta_query'][] = array(
					'key'     => 'free_demo_0_link',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_verification' ) {
				$args['meta_query'][] = array(
					'key'     => 'extended_verification_0_exist',
					'value'   => $field['value'],
					'compare' => '=='
				);
			} elseif ( $key == 'filter_cashbox_rent' ) {
				$args['meta_query'][] = array(
					'key'     => 'cashbox_rent_0_exist',
					'value'   => $field['value'],
					'compare' => '=='
				);
			} elseif ( $key == 'filter_profitness_broker' ) {
				$args['meta_query'][] = array(
					'key'     => 'payouts_0_to',
					'value'   => $field['value'],
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_mob_version' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_mobile_version_app_exist',
					'value'   => $field['value'],
					'compare' => '==',
				);
			} elseif ( $key == 'filter_exchange_volume' ) {
				$args['meta_query'][] = array(
					'key'     => 'trading_volume_day_0_number',
					'value'   => 50000,
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_documents' ) {
				$args['meta_query'][] = array(
					'key'     => 'documents_list_$_documents',
					'value'   => get_term_by( 'name', $field['value'], 'companydocuments' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_documents_ignore' ) {

			} elseif ( $key == 'filter_proof_of_income' ) {
				$args['meta_query'][] = array(
					'key'     => 'proof_of_income_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_domain_certificate_0_exist' ) {

				$args['meta_query'][] = array(
					'key'     => 'domain_certificate_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//domain_parking
			} elseif ( $key == 'filter_domain_parking_0_exist' ) {

				$args['meta_query'][] = array(
					'key'     => 'domain_parking_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//domain_parking
			} elseif ( $key == 'filter_company_hours_0_exist' ) {

				$args['meta_query'][] = array(
					'key'     => 'company_hours_0_24_7',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//domain_certificate
			} elseif ( $key == 'filter_account_opening_price_no_percent' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'account_opening_price_0_to',
						'value'   => '-1',
						'compare' => '=',
					),
					array(
						'key'     => 'account_opening_price_0_from',
						'value'   => '-1',
						'compare' => '=',
					)
				);
			} elseif ( $key == 'filter_loan_sum_dip' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'loan_sum_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '>=',
					),
					array(
						'key'     => 'loan_sum_0_from',
						'value'   => intval( $field['value'] ),
						'compare' => '<=',
					)
				);
			} elseif ( $key == 'filter_paymentmethods' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_accept_methods_0_payment_methods',
					'value'   => get_term_by( 'name', $field['value'], 'paymentmethods' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_casino_type' ) {
				$args['meta_query'][] = array(
					'key'     => 'casino_type',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'casinotypes' )->term_id)),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_bonuses_nodep' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_bonuses_nodep',
					'value' => '',
					'compare' => '!='
				);
			} elseif ( $key == 'filter_casino_number_of_games' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'casino_number_of_games',
						'value' => '',
						'compare' => '!='
					),
					array(
						'key'     => 'casino_number_of_games',
						'value' => 0,
						'compare' => '!='
					)
				);
			} elseif ( $key == 'filter_applications_proceed_time_0_24_7' ) {
				$args['meta_query'][] = array(
					'key'     => 'applications_proceed_time_0_24_7',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_paymentmethods_for_credit' ) {
				$args['meta_query'][] = array(
					'key'     => 'deposit_methods',
					'value'   => get_term_by( 'name', $field['value'], 'paymentmethods' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_additional_fields_0_label' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_additional_fields_$_label',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_application_processing_speed_card' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'application_processing_speed_card_0_from',
						'value'   => intval( $field['value'] ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'application_processing_speed_card_0_time_type_from_time_type',
						'value'   => 'days',
						'compare' => '=',
					)
				);
			} elseif ( $key == 'filter_application_processing_speed_card_0_to' ) {
				$args['meta_query'][] = array(
					'key'     => 'application_processing_speed_card_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '<=',
				);
			} elseif ( $key == 'filter_loan_rate_0_to_percent' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_rate_0_to_percent',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_loan_length_credit_0_to' ) {
				$years                = intval( $field['value'] ) / 12;
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'loan_length_credit_0_to',
						'value'   => $years,
						'compare' => '>=',
					),
					array(
						'key'     => 'loan_length_credit_0_time_type_to_time_type',
						'value'   => 'years',
						'compare' => '=',
					)
				);
			} elseif ( $key == 'filter_region' ) {
				$args['meta_query'][] = array(
					'key'     => 'region_new',
					'value'   => get_term_by( 'name', $field['value'], 'countries' )->term_id,
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_country' ) {
				$args['meta_query'][] = array(
					'key'     => 'country',
					'value'   => get_term_by( 'name', $field['value'], 'countries' )->term_id,
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_project_regions' ) {
				$args['meta_query'][] = array(
					'key'     => 'project_regions',
					'value'   => get_term_by( 'name', $field['value'], 'regions' )->term_id,
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_consult_categories' ) {
				$args['meta_query'][] = array(
					'key'     => 'consult_categories',
					'value'   => get_term_by( 'name', $field['value'], 'consultcategories' )->term_id,
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_base_2_company_size' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_company_size',
					'value'   => 'small',
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_base_2_company_size_medium' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_company_size',
					'value'   => 'medium',
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_base_2_company_size_big' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_company_size',
					'value'   => 'big',
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_base_2_company_size_newbie' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_company_size',
					'value'   => 'Новички',
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_consult_categories_marketing_pr' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'consult_categories',
						'value'   => get_term_by( 'name', 'Маркетинговый консалтинг', 'consultcategories' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'consult_categories',
						'value'   => get_term_by( 'name', 'Консалтинг в области маркетинга и PR', 'consultcategories' )->term_id,
						'compare' => 'LIKE',
					)
				);//countries_and_
			} elseif ( $key == 'filter_freee_seervices' ) {
				$args['meta_query'][] = array(
					'key'     => 'freee_seervices',
					'value'   => '',
					'compare' => '!=',
				);//countries_and_
			} elseif ( $key == 'filter_region_or_language_ukraine' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'region_new',
						'value'   => get_term_by( 'name', 'Украина', 'countries' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'languages_list',
						'value'   => serialize( strval( get_term_by( 'name', 'украинский', 'languages' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//countries_and_
			} elseif ( $key == 'filter_sanatorium_service' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_service',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'hotelservices' )->term_id ) ),
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_services_for_sale' ) {
				$args['meta_query'][] = array(
					'key'     => 'services_for_sale',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'saleservices' )->term_id ) ),
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_region_or_language_kz' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'region_new',
						'value'   => get_term_by( 'name', 'Казахстан', 'countries' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'languages_list',
						'value'   => serialize( strval( get_term_by( 'name', 'казахский', 'languages' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//countries_and_
			} elseif ( $key == 'filter_countries_and_regions' ) {
				$args['meta_query'][] = array(
					'key'     => 'countries_and_regions',
					'value'   => get_term_by( 'name', $field['value'], 'regions' )->term_id,
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_base_2_licenses_0_liscensed' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_licenses_0_liscensed',
					'value'   => intval( $field['value'] ),
					'compare' => 'LIKE',
				);//countries_and_
			} elseif ( $key == 'filter_place_of_services_0_places_of_service' ) {
				$args['meta_query'][] = array(
					'key'     => 'place_of_services_0_places_of_service',
					'value'   => intval( $field['value'] ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_services_0_services_list' ) {
				$args['meta_query'][] = array(
					'key'     => 'services_$_services_list',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => '==',
				);
			} elseif ( $key == 'filter_services_0_services_list_1' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'services_$_services_list',
						'value'   => get_term_by( 'name', 'Аудит финансовой отчетности', 'businessservices' )->term_id,
						'compare' => '==',
					),
					array(
						'key'     => 'services_$_services_list',
						'value'   => get_term_by( 'name', 'Аудит финансовой отчетности по РСБУ', 'businessservices' )->term_id,
						'compare' => '==',
					)
				);
			} elseif ( $key == 'filter_buh_progs_0_text' ) {
				$args['meta_query'][] = array(
					'key'     => 'buh_progs_$_text',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_loan_first' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_first_0_to_percent',
					'value'   => intval($field['value']),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_deposit_commission_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_deposit_commission_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_audit_membership_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'audit_membership_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_withdrawal_commission_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_withdrawal_commission_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_sanatorium_children_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'sanatorium_children_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);//blogger_interest
			} elseif ( $key == 'filter_blogger_interest' ) {
				$args['meta_query'][] = array(
					'key'     => 'blogger_interest',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'interests' )->term_id ) ),
					'compare' => 'LIKE',
				);//blogger_interest
			} elseif ( $key == 'filter_uk_types_building' ) {
				$args['meta_query'][] = array(
					'key'     => 'uk_types_building',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'buildingtypes' )->term_id ) ),
					'compare' => 'LIKE',
				);//blogger_interest
			} elseif ( $key == 'filter_uk_types_building' ) {
				$args['meta_query'][] = array(
					'key'     => 'uk_types_building',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'buildingtypes' )->term_id ) ),
					'compare' => 'LIKE',
				);//blogger_interest
			} elseif ( $key == 'filter_base_2_build_types' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_build_types',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'buildingtypes' )->term_id ) ),
					'compare' => 'LIKE',
				);//blogger_interest
			} elseif ( $key == 'filter_base_2_build_types_1' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'нежилые помещения', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'офисы', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'офисные помещения', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//blogger_interest
			} elseif ( $key == 'filter_base_2_build_types_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'образовательные учреждения', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'детские сады', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_build_types',
						'value'   => serialize( strval( get_term_by( 'name', 'школы', 'buildingtypes' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//blogger_interest
			} elseif ( $key == 'filter_blogger_interest_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Кино', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Телевидение', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'шоу-бизнес', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//blogger_interest
			} elseif ( $key == 'filter_blogger_interest_3' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(//здоровый образ жизни, фитнес, спорт, Красота и здоровье)
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'здоровый образ жизни', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'фитнес', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'спорт', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Красота и здоровье', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//
			} elseif ( $key == 'filter_blogger_interest_4' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(//здоровый образ жизни, фитнес, спорт, Красота и здоровье)
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Бьюти-индустрия', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Beauty-сфера', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//
			} elseif ( $key == 'filter_blogger_interest_5' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'Моделинг', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'blogger_interest',
						'value'   => serialize( strval( get_term_by( 'name', 'модельный бизнес', 'interests' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//
			} elseif ( $key == 'filter_base_2_delivery_types' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_delivery_types',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'deliverytypes' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_delivery_company_types' ) {
				$args['meta_query'][] = array(
					'key'     => 'delivery_company_types',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'deliverycompanytypes' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_marketing_company_category' ) {
				$args['meta_query'][] = array(
					'key'     => 'marketing_company_category',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'companycategories' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_marketing_company_category_1' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'marketing_company_category',
						'value'   => serialize( strval( get_term_by( 'name', 'Косметика и гигиена', 'companycategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'marketing_company_category',
						'value'   => serialize( strval( get_term_by( 'name', 'Красота и здоровье', 'companycategories' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_delivery_company_types_empty' ) {
				$args['meta_query'][] = array(
					'key'     => 'delivery_company_types',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_base_2_delivery_types_and_pros' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_delivery_types',
						'value'   => serialize( strval( get_term_by( 'name', 'международная доставка', 'deliverytypes' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'pros_$_text',
						'value'   => 'международная доставка',
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_social_networks' ) {
				$args['meta_query'][] = array(
					'key'     => 'social_networks_$_channel',
					'value'   => get_term_by( 'name', $field['value'], 'channels' )->term_id,
					'compare' => '=',
				);//
			} elseif ( $key == 'filter_application_price' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'application_price_0_from',
						'value'   => 150,
						'compare' => '>=',
					),
					array(
						'key'     => 'application_price_0_to',
						'value'   => 695,
						'compare' => '<=',
					),
				);//application_price
			} elseif ( $key == 'filter_ability_to_pay_outside_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'ability_to_pay_outside_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_bonuses_in_stores_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'bonuses_in_stores_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_bad_credit_loans' ) {
				$args['meta_query'][] = array(
					'key'     => 'bad_credit_loans_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_bad_credit_loans' ) {
				$args['meta_query'][] = array(
					'key'     => 'bad_credit_loans_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_avia_on_board_children' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_avia_on_board_children',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_base_2_avia_on_board_children_w_aviaservices' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_avia_on_board_children',
						'value'   => get_term_by( 'name', 'языковые школы', 'aviaservices' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_avia_on_board_children',
						'value'   => get_term_by( 'name', 'Образование за рубежом', 'aviaservices' )->term_id,
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_base_2_offers_categories_1' ) {
				//идеально по таксономиям
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'финансы', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'криптовалюты', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'инвестиции', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'электронная коммерция', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);//финансы, криптовалюты, инвестиции, электронная коммерция)
			} elseif ( $key == 'filter_base_2_offers_categories_2' ) {

				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'Кредитные и дебетовые карты', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'Кредитование', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
				);//финансы, криптовалюты, инвестиции, электронная коммерция)
			} elseif ( $key == 'filter_base_2_offers_categories_3' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'инфо-товары', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'инфобизнес', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_base_2_offers_categories_4' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'онлайн-игры', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'base_2_offers_categories',
						'value'   => serialize( strval( get_term_by( 'name', 'онлайн игры', 'offerscategories' )->term_id ) ),
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_base_2_offers_categories_this' ) {
				//идеально по таксономиям
				$args['meta_query'][] = array(
					'key'     => 'base_2_offers_categories',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'offerscategories' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_payment_models' ) {
				//идеально по таксономиям
				$args['meta_query'][] = array(
					'key'     => 'base_2_payment_models',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'paymentmodels' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_traffic_sources' ) {
				//идеально по таксономиям
				$args['meta_query'][] = array(
					'key'     => 'base_2_traffic_sources',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'tool' )->term_id ) ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_application_processing_speed_mfo_24_hours' ) {
				$args['meta_query'][] = array(
					'key'     => 'application_processing_speed_mfo_0_time_type_to_time_type',
					'value'   => 'days',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_age_restrictions_0_to' ) {
				$args['meta_query'][] = array(
					'key'     => 'age_restrictions_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_age_restrictions_0_to_reverse' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'age_restrictions_0_from',
						'value'   => intval( $field['value'] ),
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'age_restrictions_0_from',
						'value'   => '',
						'compare' => '!=',
					)
				);
			} elseif ( $key == 'filter_age_restrictions_0_from' ) {
				$args['meta_query'][] = array(
					'key'     => 'age_restrictions_0_from',
					'value'   => intval( $field['value'] ),
					'compare' => '<=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_age_restrictions_0_from_add' ) {
				$args['meta_query'][] = array(
					'key'     => 'age_restrictions_0_from',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_loan_max_0_to' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_max_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_loan_approval_percentage' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 89,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 90,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 91,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 92,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 93,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 94,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 95,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 96,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 97,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 98,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_from_percent',
						'value'   => 99,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 89,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 90,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 91,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 92,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 93,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 94,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 95,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 96,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 97,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 98,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'loan_approval_percentage_0_to_percent',
						'value'   => 99,
						'compare' => '=',
						'type'    => 'NUMERIC',
					)
				);
			} elseif ( $key == 'filter_loan_max_0_to_do' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_max_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '<=',
				);
			} elseif ( $key == 'filter_loan_extension_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_extension_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_accept_applications_0_24_7' ) {
				$args['meta_query'][] = array(
					'key'     => 'accept_applications_0_24_7',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_find_title' ) {
				$args['meta_query'][] = array(
					'key'     => 'company_name',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_loan_max_0_to_percent' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'loan_max_0_to_percent',
						'value'   => floatval( $field['value'] ),
						'compare' => '<=',
					),
					array(
						'key'     => 'loan_max_0_from_percent',
						'value'   => floatval( $field['value'] ),
						'compare' => '<=',
					)
				);
			} elseif ( $key == 'filter_car_or_house' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'documents_list_$_documents',
						'value'   => get_term_by( 'name', 'ПТС', 'companydocuments' )->term_id,
						'compare' => '=',
					),
					array(
						'key'     => 'documents_list_$_documents',
						'value'   => get_term_by( 'name', 'Документы на недвижимость', 'companydocuments' )->term_id,
						'compare' => '=',
					)
				);
			} elseif ( $key == 'filter_loan_length_0_to' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_length_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '>=',
				);
			} elseif ( $key == 'filter_loan_zalog' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_zalog_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_loan_insurance' ) {
				$args['meta_query'][] = array(
					'key'     => 'loan_insurance_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_account_price_0_from' ) {
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'account_price_0_from',
						'value'   => intval( $field['value'] ),
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'account_price_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '=',
						'type'    => 'NUMERIC',
					)
				);
			} elseif ( $key == 'filter_cashback' ) {
				$args['meta_query'][] = array(
					'key'     => 'cashback_0_to_percent',
					'value'   => 0,
					'compare' => '!=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_percent_on_capital' ) {
				$args['meta_query'][] = array(
					'key'     => 'percent_on_capital_0_to_percent',
					'value'   => 0,
					'compare' => '!=',
					'type'    => 'NUMERIC',
				);
			} elseif ( $key == 'filter_project_details' ) {
				$args['meta_query'][] = array(
					'key'     => 'project_details',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_project_details_online_tv' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'project_details',
						'value'   => 'Онлайн-телевидение',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'project_details',
						'value'   => 'Один из первых операторов',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'services_$_services_list',
						'value'   => get_term_by( 'name', 'Прямая трансляция ТВ-каналов', 'businessservices' )->term_id,
						'compare' => '==',
					)
				);
			} elseif ( $key == 'filter_project_details_online_cinema' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'project_details',
						'value'   => 'онлайн-кинотеатр',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'project_details',
						'value'   => 'Видеосервис отечественных и зарубежных',
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_services_taxonomy' ) {
				$args['meta_query'][] = array(
					'key'     => 'services_taxonomy',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_company_main_office' ) {
				$args['meta_query'][] = array(
					'key'     => 'company_main_office',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_excerpt' ) {
				$args['meta_query'][] = array(
					'key'     => 'post_excerpt',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);//
			} elseif ( $key == 'filter_account_currencies' ) {
				$args['meta_query'][] = array(
					'key'     => 'account_currencies',
					'value'   => serialize( strval( get_term_by( 'name', $field['value'], 'currencies' )->term_id ) ),
					'compare' => 'LIKE',
				);//account_currencies
			} elseif ( $key == 'filter_base_2_mobile_version_app_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_mobile_version_app_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_site_reg_needed' ) {
				$args['meta_query'][] = array(
					'key'     => 'site_reg_needed_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_best_casino' ) {
				$args['meta_query'][] = array(
					'key'     => 'casino_is_best',
					'value'   => 1,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_top_bet' ) {
				$args['posts_per_page'] = 10;
			} elseif ( $key == 'filter_date' ) {
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
			}  elseif ( $key == 'filter_search_main' ) {
				$args['s'] = $field['value'];
			} elseif ( $key == 'filter_services_plus' ) {
				$args['meta_query'][] = array(
					'key'     => 'services_plus_$_services_list',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_special_buy_links' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'services_plus_$_services_list',
						'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
						'compare' => '=',
					),
					array(
						'key'     => 'project_details',
						'value'   => 'купли/продажи ссылок',
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_special_training_seo' ) {

			} elseif ( $key == 'filter_special_premium' ) {

			} elseif ( $key == 'filter_base_2_seo_site_estimation_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_site_estimation_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_lk_exist_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'lk_exist_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_seo_site_estimation_0_comment' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_site_estimation_0_comment',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_seo_cconcurents_analyzer_0_comment' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_cconcurents_analyzer_0_comment',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_demo_free_seo' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_demo_free_seo_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_seo_keywords_0_comment' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_keywords_0_comment',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_seo_ab_testing_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_ab_testing_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_base_2_seo_conversion_analyzer_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_seo_conversion_analyzer_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_services_promote_0_services_list' ) {
				$args['meta_query'][] = array(
					'key'     => 'services_promote_$_services_list',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_demo_dostup_free_version_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_demo_dostup_free_version_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_demo_dostup_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_demo_dostup_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_sitebuild_for_whom' ) {
				$args['meta_query'][] = array(
					'key'     => 'sitebuild_for_whom',
					'value'   => get_term_by( 'name', $field['value'], 'usercategory' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_fitness_programms' ) {
				$args['meta_query'][] = array(
					'key'     => 'fitness_programms',
					'value'   => get_term_by( 'name', $field['value'], 'fitnessprogramms' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_sitebuild_for_whom_1' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'физические и юридические лица', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'частные лица', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_sitebuild_for_whom_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'физические и юридические лица', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'Коммерческие организации', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'Юридические лица', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'компании', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'sitebuild_for_whom',
						'value'   => get_term_by( 'name', 'Бизнес', 'usercategory' )->term_id,
						'compare' => 'LIKE',
					)//, компании, Бизнес
				);
			} elseif ( $key == 'filter_program_fonts_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'program_fonts_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_audio
			} elseif ( $key == 'filter_boards_free_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'boards_free_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_audio
			} elseif ( $key == 'filter_program_audio_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'program_audio_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_3d
			} elseif ( $key == 'filter_program_3d_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'program_3d_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_vector
			} elseif ( $key == 'filter_program_vector_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'program_vector_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_layers
			} elseif ( $key == 'filter_program_layers_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'program_layers_0_exist',
					'value'   => 1,
					'compare' => '==',
				);//program_layers
			} elseif ( $key == 'filter_base_2_free_version' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_free_version_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_integrations' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_integrations',
					'value'   => get_term_by( 'name', $field['value'], 'channels' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_antivirus_seo_integrations' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'antivirus_seo_integrations',
						'value'   => get_term_by( 'name', 'Instagram', 'immodules' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'antivirus_seo_integrations',
						'value'   => get_term_by( 'name', 'TikTok', 'immodules' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'antivirus_seo_integrations',
						'value'   => get_term_by( 'name', 'Социальные сети', 'immodules' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'antivirus_seo_integrations',
						'value'   => get_term_by( 'name', 'Facebook', 'immodules' )->term_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'antivirus_seo_integrations',
						'value'   => get_term_by( 'name', 'YouTube', 'immodules' )->term_id,
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_withdrawal_methods' ) {
				$args['meta_query'][] = array(
					'key'     => 'withdrawal_methods',
					'value'   => get_term_by( 'name', $field['value'], 'paymentmethods' )->term_id,
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_webmoney_wmid' ) {
				$args['meta_query'][] = array(
					'key'     => 'webmoney_wmid',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_base_2_auto_russia' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_auto_russia',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_base_2_auto_foreign' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_auto_foreign',
					'value'   => '',
					'compare' => '!=',
				);
			} elseif ( $key == 'filter_pros_0_text' ) {
				$args['meta_query'][] = array(
					'key'     => 'pros_$_text',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_currency_how_to_get_0_text' ) {
				$args['meta_query'][] = array(
					'key'     => 'currency_how_to_get_$_text',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_currency_how_to_get_0_text_add_new_2' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'currency_how_to_get_$_text',
						'value'   => 'получать в игре',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'currency_how_to_get_$_text',
						'value'   => 'В награду за выполнение заданий в играх',
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_pros_0_text_plus_currency_growfactors' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'pros_$_text',
						'value'   => 'Мгновенное подтверждение транзакций',
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'currency_growfactors',
						'value'   => get_term_by( 'name', 'Высокая скорость обработки транзакций', 'growfactors' )->term_id,
						'compare' => 'LIKE',
					)
				);
			} elseif ( $key == 'filter_application_processing_speed_0_to' ) {
				// значения в БД <= value
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'application_processing_speed_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'application_processing_speed_0_to',
						'value'   => 0,
						'compare' => '!=',
					),
					array(
						'key'     => 'application_processing_speed_0_to',
						'value'   => '',
						'compare' => '!=',
					)
				);//scalping
			} elseif ( $key == 'filter_account_opening_speed_0_to' ) {
				// значения в БД <= value
				$args['meta_query'][] = array(
					'relation' => 'AND',
					array(
						'key'     => 'account_opening_speed_0_to',
						'value'   => intval( $field['value'] ),
						'compare' => '<=',
						'type'    => 'NUMERIC',
					),
					array(
						'key'     => 'account_opening_speed_0_to',
						'value'   => 0,
						'compare' => '!=',
					),
					array(
						'key'     => 'account_opening_speed_0_to',
						'value'   => '',
						'compare' => '!=',
					)
				);//scalping
			} elseif ( $key == 'filter_scalpingt' ) {
				$args['meta_query'][] = array(
					'key'     => 'scalping_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);
			} elseif ( $key == 'filter_account_verification_aml_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'account_verification_aml_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_base_2_car_tech_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_car_tech_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_base_2_car_tradein_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_car_tradein_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_base_2_car_test_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_car_test_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_stop_loss_and_take_profit_function' ) {
				$args['meta_query'][] = array(
					'key'     => 'stop_loss_and_take_profit_function_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_online_banking' ) {
				$args['meta_query'][] = array(
					'key'     => 'online_banking_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_account_opening_price_0_to' ) {
				$args['meta_query'][] = array(
					'key'     => 'account_opening_price_0_to',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//stop_loss_and_take_profit_function
			} elseif ( $key == 'filter_drugs_delivery_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'drugs_delivery_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//drugs_booking
			} elseif ( $key == 'filter_drugs_booking_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'drugs_booking_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//drugs_booking
			} elseif ( $key == 'filter_online_consult_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'online_consult_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//drugs_preorder
			} elseif ( $key == 'filter_drugs_preorder_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'drugs_preorder_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//drugs_preorder
			} elseif ( $key == 'filter_drugs_return_0_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'drugs_return_0_exist',
					'value'   => intval( $field['value'] ),
					'compare' => '==',
				);//drugs_preorder
			} elseif ( $key == 'filter_drugs_categories' ) {
				$args['meta_query'][] = array(
					'key'     => 'drugs_categories',
					'value'   => get_term_by( 'name', $field['value'], 'drugscategories' )->term_id,
					'compare' => 'LIKE',
				);//drugs_preorder
			} elseif ( $key == 'filter_wallet_type' ) {
				$args['meta_query'][] = array(
					'key'     => 'wallet_type',
					'value'   => get_term_by( 'name', $field['value'], 'wallet_types' )->term_id,
					'compare' => 'LIKE',
				);//drugs_preorder
			} elseif ( $key == 'filter_earn_methods' ) {
				$args['meta_query'][] = array(
					'key'     => 'earn_methods_$_services_list',
					'value'   => get_term_by( 'name', $field['value'], 'businessservices' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_assets_types_0_assets_types_list' ) {
				$args['meta_query'][] = array(
					'key'     => 'assets_types_$_assets_types_list',
					'value'   => get_term_by( 'name', $field['value'], 'companyactivetypes' )->term_id,
					'compare' => '=',
				);
			} elseif ( $key == 'filter_base_2_plarforms_0_device' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_plarforms_$_device',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			} elseif ( $key == 'filter_sitebuild_category' ) {
				$args['meta_query'][] = array(
					'key'     => 'sitebuild_category',
					'value'   => get_term_by( 'name', $field['value'], 'categorysites' )->term_id,
					'compare' => 'LIKE',
				);//
			} elseif ( $key == 'filter_base_2_sitebuild_hosting_0_comment' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_sitebuild_hosting_0_comment',
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);//base_2_sitebuild_hosting
			} elseif ( $key == 'filter_sitebuild_types_of_sites' ) {
				$args['meta_query'][] = array(
					'key'     => 'sitebuild_types_of_sites',
					'value'   => get_term_by( 'name', $field['value'], 'typesofsites' )->term_id,
					'compare' => 'LIKE',
				);//
			} elseif ( $key == 'filter_base_2_mobile_version_app_exist' ) {
				$args['meta_query'][] = array(
					'key'     => 'base_2_mobile_version_app_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//manager_assistance
			} elseif ( $key == 'filter_manager_assistance' ) {
				$args['meta_query'][] = array(
					'key'     => 'manager_assistance_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//manager_assistance
			} elseif ( $key == 'filter_traders_training' ) {
				$args['meta_query'][] = array(
					'key'     => 'traders_training_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//single_account
			} elseif ( $key == 'filter_single_account' ) {
				$args['meta_query'][] = array(
					'key'     => 'single_account_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//filter_margin_trading
			} elseif ( $key == 'filter_margin_trading' ) {
				$args['meta_query'][] = array(
					'key'     => 'margin_trading_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//filter_individual_investment_account
			} elseif ( $key == 'filter_individual_investment_account' ) {
				$args['meta_query'][] = array(
					'key'     => 'individual_investment_account_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//trust_management
			} elseif ( $key == 'filter_trust_management' ) {
				$args['meta_query'][] = array(
					'key'     => 'trust_management_0_exist',
					'value'   => $field['value'],
					'compare' => '=',
				);//trust_management
			} elseif ( $key == 'filter_traders_training_filter_manager_assistance' ) {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => 'traders_training_0_exist',
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'     => 'manager_assistance_0_exist',
						'value'   => 1,
						'compare' => '=',
					)
				);//manager_assistance
			} elseif ( $key == 'filter_special_freelance' ) {

			} elseif ( ( $key == 'filter_special_like_cheat' ) || ( $key == 'filter_individual_investment_accountasfasfasf' ) || ( $key == 'filter_special_dep_methods' ) || ( $key == 'filter_special_withdrawal_methods' ) || ( $key == 'filter_special_rating_a' ) || ( $key == 'filter_special_traffic' ) || ( $key == 'filter_special_get_by_online' ) || ( $key == 'filter_special_unlimited_host' ) ) {

			} else {
				$args['meta_query'][] = array(
					'key'     => get_term( $field['key'], 'field_types' )->slug,
					'value'   => $field['value'],
					'compare' => 'LIKE',
				);
			}
		}

		return $args;
		// значения в БД <= value
	}
}