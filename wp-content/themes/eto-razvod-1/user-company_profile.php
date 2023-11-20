<?php
acf_form_head();
set_query_var('dashboard_type', 'dashboard_comments');
set_query_var('dashboard_breadcrumb_name', 'Профиль');

get_header();
$userid = get_query_var('user_id');
$company_slug = get_query_var('company_slug');
$comp_id = get_query_var('comp_id');
$counters = profile_stats_count( $userid );
//echo profile_top($userid,$counters);



?>
    <link rel='stylesheet' id='acf-input-font-awesome-css'  href='https://etorazvod.ru/wp-content/plugins/advanced-custom-fields-font-awesome/assets/css/input.css?ver=3.1.1' media='all' />
    <link rel='stylesheet' id='acf-input-font-awesome_library-css'  href='https://use.fontawesome.com/releases/v5.15.4/css/all.css?ver=5.8.1' media='all' />
<?php
$current_user = wp_get_current_user();
$user_id = $current_user->data->ID;
echo print_css_links('user_page');
echo  print_js_links()['user_page'];
echo  print_js_links()['user_editor'];
echo  print_css_links('user_form');
echo  print_css_links('popup_forms');
//		echo  print_js_links()['show_block'];
//		echo  print_css_links('show_block');
echo  print_css_links('user_editor');
//$result .= print_js_links()['comments_loader_dashboard'];
//$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );  ?>
    <div class="page_content page_container background_light review_container_about visible">
        <div class="wrap  justify-content-space-between wrap-no-padding-top">
            <div class="profile-wrapper">
                <div class="profile-wrapper__left">

					<?php echo company_menu($current_user,$user_id,'dashboard',$comp_id,$company_slug);
					?>
                </div>
                <div class="profile-wrapper__center_sub">
                    <div class="breadcrumbs_dashboard isdesctop">
						<?php if (function_exists('show_breadcrumbs')) {
							echo show_breadcrumbs();
						} ?>
                    </div>
					<?php

					$comp_id_for_edit = 0;
					$args = array(
						'post_type'		=> 'casino',
						'post_status' => 'draft',
						'meta_query'	=> array(
							'relation'		=> 'AND',
							array(
								'key'		=> 'id_parent_for_edit_company_profile',
								'value'		=> array($comp_id),
								'compare'	=> 'IN'
							),
						)
					);
					$the_query = new WP_Query( $args );
					if( $the_query->have_posts() ):
						while ( $the_query->have_posts() ) : $the_query->the_post();
