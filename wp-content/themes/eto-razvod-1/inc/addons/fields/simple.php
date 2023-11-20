<?php
function simple_from_to($item) {
    $result = '';
    
    if ($item['from'] || $item['to']) {
        $result .= '<span class="field_number bbb9832hjasfa">';
        if ($item['from'] && $item['to'] && $item['from'] == $item['to']) {
            $result .= '<span>'.$item['from'].'</span>';
        } elseif($item['from'] && $item['to'] && $item['from'] != $item['to']) {
        	if ($company_type = get_term( get_field('company_type',get_the_ID()), 'companytypes' )->name == 'courses') {
				if (isset($item['currency'])) {
					$result .= '<span  class="course_price"><span  class="course_price_1"><a href="/visit/'.get_field('company_redirect_key',get_the_ID()).'/" target="_blank">'.$item['from'].' '.term_field($item['currency'],'currencies','name').'</a><span class="course_price_2">'.__('Купить со скидкой','sa_theme').'</span></span> <span class="course_price_3">'.$item['to'].' '.term_field($item['currency'],'currencies','name').'</span></span>';
				} else {
					$result .= __('От','sa_theme').' <span>'.$item['from'].'</span> '.__('до','sa_theme').' <span>'.$item['to'].'</span>';
				}
				
			} else {
				$result .= __('От','sa_theme').' <span>'.$item['from'].'</span> '.__('до','sa_theme').' <span>'.$item['to'].'</span>';
			}
        
        } elseif($item['from'] && !$item['to']) {
            $result .= __('От','sa_theme').' <span>'.$item['from'].'</span>';
        } elseif(!$item['from'] && $item['to']) {
            $result .= __('До','sa_theme').' <span>'.$item['to'].'</span>';
        }
        $result .= '</span>';
    }
	if (get_locale() != 'ru_RU') {
		
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}

function simple_from_to_time($item) {
    $result = '';
    //echo 'ttt'; print_r($item);
    $time_type_from = $item['time_type_from_time_type'];
    $time_type_to = $item['time_type_to_time_type'];
    if($time_type_from['value'] == $time_type_to['value']) {
        $time_from = '';
        $time_to = ' '.$time_type_to['label'];
    } elseif($time_type_from['value'] != $time_type_to['value']) {
        $time_from = ' '.$time_type_from['label'];
        $time_to = ' '.$time_type_to['label'];
    }
    if ($item['from'] || $item['to']) {
        $result .= '<span class="field_number asfas13535778">';
        if ($item['from'] && $item['to'] && $item['from'] == $item['to'] && $time_type_from['value'] == $time_type_to['value']) {

            if ($time_to == ' лет') {
                if ((intval($item['from']) == 1) || (intval($item['from']) % 10 == 1)) {
                    $time_to = ' год';
                } elseif ((((intval($item['from']) > 1) && (intval($item['from']) < 5)) || ((intval($item['from']) % 10 > 1) && (intval($item['from']) % 10 < 5))) && ((intval($item['from']) < 10) || (intval($item['from']) > 19))) {
                    $time_to = ' года';
                } elseif (((intval($item['from']) > 4) && (intval($item['from']) < 11)) || ((intval($item['from']) % 10 > 4) && (intval($item['from']) % 10 < 11))) {
                    $time_to = ' лет';
                } else {
                    $time_to = ' лет';
                }
            }
            $result .= '<span>'.$item['from'].$time_to.'</span>';
        } elseif($item['from'] && $item['to'] && $item['from'] != $item['to'] || $item['from'] && $item['to'] && $item['from'] == $item['to'] && $time_type_from['value'] != $time_type_to['value']) {
            $result .= __('От','sa_theme').' <span>'.$item['from'].$time_from.'</span> '.__('до','sa_theme').' <span>'.$item['to'].$time_to.'</span>';
        } elseif($item['from'] && !$item['to']) {
	        if ($time_type_from['value'] == 'minutes') {
		        $result .= __('От','sa_theme').' <span>'.$item['from'].' '.$time_type_from['label'].'</span>';
	        } else {
		        $result .= __('От','sa_theme').' <span>'.$item['from'].$time_from.'</span>';
	        }
        } elseif(!$item['from'] && $item['to']) {
            $result .= __('До','sa_theme').' <span>'.$item['to'].$time_to.'</span>';
        }
        $result .= '</span>';
    }
	if (get_locale() != 'ru_RU') {
		
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}

function field_period($item,$format) {
    $result = '';
    if($format == 'label') {
        if($item['label'] != 'no period') {
            $result .= $item['label'];
        }
    }
	if (get_locale() != 'ru_RU') {
		
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}


function term_field($id,$taxonomy,$format) {

    $result = '';
    if(get_term( $id, $taxonomy )->name != 'no' && get_term( $id, $taxonomy )->slug != 'no') {
        if($format == 'name') {
            $result .= get_term( $id, $taxonomy )->name;
        } elseif($format == 'slug') {
            $result .= get_term( $id, $taxonomy )->slug;
        } elseif($format == 'name_icon') {
            if(get_field('icon','term_'.$id)) {
                $result .= '<i class="'.get_field('icon','term_'.$id).'"></i>';
            }
            $result .= get_term( $id, $taxonomy )->name;
        } elseif($format == 'icon') {
            if(get_field('icon','term_'.$id)) {
                $result .= '<i class="'.get_field('icon','term_'.$id).'"></i>';
            }
        }
    }
	if (get_locale() != 'ru_RU') {
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;

}

function terms_field($ids, $taxonomy, $format) {
    $result = '';
    if(!empty($ids)) {

        $args = array(
            'taxonomy'	=> $taxonomy,
            'include'	=> $ids,
            'orderby'  => 'include',
            'hide_empty' => false
        );
        $terms = get_terms($args);
        $total = count($terms);
        $total_counter = 0;

        if($format == 'comas') {
            $etc = '';
            
			if ($taxonomy == 'languages') {
				$language = get_locale();
				

				
				
				$count_terms_temp = count($terms);
				if ($language != 'ru_RU' && $count_terms_temp > 1) {
					$i = 0;
					$end_last = end($terms);
					$last = array_pop($terms);
				}
				
				foreach($terms as $item) {
					$total_counter++;
					if ($total_counter == $total){
						$result .= $item->name;
					} else {
						if ($language != 'ru_RU' && $count_terms_temp > 1) {
							if ( $item->name != 'Русский' ) {
								$result .= $item->name . ', ';
							} else {
								$i = 1;
							}
						} else {
							$result .= $item->name . ', ';
						}
					}
				}
				
				if ($language != 'ru_RU' && $count_terms_temp > 1) {
					if ( $i == 1 ) {
						$result .= 'Русский, ';
					}
					$result .= $end_last->name;
				}
				
				
			} else {
				foreach($terms as $item) {
					$total_counter++;
					if ($total_counter == $total){
						$result .= $item->name;
					} else {
							$result .= $item->name . ', ';
					}
				}
			}
        
			
        } elseif($format == 'comas_howto_tools') {
            foreach($terms as $item) {
                $total_counter++;
                if ($total_counter == $total){
                    $result .= '<span itemprop="tool" itemtype="http://schema.org/HowToTool">'.$item->name.'</span>';
                } else {
                    $result .= '<span itemprop="tool" itemtype="http://schema.org/HowToTool">'.$item->name.'</span>, ';
                }
            }
        } elseif($format == 'comas_howto_supply') {
            foreach($terms as $item) {
                $total_counter++;
                if ($total_counter == $total){
                    $result .= '<span itemprop="supply" itemtype="http://schema.org/HowToSupply">'.$item->name.'</span>';
                } else {
                    $result .= '<span itemprop="supply" itemtype="http://schema.org/HowToSupply">'.$item->name.'</span>, ';
                }
            }
        } elseif($format == 'only_one') {
            $show_more = count($terms)-1;
            $result .= $terms[0]->name;
            if($show_more >= 1) {
                $result .=' '.__('и еще','er_theme').' '.$show_more;
            }
        } elseif($format == 'list_rating') {
            $result .= '<div class="list_style_2">';
            foreach($terms as $item) {
                $total_counter++;
                if($total >=3 && $total_counter == 3) {
                  //  $result .= '<div class="show_more_wraper">';
                }
                if ($total_counter == $total){
                    $result .= $item->name;
                } else {
                    $result .= $item->name.', ';
                }
            }
            if($total >=3) {
               // $result .= '</div>';
               // $rest = $total - 2;
               // $result .= '<div class="show_more show_more_link">'.__('и еще','er_theme').' '.$rest.' <i class="fas fa-chevron-down"></i></div>';
               // $result .= '<div class="hide_more show_more_link">'.__('свернуть','er_theme').' <i class="fas fa-chevron-up"></i></div>';
            }
            $result .= '</div>';
        } elseif($format == 'list') {
            $result .= '<ul class="terms_list">';
            foreach($terms as $item) {
                $total_counter++;
                if ($total_counter == $total){
                    $result .= '<li class="last">'.$item->name.'</li>';
                } else {
                    $result .= '<li>'.$item->name.'</li>';
                }
            }
            $result .= '</ul>';
        }
    }
	if (get_locale() != 'ru_RU') {
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}

function simple_field($field_type,$item,$table_type) {
    global $post;
    $result = '';
    $field_class = $item['wrapper']['class'];
    $field_name = $item['name'];
    if($field_type == 'from_to') {
        if ($item['from'] || $item['to']) {
            $result .= '<span class="field_number a0909389">';
            if ($item['from'] && $item['to'] && $item['from'] == $item['to']) {
                $result .= $item['from'];
            } elseif($item['from'] && $item['to'] && $item['from'] != $item['to']) {
                $result .= __('From','sa_theme').' '.$item['from'].' '.__('to','sa_theme').' '.$item['to'];
            } elseif($item['from'] && !$item['to']) {
                $result .= __('From','sa_theme').' '.$item['from'];
            } elseif(!$item['from'] && $item['to']) {
                $result .= __('Up to','sa_theme').' '.$item['to'];
            }
            $result .= '</span>';
        }
        if($item['currency']) {
            $result .= '<span class="field_currency">';
            $result .= ' ';
            $result .= term_field($item['currency'],'currencies','name');
            $result .= '</span>';
        }
        if($item['text']) {
            $result .= '<span class="field_promocode">';
            $result .= $item['text'];
            $result .= '</span>';
        }
        if($item['comment']) {
            $result .= '<span class="field_comment">';
            $result .= $item['comment'];
            $result .= '</span>';
        }
    } elseif($field_type == 'checkbox') {

        if(!empty($item['value'])) {
            $total = count($item['value']);
            $i = 0;
            foreach ($item['value'] as $it) {
                $i++;
                $result .= $it['label'];
                if ($i != $total) {
                    $result .= ', ';
                }
            }
        }
    } elseif($field_type == 'rating') {
        $rating_value = $item['value']*10;
        if($rating_value >= 70) {
            $rating_color = 'green';
        } elseif($rating_value >= 40 && $rating_value < 70) {
            $rating_color = 'orange';
        } elseif($rating_value < 40) {
            $rating_color = 'red';
        }
        $result .= '<div class="rating_field '.$rating_color.'">';
        $result .= '<div class="rating_value" style="width:'.$rating_value.'%">';
        $result .= '<span>'.$item['value'].' '.__('из 10','sa_theme').'</span>';
        $result .= '</div></div>';
    } elseif(in_array($field_class, array('webmoney_advisor')) && $item['value']) {
        $result .= '<a href="'.$item['value'].'" target="_blank" rel="nofollow" class="field_link_simple">'.__('Проверить отзывы и претензии','er_theme').'</a>';
    } elseif($field_type == 'range') {
        if($field_class == 'score') {
            $result .= '<span class="green_text">'.$item['value'].'/10</span>';
        }
    } elseif($field_type == 'number') {
        $result .= $item['value'];
    } elseif($field_type == 'text') {
        if($field_class == 'company_name') {
            $result .= '<a href="'.get_bloginfo('url').'/visit/'.get_field('company_redirect_key',$post->ID).'/" rel="nofollow" target="_blank"><span>'.$item['value'].'</span></a>';
        } else {
            $result .= '<span class="field_text '.$field_class.' '.$field_name.'">'.$item['value'].'</span>';
        }
        if(in_array($field_class, array('webmoney_wmid')) && $table_type != 'rating' && $item['value']) {
            $result .= ' <a href="https://passport.webmoney.ru/asp/CertView.asp?wmid='.$item['value'].'" target="_blank" rel="nofollow" class="field_link_simple">'.__('Проверить аттестат','er_theme').'</a>';
        }
    } elseif($field_type == 'message' && $field_class == 'date_modified') {
        $result .= get_the_modified_date();
    } elseif($field_type == 'date_picker') {
        $result .= $item['value'];
        if($item['name'] == 'company_established' && $item['value']) {
            $current_language = get_locale();
            if($current_language == 'ru_RU') {
                $result .= ' '.__('год','sa_theme');
            }
        }
    } elseif($field_type == 'taxonomy') {

        if($item['taxonomy'] == 'languages' && $table_type == 'rating') {
            $result .= terms_field($item['value'], $item['taxonomy'], 'only_one');
        } elseif(in_array($item['taxonomy'],array('paymentmethods','courcescategories','businessservices','drugscategories','tools')) && $table_type == 'rating') {
            $result .= terms_field($item['value'], $item['taxonomy'], 'list_rating');
        } else {

            if(in_array($item['field_type'],array('multi_select','checkboxes','checkbox'))) {
                $result .= terms_field($item['value'], $item['taxonomy'], 'comas');
            } elseif(in_array($item['field_type'],array('radio','select'))) {
                $result .= term_field($item['value'],$item['taxonomy'],'name');
            }
        }
    }
	if (get_locale() != 'ru_RU') {
		
			$result = str_replace('https://etorazvod.ru/','/', $result);
		
	}
    return $result;
}
?>