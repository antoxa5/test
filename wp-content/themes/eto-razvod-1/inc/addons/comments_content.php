<?php

if(!function_exists('get_comment_current_content')) {
    function get_comment_current_content($comment_ID) {
        $result_array = array();
        $current_language = get_locale();
        $language_original = get_field('language_original','comment_'.$comment_ID);
        if(!$language_original || $language_original == '') {
            $language_original = 'ru_RU';
        }
        if($language_original == $current_language) {
            $result_array['available'] = 'yes';
            $comment = get_comment($comment_ID);
            $review_title = get_field('review_title', 'comment_' . $comment_ID);
            if($review_title && $review_title != '') {
                $result_array['title'] = $review_title;
            }
            $result_array['content'] = $comment->comment_content;
            $review_pluses = get_field('review_pluses','comment_'.$comment_ID);
            $review_minuses = get_field('review_minuses','comment_'.$comment_ID);
            if( is_array( $review_pluses ) && array_filter($review_pluses)) {
                foreach ($review_pluses as $item) {
                    if($item['text'] && $item['text'] != '') {
                        $result_array['pluses'][] = $item['text'];
                    }
                }
            }
            if( is_array( $review_minuses ) && array_filter($review_minuses)) {
                foreach ($review_minuses as $item) {
                    if($item['text'] && $item['text'] != '') {
                        $result_array['minuses'][] = $item['text'];
                    }
                }
            }


        } else {
            $translations = get_field('comment_translations','comment_'.$comment_ID);
            $comm_translations = array();
            $comm_translations = array();
            if(!empty($translations)) {
                foreach ($translations as $item) {
                   // print_r($item);
                    if($item['title'] && $item['title'] != '') {
                        $comm_translations[$item['language']]['title'] = $item['title'];
                    }
                    if($item['translation'] && $item['translation'] != '') {
                        $comm_translations[$item['language']]['content'] = $item['translation'];
                    }
                    if(!empty($item['pluses'])) {
                        foreach ($item['pluses'] as $plus) {
                            if($plus['text'] && $plus['text'] != '') {
                                $comm_translations[$item['language']]['pluses'][] = $plus['text'];
                            }
                        }
                    }
                    if(!empty($item['minuses'])) {
                        foreach ($item['minuses'] as $minus) {
                            if($minus['text'] && $minus['text'] != '') {
                                $comm_translations[$item['language']]['minuses'][] = $minus['text'];
                            }
                        }
                    }

                }
            }
            if(array_key_exists($current_language,$comm_translations)) {
                $result_array['title'] = $comm_translations[$current_language]['title'];
                $result_array['content'] = $comm_translations[$current_language]['content'];
                if(!empty($comm_translations[$current_language]['pluses'])) {
                    $result_array['pluses'] = $comm_translations[$current_language]['pluses'];
                }
                if(!empty($comm_translations[$current_language]['minuses'])) {
                    $result_array['minuses'] = $comm_translations[$current_language]['minuses'];
                }
                if($result_array['content'] && $result_array['content'] != '') {
                    $result_array['available'] = 'yes';
                }
                if($language_original == 'ru_RU' ) {
                    $translation_language = 'RU';
                } elseif($language_original == 'fr_FR' ) {
                        $translation_language = 'FR';
                } elseif($language_original == 'en_US' ) {
                    $translation_language = 'EN';
                } elseif($language_original == 'es_ES' ) {
                    $translation_language = 'ES';
                } elseif($language_original == 'de_DE' ) {
                    $translation_language = 'DE';
                }
                $result_array['translated_from'] = $translation_language;
            }
        }
        return $result_array;
    }
}

?>