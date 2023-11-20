<?php
function repeater_fields($field,$table_type) {
    global $post;
//    print_r($field);
    $result = '';
    $field_class = $field['wrapper']['class'];
    $field_values = $field['value'];
    $i=0;
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
                $result .= '<div class="mobile_row">'.__('Есть мобильные приложения','er_theme');
                if(!empty($field_values['app_links'])) {
                    $result .= ' <span class="field_comment_clean">(';
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
                    $result .= ')</span>';
                }
                $result .= '</div>';
            } else {
                $result .= '<div class="mobile_row">'.__('Нет мобильных приложений','er_theme').'</div>';
            }
        } elseif($field_class == 'licenses') {
            //$result .= 'licenses';
            //print_r($field_values);
            if ($field_values[0]['liscensed']) {

                if($table_type == 'rating') {
                    $result .= '<span class="yes_green">'.__('есть', 'er_theme').'</span>';
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
                }
            }
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
            foreach($field_values as $item) {
                $total_counter++;
                $icon = term_field($item['channel'],'channels','name');
                if($item['link']) {
                    $result .= '<a class="er_social_network border_radius_general test" href="'.$item['link'].'" target="_blank" rel="nofollow">';
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
        } elseif($table_type == 'rating' && $field_class == 'services') {
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

                        $result .= '<a class="bonus_div_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        if(wp_is_mobile() && $item['comment']) {
                            $result .= '<i class="fas fa-question"></i>';
                        }
                    } else {
                        $result .= '<div class="bonus_div_link">';
                    }
                    $result .= '<div class="bonus_div">';
                    if($item['bonus_format'] && $item['text']) {
                        $result .= $item['text'];
                        if($item['comment']) {

                            $result .= '<div class="bonus_comment">';
                            $result .= $item['comment'];
                            $result .= '</div>';
                        }
                    } elseif($item['bonus_format'] && !$item['text'] && $item['comment']) {
                        $result .= $item['comment'];
                    } elseif($item['from'] || $item['to']) {
                        $result .= simple_from_to($item);
                        if($item['currency']) {
                            $result .= ' ';
                            $result .= term_field($item['currency'],'currencies','name');
                        }
                        if($item['comment']) {
                            $result .= '<div class="bonus_comment">';
                            $result .= $item['comment'];
                            $result .= '</div>';
                        }

                    }


                    $result .= '</div>';
                    if($item['link']) {
                        $result .= '</a>';
                    } else {
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
                if(in_array($field_class, array('number_plus','repeater_yesno','repeater_yesno_demo','regulators_list','repeater_24_7','repeater_fromto_year','repeater_fromto_loan','repeater_proscons','documents')) && in_array($table_type,array('rating','rating_yes_link')) || $table_type == 'rating_info_fromto' && $field_class == 'repeater_fromto') {
                } else {
                    $result .= '<div class="repeater_field '.$field_class.$last.' '.$field['name'].'">';
                }
                if($item['link'] && !in_array($field_class, array('repeater_websites','social_networks','mobile_apps','repeater_yesno_demo','forum_links','webmoney_advisor','bonuses','linked_text','operators_list')) && $field['name'] != 'api_integration') {

                    if($table_type == 'review') {
                        $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= __('Регистрация','sa_theme');
                        $result .= '</a>';
                    } elseif ($table_type == 'rating' || $table_type == 'rating_yes_link') {
                        $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                        $result .= __('Открыть','sa_theme');
                        $result .= '</a>';
                    }

                } elseif($item['link'] && $field['name'] == 'api_integration' && $table_type != 'rating') {
                    $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
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
                            $result .= '<span class="yes_green">'.__('есть', 'er_theme').'</span>';
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
                        } elseif($table_type == 'rating' && $field['name'] == 'loan_insurance') {
                            $result .= __('не требуется','er_theme');
                        } elseif($table_type == 'rating' && in_array($field['name'],array('business_loans','pay_by_phone'))) {
                            $result .= '<span class="no_red">'.__('нет','er_theme').'</span>';
                        } elseif($table_type == 'rating') {
                            $exist_value = '';
                        }


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
                } elseif(in_array($field_class,array('repeater_legal','site_spec'))) {
                    $values = $field['value'];
                    $sub_fields = $field['sub_fields'];
                    if (array_filter($values[0])) {
                        foreach ($sub_fields as $fie) {
                            $field_value = $values[0][$fie['name']];
                            if($field_value) {
                                $result .= '<div>';
                                if($field_value == 1) {
                                    $result .= '<img src="'.get_template_directory_uri().'/images/greenbullet.png" alt="Да" width="11" height="11" /><span class="gray">'.$fie['label'].'</span> ';
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
                } elseif($field_class == 'repeater_proscons') {
                    if($table_type == 'rating') {

                        if($item['text'] && $total_counter < 2) {
                            $result .= '<div>';
                            $result .= $item['text'];
                            $result .= '</div>';
                        }
                    } else {
                        $exist = $item['text'];
                        if($field['name'] == 'pros') {
                            $exist_value = $item['text'];
                            $exist_class = 'yes';
                        } else {
                            $exist_value = $item['text'];
                            $exist_class = 'no';
                        }

                        $result .= '<span class="field_pros_cons '.$exist_class.'">'.$exist_value.'</span>';
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
                            $result .= '<span class="field_number">1:'.$item['to'].'</span>';
                        }
                    } else {
                        $result .= 'N/A';
                    }

                } elseif(in_array($field_class, array('repeater_websites'))) {
                    if($item['site_url']) {

                        $result .= '<a class="field_site_url" href="'.get_bloginfo('url').'/visit/'.get_field('company_redirect_key').'/" target="_blank" rel="nofollow">';
                        $result .= $item['site_url'];
                        $result .= '</a>';
                    }
                } elseif(in_array($field_class, array('services'))) {
                    if($table_type == 'rating') {

                        $result .= term_field($item['services_list'],'businessservices','name');

                    } else {
                        $result .= '<span class="row_name">';
                        $result .= term_field($item['services_list'],'businessservices','name');
                        $result .= '</span>';
                        if($item['from'] || $item['to']) {
                            $result .= ' / ';
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
                            $result .= '<span class="field_number">';
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
                } elseif(in_array($field_class, array('forum_links'))) {
                    if($item['link'] && $item['text']) {
                        $result .= '<a href="'.$item['link'].'" target="_blank" rel="nofollow">'.$item['text'].'</a>';
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
                        $result .= '<span class="field_number">';
                        $result .= $item['number'];
                        $suffix_value = $item['suffix']['value'];
                        $suffix_label = $item['suffix']['label'];

                        if($suffix_value != 'no') {
                            $result .= ' '.$suffix_label;
                        }
                        $result .= '</span>';

                        if($item['currency']) {
                            $result .= '<span class="field_currency">';
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
                        $result .= 'N/A';
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
                            $result .= '<span class="field_number"> / '.__('Ставка:','er_theme').' ';
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
                        $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
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
                            $result .= '<span class="field_currency">';
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
                                    $result .= '<span class="field_number">';
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
                                $result .= '<span class="field_currency">';
                                $result .= ' ';
                                $result .= term_field($item['currency'],'currencies','name');
                                $result .= '</span>';
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
                    $result .= '<a class="field_link" href="'.$item['link'].'" target="_blank" rel="nofollow">';
                    if($table_type == 'review') {
                        $result .= __('Открыть демо счет','sa_theme');
                    } elseif($table_type == 'rating' || $table_type == 'rating_yes_link') {
                        $result .= __('Открыть','sa_theme');
                    }
                    $result .= '</a>';
                }
                if($item['comment'] && !in_array($field_class, array('social_networks','bonuses','repeater_yesno','f')) && $table_type != 'rating' && $table_type != 'rating_yes_link') {
                    $result .= '<span class="field_comment">';
                    $result .= $item['comment'];
                    $result .= '</span>';
                }



                if(in_array($field_class, array('number_plus','repeater_yesno','repeater_yesno_demo','regulators_list','repeater_27_7','repeater_fromto_year','repeater_fromto_loan','repeater_proscons','documents')) && in_array($table_type,array('rating','rating_yes_link')) || $table_type == 'rating_info_fromto' && $field_class == 'repeater_fromto') {

                } else {
                    $result .= '</div>';
                }
                $i++;
            }
        }

    }


    return $result;
}
?>