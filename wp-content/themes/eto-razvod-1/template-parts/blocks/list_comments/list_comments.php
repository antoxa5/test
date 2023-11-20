<?php
/**
 * List Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_comments-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
if(get_field('title_tag')) {
    $title_tag = get_field('title_tag');
} else {
    $title_tag = 'div';
}
if(get_field('description_tag')) {
    $description_tag = get_field('description_tag');
} else {
    $description_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_comments';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$title = get_field('title');
$description = get_field('description');
$style = get_field('style');
$comment_type = get_field('comment_type');

$result = '';
wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' background_light">';
	if($title) {
		$result .= '<'.$title_tag.' class="block_title font_new_medium_2 line_big font_bold color_dark_blue  text_centered m_b_5">'.$title.'</'.$title_tag.'>';
	}
	if($description) {
		$result .= '<'.$description_tag.' class="block_description line_big color_darker_gray  text_centered m_b_40">'.$description.'</'.$description_tag.'>';
	}

    $current_language = get_locale();

if($current_language != 'ru_RU') {

    $posts_in_language_args = array(
        'post_type' => 'casino',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'enable_translations',
                'value' => $current_language,
                'compare' => 'LIKE'
            )
        )

    );
    $posts_in_language = new WP_Query($posts_in_language_args);
    wp_reset_postdata();
    $post_ids_lang = wp_list_pluck( $posts_in_language->posts, 'ID' );
    $post_ids_lang_string = implode( ',', $post_ids_lang );
    //$result .= $posts_in_language->found_posts;

    //$result .= $current_language;
   // $result .= $post_ids_lang_string;
    global $wpdb;
    $sql = "SELECT comment_ID, comment_date, comment_content, comment_post_ID
         FROM {$wpdb->comments} WHERE
         comment_post_ID in (".implode(',', $post_ids_lang).") AND comment_approved = 1
         ORDER by comment_date DESC LIMIT 1";

    $comments_list = $wpdb->get_results( $sql );
    //echo count($comments_list);
    //print_r($comments_list);
    $comments = $comments_list;
} else {

    $args = array(
        'number' => 10,
        'status' => 'approve',
        //'orderby'=>'comment_date',
        //'order'=>'DESC'
    );
    if ($comment_type && $comment_type != '') {
        if ($comment_type == 'reviews') {
            $args['meta_query'] = array(
                'relation' => 'AND',
                array(
                    'key' => 'comment_type',
                    'value' => 'reviews',
                    'compare' => '=',
                ),
            );
        } elseif ($comment_type == 'abuses') {
            $args['meta_query'] = array(
                'relation' => 'AND',
                array(
                    'key' => 'is_abuse',
                    'value' => 1,
                    'compare' => '=',
                ),
            );
        }
    }
    $comments = get_comments($args);
}

    $result .= '<ul class="comments_widget_show" style="display: none">';
    foreach ($comments as $comment) {
        if($current_language != 'ru_RU') {
            $translations = get_field('comment_translations','comment_'.$comment->comment_ID);
            $comm_content = $translations[0]['translation'];
        } else {
            $comm_content = $comment->comment_content;
        }
        $result .= '<li>';
        $result .= '<div class="comment_text color_dark_blue">'.wp_trim_words($comm_content,15).'</div>';
        $result .= '</li>';
    }
    $result .= '</ul>';
    $result .= '
    <script type="text/javascript">
    $ = jQuery.noConflict();
    function list_comments_ajax_widget() {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=list_comments_ajax_widget&comment_type='.$comment_type.'",
            beforeSend: function(xhr) {
    
            },
            success: function( data ) {
                //console.log(data);
                $("#'.esc_attr($id).' .comments_widget").empty();
                $("#'.esc_attr($id).'").append(data);
            }
        });
    }
    jQuery(document).ready(function($){
        list_comments_ajax_widget();
    });
    </script>
    ';
/*
	$result .= '<ul class="comments_widget">';
$count_o_v = 0;
$count_o_v_2 = 0;
$m = 0;
	foreach ($comments as $comment) {
		$total_rating_value = '';
		$data_percent = 0;
		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($comment->comment_post_ID);
		} else {
			$rating_fields_group = 0;
		}
		$rating_fields = get_comment_rating_fields($rating_fields_group,'key');
		if(!empty($rating_fields)) {
			$total_rating = get_comment_rating_values($rating_fields,$comment,'total');
			$total_rating_value = 5 / 100 * $total_rating;
			$data_percent = $total_rating / 100;
			if ( $total_rating >= 70 ) {
				$rating_color = 'green';
				$data_color = '#21B67B';
			} elseif ( $total_rating >= 40 && $total_rating < 70 ) {
				$rating_color = 'normal';
				$data_color = '#001640';
			} elseif ( $total_rating < 40 ) {
				$rating_color = 'red';
				$data_color = '#fc0100';
			}
		}
		$count_o_v++; $oddEven = ($count_o_v % 2) ? 'odd':'even';
		$count_o_v_2++; $oddEven_2 = ($count_o_v_2 % 3) ? 'third':'third';
		
		if ($m < 2) {
            $new_o_v = 'new_odd';
        } elseif ( ($m > 1) && ($m < 4) ) {

            $new_o_v = 'new_even';
        } 


		$m = ++$m;
		if ($m == 4) {
			$m = 0;
		} 
		$result .= '<li class="white_block '.$new_o_v.'">';

	  $comment_author = get_userdata( $comment->user_id );
	  if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
		$pubprofile = ' data-pub="1" ';
	  } else {
		$pubprofile = '';
	  }


		$result .= '<div class="comment-body body_'.$comment->comment_ID.'" data-body-id="body_'.$comment->comment_ID.'">';
		$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
		$result .= '<div class="comment_header">';
		$result .= '<div class="comment_avatar"';
		if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { $result .= 'style="background-image: url('.$attachment_id['sizes']['thumbnail'].')"'; };
		$result .= ' '.$pubprofile.' data-link="https://etorazvod.ru/user/'.$comment_author->user_nicename.'/">';
		if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { $result .= '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; };
		$result .= '</div>';	
		if($comment_author->first_name && !$comment_author->last_name) { 
			$author_name = $comment_author->first_name; 
		} elseif(!$comment_author->first_name && $comment_author->last_name) { 
			$author_name = $comment_author->last_name; 
		} elseif($comment_author->first_name && $comment_author->last_name) { 
			$author_name = $comment_author->first_name.' '.$comment_author->last_name; 
		} else {
			$author_name = $comment_author->user_nicename; 
		} 
		
		if($total_rating_value != '') {
			$result .= '<div class="review_average_round progress small '.$rating_color.'" id="comment_rating_total_'.$comment->comment_ID.'" data-percent="'.$data_percent.'" data-color="'.$data_color.'">';
				$result .= '<div class="inner color_dark_blue font_bold font_small pointer">'.round($total_rating_value,1).'</div>';
			$result .= '</div>';
		}
			$result .= '<div class="comment_rate" id="rate-comment-'.$comment->comment_ID.'">';
				$result .= '<span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id='.$comment->comment_ID.'></span>';
				$comment_rate = get_field('comment_rate', $comment);
				if(!$comment_rate) {
					$comment_rate = 0;
				}
				if($comment_rate == 0) {
					$rate_number_class = 'neutral';
					$comment_rate_plus = '';
				} elseif($comment_rate > 0) {
					$rate_number_class = 'positive';
					$comment_rate_plus = '+';
				} elseif($comment_rate < 0) {
					$rate_number_class = 'negative';
					$comment_rate_plus = '';
				}
				$result .= '<div class="rate_number_container"><span class="rate_number '.$rate_number_class.'">'.$comment_rate_plus.$comment_rate.'</span></div>';
				$result .= '<span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id='.$comment->comment_ID.'></span>';
			$result .= '</div>';
		$result .= '</div>';
		$comment_post_id = $comment->comment_post_ID ;
		$result .= '<div class="font_smaller color_dark_gray comment_meta ">';
		$result .= '<span class="comment-author font_bold color_dark_blue" '.$pubprofile.' data-link="'.get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/">'.$author_name.'</span>';
		if($comment_type == 'abuses') {
			$result .= ' '.__('написал(а) жалобу на компанию').' ';
		} else {
			$result .= ' '.__('написал(а) отзыв к компании').' ';
		}
		$result .= '<a class="comment-post-link color_dark_blue font_bold" href="'.get_permalink($comment_post_id).'#comment-'.$comment->comment_ID.'" target="_blank">'.get_field('company_name',$comment_post_id).'</a>';

		$a = human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comment->comment_ID)), current_time( 'timestamp' ) );
		if (mb_strpos($a, 'месяц') !== false) {
			$result .= ' <span data-id="44" class="comment-date">'.intval($a).' '.counted_text($a,__('месяц','er_theme'),__('месяца','er_theme'),__('месяцев','er_theme')).' '.__( 'назад' ).'</span>';
		} else {
			$result .= ' <span data-id="14"  class="comment-date">'.human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comment->comment_ID)), current_time( 'timestamp' ) ).' '.__( 'назад' ).'</span>';
		}

		$result .= '</div>';
		if($new_o_v == 'new_odd') {
			$trim_number = 7;
		} else {
			$trim_number = 22;
		}
		$result .= '<div class="comment_text color_dark_blue">'.wp_trim_words($comment->comment_content,$trim_number).'</div>';
		$result .= '</div>';
		$result .= '</li>';
	}
	$result .= '</ul>';
	$result .= '<div class="button pointer button_violet radius_small button_padding_big font_small font_bold button_centered line_show_more_comments flex" data-height="850">'.__('Показать еще','er_theme').'</div>';
*/
    $result .= '</div>';
echo $result;
?>