//echo get_the_ID();
							$comp_id_for_edit = get_the_ID();

						endwhile;
					endif;
					wp_reset_query();

					if ($comp_id_for_edit == 0) {
						function duplicate($post_id) {
							$comp_id = get_query_var('comp_id');
							$title   = get_the_title($post_id);
							$oldpost = get_post($post_id);
							$get_the_content = get_the_content($post_id);
							$post    = array(
								'post_title' => 'Дочерняя страница для редактирования '.get_field('company_name',$comp_id),
								'post_status' => 'draft',
								'post_content'  => $get_the_content,
								'post_type' => $oldpost->post_type,
								'post_author' => 17
							);
							$new_post_id = wp_insert_post($post);
							$data = get_post_custom($post_id);
							foreach ( $data as $key => $values) {
								foreach ($values as $value) {
									add_post_meta( $new_post_id, $key, maybe_unserialize( $value ) );
								}
							}
							return $new_post_id;
						}
						$new_post_id = duplicate($comp_id);
						$company_type = get_field('company_type',$comp_id);
						update_field('company_type',$company_type,$new_post_id);
						update_field('id_parent_for_edit_company_profile',$comp_id,$new_post_id);
						update_field('company_redirect_key','',$new_post_id);
						$comp_id_main_test = $new_post_id;
						//echo 'test1';
					} else {
						$comp_id_main_test = $comp_id_for_edit;
						//echo 'test2';
					}

					//echo $comp_id_main_test;


					//$d = duplicate(95);
					//echo get_field('company_type',95);

					//update_field('company_type',2065,156698);

					$current_user = wp_get_current_user();
					$user_id = $current_user->data->ID;

					$term_slug = get_term( get_field( 'company_type', $comp_id_main_test ), 'companytypes' )->name;
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
                        'field_5eda2fa971af4',
                        'field_5eaafac934837',

						'field_5eaaecf251ec3', //vernut
						'field_5eda30ece9db3', //vernut
						'field_5e45f1b258a9c',  //vernut
						'field_5e45fbfa99141',  //vernut
						'field_5eb2a182b8b9c',  //vernut
						'field_5eb2a19fb8b9e',  //vernut
						'field_5eda31817646b',  //vernut
						'field_5e45ff08f75e1',  //vernut
						'field_5eaad96d4b44a',   //vernut
						'field_5e6c23d4ac645',   //vernut
						// 'field_5eda3c26040c9',   //vernut
						'field_5e4847b0dcc01',   //vernut
						'field_5e6c27aa8ef75',
						'field_5eda37ce59338',
						'field_5eaad63d37c17',
						'field_5eda42ddc2f74', 'field_5eaae01c99e96', 'field_5eaad66937c19','field_6082ac017bbef'

					];
					foreach ( $arr_del as $item ) {
						if ( ( $key = array_search( $item, $array_to_upd ) ) !== false ) {
							unset( $array_to_upd[ $key ] );
						}
					}
					$acf_form_settings = array(
						'post_id'      => $comp_id_main_test,
						'post_title'   => false,
						'post_content' => false,
						'fields'       => $array_to_upd,
						'submit_value' => __( 'Сохранить' ),
						'kses' => false,
						'form_attributes' => array(
							'class' => 'new-campaign-form',
							'id'=>'modalAjaxTrying'

						),
					);
					//the_content($comp_id_main_test);
					echo '<div class="acf_form_edit">';
					//echo $comp_id_main_test
					acf_form( $acf_form_settings );
					echo '</div><span class="text_form_dashboard">Для начала, внесите все нужные изменения в таблицу и только после этого отправляйте на модерацию. После отправки на модерацию, правки в таблице будут запрещены до прохождения модерации.</span>';
                    echo '<span class="save_to_moderate">Сохранить</span><span class="send_to_moderate">Отправить на модерацию</span>';
					?>
                    <div class="comment_bar_info_wrapper comment_bar_info_wrapper_user_editor"></div>
					<?php //echo profile_container_about($user_id,NULL,'desc','show');
					/*$get_support = get_field('base_2_support',$comp_id_main_test);

					foreach ($get_support  as $item ) {

						echo '<span class="profile_sidebar_contact_link" >';
					    if (get_field('icon','channels_'.$item['channel'])) {
						    echo '<i class="'.get_field('icon','channels_'.$item['channel']).'" aria-hidden="true"></i>';
                        }
					    if ($item['text'] != '') {
					        echo $item['text'];
                        } else {
					        echo get_term_by('ID', $item['channel'], 'channels')->name;
                        }
					    echo '</span>';

						 //print_r(get_term_by('ID', $item['channel'], 'channels'));
					}*/

					?>

                </div>
                <!--<div class="profile-wrapper__right_sub">< ?php echo company_edit_avatar_block($comp_id) ?><div class="container_side flex flex_column soon_block"><span class="soon_dashboard">Скоро</span>< ?php echo company_t_contacts_sidebar($comp_id_main_test,'edit') ?></div><div class="container_side flex flex_column soon_block"><span class="soon_dashboard">Скоро</span>< ?php echo company_t_contacts_social_sidebar($comp_id_main_test,'edit') ?></div>< ?php echo fast_links_profile( $user_id ,'noborder',[['#','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]) ?>< ?php echo menu_footer_links(true) ?></div>-->
                <div class="profile-wrapper__right_sub"><?php echo company_edit_avatar_block($comp_id) ?><div class="container_side flex flex_column soon_block"><span class="soon_dashboard">Скоро</span><?php echo company_t_contacts_sidebar($comp_id_main_test,'edit') ?></div><div class="container_side flex flex_column soon_block"><span class="soon_dashboard">Скоро</span><?php echo company_t_contacts_social_sidebar($comp_id_main_test,'edit') ?></div><?php echo fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]) ?><?php echo menu_footer_links(true) ?></div>
            </div>
        </div>
    </div>
<?php
echo print_css_links('profile_top');
get_footer('profile');
?>