<?php
function repeater_fields($field,$table_type,$post_id = 0) {
    global $post;
//    print_r($field);
    $result = '';
    $field_class = $field['wrapper']['class'];
    $field_values = $field['value'];
    $i=0;
    $current_language = get_locale();
    if(!empty($field_values)) {
        if($field_class == 'clone_taxonomy') {
            $taxonomy = $field['sub_fields'][0]['taxonomy'];
            $ids = $field_values[$field['sub_fields'][0]['_name']];
            $result .= terms_field($ids,$taxonomy,'comas');
        } elseif($field_class == 'mobile_apps') {
            /* if($field_values['mobile_exist']) {
                $result .= '<div class="mobile_row"><img src="'.get_template_directory_uri().'/images/greenbullet.png" alt="Да" width="11" height="11" />'.__('Есть мобильная версия сайта','er_theme').'</div>';
            } else {
                $result .= '<div class="mobile_row"><img src="'.get_template_directory_uri().'/images/xbullet.png" alt="Нет" width="9" height="9" />'.__('Нет мобильной версии сайта','er_theme').'</div>';
            } */
            if($field_values['app_exist']) {
                $result .= '<div class="mobile_row">';
				if($table_type != 'rating') {
					$result .= __('Есть мобильные приложения','er_theme');
				}
				
                if(!empty($field_values['app_links'])) {
					if($table_type != 'rating') {
                    $result .= ' <span class="field_comment_clean">(';
					}
                    $i = 0;
                    $total = count($field_values['app_links']);
                    foreach($field_values['app_links'] as $item) {
                        $i++;
                        $result .= '<a href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= $item['device']['label'];
                        $result .= '</a>';
                        if($i != $total) {
                            $result .= ' / ';
                        }
                    }
					if($table_type != 'rating') {
                    $result .= ')</span>';
					}
                }
                $result .= '</div>';
            } else {
				if($table_type == 'rating') {
					$result .= 'N/A';
				} else {
					$result .= '<div class="mobile_row">'.__('Нет мобильных приложений','er_theme').'</div>';
				}
                
            }

		} elseif($field_class == 'repeater_comm_new') {
			
			if(!empty($field_values)) {
				foreach($field_values as $item) {
					$result .= '<div class="repeater_comm_new">';
					$result .= term_field($item['comission_type'],'commissiontypes','name');
					if(!empty($item['comission_values'])) {
						$result .= ': ';
						$count_comms = count($item['comission_values']);
						$count_comms_xx = 0;
						foreach($item['comission_values'] as $comms) {
							$count_comms_xx++;
							if($comms['from'] || $comms['to']) { 
                        		$result .= simple_from_to($comms);
								if($comms['currency']) {
									$result .= ' ';
									$result .= term_field($comms['currency'],'currencies','name');
								}
								if($comms['comm_type']) {
									$result .= ' '.__('для','er_theme').' '.$comms['comm_type'];
								}
								if($comms['comment']) {
									$result .= ' / '.$comms['comment'];
								}
							} elseif($comms['from'] == 0 && $comms['to'] == 0) {
								$result .= '0';
								if($comms['currency']) {
									$result .= ' ';
									$result .= term_field($comms['currency'],'currencies','name');
								}
								if($comms['comm_type']) {
									$result .= ' '.__('для','er_theme').' '.$comms['comm_type'];
								}
								if($comms['comment']) {
									$result .= ' '.$comms['comment'];
								}
							}
							if($count_comms_xx != $count_comms) {
								$result .= ' / ';
							}
						}
					} else {
						if($item['exist'] && $item['exist'] == 1) {
							$result .= ': '.__('Есть','er_theme');
						} else {
							$result .= ': '.__('Нет','er_theme');
						}
					}
					
					
					
					$result .= '</div>';
				}
			}
			
			
		} elseif($field_class == 'repeater_new_min_dep') {
			$verified = $field_values[0]['verified'];
			$verified_crypto = $verified[0]['crypto'];
			$verified_fiat = $verified[0]['fiat'];
			$verified_crypto_n_a = $verified[0]['crypto_not_allowed'];
			$verified_fiat_n_a = $verified[0]['fiat_not_allowed'];
			$unverified = $field_values[0]['unverified'];
			$unverified_crypto = $unverified[0]['crypto'];
			$unverified_fiat = $unverified[0]['fiat'];
			$unverified_crypto_n_a = $unverified[0]['crypto_not_allowed'];
			$unverified_fiat_n_a = $unverified[0]['fiat_not_allowed'];
			$result .= '<div class="repeater_new_min_dep">';
				$result .= '<div class="repeater_new_min_dep_verified">';
				$result .= '<div class="repeater_new_min_dep_th_main">'.__('Верифицированный','er_theme').'</div>';
				if(!empty($verified_crypto) || !empty($verified_fiat) || $verified_crypto_n_a || $verified_fiat_n_a) {
					$result .= '<div class="repeater_new_min_dep_left">';
						$result .= '<div class="repeater_new_min_dep_th_sub">'.__('Криптовалюта','er_theme').'</div>';
						if($verified_crypto_n_a) {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Недоступно','er_theme').'</div>';
						} elseif(!empty($verified_crypto)) {
							$result .= '<ul class="repeater_new_min_dep_content">';
							foreach($verified_crypto as $item) {
								$result .= '<li>';
								if($item['from'] && $item['from'] != '') {
									$result .= __('От','er_theme');
									if(fmod($item['from'], 1) !== 0.00) {
										$result .= ' '.$item['from'];
									} else {
										$result .= ' '.number_format($item['from'],0,'.',' ');
									}
								}
								if($item['to'] && $item['to'] != '') {
									$result .= ' '.__('до','er_theme');
									if(fmod($item['to'], 1) !== 0.00) {
										$result .= ' '.$item['to'];
									} else {
										$result .= ' '.number_format($item['to'],0,'.',' ');
									}
								}
								if($item['currency']) {
									$result .= ' ';
									$result .= term_field($item['currency'],'currencies','name');
								}
								if($item['comment']) {
									if($item['to'] || $item['from']) {
										$result .= ' / ';
									}
									$result .= $item['comment'];
								}
								$result .= '</li>';
							}
							$result .= '</ul>';
						} else {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
						}
					$result .= '</div>';
					$result .= '<div class="repeater_new_min_dep_right">';
						$result .= '<div class="repeater_new_min_dep_th_sub">'.__('Фиат','er_theme').'</div>';
						if($verified_fiat_n_a) {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Недоступно','er_theme').'</div>';
						} elseif(!empty($verified_fiat)) {
							$result .= '<ul class="repeater_new_min_dep_content">';
							foreach($verified_fiat as $item) {
								$result .= '<li>';
								if($item['deposit_methods_pay']) {
									$result .= '<span>'.terms_field($item['deposit_methods_pay'], 'paymentmethods', 'comas').':</span>';
								}
								if($item['from'] && $item['from'] != '') {
									$result .= ' '.__('от','er_theme');
									$result .= ' '.number_format($item['from'],0,'.',' ');
								}
								if($item['to'] && $item['to'] != '') {
									$result .= ' '.__('до','er_theme');
									$result .= ' '.number_format($item['to'],0,'.',' ');
								}
								if($item['currency']) {
									$result .= ' ';
									$result .= term_field($item['currency'],'currencies','name');
								}
								if($item['comment']) {
									if($item['to'] || $item['from']) {
										$result .= ' / ';
									}
									$result .= $item['comment'];
								}
								$result .= '</li>';
							}
							$result .= '</ul>';
						} else {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
						}
					$result .= '</div>';
				} else {
					$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
					
				}
				
				$result .= '</div>';
				$result .= '<div class="repeater_new_min_dep_unverified">';
				$result .= '<div class="repeater_new_min_dep_th_main">'.__('Неверифицированный','er_theme').'</div>';
				if(!empty($unverified_crypto) || !empty($unverified_fiat) || $unverified_crypto_n_a || $unverified_fiat_n_a) {
					$result .= '<div class="repeater_new_min_dep_left">';
						$result .= '<div class="repeater_new_min_dep_th_sub">'.__('Криптовалюта','er_theme').'</div>';
						if($unverified_crypto_n_a) {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Недоступно','er_theme').'</div>';
						} elseif(!empty($unverified_crypto)) {
							$result .= '<ul class="repeater_new_min_dep_content">';
							foreach($unverified_crypto as $item) {
								$result .= '<li>';
								if($item['from'] && $item['from'] != '') {
									$result .= __('От','er_theme');
									if(fmod($item['from'], 1) !== 0.00) {
										$result .= ' '.$item['from'];
									} else {
										$result .= ' '.number_format($item['from'],0,'.',' ');
									}
								}
								if($item['to'] && $item['to'] != '') {
									$result .= ' '.__('до','er_theme');
									if(fmod($item['to'], 1) !== 0.00) {
										$result .= ' '.$item['to'];
									} else {
										
										$result .= ' '.number_format($item['to'],0,'.',' ');
									}
								}
								if($item['currency']) {
									$result .= ' ';
									$result .= term_field($item['currency'],'currencies','name');
								}
								if($item['comment']) {
									if($item['to'] || $item['from']) {
										$result .= ' / ';
									}
									$result .= $item['comment'];
								}
								$result .= '</li>';
							}
							$result .= '</ul>';
						} else {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
						}
					$result .= '</div>';
					$result .= '<div class="repeater_new_min_dep_right">';
						$result .= '<div class="repeater_new_min_dep_th_sub">'.__('Фиат','er_theme').'</div>';
						if($unverified_fiat_n_a) {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Недоступно','er_theme').'</div>';
						} elseif(!empty($unverified_fiat)) {
							$result .= '<ul class="repeater_new_min_dep_content">';
							foreach($unverified_fiat as $item) {
								$result .= '<li>';
								if($item['deposit_methods_pay']) {
									$result .= '<span>'.terms_field($item['deposit_methods_pay'], 'paymentmethods', 'comas').':</span>';
								}
								if($item['from'] && $item['from'] != '') {
									$result .= ' '.__('от','er_theme');
									$result .= ' '.number_format($item['from'],0,'.',' ');
								}
								if($item['to'] && $item['to'] != '') {
									$result .= ' '.__('до','er_theme');
									$result .= ' '.number_format($item['to'],0,'.',' ');
								}
								if($item['currency']) {
									$result .= ' ';
									$result .= term_field($item['currency'],'currencies','name');
								}
								if($item['comment']) {
									if($item['to'] || $item['from']) {
										$result .= ' / ';
									}
									$result .= $item['comment'];
								}
								$result .= '</li>';
							}
							$result .= '</ul>';
						} else {
							$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
						}
					$result .= '</div>';
				} else {
					$result .= '<div class="repeater_new_min_dep_content">'.__('Лимиты отсутствуют','er_theme').'</div>';
					
				}
				
				$result .= '</div>';
			$result .= '</div>';
        } elseif($field_class == 'licenses') {
            //$result .= 'licenses';
            //print_r($field_values);
            if ($field_values[0]['liscensed']) {

                if($table_type == 'rating') {
                    $result .= '<span class="yes_green">'.__('Есть', 'er_theme').'</span>';
                } else {


                    $result .= '<div class="license_row">'.__('Лицензирована','er_theme').'</div>';
                    if(!empty($field_values[0]['liscenses'])) {
                        foreach ($field_values[0]['liscenses'] as $item) {
                            $result .= '<div class="license_row">';
                            $result .= $item['text'];
                            $result .= ' <span class="field_comment">('.__('Активна','er_theme').')</span>';
                            $result .= '</div>';
                        }
                    } else {
                        $result_empty = 'empty';
                    }
                }
            }
        } elseif($field_class == 'support') {
            foreach($field_values as $item) {
                if($table_type == 'rating') {
                    $result .= term_field($item['channel'],'channels','icon');
                } elseif($table_type == 'review') {

                    $term_name = term_field($item['channel'],'channels','name');
                    
					/*if (is_user_logged_in()) {*/
						if (get_field('izobrajenie', 'channels' . '_' . $item['channel'])) {
							$result .= '<span class="logo_cloud">';
							$result .= '<span class="cloud_text">';
							if(in_array($term_name,array('Электронная почта','Skype'))) {
								$linkname = 'Mail link';
								if(in_array($term_name,array('Электронная почта'))) {
									$prefix = 'mailto:';
									$linkname = 'Mail link';
								} elseif(in_array($term_name,array('Skype'))) {
									$prefix = 'skype:';
									$linkname = 'Skype link';
								}
								$result .= '<a href="'.$prefix.$item['text'].'" aria-label="'.$linkname.'">';
								$result .= $item['text'];
								$result .= '</a>';
							} else {
								if ($item['text']) {
									$result .= $item['text'];
								} else {
									$result .= term_field($item['channel'],'channels','name');
								}
								
							}
							$result .= '</span>';
							if(in_array($term_name,array('Электронная почта','Skype','vc.ru'))) {
								$linkname = 'Mail link';
								if(in_array($term_name,array('Электронная почта'))) {
									$prefix = 'mailto:';
									$linkname = 'Mail link';
								} elseif(in_array($term_name,array('Skype'))) {
									$prefix = 'skype:';
									$linkname = 'Skype link';
								} elseif(in_array($term_name,array('vc.ru'))) {
									$prefix = '';
									$linkname = 'VC.RU link';
								}
								if ($item['text'] == '') {
									$result .= '<span class="logoer" style="-webkit-mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); background: #6321B6;">';
									$result .= '</span>';
								} else {
									$result .= '<a href="'.$prefix.$item['text'].'" aria-label="'.$linkname.'" class="logoer" style="-webkit-mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); background: #6321B6;">';
									$result .= '</a>';
								}
								
							} else {
								$result .= '<span class="logoer" style="-webkit-mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); mask-image: url('.get_field('izobrajenie', 'channels' . '_' . $item['channel']).'); background: #6321B6;">';
								$result .= '</span>';
								
							}
							$result .= '</span>';
						} else {
							$result .= '<div class="support_channel">';
							$result .= term_field($item['channel'],'channels','name');
							if($item['text']) {
								$result .= ': ';
								if(in_array($term_name,array('Электронная почта','Skype'))) {
									$linkname = 'Mail link';
									if(in_array($term_name,array('Электронная почта'))) {
										$prefix = 'mailto:';
										$linkname = 'Mail link';
									} elseif(in_array($term_name,array('Skype'))) {
										$prefix = 'skype:';
										$linkname = 'Skype link';
									}
									$result .= '<a href="'.$prefix.$item['text'].'" aria-label="'.$linkname.'">';
									$result .= $item['text'];
									$result .= '</a>';
								} else {
									$result .= $item['text'];
								}
							}
							$result .= '</div>';
						}
					/*} else {
						$result .= '<div class="support_channel">';
						$result .= term_field($item['channel'],'channels','name');
						if($item['text']) {
							$result .= ': ';
							if(in_array($term_name,array('Электронная почта','Skype'))) {
								if(in_array($term_name,array('Электронная почта'))) {
									$prefix = 'mailto:';
								} elseif(in_array($term_name,array('Skype'))) {
									$prefix = 'skype:';
								}
								$result .= '<a href="'.$prefix.$item['text'].'">';
								$result .= $item['text'];
								$result .= '</a>';
							} else {
								$result .= $item['text'];
							}
						}
						$result .= '</div>';
					}*/
                    
                
                }
            }
		} elseif($field_class == 'repeater_buy_types') {
			
			foreach($field_values[0] as $buy_key => $buy_value) {
				if(!empty($buy_value[0])) {
					
					if($buy_value[0]['exists'] == 1) {
						$buy_value_exists = __('да','er_theme');
					} else {
						$buy_value_exists = __('нет','er_theme');
					}
					if($buy_value_exists != '') {
						if($buy_key == 'online') {
							$buy_key = __('Онлайн','er_theme');
						} elseif($buy_key == 'hypotheque') {
							$buy_key = __('В ипотеку','er_theme');
						} elseif($buy_key == 'credit') {
							$buy_key = __('В кредит','er_theme');
						} elseif($buy_key == 'paypart') {
							$buy_key = __('В рассрочку','er_theme');
						} elseif($buy_key == 'mother_capital') {
							$buy_key = __('С материнским капиталом','er_theme');
						} elseif($buy_key == 'military') {
							$buy_key = __('Военная ипотека','er_theme');
						} elseif($buy_key == 'sub') {
							$buy_key = __('Субсидии','er_theme');
						} elseif($buy_key == 'escrow') {
							$buy_key = __('По эскроу-счету','er_theme');
						}
						$result .= '<div class="buy_types">';
						$result .= $buy_key.': ';
						$result .= $buy_value_exists;
						if($buy_value[0]['comment'] && $buy_value[0]['comment'] != '') {
							$result .= ' / '.$buy_value[0]['comment'];
						}
						$result .= '</div>';
					}
					
				}
				
			}
		} elseif($field_class == 'repeater_arbitrage') {
			$count_good = $field_values[0]['count_good'];
			$count_bad = $field_values[0]['count_bad'];
			if($count_good && $count_good != '') {
				$result .= '<div class="repeater_arbitrage">'.__('Выигранные дела','er_theme').': '.$count_good.'</div>';
			}
			if($count_bad && $count_bad != '') {
				$result .= '<div class="repeater_arbitrage">'.__('Проигранные дела','er_theme').': '.$count_bad.'</div>';
			}
		} elseif($field_class == 'repeater_objects') {
			$result .= '<div class="repeater_objects">';
				$count_objects = $field_values[0]['count_objects'];
				$count_meters = $field_values[0]['count_meters'];

				if($count_objects) {
					$result .= number_format($count_objects,0,'.',' ').' '.counted_text($count_objects,__('объект','er_theme'),__('объекта','er_theme'),__('объектов','er_theme'));
				}
				if($count_objects && $count_meters) {
					$result .= ' / ';
				}
				if($count_meters) {
					$result .= number_format($count_meters,0,'.',' ').' '.__('кв. м.','er_theme');
				}
				
			$result .= '</div>';
        } elseif($field_class == 'repeater_storage_crypto') {
            $result .= '<div class="repeater_storage">';
            if($field_values[0]['storage_cold'][0]['exist']) {
                $exist_value = __('да','er_theme');
            } else {
                $exist_value = __('нет','er_theme');
            }

            $result .= '<span class="field_text">'.__('Холодный','er_theme').': </span>';
            $result .= '<span class="field_exist">'.$exist_value.'</span>';
            if($field_values[0]['storage_cold'][0]['comment']) {
                $result .= '<span class="field_comment">'.$field_values[0]['storage_cold'][0]['comment'].'</span>';
            }
            $result .= '</div>';
            $result .= '<div class="repeater_storage">';
            if($field_values[0]['storage_coldhot'][0]['exist']) {
                $exist_value = __('да','er_theme');
            } else {
                $exist_value = __('нет','er_theme');;
            }

            $result .= '<span class="field_text">'.__('Горячий','er_theme').': </span>';
            $result .= '<span class="field_exist">'.$exist_value.'</span>';
            if($field_values[0]['storage_coldhot'][0]['comment']) {
                $result .= '<span class="field_comment">'.$field_values[0]['storage_coldhot'][0]['comment'].'</span>';
            }
            $result .= '</div>';
        } elseif($field_class == 'social_networks') {
            $total = count($field_values);
            $total_counter = 0;
            $current_language = get_locale();
            foreach($field_values as $item) {
                $total_counter++;
                $icon = term_field($item['channel'],'channels','name');
                if($current_language == 'ru_RU' && in_array($icon,array('Facebook','Instagram'))) {
                    continue;
                }
                if($item['link']) {
                    $result .= '<a class="er_social_network border_radius_general test" href="'.$item['link'].'" target="_blank" rel="nofollow" data-chanel="'.$icon.'">';
                    $result .= $icon;
                    $result .= '</a>';
                } else {
                    $result .= '<span class="er_social_network border_radius_general">'.$icon.'</span>';
                }
                if($total != $total_counter) {
                    $result .= ', ';
                }
            }
        } elseif($field_class == 'payment_aquiring') {
            //print_r($field_values);
            $mobile = $field_values[0]['mobile'];
            $sale = $field_values[0]['sale'];
            $internet = $field_values[0]['internet'];
            if(!empty($sale)) {
                $result .= '<div>';
                $result .= '<span class="gray">'.__('Торговый эквайринг:','er_theme').'</span> ';
                $result .= '<span>'.terms_field($sale, 'paymentmethods', 'comas').'</span>';
                $result .= '</div>';
            }
            if(!empty($mobile)) {
                $result .= '<div>';
                $result .= '<span class="gray">'.__('Мобильный эквайринг:','er_theme').'</span> ';
                $result .= '<span>'.terms_field($mobile, 'paymentmethods', 'comas').'</span>';
                $result .= '</div>';
            }
            if(!empty($internet)) {
                $result .= '<div>';
                $result .= '<span class="gray">'.__('Интернет-эквайринг:','er_theme').'</span> ';
                $result .= '<span>'.terms_field($internet, 'paymentmethods', 'comas').'</span>';
                $result .= '</div>';
            }
        } elseif($table_type == 'rating' && $field_class == 'services' && $field['name'] != 'cources_prices_paid') {
            $total = count($field_values);
            $total_counter = 0;
            $result .= '<div class="list_style_2">';
            foreach($field_values as $item) {
                $total_counter++;
                if($total >=3 && $total_counter == 3) {
                   // $result .= '<div class="show_more_wraper">';
                }
                if ($total_counter == $total){
                    $result .= term_field($item['services_list'],'businessservices','name').'';
                } else {
                    $result .= term_field($item['services_list'],'businessservices','name').', ';
                }
            }
            if($total >=3) {
              //  $result .= '</div>';
               // $rest = $total - 2;
               // $result .= '<div class="show_more show_more_link">'.__('и еще','er_theme').' '.$rest.' <i class="fas fa-chevron-down"></i></div>';
              //  $result .= '<div class="hide_more show_more_link">'.__('свернуть','er_theme').' <i class="fas fa-chevron-up"></i></div>';
            }
            $result .= '</div>';
		} elseif($field_class == 'repeater_car_insurance') {
            if($field_values[0]['kasko'][0]['exist']) {
                $exist_value_kasko = __('Да','er_theme');
            } else {
                $exist_value_kasko = __('Нет','er_theme');
            }
            if($field_values[0]['kasko'][0]['comment']) {
                $exist_value_kasko .= ' ('.$field_values[0]['kasko'][0]['comment'].')';
            }
            if($field_values[0]['osago'][0]['exist']) {
                $exist_value_osago = __('Да','er_theme');
            } else {
                $exist_value_osago = __('Нет','er_theme');
            }
            if($field_values[0]['osago'][0]['comment']) {
                $exist_value_osago .= ' ('.$field_values[0]['osago'][0]['comment'].')';
            }
            $result .= __('КАСКО','er_theme').': '.$exist_value_kasko.' / '.__('ОСАГО','er_theme').': '.$exist_value_osago;
            if($field_values[0]['comment']) {
                $result .= ' / '.$field_values[0]['comment'];
            }
        } elseif($field_class == 'bonuses') {
            $result .= '<div class="bonus-wrapper">';

            $total = count($field_values);
            $total_counter = 0;
            foreach ($field_values as $item) {
                $total_counter++;
				if($table_type == 'rating' && $total_counter == 2) {
					break;
				}
                if(!$item['hide_from_rating']) {
                    if(wp_is_mobile() && $total_counter >2 ) {
                        continue;
                    }
                    if($item['link']) {

                        $result .= '<a class="bonus_div_link bonus_div_link44" href="'.str_replace("https://etorazvod.ru","",$item['link']).'" target="_blank" rel="nofollow">';
                        if(wp_is_mobile() && $item['comment']) {
                            $result .= '<i class="fas fa-question"></i>';
                        }
						
                    } else {
                        $result .= '<div class="bonus_div_link">';
                    }
                    $result .= '<div class="bonus_div">';
                    if($item['bonus_format'] && $item['text']) {
                        $result .= $item['text'];
						if($table_type != 'rating') {
							$result .= '<span class="get_bonus_button get_bonus_button_1">'.__('Получить','er_theme').'</span>';
						}
                    } elseif($item['bonus_format'] && !$item['text'] && $item['comment']) {
                        $result .= $item['comment'];
                    } elseif($item['from'] || $item['to']) {
                        $result .= simple_from_to($item);
                        if($item['currency']) {
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                        }
						if($table_type != 'rating') {
							$result .= '<span class="get_bonus_button get_bonus_button_2">'.__('Получить','er_theme').'</span>';
						}

                    }


                    $result .= '</div>';
                    if($item['link']) {
                        $result .= '</a>';
                    } else {
                        $result .= '</div>';
                    }

                    if($item['comment']) {
                        $result .= '<div class="bonus_comment">';
                        $result .= do_shortcode( $item['comment'] );
                        $result .= '</div>';
                    }
                    //}
                }
            }
            $result .= '</div>';
        } else {
            $total = count($field_values);
            $total_counter = 0;
            foreach ($field_values as $item) {
                $total_counter++;

                if($total == 1) {
                    $last = ' item_single';
                } elseif ($total_counter == $total){
                    $last = ' item_last';
                } else {
                    $last = ' item_'.$total_counter;
                }
                if(in_array($field_class, array('number_plus','repeater_yesno','repeater_yesno_demo','regulators_list','repeater_24_7','repeater_fromto_year','repeater_fromto_loan','repeater_proscons','documents')) && in_array($table_type,array('rating','rating_yes_link')) || $table_type == 'rating_info_fromto' && $field_class == 'repeater_fromto' || in_array($field_class,array('linked_text_comma'))) {
                } else {
					if(!in_array($field_class,array('terminals_new'))) {
                    $result .= '<div class="repeater_field '.$field_class.$last.' '.$field['name'].'">';
					}
                }
                if($item['link'] && !in_array($field_class, array('repeater_websites','social_networks','mobile_apps','repeater_yesno_demo','forum_links','webmoney_advisor','bonuses','linked_text','operators_list','linked_text_comma')) && $field['name'] != 'api_integration') {

                    if($table_type == 'review') {
                        $result .= '<a class="field_link field_link_4" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= __('Регистрация','sa_theme');
                        $result .= '</a>';
                    } elseif ($table_type == 'rating' || $table_type == 'rating_yes_link') {
                        $result .= '<a class="field_link field_link_6" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= __('Открыть','sa_theme');
                        $result .= '</a>';
                    }

                } elseif($item['link'] && $field['name'] == 'api_integration' && $table_type != 'rating') {
                    $result .= '<a class="field_link field_link_7" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                    $result .= __('Подробнее','sa_theme');
                    $result .= '</a>';
                }
                if(in_array($field_class,array('repeater_yesno','repeater_yesno_demo'))) {

                    $exist = $item['exist'];
                    if($exist) {
                        if($table_type == 'review') {
                            if($item['comment']) {
                                $result .= $item['comment'];
                            } else {
                                if(!$item['link']) {
                                    $exist_value = __('Да', 'er_theme');
                                    $exist_class = 'yes';
                                    $result .= '<span class="field_exist ' . $exist_class . '">' . $exist_value . '</span>';
                                }
                            }
                        } elseif($table_type == 'rating' && $field['name'] == 'loan_insurance') {
                            $result .= __('требуется','er_theme');
                        } elseif($table_type == 'rating' && in_array($field['name'],array('business_loans','pay_by_phone'))) {
                            $result .= '<span class="yes_green">'.__('Есть', 'er_theme').'</span>';
                        } elseif($table_type == 'rating' && $field_class != 'repeater_yesno_demo' && $table_type != 'rating_yes_link') {
                            $exist_value = __('Есть','er_theme');
                            $exist_class = 'yes';
                            $result .= '<span class="field_exist '.$exist_class.'">'.$exist_value.'</span>';
                        }


                    } else {
                        if($table_type == 'review') {
                            $exist_value = __('Нет','er_theme');
                            $exist_class = 'no';
                            $result .= '<span class="field_exist '.$exist_class.'">'.$exist_value.'</span>';
							if($field['name'] == 'margin_trading' && $item['comment']) {
								$result .= ' / '.$item['comment'];
							}
                        } elseif($table_type == 'rating' && $field['name'] == 'loan_insurance') {
                            $result .= __('не требуется','er_theme');
                        } elseif($table_type == 'rating' && in_array($field['name'],array('business_loans','pay_by_phone'))) {
                            $result .= '<span class="no_red">'.__('нет','er_theme').'</span>';
                        } elseif($table_type == 'rating') {
                            $exist_value = '';
                        }


                    }

				} elseif(in_array($field_class, array('linked_text_comma'))) {
                    if($item['link'] && $item['text']) {
                    	/*if ($current_language != 'ru_RU') {
                    		$url_to_postid = url_to_postid($item['link']);
                    		if (gettype(get_field('enable_translations',$url_to_postid)) == 'array') {
								if (in_array('en_US',get_field('enable_translations',$url_to_postid))) {
									$result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
									$result .= $item['text'];
									$result .= '</a>';
									if($total != $total_counter) {
										$result .= ', ';
									}
								}
							}
       
						} else {
							$result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
							$result .= $item['text'];
							$result .= '</a>';
							if($total != $total_counter) {
								$result .= ', ';
							}
						}*/
	
						$result .= '<a class="field_link field_link_9" href="'.$item['link'].'" target="_blank" rel="nofollow">';
						$result .= $item['text'];
						$result .= '</a>';
						if($total != $total_counter) {
							$result .= ', ';
						}
                    
                    } elseif(!$item['link'] && $item['text']) {
                        $result .= $item['text'];
                        if($total != $total_counter) {
                            $result .= ', ';
                        }
                    } elseif($field['name'] == 'base_2_invest_plan' && !$item['text']) {
                        $result .= 'N/A';
                    }


                } elseif(in_array($field_class,array('repeater_24_7'))) {
                    if($item['24_7'] || $item['comment']) {
                        $exist = $item['24_7'];
                        if($exist) {
                            $result .= __('Круглосуточно','er_theme');
                        } elseif(in_array($field_class,array('repeater_24_7')) && $table_type == 'rating' && $item['comment']) {
                            $result .= $item['comment'];
                        }
                    } else {
                        $result .= 'N/A';
                    }

                } elseif($field_class == 'repeater_text') {
                    $result .= $item['text'];
                } elseif($field_class == 'support_phones') {
                    $result .= '<a href="tel:'.$item['text'].'">';
                    $result .= $item['text'];
                    $result .= '</a>';
                } elseif(in_array($field_class,array('site_spec'))) {
                    $values = $field['value'];
                    $sub_fields = $field['sub_fields'];
                    if (array_filter($values[0])) {
                        foreach ($sub_fields as $fie) {
                            $field_value = $values[0][$fie['name']];
                            if($field_value) {
                                $result .= '<div>';
                                if($field_value == 1) {
                                    $result .= '<span class="gray">'.$fie['label'].'</span> ';//в начале было <img src="'.get_template_directory_uri().'/images/greenbullet.png" alt="Да" width="11" height="11" />
                                } else {
                                    $result .= '<span class="gray">'.$fie['label'].':</span> ';
                                    $result .= '<span>';
                                    $result .= $field_value;
                                    $result .= '</span>';
                                }
                                $result .= '</div>';
                            }
                        }
                    } else {
                        $result .= 'N/A';

                    }
				} elseif(in_array($field_class,array('repeater_legal'))) {
                    $values = $field['value'];
                    $sub_fields = $field['sub_fields'];
                    if (array_filter($values[0])) {
                        foreach ($sub_fields as $fie) {
                            $field_value = $values[0][$fie['name']];
                            if($field_value) {
                                $result .= '<div>';
                                    $result .= '<span class="gray">'.$fie['label'].':</span> ';
                                    $result .= '<span>';
                                    $result .= $field_value;
                                    $result .= '</span>';
                                $result .= '</div>';
                            }
                        }
                    } else {
                        $result .= 'N/A';

                    }
                } elseif($field_class == 'repeater_proscons') {
                    if($table_type == 'rating') {

                        if($item['text'] && $total_counter < 2) {
                            $result .= '<div>';
                            $result .= $item['text'];
                            $result .= '</div>';
                        }
                    } else {
                        $exist = $item['text'];
                        if($field['name'] == 'pros' || $field['name'] == 'pros_4' || $field['name'] == 'pros_2') {
                            $exist_value = $item['text'];
                            $exist_class = 'yes';
                        } else {
                            $exist_value = $item['text'];
                            $exist_class = 'no';
                        }

                        $result .= '<span class="field_pros_cons '.$exist_class.'" d="'.$field['name'].'">'.$exist_value.'</span>';
                    }
                } elseif($field_class == 'spreads') {
                    $spread_type_value = $item['spread_type']['value'];
                    $spread_type_label = $item['spread_type']['label'];

                    $result .= simple_from_to($item);
                    if($spread_type_value != 'no') {
                        $result .= ' ('.$spread_type_label.')';
                    }
                } elseif($field_class == 'leverage') {
                    if($item['to'] || $item['comment']) {
                        if($item['to']) {
                            $result .= '<span class="field_number field_number_13">'.__('До','er_theme').' 1:'.$item['to'].'</span>';
                        }
                    } else {
                        $result .= 'N/A';
                    }

                } elseif(in_array($field_class, array('repeater_websites'))) {
                    if($item['site_url']) {
						$pos_instagram = strpos($item['site_url'], 'instagram.com/');
						if($pos_instagram === false) {
							$n_url = $item['site_url'];
							$icon_insta = '';
						} else {
							$n_url = str_replace("instagram.com/","@",$item['site_url']);
							$n_url = str_replace("www.","",$n_url);
							$n_url = str_replace("https://","",$n_url);
							$n_url = str_replace("http://","",$n_url);
							$icon_insta = ' site_insta';
							
						}
                        $result .= '<a class="field_site_url'.$icon_insta.'" href="'.get_bloginfo('url').'/visit/'.get_field('company_redirect_key').'/" target="_blank" rel="nofollow">';
                        $result .= $n_url;
                        $result .= '</a>';
                    }
                } elseif(in_array($field_class, array('services'))) {
                    if($table_type == 'rating' && $field['name'] != 'cources_prices_paid') {

                        $result .= term_field($item['services_list'],'businessservices','name');

                    } else {
                        $result .= '<span class="row_name">';
                        $result .= term_field($item['services_list'],'businessservices','name');
                        $result .= '</span>';
                        if($item['from'] || $item['to']) {
							if($table_type == 'rating') {
								$result .= '<div class="font_smaller_2 font_normal color_dark_gray">';
							} else {
								$result .= ' / ';
							}
                            
                            if(in_array('-1',array($item['from'],$item['to']))) {
                                $result .= __('Бесплатно','er_theme');
                            } else {
                                $result .= simple_from_to($item);
                                if($item['currency']) {
                                    $result .= '<span class="field_currency">';
                                    $result .= ' ';
                                    $result .= term_field($item['currency'],'currencies','name');
                                    $result .= '</span>';
                                }
                                if($item['period'] && $item['period']['value'] != 'no') {
                                    $result .= '<span class="field_period">';
                                    $result .= ' ';
                                    $result .= field_period($item['period'],'label');
                                    $result .= '</span>';
                                }
                            }
							if($table_type == 'rating') {
								$result .= '</div>';
							}



                        } else {
                            //$result .= 'N/A';
                        }

                    }

                } elseif(in_array($field_class, array('regulators_list'))) {
                    if($table_type == 'review') {
                        $result .= '<span class="row_name">';
                        $result .= term_field($item['regulators'],'companyregulators','name');
                        $result .= '</span>';
                    } elseif($table_type == 'rating') {
                        $result .= term_field($item['regulators'],'companyregulators','name');
                        if($total != $total_counter) {
                            $result .= ', ';
                        }
                    }
                } elseif(in_array($field_class, array('documents'))) {
                    if($table_type == 'review') {
                        $result .= '<span class="row_name">';
                        $result .= term_field($item['documents'],'companydocuments','name');
                        $result .= '</span>';
                    } elseif($table_type == 'rating') {
                        $result .= term_field($item['documents'],'companydocuments','name');
                        if($total != $total_counter) {
                            $result .= ', ';
                        }
                    }
                } elseif(in_array($field_class, array('operators_list'))) {
                    $result .= '<div class="support_channel">';
                    if($item['link']) {
                        $result .= '<a href="'.$item['link'].'" target="_blank" rel="nofollow">';
                    }
                    $result .= $item['device']['label'];
                    if($item['link']) {
                        $result .= '</a>';
                    }
					$result .= '</div>';
                } elseif(in_array($field_class, array('ingridients_list'))) {
                    $result .= '<span class="row_name">';
                    $result .= term_field($item['ingridients'],'ingridients','name');
                    $result .= '</span>';
                } elseif(in_array($field_class, array('actives_list'))) {
                    $result .= '<span class="row_name">';
                    $result .= term_field($item['assets_types_list'],'companyactivetypes','name');
                    $result .= '</span>';
				} elseif(in_array($field_class, array('terminals_new'))) {
                    $result .= terms_field($item['terminals_list'],'companyterminals','comas');
					if($item['comment'] && $item['comment'] != '') {
						$result .= ' ('.$item['comment'].')';
					}
					if($total != $total_counter) {
                            $result .= ', ';
                        }
                } elseif($field_class == 'repeater_registration') {
                    if($item['registration_type']) {
                        $result .= $item['registration_type']['label'];
                    }
                } elseif($field_class == 'place_of_services') {
                    //print_r($item['places_of_service']);
                    foreach ($item['places_of_service'] as $it) {
                        if($it['label'] != 'home') {
                            $result .= '<div class="field_checklist">';
                            $result .= $it['label'];
                            if ($it['value'] == 'online') {
                                $result .= ' <span class="field_comment">(<a href="' . get_bloginfo('url') . '/visit/' . get_field('company_redirect_key') . '/" target="_blank" rel="nofollow">' . __('Оформить', 'er_theme') . '</a>)</span>';
                            }
                            $result .= '</div>';
                        }
                    }

                } elseif($field_class == 'repeater_fromto_sms') {
                    if ($item['exist']) {
                        if($item['from'] || $item['to'] ) {
                            if(in_array('-1',array($item['from'],$item['to']))) {
                                $result .= __('Бесплатно','er_theme');
                            } else {
                                $result .= simple_from_to($item);
                                if($item['currency']) {
                                    $result .= '<span class="field_currency">';
                                    $result .= ' ';
                                    $result .= term_field($item['currency'],'currencies','name');
                                    $result .= '</span>';
                                }
                                if($item['period'] && $item['period']['value'] != 'no') {
                                    $result .= '<span class="field_period">';
                                    $result .= ' ';
                                    $result .= field_period($item['period'],'label');
                                    $result .= '</span>';
                                }
                            }
                        }
                    } else {
                        $exist_class = 'no';
                        $result .= '<span class="field_exist '.$exist_class.'">'.__('Нет','er_theme').'</span>';
                    }

                } elseif($field_class == 'repeater_fromto_percents' || $field_class == 'repeater_fromto_percent') {
                    if(in_array('-1',array($item['from_percent'],$item['to_percent']))) {
                        $result .= __('Без процентов','er_theme');
                    } else {

                        if ($item['from_percent'] || $item['to_percent']) {
                            $result .= '<span class="field_number field_number_2">';
                            if ($item['from_percent'] && $item['to_percent'] && $item['from_percent'] == $item['to_percent']) {
                                $result .= $item['from_percent'].'%';
                            } elseif($item['from_percent'] && $item['to_percent'] && $item['from_percent'] != $item['to_percent']) {
                                $result .= __('От','sa_theme').' '.$item['from_percent'].'%'.' '.__('до','sa_theme').' '.$item['to_percent'].'%';
                            } elseif($item['from_percent'] && !$item['to_percent']) {
                                $result .= __('От','sa_theme').' '.$item['from_percent'].'%';
                            } elseif(!$item['from_percent'] && $item['to_percent']) {
                                $result .= __('До','sa_theme').' '.$item['to_percent'].'%';
                            }
                            $result .= '</span>';
                        } else {
                            $result .= 'N/A';
                        }
                    }
				} elseif($field_class == 'repeater_fromto_crypto') {
					if($item['number']) {
						$result .= $item['number'].' ';
						if($item['currency']) {
                                    $result .= '<span class="field_currency">';
                                    $result .= ' ';
                                    $result .= term_field($item['currency'],'currencies','name');
                                    $result .= '</span> ';
                                
                            }
					} elseif(in_array('-1',array($item['from'],$item['to']))) {
                                $result .= __('Бесплатно','er_theme');
                            } else {
                                $result .= simple_from_to($item);
                                if($item['currency']) {
                                    $result .= '<span class="field_currency">';
                                    $result .= ' ';
                                    $result .= term_field($item['currency'],'currencies','name');
                                    $result .= '</span>';
                                }
                                if($item['period'] && $item['period']['value'] != 'no') {
                                    $result .= '<span class="field_period">';
                                    $result .= ' ';
                                    $result .= field_period($item['period'],'label');
                                    $result .= '</span>';
                                }
                            }
					if($item['number'] && $item['to_percent'] ) {
						$result .= '/ ';
					} elseif($item['from'] && $item['to'] && $item['to_percent']) {
						$result .= ' / ';
					}
					if($item['to_percent']) {
							if($item['show_plus']) {
								$result .= '<span class="percent percent_plus">';
								$result .= '+';
							} else {
								$result .= '<span class="percent percent_minus">';
								$result .= '';
							}
                            
							$result .= $item['to_percent'].'%</span>';
                        }
					
                } elseif(in_array($field_class, array('forum_links'))) {
                    if($item['link'] && $item['text']) {
                        $result .= '<a href="'.$item['link'].'" target="_blank" rel="nofollow">'.$item['text'].'</a>';
                    }
				} elseif(in_array($field_class, array('number_plus_sum'))) {
                    if($item['number'] || $item['comment']) {
                        $result .= number_format($item['number'],0,'.',' ');
                        if($item['show_plus']) {
                            $result .= '+';
                        }
                    } else {
                        $result .= 'N/A';
                    }
                    if($item['from'] != '' || $item['to'] != '') {
                        if(in_array('-1',array($item['from'],$item['to']))) {
                            $result .= __('Бесплатно','er_theme');
                        } else {
                            $result .= ' '.__('на сумму','er_theme').' ';
                            $result .= simple_from_to($item);
                            if($item['currency'] && !in_array('-1',array($item['from'],$item['to']))) {
                                if($item['from'] || $item['to']) {
                                    $result .= '<span class="field_currency">';
                                    $result .= ' ';
                                    $result .= term_field($item['currency'],'currencies','name');
                                    $result .= '</span>';
                                }
                            }
                        }
                    }
                } elseif(in_array($field_class, array('number_plus'))) {
                    if($item['number'] || $item['comment']) {
                        $result .= $item['number'];
                        if($item['show_plus']) {
                            $result .= '+';
                        }
                    } else {
                        $result .= 'N/A';
                    }
                } elseif(in_array($field_class, array('sum_year'))) {
                    if($item['number'] || $item['comment']) {
                        if ($item['year']) {
                            $result .= '<span class="field_year">';
                            $result .= $item['year'].' г. / ';
                            $result .= '</span>';
                        }
                        $result .= '<span class="field_number field_number_5">';
                        $result .= $item['number'];
                        $suffix_value = $item['suffix']['value'];
                        $suffix_label = $item['suffix']['label'];

                        if($suffix_value != 'no') {
                            $result .= ' '.$suffix_label;
                        }
                        $result .= '</span>';

                        if($item['currency']) {
                            $result .= '<span class="field_currency a3">';
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                            $result .= '</span>';
                        }
                    } else {
                        $result .= 'N/A';
                    }
                } elseif(in_array($field_class, array('repeater_fromto_time'))) {
					
                    if($item['from'] || $item['to']) {
                        if($item['payment_methods']) {
                            $result .= '<div>'.terms_field($item['payment_methods'], 'paymentmethods', 'comas').':</div>';
                        }
                        if(in_array('-1',array($item['from'],$item['to']))) {
                            $result .= __('Моментально','er_theme');
                        } else {
                            $result .= simple_from_to_time($item);
                        }
                    } else {
						if($item['payment_methods']) {
                            $result .= terms_field($item['payment_methods'], 'paymentmethods', 'comas');
                        } else {
                        	$result .= 'N/A';
						}
                    }

                } elseif(in_array($field_class, array('repeater_fromto_loan'))) {
                    if($item['from'] || $item['to'] || $item['from_percent'] || $item['to_percent']) {
                        $result .= simple_from_to($item);
                        if($item['currency']) {
                            $result .= '<span class="field_currency">';
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                            $result .= '</span>';
                        }
                        if ($item['from_percent'] || $item['to_percent']) {
							//$result .= print_r($item);
                            $result .= '<span class="field_number field_number_9"> / '.__('Ставка:','er_theme').' ';
                            if ($item['from_percent'] && $item['to_percent'] && $item['from_percent'] == $item['to_percent']) {
                                $result .= $item['from_percent'].'%';
                            } elseif($item['from_percent'] && $item['to_percent'] && $item['from_percent'] != $item['to_percent']) {
                                $result .= __('от','sa_theme').' '.$item['from_percent'].'%'.' '.__('до','sa_theme').' '.$item['to_percent'].'%';
                            } elseif($item['from_percent'] && !$item['to_percent']) {
                                $result .= __('от','sa_theme').' '.$item['from_percent'].'%';
                            } elseif(!$item['from_percent'] && $item['to_percent']) {
                                $result .= __('до','sa_theme').' '.$item['to_percent'].'%';
                            }
                            $result .= '</span>';
                        }
                    } else {
                        $result .= 'N/A';
                    }
                } elseif(in_array($field_class, array('linked_text'))) {
                    if($item['link'] && $item['text']) {
                        $result .= '<a class="field_link field_link_10" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= $item['text'];
                        $result .= '</a>';
                    } elseif(!$item['link'] && $item['text']) {
                        $result .= $item['text'];
                    } elseif($field['name'] == 'base_2_invest_plan' && !$item['text']) {
                        $result .= 'N/A';
                    }/*
                } elseif(in_array($field_class, array('bonuses'))) {


                    if($item['bonus_format'] && $item['text']) {
                        $result .= '<span class="green_text">'.$item['text'].'</span>';
                        if($item['comment']) {
                            $result .= '<span class="field_comment">(';
                            $result .= $item['comment'];
                            $result .= ')</span>';
                        }
                    } elseif($item['bonus_format'] && !$item['text'] && $item['comment']) {
                        $result .= '<span class="green_text">'.$item['comment'].'</span>';
                    } elseif($item['from'] || $item['to']) {
                        $result .= '<span class="green_text">'.simple_from_to($item);
                        if($item['currency']) {
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                        }
                        $result .='</span>';
                        if($item['comment']) {
                            $result .= '<span class="field_comment">(';
                            $result .= $item['comment'];
                            $result .= ')</span>';
                        }
                    }
                    if($item['link']) {
                        $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= __('Получить','er_theme');
                        $result .= '</a>';
                    }

*/
                } elseif(in_array($field_class, array('money_commissions'))) {
                    //print_r($item);
                    if($item['from'] || $item['to'] || $item['money_transfer_speed'][0]['from'] || $item['money_transfer_speed'][0]['to'] || $item['from_percent'] || $item['to_percent']) {
                        $result .= '<div class="row_sum_commissions">';
                        $result .= simple_from_to($item);
                        if($item['currency'] && $item['from'] || $item['currency'] && $item['to']) {
                            $result .= '<span class="field_currency a4">';
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                            $result .= '</span>';
                        }
                        if($item['from_percent'] || $item['to_percent']) {
                            if($item['from'] || $item['to']) {
                                $result .= ' / ';
                            }
                            if(in_array('-1',array($item['from_percent'],$item['to_percent']))) {
                                $result .= __('Без комиссии','er_theme');
                            } else {
                                $result .= __('Комиссия','er_theme').' ';
                                if ($item['from_percent'] || $item['to_percent']) {
                                    $result .= '<span class="field_number field_number_88">';
                                    if ($item['from_percent'] && $item['to_percent'] && $item['from_percent'] == $item['to_percent']) {
                                        $result .= $item['from_percent'].'%';
                                    } elseif($item['from_percent'] && $item['to_percent'] && $item['from_percent'] != $item['to_percent']) {
                                        $result .= __('от','sa_theme').' '.$item['from_percent'].'%'.' '.__('до','sa_theme').' '.$item['to_percent'].'%';
                                    } elseif($item['from_percent'] && !$item['to_percent']) {
                                        $result .= __('от','sa_theme').' '.$item['from_percent'].'%';
                                    } elseif(!$item['from_percent'] && $item['to_percent']) {
                                        $result .= __('до','sa_theme').' '.$item['to_percent'].'%';
                                    }
                                    $result .= '</span>';
                                }
                            }
                        }

                        $result .= '</div>';
                        $speed = $item['money_transfer_speed'][0];
                        if($speed['from'] || $speed['to']) {
                            $result .= '<div class="speed_field">';
                            $speed = $item['money_transfer_speed'][0];
                            //print_r($speed);
                            if(in_array('-1',array($speed['from'],$speed['to']))) {
                                $result .= __('Моментально','er_theme');
                            } else {
                                $result .= simple_from_to_time($speed);
                            }
                            $result .= '</div>';
                        }


                    } else {
                        $result .= 'N/A';
                    }
                } elseif(in_array($field_class, array('repeater_fromto','repeater_fromto_year'))) {
                    if($item['from'] || $item['to'] || $item['comment']) {
                        if(in_array('-1',array($item['from'],$item['to']))) {
                            $result .= __('Бесплатно','er_theme');
                        } else {
                            $result .= simple_from_to($item);

                            $suffix_value = $item['suffix']['value'];
                            $suffix_label = $item['suffix']['label'];
                        }
                        if($suffix_value != 'no') {
                            $result .= ' '.$suffix_label;
                        }
                        if(in_array($field_class, array('repeater_fromto_year'))) {
                            if($item['from'] || $item['to']) {
                                $result .= ' '.__('лет','sa_theme');
                            }
                        }

                        if($item['currency'] && !in_array('-1',array($item['from'],$item['to']))) {
                            if($item['from'] || $item['to']) {
                            	if (strpos(simple_from_to($item),'course_price') !== false) {
									
								} else {
									$result .= '<span class="field_currency">';
									$result .= ' ';
									$result .= term_field($item['currency'],'currencies','name');
									$result .= '</span>';
								}
                                
                            
                            }
                        }

                    } else {
						
                        $result .= 'N/A';
                    }

                }
                if(in_array($field_class, array('repeater_phones'))) {
                    $result .= '<span class="field_phone">';
                    if($item['phone_country']) {
                        $result .= '+'.$item['phone_country'].' ';
                    }
                    if($item['phone_city']) {
                        $result .= '('.$item['phone_city'].') ';
                    }
                    if($item['phone_number']) {
                        $result .= $item['phone_number'];
                    }
                    if($item['phone_ext']) {
                        $result .= ' '.__('доб.','sa_theme').' '.$item['phone_ext'];
                    }

                    $result .= '</span>';
                }
				
                if(in_array($field_class, array('social_networks'))) {
                    if($item['channel']) {
                        if($item['link']) {
                            $result .= '<a class="field_icon" href="'.get_bloginfo('url').'/go/affs-'.$post->ID.'-'.$field['name'].'-'.$i.'/" target="_blank" rel="nofollow">';
                            $result .= term_field($item['channel'],'channels','icon');
                            $result .= '</a>';
                        } else {
                            $result .= '<span class="field_icon">';
                            $result .= term_field($item['channel'],'channels','icon');
                            $result .= '</span>';
                        }
                        $result .= '<span class="field_comment">';
                        $result .= '<strong>'.term_field($item['channel'],'channels','name').'</strong>';
                        if($item['comment']) {
                            $result .= '<br />'.$item['comment'];
                        }
                        $result .= '</span>';

                    }
                }

                if($item['email']) {
                    $result .= '<a class="field_email" href="mailto:'.$item['email'].'">';
                    $result .= $item['email'];
                    $result .= '</a>';
                }
                if($item['link'] && $field_class == 'repeater_yesno_demo') {

                    if($table_type == 'review') {
                        $result .= ' <a class="field_link field_link_2" href="'.$item['link'].'" target="_blank" rel="nofollow">';
	
						if ($term_slug = get_term( get_field('company_type', $post_id), 'companytypes' )->name == 'slotsonline') {
							$result .= __('Free demo game','sa_theme');
						} else {
							$result .= __('Открыть демо счет','sa_theme');
						}
                    
                    } elseif($table_type == 'rating' || $table_type == 'rating_yes_link') {

                        $company_name = get_field( 'company_name', $post_id );
                        $result .= ' <a class="field_link field_link_1" href="'.$item['link'].'" target="_blank" rel="nofollow" title="'.__('На сайт','er_theme').' '.$company_name.'">';

                        $result .= __('На сайт','sa_theme');
                    }
                    $result .= '</a>';
                }
                if($item['comment'] && !in_array($field_class, array('social_networks','bonuses','repeater_yesno','f','repeater_yesno_demo','terminals_new')) && $table_type != 'rating' && $table_type != 'rating_yes_link') {
                    $result .= '<span class="field_comment">';
                    $result .= $item['comment'];
                    $result .= '</span>';
                } 



                if(in_array($field_class, array('number_plus','repeater_yesno','repeater_yesno_demo','regulators_list','repeater_27_7','repeater_fromto_year','repeater_fromto_loan','repeater_proscons','documents')) && in_array($table_type,array('rating','rating_yes_link')) || $table_type == 'rating_info_fromto' && $field_class == 'repeater_fromto' || in_array($field_class,array('linked_text_comma'))) {

                } else {
					if(!in_array($field_class,array('terminals_new'))) {
                    $result .= '</div>';
					}
                }
                $i++;
            }
        }

    }

	if (get_locale() != 'ru_RU') {
		
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}
?>