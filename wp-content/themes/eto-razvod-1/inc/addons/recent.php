<?php

if(!function_exists('recent_viewed')) {
    function recent_viewed() {
        $result = '';
        if(isset($_COOKIE['recent_viewed'])) {
            $cookies = array_reverse(json_decode($_COOKIE['recent_viewed']));
            $x = 0;
            $result .= '<div class="recent_viewed">';
                $result .= '<div class="wrap flex">';
                    $result .= '<div class="recent_viewed_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Вы недавно смотрели','er_theme').'</div>';
                    $result .= '<ul class="flex">';
                    foreach($cookies as $post_id) {
                        if($x == 10) {
                            break;
                        }
                        $x++;
                        $result .= '<li>';
                        $result .= '<a href="'.get_the_permalink($post_id).'">'.review_logo($post_id).'</a>';
                        $result .= '</li>';
                    }
                    $result .= '</ul>';
                $result .= '</div>';
            $result .= '</div>';
        } else {
            $result = 'none';
        }
        return $result;
    }
}

if(!function_exists('recent_viewed_add')) {
    function recent_viewed_add($post_id) {
        //$result = '';
        if(!isset($_COOKIE['recent_viewed'])) {
            $cookies = array();
            $cookies[] = $post_id;
            $cookies_encoded = json_encode($cookies);
           // $result = 'set';
            setcookie('recent_viewed', $cookies_encoded, time()+172800, '/');
        } else {
            $cookies = json_decode($_COOKIE['recent_viewed']);
            //print_r($cookies);
            if(!in_array($post_id,$cookies)) {
                $cookies[] = $post_id;
                $cookies_encoded = json_encode($cookies);
              //  $result = 'added';
                setcookie('recent_viewed', $cookies_encoded, time()+172800, '/');
            } else {
              //  $result = 'exists';
            }

        }

        //return $result;
    }
}