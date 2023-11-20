<?php

if(!function_exists('tag_filters')) {
    function tag_filters($tag) {
        $filters = get_field('tags_filter_fields','term_'.$tag);
       // echo '<pre>';
        //print_r($filters);
       // echo '</pre>';
        $tag_filters = array();
        $x = 0;
        if(!empty($filters)) {
            foreach ($filters as $item) {
                $tag_filters[$x] = array(
                    'field_name' => $item['td_term']->slug
                );
                if($item['placeholder']) {
                    $tag_filters[$x]['placeholder'] = 1;
                }
                if($item['td_name'] && $item['td_name'] != '') {
                    $tag_filters[$x]['title'] = $item['td_name'];
                } else {
                    $tag_filters[$x]['title'] = $item['td_term']->name;
                }
                $key = get_field('key','term_'.$item['td_term']->term_id);
                if($key && $key != '') {
                    $tag_filters[$x]['key'] = $key;
                    $field = get_field_object($key);
                   /* echo '<pre>';
                    print_r($field);
                    echo '</pre>';*/
                    $type = $field['type'];
                    $class = $field['wrapper']['class'];
                    $subfields = $field['sub_fields'];
                    $taxonomy = $field['taxonomy'];
                    if($class && $class != '') {
                        $tag_filters[$x]['class'] = $class;
                    }
                    if($type && $type != '') {
                        $tag_filters[$x]['type'] = $type;
                        if($type == 'taxonomy') {
                            $tax_style = $field['field_type'];
                            if($tax_style && $tax_style != '') {
                                $tag_filters[$x]['tax_style'] = $tax_style;
                            }
                        }
                    }
                    if($taxonomy && $taxonomy != '') {
                        $tag_filters[$x]['taxonomy'] = $taxonomy;

                    }
                    if($key == 'system') {
                        $tag_filters[$x]['type'] = 'system';
                    }
                }


                $x++;
            }
        }
       /* echo '<pre>';
        print_r($tag_filters);
        echo '</pre>';
        echo '<br />';
        echo '<br />';
        echo '<br />';*/
        $result = '';
        $y = 0;
        if(!empty($tag_filters)) {
            $result .= '<form id="main_filter">';
            $result .= '<ul class="filter_tags">';
            foreach ($tag_filters as $tag_filter) {
                $y++;
                $result .= filter_field($tag_filter, $y, 'main_filter');
            }
            $result .= '</ul>';
            $result .= '<input class="button button_green button_big button_big_padding m_r_auto pointer" type="submit" value="'.__('Отфильтровать','er_theme').'" />';
            $result .= '</form>';
        }
        return $result;
    }
}

if(!function_exists('filter_field')) {
    function filter_field($field,$number,$id) {
       // echo '<pre>';
        // //print_r($field);
       // echo '</pre>';
        $result = '';
        $field_id = $id.'_'.$number;
        $result .= '<li>';
        if($field['placeholder']) {
            $placeholder = ' placeholder="'.$field['title'].'"';
        } else {
            $placeholder = '';
            $result .= '<label for="'.$field_id.'">';
            $result .= '<span class="field_title">'.$field['title'].'</span>';
            $result .= '</label>';
        }

        if($field['type'] == 'text') {
            $result .= '<input class="filter_field_text" id="'.$field_id.'" type="text" name="'.$field['field_name'].'"'.$placeholder.' />';
        } elseif($field['type'] == 'taxonomy') {
            $result .= '<div class="filter_field_select_tax dropdown inactive" data-taxonomy="'.$field['taxonomy'].'" id="filter_field_leverage_'.$field_id.'">';
            $result .= '<span class="field_title">'.$field['title'].'</span>';
            $result .= '<input class="" id="'.$field_id.'"  type="hidden" name="'.$field['field_name'].'" />';
            $result .= '</div>';

        } elseif($field['type'] == 'repeater') {
            if($field['class'] == 'leverage') {
                $result .= '<input class="filter_field_leverage" id="'.$field_id.'" type="text" name="'.$field['field_name'].'"'.$placeholder.' />';
            } elseif($field['class'] == 'repeater_fromto') {
                $result .= '<input class="filter_field_fromto" id="'.$field_id.'" type="text" name="'.$field['field_name'].'"'.$placeholder.' />';
            } elseif($field['class'] == 'repeater_yesno_demo') {
                $result .= '<input class="filter_field_checkbox custom-checkbox" id="'.$field_id.'" type="checkbox" name="'.$field['field_name'].'" value="" />';
                $result .= '<label for="'.$field_id.'">';
                $result .= '<span class="field_title">'.$field['title'].'</span>';
                $result .= '</label>';
            }
        } elseif($field['type'] == 'system') {
            if($field['field_name'] == 'system_rating') {
                $result .= '<input class="filter_field_rating" id="'.$field_id.'" type="text" name="'.$field['field_name'].'"'.$placeholder.' />';
            }
        }
        $result .= '</li>';
        return $result;
    }
}

if (!function_exists('show_more_filter')) {
    add_action('wp_ajax_show_more_filter', 'show_more_filter');
    add_action('wp_ajax_nopriv_show_more_filter', 'show_more_filter');
    function show_more_filter() {
        $result = '';
        $tag = $_POST['tag'];
        $result .= tag_filters($tag);
        echo $result;
        die;
    }
}


if (!function_exists('ajax_load_list')) {
    add_action('wp_ajax_ajax_load_list', 'ajax_load_list');
    add_action('wp_ajax_nopriv_ajax_load_list', 'ajax_load_list');
    function ajax_load_list() {
        $terms = get_terms( [
            'taxonomy' => $_POST['taxonomy'],
            'hide_empty' => false,
        ] );
        $result = '';
       // print_r($terms);
        if(!empty($terms)) {
            $result .= '<ul class="taxonomy_field_terms">';
            foreach ($terms as $term) {
                if(get_field('tag_hide_from_list','term_'.$term->term_id)) {

                } else {
                    $result .= '<li data-term-id="' . $term->term_id . '">';
                    $result .= $term->name;
                    $result .= '</li>';
                }
            }
            $result .= '</ul>';
        }
        echo $result;
        die;
    }
}

?>