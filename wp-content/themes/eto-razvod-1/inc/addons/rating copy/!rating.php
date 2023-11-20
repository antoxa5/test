<?php
function bonustable_func($atts) {
    extract(shortcode_atts(array(
        'usa' => 'n',
        'num' => 10,
        'orderby' => 'menu_order',
        'sort' => 'ASC',
        'type' => 'full',
        'show_search' => 0,
        'full_link' => '',
        'full_link_title' => __("Перейти в рейтинг", "er_theme"),
        'tag'=>'',
        'version' =>1
    ), $atts));
    $result = '';
    //$result .= $sort.'<br />'.$type.'<br />'.$show_search.'<br />'.$orderby.'<br />'.$num.'<br />'.$tag.'<br />'.$version;
    $term_id = get_term_by('slug', $tag, 'affiliate-tags')->term_id;
    $result .= bottom_brokers_new(array($term_id,$orderby,$sort,$num,$type,$tag,$show_search));
    return $result;
}


add_shortcode('bonustable', 'bonustable_func');

function bottom_brokers_new($er_tags) {


    $result ='';

    $er_tag = array($er_tags[0]);
    if(!$er_tags[4]) {
        if(get_field('block_title_recommend','term_'.$er_tags[0])) {
            $result .= '<h2 id="bottombrokers">'.get_field('block_title_recommend','term_'.$er_tags[0]).'</h2>';
        } else {
            $result .= '<h2 id="bottombrokers">Выберите надежную компанию</h2>';
        }
    }
    if($er_tags[3]) {
        $num = $er_tags[3];
    } else {
        $num = 3;
    }
    if($er_tags[2]) {
        $sort = $er_tags[2];
    } else {
        $sort = 'ASC';
    }
    if($er_tags[1]) {
        $orderby = $er_tags[1];
    } else {
        $orderby = 'menu_order';
    }
    $er_posts = new WP_Query( array(
        'post_type' => 'casino',
        'posts_per_page' => $num,
        'orderby' => $orderby,
        'order' => $sort,
        'tax_query' => array(
            array(
                'taxonomy' => 'affiliate-tags',
                'field'    => 'id',
                'terms'    => $er_tag,
            ),
        ),
    ) );
    // The Loop
    if ( $er_posts->have_posts() ) {
        if($er_tags[4]) {
            $custom_table = get_field_object('tags_recommended_fields_rating','term_'.$er_tags[0]);
        } else {
            $custom_table = get_field_object('tags_recommended_fields','term_'.$er_tags[0]);
        }
        if(!empty($custom_table['value'])) {

            $th = array();
            $row = array();
            $i = 0;
            $total = count($custom_table['value']);
            foreach($custom_table['value'] as $td) {
                if($td['hideme_short'] && $er_tags[4] == 'short') {
                    continue;
                }
                $i++;
                $th_item = array();
                $td_item = array();
                // echo '<pre>';
                //print_r($td);
                //echo '<pre>';
                $td_id = $td['td'];
                //echo $td['td']['value'];
                if($td['td_name'] != '') {
                    $th_item['value'] = $td['td_name'];
                } else {
                    $th_item['value'] = $td['td']['label'];
                }
                if($td['sort']) {
                    $th_item['sort'] = $td['sort'];
                }
                $td_item['value'] = $td['td'];
                if($td['button_text'] != '' && in_array($td['td']['value'],array('link_visit','link_review'))) {
                    $td_item['button_text'] = $td['button_text'];
                }
                if($td['review_link'] != '' && in_array($td['td']['value'],array('link_visit'))) {
                    $td_item['review_link'] = $td['review_link'];
                }
                if($td['hideme'] == true) {
                    $hideme = ' hideme1';
                } else {
                    $hideme = '';
                }
                if($i == '1') {
                    $th_item['class'] = 'item_first'.$hideme;
                    $td_item['class'] = 'item_first'.$hideme;
                } elseif($i == '2' && !$er_tags[4]) {
                    $th_item['class'] = 'item_'.$i.$hideme;
                    $td_item['class'] = 'item_'.$i.' blueh'.$hideme;
                } elseif($i == $total) {
                    $th_item['class'] = 'item_last bright'.$hideme;
                    $td_item['class'] = 'item_last bright'.$hideme;
                } else {
                    $th_item['class'] = 'item_'.$i.$hideme;
                    $td_item['class'] = 'item_'.$i.$hideme;
                }
                if($td['information_fields']) {
                    $td_item['information_fields'] = $td['information_fields'];
                }
                if($td['date_name']) {
                    $td_item['date_name'] = $td['date_name'];
                }
                if($td['width'] != '') {
                    $th_item['width'] = $td['width'];
                }


                $th[] = $th_item;
                $row[] = $td_item;
            }


        } else {


            if($er_tags[4]) {
                $th = array(
                    array(
                        'value' => 'Компания',
                        'class' => 'item_first'
                    ),
                    array(
                        'value' => 'Информация',
                        'class' => 'item_2'
                    ),
                    array(
                        'value' => 'Бонусы',
                        'class' => 'item_3 hideme1'
                    ),
                    array(
                        'value' => 'Регистрация',
                        'class' => 'item_last bright'
                    ),
                );
                $row = array(
                    array(
                        'value' => array(
                            'value' => 'name',
                            'label' => 'Компания'
                        ),
                        'class' => 'item_first'
                    ),
                    array(
                        'value' => array(
                            'value' => 'information',
                            'label' => 'Информмация'
                        ),
                        'class' => 'item_2'
                    ),
                    array(
                        'value' => array(
                            'value' => 'bonus',
                            'label' => 'Бонусы'
                        ),
                        'class' => 'item_3'
                    ),
                    array(
                        'value' => array(
                            'value' => 'link_visit',
                            'label' => 'Регистрация'
                        ),
                        'button_text' => 'Перейти',
                        'class' => 'item_last bright'
                    ),
                );
            } else {
                $th = array(
                    array(
                        'value' => 'Компания',
                        'class' => 'item_first'
                    ),
                    array(
                        'value' => 'Бонусы',
                        'class' => 'item_2'
                    ),
                    array(
                        'value' => 'Обзор',
                        'class' => 'item_3 hideme1'
                    ),
                    array(
                        'value' => 'Регистрация',
                        'class' => 'item_last bright'
                    ),
                );
                $row = array(
                    array(
                        'value' => array(
                            'value' => 'name',
                            'label' => 'Компания'
                        ),
                        'class' => 'item_first'
                    ),
                    array(
                        'value' => array(
                            'value' => 'bonus',
                            'label' => 'Бонусы'
                        ),
                        'class' => 'item_2 blueh'
                    ),
                    array(
                        'value' => array(
                            'value' => 'link_review',
                            'label' => 'Обзор'
                        ),
                        'class' => 'item_3 hideme1'
                    ),
                    array(
                        'value' => array(
                            'value' => 'link_visit',
                            'label' => 'Регистрация'
                        ),
                        'button_text' => 'Перейти',
                        'class' => 'item_last bright'
                    ),
                );
            }
        }


        $table_head = '';
        foreach($th as $item) {
            //print_r($item);
            if(!$item['sort']) {
                $sort = ' sorter-false';
            } else {
                $sort = '';
            }
            $table_head .= '<th class="'.$item['class'].$sort.'">';
            $table_head .= $item['value'];
            $table_head .= '</th>';
        }
        if($er_tags[4]) {
            //print_r($er_tags);
            if (!isset($_REQUEST['search_submit_company'])) {
                //print_r($_REQUEST);
                if($er_tags[6] == 1) {
                   // $result .= loop_search_er($er_tags[5], false,'');
                    //$result .= '<div id="new_table_search"></div>';
                }
            }
            //$result .= '<script src="'.get_bloginfo('template_url').'/js/jquery.tablesorter.js"></script>';
            //$result .= '<script>';
            //$result .= 'jQuery(document).ready(function($){';
            //$result .= '$(".sortable_table").tablesorter();';
            //$result .= '$(".er_search_box").appendTo("#new_table_search");';
            //$result .= '});';
            //$result .= '</script>';
            $result .= '<div class="tablewrapper"><div class="tablewrapper-ins"><table cellpadding="3"  cellspacing="0" class="comptable er_newtable renewed sortable_table full_table ratetable-'.get_the_id().'" align="center" id="table_'.$er_tags[5].'">';

        } else {
            $result .= '<table cellpadding="3" cellspacing="0" class="comptable er_newtable renewed ratetable-'.get_the_id().'" align="center">';
        }

        $result .= '<thead><tr>';
        $result .= $table_head;
        $result .= '</tr></thead>';
        $x=0;
        while ( $er_posts->have_posts() ) {
            $er_posts->the_post();
            $x++;
            $the_field = '';
            if($x % 2 == 0){
                $oddeven = 'even';
            }
            else{
                $oddeven = 'odd';
            }
            $result .= '<tr id="row_'.$x.'" class="'.$oddeven.'">';
            foreach($row as $item) {

                if($er_tags[4] && $item['value']['value'] == 'information') {
                    
                    $information_class = ' company_info';
                } else {
                    $information_class = '';
                }
                $result .= '<td class="'.$item['class'].$information_class.' '.$item['value']['value'].'">';
                if ($item['value']['value'] == 'information') {
                    //echo '<pre>';
                    //print_r($item);
                    //echo '</pre>';
                    if($item['information_fields']) {
                        foreach ($item['information_fields'] as $it) {
                            if(information_field($it['value'],get_the_ID())) {
                                $result .= '<div>'.$it['label'].': <strong>';
                                $result .= information_field($it['value'],get_the_ID());
                                $result .= '</strong></div>';
                            }
                        }
                    }
                } elseif($item['value']['value'] == 'name' && $er_tags[4]) {

                    $result .= '<div class="er_order_number">'.$x.'</div>';

                    $item['value']['value'] = 'name_full';
                    $result .= brokers_field_new($item,get_the_ID(),$the_field);
                } else {
                    $result .= brokers_field_new($item,get_the_ID(),$the_field);
                }
                $result .= '</td>';
            }
            $result .= '</tr>';


        }
        if($er_tags[4]) {
            $result .= '</table><div class="navtab"></div></div></div>';
        } else {
            $result .= '</table>';
        }

    }
    wp_reset_postdata();
    return $result;
}
function brokers_field_new($item,$post_id,$the_field) {
    $result = '';
    $yes = __('Да','sa_theme');
    $no = __('Нет','sa_theme');
    $na = __('N/A','sa_theme');
    $free = __('Бесплатно','sa_theme');
    $field_id = $item['value']['value'];
    //$result .= $field_id.'<br />';

    if($field_id == 'link_review') {
        if($item['button_text']) {
            $text = $item['button_text'];
        } else {
            $text = __('Обзор','sa_theme');
        }
        $link = get_the_permalink($post_id);
        $result .= '<a href="'.$link.'">'.$text.'</a>';
    } elseif($field_id == 'name') {
        /* $item = get_field('company_logo')['url'];
        $link = get_the_permalink($post_id);
        $result .= '<div class="er_company_name"><a target="_blank" class="er_table_title_link" href="'.$link.'" style="background-image:url('.$item.')"></a></div>';
   */
        $logo = get_field('company_icon',$post_id)['url'];
        if(!$logo) {
            $logo = get_field('company_logo',$post_id)['url'];
        }
        $company_name = get_field('company_name',$post_id);
        $link = get_bloginfo('url').'/visit/'.get_field('company_redirect_key',$post_id).'/';
        $company_link = get_the_permalink($post_id);
        $er_company_site_str = get_field('websites',$post_id)[0]['site_url'];
        $er_company_site_str_2 = preg_replace('#^[^:/.]*[:/]+#i', '', $er_company_site_str);
        $site = preg_replace('/^www\./', '', rtrim($er_company_site_str_2,'/'));
        $established = get_field('company_established',$post_id);

        $result .= '<div class="er_company_name_img"><a class="er_table_title_link" href="'.$company_link.'" style="background-image:url('.$logo.')" rel="nofollow"></a></div>';
        if($company_name || $site) {
            $result .= '<div class="er_table_name_site">';
            if ($company_name) {
                $result .= '<a class="er_table_title_name" href="'.$company_link.'">' . $company_name . '</a>';
            }
            if ($site) {
                $result .= '<div class="er_table_title_site">';
                $result .= '<a href="' . $link . '" target="_blank" rel="nofollow">' . $site . '</a>';
                $result .= '</div>';
            }
            $result .= '</div>';
        }
    } elseif($field_id == 'name_full') {
        $logo = get_field('company_icon',$post_id)['url'];
        if(!$logo) {
            $logo = get_field('company_logo',$post_id)['url'];
        }
        $company_name = get_field('company_name',$post_id);
        $link = get_bloginfo('url').'/visit/'.get_field('company_redirect_key',$post_id).'/';
        $company_link = get_the_permalink($post_id);
        $er_company_site_str = get_field('websites',$post_id)[0]['site_url'];
        $er_company_site_str_2 = preg_replace('#^[^:/.]*[:/]+#i', '', $er_company_site_str);
        $site = preg_replace('/^www\./', '', rtrim($er_company_site_str_2,'/'));
        $established = get_field('company_established',$post_id);

        $result .= '<div class="er_company_name_img"><a class="er_table_title_link" href="'.$company_link.'" style="background-image:url('.$logo.')" rel="nofollow"></a></div>';
        if($company_name || $site) {
            $result .= '<div class="er_table_name_site">';
            if ($company_name) {
                $result .= '<a class="er_table_title_name" href="'.$company_link.'" >' . $company_name . '</a>';
            }
            if ($site) {
                $result .= '<div class="er_table_title_site">';
                $result .= '<a href="' . $link . '" target="_blank" rel="nofollow">' . $site . '</a>';
                $result .= '</div>';
            }
            $result .= '</div>';
        }
    } elseif($field_id == 'bonus') {
        $item = get_field_object('base_2_bonuses',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $no;
        }

    } elseif($field_id == 'api') {
        $item = get_field_object('api_integration',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'min_dep') {
        $item = get_field_object('min_dep',$post_id);
        $result_print = repeater_fields($item,'rating');
        if($result_print && $result_print != '<div class="repeater_field repeater_fromto item_single min_dep">N/A</div>') {
            $result .= $result_print;
        } else {
            $result .= __('От','er_theme').' 1 USD';
        }

    } elseif($field_id == 'pros') {
        $item = get_field_object('pros',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'card_price_issue') {
        $item = get_field_object('card_issue_price',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'spreads') {
        $item = get_field_object('base_2_spreads',$post_id);
        if(simple_field($item['type'],$item,'rating')) {
            $result .= simple_field($item['type'],$item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'loan_sum') {
        $item = get_field_object('loan_max',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'loan_term') {
        $item = get_field_object('loan_length',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'lending_rate') {
        $item = get_field_object('loan_rate',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'credit_sum') {
        $item = get_field_object('loan_sum',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'credit_percent') {
        $item = get_field_object('percent_on_loan',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'card_cashback') {
        $item = get_field_object('cashback',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'commission_aquiring') {
        $item = get_field_object('aquiring_commission',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'money_trransfer') {
        $item = get_field_object('money_transfer_speed',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'connect_cost') {
        $item = get_field_object('account_opening_price',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'open_account_cost') {
        $item = get_field_object('account_opening_price',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'card_percent_capital') {
        $item = get_field_object('percent_on_capital',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'orders_proceed_speed') {
        $item = get_field_object('application_processing_speed',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'credit_term') {
        $item = get_field_object('loan_length_credit',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'monthly_payment') {
        $item = get_field_object('minimum_monthly_payment_card',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'credit_light_term') {
        $item = get_field_object('grace_period',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'transaction_speed') {
        $item = get_field_object('card_transfer_speed',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'actives') {
        $item = get_field_object('count_assets',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'insurance_programms') {
        $item = get_field_object('count_insurance_programms',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'fiat') {
        $item = get_field_object('exchange_for_fiat_currencies',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'project_features') {
        $item = get_field_object('project_details',$post_id);
        if(simple_field($item['type'],$item,'rating')) {
            $result .= simple_field($item['type'],$item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'courses_categories') {
        $item = get_field_object('cources_categories',$post_id);
        if(simple_field($item['type'],$item,'rating')) {
            $result .= simple_field($item['type'],$item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'earn_methods') {
        $item = get_field_object('earn_methods',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'services_plus') {
        $item = get_field_object('services_plus',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'services') {
        $item = get_field_object('services',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'rating') {
        $item = get_field_object('total_score',$post_id);
        if(simple_field($item['type'],$item,'rating')) {
            $result .= simple_field($item['type'],$item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'address') {

    } elseif($field_id == 'age') {
        $item = get_field_object('age_restrictions',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'delivery_hours') {
        $item = get_field_object('company_hours_delivery',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'min_order') {
        $item = get_field_object('delivery_min_order',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'deposit_term') {
        $item = get_field_object('invest_work_terms',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }

    } elseif($field_id == 'payout_term') {
        $item = get_field_object('payout_terms',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'storage') {
        $item = get_field_object('safe_term',$post_id);
        $result .= repeater_fields($item,'rating');
        $item2 = get_field_object('safe_rules',$post_id);
        $result .= simple_field($item2['type'],$item2,'rating');
    } elseif($field_id == 'application_processing') {
        $item = get_field_object('application_processing_speed',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'exchange_directions') {
        $item = get_field_object('number_of_exchange_directions',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'bet_points') {
        $item = get_field_object('bet_points_count',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'deposit_limit') {
        $item = get_field_object('income_min_limit',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'withdrawal_limit') {
        $item = get_field_object('outcome_max_limit',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'sales_ammount') {
        $item = get_field_object('trading_volume_day',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }


    } elseif($field_id == 'payout') {
        $item = get_field_object('payouts',$post_id);
        if(repeater_fields($item,'rating')) {
            $result .= repeater_fields($item,'rating');
        } else {
            $result .= $na;
        }
    } elseif($field_id == 'link_visit') {
        if($item['button_text']) {
            $text = $item['button_text'];
        } else {
            $text = __('Перейти','sa_theme');
        }
        if( wp_is_mobile() ) {
            //$bonuses = get_field_object('base_2_bonuses',$post_id);
            //$result .= repeater_fields($bonuses,'rating');
        }
        $link = get_bloginfo('url').'/visit/'.get_field('company_redirect_key',$post_id).'/';
        $result .= '<a href="'.$link.'" target="_blank" rel="nofollow" class="visit">'.$text.'</a>';
       /* if($item['review_link']) {
            $result .= '<a href="'.get_the_permalink($post_id).'" target="_blank" rel="nofollow">'.__('Обзор','er_theme').'</a>';
        }*/


    } else {
        $item = get_field_object($field_id,$post_id);
        if(in_array($item['type'],array('repeater'))) {
            if(repeater_fields($item,'rating')) {
                $result .= repeater_fields($item,'rating');
            } else {
                $result .= $na;
            }
        } elseif(in_array($item['type'],array('taxonomy','date_picker','text','textarea','range'))) {
            if(simple_field($item['type'],$item,'rating')) {
                $result .= simple_field($item['type'],$item,'rating');
            } else {
                $result .= $na;
            }
        }
    }
    return $result;
}
function information_field($field_id,$post_id) {
    $result = '';
    //$result .= $field_id.' '.$post_id;
    if($field_id == 'orders') {
        $item = get_field_object('order_types_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'liquidity') {
        $item = get_field_object('liquidity_providers_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'terminals') {
        $item = get_field_object('terminals_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'main_office') {
        $item = get_field_object('company_main_office',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'languages') {
        $item = get_field_object('languages_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'game_publisher') {
        $item = get_field_object('game_publisher',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'owner') {
        $item = get_field_object('company_owner',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'main_office_manufacturer') {
        $item = get_field_object('company_main_office_manufacturer',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'wmid') {
        if(get_field('webmoney_wmid',$post_id)) {
            $item = get_field_object('webmoney_wmid',$post_id);

            $result .= simple_field($item['type'],$item,'rating');
        }
    } elseif($field_id == 'bl') {
        if(get_field('webmoney_bl',$post_id)) {
            $item = get_field_object('webmoney_bl',$post_id);
            $result .= simple_field($item['type'],$item,'rating');
        }
    } elseif($field_id == 'delivery_features') {
        $item = get_field_object('delivery_details',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'stocks') {
        $item = get_field_object('fonds_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'regions') {
        $item = get_field_object('project_regions',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'project_features') {
        $item = get_field_object('project_details',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'reestr_number') {
        $item = get_field_object('register_number',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'card_type') {
        $item = get_field_object('cardd_type',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'game_genre') {
        $item = get_field_object('game_genre',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'game_type') {
        $item = get_field_object('game_type',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'option_types') {
        $item = get_field_object('option_types_list',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'kitchen_types') {
        $item = get_field_object('kitchen_types',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'accept_orders') {
        $item = get_field_object('accept_applications',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'ibank') {
        $item = get_field_object('online_banking',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'pay_by_phone') {
        $item = get_field_object('pay_by_phone',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'free_delivery_terms') {
        $item = get_field_object('delivery_free_terms',$post_id);
        $result .= repeater_fields($item,'rating_info_fromto');
    } elseif($field_id == 'age') {
        $item = get_field_object('age_restrictions',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'first_loan') {
        $item = get_field_object('loan_first',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'docs') {
        $item = get_field_object('documents_list',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'issue') {
        $item = get_field_object('account_opening_price',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'forbusiness_loans') {
        $item = get_field_object('business_loans',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'reissue') {
        $item = get_field_object('card_reissue_price',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'insurance') {
        $item = get_field_object('loan_insurance',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'cryptocurrencies') {
        $item = get_field_object('number_of_cryptocurrencies',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'support') {
        $item = get_field_object('base_2_support',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'licenses') {
        $item = get_field_object('base_2_licenses',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'laws') {
        $item = get_field_object('controllers_laws',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'demo') {
        $item = get_field_object('free_demo',$post_id);
        $result .= repeater_fields($item,'rating');
    } elseif($field_id == 'partners') {
        $item = get_field_object('affiliate_program',$post_id);
        $result .= repeater_fields($item,'rating_yes_link');
    } elseif($field_id == 'owner') {
        $item = get_field_object('company_owner',$post_id);
        $result .= simple_field($item['type'],$item,'rating');
    } elseif($field_id == 'regulators') {
        $item = get_field_object('regulators_list',$post_id);
        $result .= repeater_fields($item,'rating');
    } else {
        $item = get_field_object($field_id,$post_id);
        if(in_array($item['type'],array('repeater'))) {
            $result .= repeater_fields($item,'rating');
        } elseif(in_array($item['type'],array('taxonomy','date_picker','text','textarea','range'))) {
            $result .= simple_field($item['type'],$item,'rating');
        }
    }
    return $result;
}

?>