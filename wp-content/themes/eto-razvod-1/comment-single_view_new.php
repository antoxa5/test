<?php
$comment_ID = get_query_var('comment_single_page_new');
$comment = get_comment($comment_ID);
//
/*$review_aff_tags_text = '';
$review_aff_tags = get_field('review_aff_tags',$comment->comment_post_ID);
foreach ($review_aff_tags  as $item ) {
	$tag_term = get_term( $item, 'affiliate-tags' );
	$tag = $tag_term->slug;
	$review_aff_tags_text .= $tag.',';
}
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' =>  rtrim($review_aff_tags_text, ", ")));
*/
get_header();

$comment_general_id = $comment_ID;
$recommend = get_field('review_recommend_friends','comment_'.$comment_ID);
$review_pluses = get_field('review_pluses','comment_'.$comment_ID);
$review_minuses = get_field('review_minuses','comment_'.$comment_ID);
$review_year = get_field('review_year','comment_'.$comment_ID);
$review_title = get_field('review_title','comment_'.$comment_ID);
$rating_service = get_field('rating_service','comment_'.$comment_ID);
$rating_team = get_field('rating_team','comment_'.$comment_ID);
$rating_quality = get_field('rating_quality','comment_'.$comment_ID);
$rating_price = get_field('rating_price','comment_'.$comment_ID);
$textfrompost = $comment->comment_content;
if(function_exists('get_rating_fields_group')) {
    $rating_fields_group = get_rating_fields_group($comment->comment_post_ID);
} else {
    $rating_fields_group = 0;
}

wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css', [], filemtime(TEMPLATEPATH . '/css/comments.css'));
wp_enqueue_script( 'ajax-comments', get_template_directory_uri() . '/js/ajax-comments.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/ajax-comments.js') );
wp_enqueue_script( 'heygo', get_template_directory_uri() . '/js/heygo.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/heygo.js') );
wp_enqueue_script( 'slider_new_comp', get_template_directory_uri() . '/js/slider_new_comp.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/slider_new_comp.js') );
//slider_new_comp.js
if (($comment->user_id == 31) || ($comment->user_id == 17)) {
	//print_r($comment->comment_post_ID);
if ( strstr( $textfrompost, '<a href' ) ) {
    $textfull = $comment->comment_content;
} else {


    $textfrompost = htmlspecialchars( $textfrompost );$textfrompost = trim(preg_replace('/(\r?\n){2,}/', ' ezTwoTab81939831 ', $textfrompost));$textfrompost = trim(preg_replace('/[\r\n]+/', ' ezOneTab81939831 ', $textfrompost));
    $textexplode  = explode( " ", $textfrompost );

    $regex = "((https?|ftp)\:\/\/)?";
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
    $regex .= "(\:[0-9]{2,5})?";
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

    $textfull      = '';
    $urlisnotempty = 0;
    foreach ( $textexplode as $key => $value ) {
        //echo strlen($value);
        /////////////////////////////////////////////////////////////////////////////
        $remove_go_from_text = rtrim( $value, "." );
        //echo strlen($remove_go_from_text);
        if ( strlen( $value ) == strlen( $remove_go_from_text ) ) {
            $strwithdot = '';
        } else {
            $strwithdot = '.';
        }
        /////////////////////////////////////////////////////////////////////////////
        $remove_go_from_text2 = rtrim( $remove_go_from_text, "!" );

        if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text ) ) {
            $strwithcomma = '';
        } else {
            $strwithcomma = '!';
        }
        /////////////////////////////////////////////////////////////////////////////
        $remove_go_from_text3 = rtrim( $remove_go_from_text2, "," );

        if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text3 ) ) {
            $strwithup = '';
        } else {
            $strwithup = ',';
        }
        /////////////////////////////////////////////////////////////////////////////
        //echo strlen($remove_go_from_text);

        if ( preg_match( "/^$regex$/", $remove_go_from_text3 ) ) {
            //if ($urlisnotempty != 1) {

            if ( strpos( $remove_go_from_text3, 'https://' ) !== false ) {
                $textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
            } elseif ( strpos( $remove_go_from_text3, 'http://' ) !== false ) {
                $textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
            } else {
                $textfull .= '<a href="https://' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
            }

            $urlisnotempty = 1;

            //} else {
            //  $textfull .= htmlspecialchars($value).' ';
            //}
        } else {
            $textfull .= htmlspecialchars( $value ) . ' ';
        }
    }
}
} else {
    $textfull = $comment->comment_content;
}
$textfull = trim(preg_replace('/ ezOneTab81939831 /', "\n", $textfull));
$textfull = trim(preg_replace('/ ezTwoTab81939831 /', "\n\n", $textfull));
$textfull = str_replace('amp;','',$textfull);
echo review_top($comment->comment_post_ID,'single_review_page');
echo 333;
?>
    <div class="review_page_main page_content page_container background_light review_container_actions visible" itemscope itemtype="https://schema.org/Review">
        <div class="wrap flex_wrap comment_single_page_view">

            <div class="container_left">
                <ul id="reviews">
           <!-- <div class="comment-wrapper__left">
                <div class="white_block">
                    <?php $comment_author = get_userdata( $comment->user_id );
                    $attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );

                    ?>
                    <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
                        $pubprofile = ' data-pub="1" ';
                    } else {
                        $pubprofile = '';
                    } ?>
                    <div class="comment_avatar pointer"  <?php echo $pubprofile; ?> data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
                    <div class="comment_author_wrapper m_b_5">
                        <?php if($comment->user_id) {?>
                            <?php $comment_author = get_userdata( $comment->user_id ); ?>
                            <span data-id="9" class="comment-author font_bold font_small color_dark_blue pointer" itemprop="author" data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { echo $comment_author->user_nicename; } ?></span>
                            <?php echo $labelpro; ?><?php echo $user_status_label; ?>
                        <?php }; ?>
                    </div>
                    <div class="date-line"><span class="comment_to_id color_dark_gray font_small"></span> <span class="comment-date font_smaller color_dark_gray date_abuse" itemprop="datePublished" content="<?php comment_date( 'Y-m-d',$comment->comment_ID ); ?>T<?php comment_date( 'H:i:s',$comment->comment_ID ); ?>+00:00" data-profile="<?php comment_date('j F Y',$comment->comment_ID) ?>"><?php comment_date( 'j F Y в H:i',$comment->comment_ID ); ?></span></div>

                    <?php

                    if(get_field('review_year','comment_'.$comment->comment_ID) && get_field('review_year','comment_'.$comment->comment_ID) != '' ) {?>
                        <span class="comment-date font_smaller color_dark_gray"><?php _e('Год использования:','er_theme'); ?> <span class="color_dark_blue font_bold"><?php echo get_field('review_year','comment_'.$comment->comment_ID); ?></span></span>
                    <?php }; ?>
                    <?php if(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'yes') { ?>
                        <div class="comment_recommend_yes color_dark_gray font_small "><?php _e('Рекомендую','er_theme'); ?></div>
                    <?php } elseif(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'no') { ?>
                        <div class="comment_recommend_no color_dark_gray font_small m_t_20"><?php _e('Не рекомендую','er_theme'); ?></div>
                    <?php } ?>
                </div>
                <div class="white_block">
                    <?php  ?>
                    <?php echo review_logo($comment->comment_post_ID);
                    $company_name = get_field('company_name',$comment->comment_post_ID);
                    if($company_name != '') {

                        echo '<a href="'.get_the_permalink($comment->comment_post_ID).'" target="_blank" class="color_dark_blue font_bold link_no_underline link_company_single_review">'.__('Отзыв на компанию','er_theme').' '.$company_name.'</a>';
                    }
                    ?>
                </div>
            </div>-->

                <li class="white_block comment comment_single_page" data-commentid="<?php echo $comment->comment_ID; ?>">
                    <div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>" data-set="<?php echo "'.get_the_permalink($comment->comment_post_ID).'comment-'.$comment->comment_ID.'/" ?>">
                    <div class="comment_single_header">

                        <div class="comment_meta">
                            <div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Organization" class="color_dark_gray comment_to_post_single font_normal color_dark_gray">
                                <?php _e('Отзыв о компании','er_theme'); ?> <a href="<?php echo get_the_permalink($comment->comment_post_ID); ?>" class="color_dark_blue link_no_underline hover_dark font_bold" target="_blank"><?php echo $company_name; ?></a>
                                <meta itemprop="name" content="<?php echo $company_name; ?>">
                            </div>
                        <div class="date-line"><span class="comment-date font_smaller color_dark_gray date_abuse" itemprop="datePublished" content="<?php comment_date( 'Y-m-d',$comment->comment_ID ); ?>T<?php comment_date( 'H:i:s',$comment->comment_ID ); ?>+00:00" data-profile="<?php comment_date('j F Y',$comment->comment_ID) ?>"><?php comment_date( 'j F Y в H:i',$comment->comment_ID ); ?></span>

                        <?php

                        if(get_field('review_year','comment_'.$comment->comment_ID) && get_field('review_year','comment_'.$comment->comment_ID) != '' ) {?>
                            <span class="comment-date font_smaller color_dark_gray">&bull; <?php _e('Год использования:','er_theme'); ?> <span class="color_dark_blue font_bold"><?php echo get_field('review_year','comment_'.$comment->comment_ID); ?></span></span>
                        <?php }; ?>
                        </div>
                    </div>

                        <?php
                        $total_rating = get_comment_rating_values(get_comment_rating_fields($rating_fields_group,'key'),$comment,'total');
                        $total_rating_value = 5 / 100 * $total_rating;
                        $data_percent = $total_rating / 100;
                        if ($total_rating != 0) {
                            if ( $total_rating >= 70 ) {
                                $rating_color = 'green';
                            } elseif ( $total_rating >= 40 && $total_rating < 70 ) {
                                $rating_color = 'orange';
                            } elseif ( $total_rating < 40 ) {
                                $rating_color = 'red';
                            }
                            ?>
                            <div  class="comment_total_rating" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating">
                                <div class="review_average_round progress small <?php echo $rating_color;?>" id="comment_rating_total_<?php echo $comment->comment_ID; ?>" data-percent="<?php echo $data_percent; ?>">
                                    <div class="inner color_dark_blue font_bold font_small pointer" itemprop="ratingValue"><?php echo round($total_rating_value,1); ?></div>

                                </div>
                                <meta itemprop="worstRating" content = "1" />
                                <meta itemprop="bestRating" content = "5" />
                            </div>

                        <?php };
                        ?>
                        <div class="comment_rate" id="rate-comment-<?php echo $comment->comment_ID; ?>">
                            <span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
                            <?php
                            $comment_rate = get_field('comment_rate', $comment);
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
                            ?>
                            <div class="rate_number_container"><span class="rate_number <?php echo $rate_number_class; ?>"><?php echo $comment_rate_plus.$comment_rate; ?></span></div>
                            <span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
                        </div>
                    </div>
                        <div class="comment_rating_details">
                            <?php echo get_comment_rating_values(get_comment_rating_fields($rating_fields_group,'key'),$comment,'list'); ?>
                        </div>
                        <?php
                        if($review_title && $review_title != '') {
                            $review_title = $review_title;
                        } else {
                            $review_title = wp_trim_words($comment->comment_content, 7,'');
                        }
                        $review_title_last = substr($review_title, -1);
                        if(in_array($review_title_last,array(',','.'))) {
                            $review_title = substr($review_title,0, -1);
                        } elseif(in_array($review_title_last,array('!','?','...'))) {
                            $review_title = $review_title;
                        } else {
                            $review_title = $review_title.'...';
                        }

                        echo '<h1 class="comment_single_title">'.$review_title.'</h1>'; ?>
                    <div class="comment_text comment_text_<?php echo $comment->comment_ID; ?>">
                        <div itemprop="reviewBody"><?php echo apply_filters('the_content', $textfull); ?></div><?php

                        $comment_files = get_field('comment_files','comment_'.$comment->comment_ID);
                        if(!empty($comment_files)) {
                            echo '<ul class="comment_attached_files_list">';
                            foreach ($comment_files as $file) {
                                $full = wp_get_attachment_image_url( $file['file'], 'full' );
                                $thumb = wp_get_attachment_image_url( $file['file'], 'thumbnail' );
                                if($file['file_type'] == 'url') {
                                    echo '<li><a href="'.$file['link'].'" style="background-image:url('.$thumb.');" class="youtube_link">';
                                    echo '</a></li>';
                                } else {
                                    echo '<li><a href="'.$full.'" style="background-image:url('.$thumb.');">';
                                    echo '</a></li>';
                                }
                            }
                            echo '</ul>';
                        }
                        $review_pluses = get_field('review_pluses','comment_'.$comment->comment_ID);
                        $review_minuses = get_field('review_minuses','comment_'.$comment->comment_ID);
                        if(array_filter($review_pluses) || array_filter($review_minuses)) {
                            $result_pluses = '';
                            $result_pluses .= '<div class="review_pluses_minuses flex flex_wrap m_t_15">';

                            if(array_filter($review_pluses)) {
                                $result_pluses .= '<div class="review_pluses_minuses_left">';
                                $result_pluses .= '<div class="plus_minus_title font_smaller_2 color_dark_blue font_uppercase font_bolder">'.__('Плюсы','er_theme').'</div>';
                                $result_pluses .= '<ul class="pluses">';
                                foreach ($review_pluses as $item) {
                                    if($item != '') {
                                        $result_pluses .= '<li>'.$item['text'].'</li>';
                                    }

                                }
                                $result_pluses .= '</ul>';
                                $result_pluses .= '</div>';
                            }
                            if(array_filter($review_minuses)) {
                                $result_pluses .= '<div class="review_pluses_minuses_right">';
                                $result_pluses .= '<div class="plus_minus_title font_smaller_2 color_dark_blue font_uppercase font_bolder">'.__('Минусы','er_theme').'</div>';
                                $result_pluses .= '<ul class="minuses">';
                                foreach ($review_minuses as $item) {
                                    if($item != '') {
                                        $result_pluses .= '<li>'.$item['text'].'</li>';
                                    }
                                }
                                $result_pluses .= '</ul>';
                                $result_pluses .= '</div>';
                            }
                            $result_pluses .= '</div>';
                            echo $result_pluses;
                        }

                        ?>
                    </div>
                    <div class="comment_single_footer">
                        <?php
                        $childcomments = get_comments(array(
                            //'post_id'   => get_the_ID(),
                            'status'    => 'approve',
                            'order'     => 'DESC',
                            'parent'    => $comment->comment_ID,
                        ));
                        $comment_replies = count($childcomments);
                        if (substr($comment_replies, -1) == 1) {
                            $comment_replies_text = __('ответ','er_theme');
                        } elseif(substr($comment_replies, -1) > 1 && substr($comment_replies, -1) < 5) {
                            $comment_replies_text = __('ответа','er_theme');
                        } else {
                            $comment_replies_text = __('ответов','er_theme');
                        }
                        if($comment_replies != 0) {
                            ?>
                            <div class="comment_reply_count dropdown flex color_dark_gray m_right_20 pointer inactive"><?php echo $comment_replies; ?> <?php echo $comment_replies_text; ?></div>
                        <?php }
                        ?>
                        <a rel="nofollow" data-user-id="<?php echo $comment->user_id; ?>" class="comment-reply-link color_dark_blue pointer inactive" data-commentid="<?php echo $comment->comment_ID; ?>" data-postid="<?php echo $comment->comment_post_ID; ?>" data-appendto="<?php comment_ID(); ?>"><?php _e('Ответить','er_theme'); ?></a>
                        <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
                            <span class="comment_permalink"></span>
                            <span class="comment_share"></span>
                        </div>
                        <?php if(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'yes') { ?>
                            <div class="comment_recommend_yes color_dark_gray font_small"><?php _e('Рекомендую','er_theme'); ?></div>
                        <?php } elseif(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'no') { ?>
                            <div class="comment_recommend_no color_dark_gray font_small"><?php _e('Не рекомендую','er_theme'); ?></div>
                        <?php } ?>
                    </div>
                    </div>
	                <?php $parentid = intval($comment->comment_ID);
	                /*$args_sorted_2 = get_comments(array(
		                'status'    => 'approve',
		                'order'     => 'DESC',
		                'parent'    => $parentid,
	                ));

	                echo '<ul class="children visible">';
	                wp_list_comments( array(
		                'callback' => 'custom_comment_single_profile',
		                'per_page' => -1,
		                'rating_fields' => get_comment_rating_fields(0,'key'),
	                ),$args_sorted_2);
	                echo '</ul>'; */
	                ?>
                </li>
                </ul>
                <?php
                $args_more = array(
                    'number' => 3,
                    'status' => 'approve',
                    'orderby'=>'comment_date',
                    'order'=>'DESC',
                    'post_id' => $comment->comment_post_ID,
                    'comment__not_in' => $comment->comment_ID,
                );

                $args_more['meta_query'] = array(
                    'relation'		=> 'AND',
                    array(
                        'key'	 	=> 'comment_type',
                        'value'	  	=> 'reviews',
                        'compare' 	=> '=',
                    ),
                );

                $comments_more = get_comments($args_more);
                $result = '';
                if(!empty($comments_more)) {
                    $result .= '<h2 class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30 m_t_20 single_comment_more_title">'.__('Еще отзывы о компании','er_theme').' '.$company_name.'</h2>';

                    $result .= '<ul class="comments_widget_single_review">';
                    foreach ($comments_more as $comm_more) {
                        $total_rating_value = '';
                        $data_percent = 0;
                        if (function_exists('get_rating_fields_group')) {
                            $rating_fields_group = get_rating_fields_group($comm_more->comment_post_ID);
                        } else {
                            $rating_fields_group = 0;
                        }
                        $rating_fields = get_comment_rating_fields($rating_fields_group, 'key');
                        if (!empty($rating_fields)) {
                            $total_rating = get_comment_rating_values($rating_fields, $comm_more, 'total');
                            $total_rating_value = 5 / 100 * $total_rating;
                            $data_percent = $total_rating / 100;
                            if ($total_rating >= 70) {
                                $rating_color = 'green';
                                $data_color = '#21B67B';
                            } elseif ($total_rating >= 40 && $total_rating < 70) {
                                $rating_color = 'normal';
                                $data_color = '#001640';
                            } elseif ($total_rating < 40) {
                                $rating_color = 'red';
                                $data_color = '#fc0100';
                            }
                        }
                        $count_o_v++;
                        $oddEven = ($count_o_v % 2) ? 'odd' : 'even';
                        $count_o_v_2++;
                        $oddEven_2 = ($count_o_v_2 % 3) ? 'third' : 'third';

                        if ($m < 2) {
                            $new_o_v = 'new_odd';
                        } elseif (($m > 1) && ($m < 4)) {

                            $new_o_v = 'new_even';
                        }


                        $m = ++$m;
                        if ($m == 4) {
                            $m = 0;
                        }
                        $result .= '<li class="white_block ' . $new_o_v . '">';

                        $comment_author = get_userdata($comm_more->user_id);
                        if (get_field('pub_profile', 'user_' . $comm_more->user_id) == 'yes') {
                            $pubprofile = ' data-pub="1" ';
                        } else {
                            $pubprofile = '';
                        }


                        $result .= '<div class="comment-body body_' . $comm_more->comment_ID . '" data-body-id="body_' . $comm_more->comment_ID . '" data-set="'.get_the_permalink($comm_more->comment_post_ID).'comment-'.$comm_more->comment_ID.'/">';
                        $attachment_id = get_field('photo_profile', 'user_' . $comm_more->user_id);
                        $result .= '<div class="comment_header flex flex_wrap">';
                        $result .= '<div class="comment_avatar"';
                        if ($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                            $result .= 'style="background-image: url(' . $attachment_id['sizes']['thumbnail'] . ')"';
                        };
                        $result .= ' ' . $pubprofile . ' data-link="https://etorazvod.ru/user/' . $comment_author->user_nicename . '/">';
                        if (is_registered_from_social($comm_more->user_id)['main'] && is_registered_from_social($comm_more->user_id)['main'] != 'none') {
                            $result .= '<div class="social_provider_registered ' . is_registered_from_social($comm_more->user_id)['main'] . '"></div>';
                        };
                        $result .= '</div>';
                        if ($comment_author->first_name && !$comment_author->last_name) {
                            $author_name = $comment_author->first_name;
                        } elseif (!$comment_author->first_name && $comment_author->last_name) {
                            $author_name = $comment_author->last_name;
                        } elseif ($comment_author->first_name && $comment_author->last_name) {
                            $author_name = $comment_author->first_name . ' ' . $comment_author->last_name;
                        } else {
                            $author_name = $comment_author->user_nicename;
                        }
                        $result .= '<div class="font_smaller color_dark_gray comment_meta ">';
                        if($comm_more->user_id != 0) {
                            $result .= '<span class="comment-author font_bold color_dark_blue" ' . $pubprofile . ' data-link="' . get_bloginfo('url') . '/user/' . $comment_author->user_nicename . '/">' . $author_name . '</span>';
                        } else {
                            $result .= '<span class="comment-author font_bold color_dark_blue">' . __('Анонимный пользователь','er_theme') . '</span>';
                        }
                        //$result .= '<span class="comment-author font_bold color_dark_blue" ' . $pubprofile . ' data-link="' . get_bloginfo('url') . '/user/' . $comment_author->user_nicename . '/">' . $author_name . '</span>';
	                    $a = human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comment->comment_ID)), current_time( 'timestamp' ) );
	                    if (mb_strpos($a, 'месяц') !== false) {
		                    $result .= ' <span data-id="44" class="comment-date do_not_translate_css_class">'.intval($a).' '.counted_text($a,'месяц','месяца','месяцев').' '.__( 'назад', 'er_theme' ).'</span>';
	                    } else {
		                    $result .= ' <span data-id="14"  class="comment-date do_not_translate_css_class">'.human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comment->comment_ID)), current_time( 'timestamp' ) ).' '.__( 'назад', 'er_theme' ).'</span>';
	                    }
                        $result .= '</div>';


                        if ($total_rating_value != '') {
                            $result .= '<div class="review_average_round progress small ' . $rating_color . ' comment_total_rating" id="comment_rating_total_' . $comm_more->comment_ID . '" data-percent="' . $data_percent . '" data-color="' . $data_color . '">';
                            $result .= '<div class="inner color_dark_blue font_bold font_small pointer">' . round($total_rating_value, 1) . '</div>';
                            $result .= '</div>';
                        }
                        $result .= '<div class="comment_rate" id="rate-comment-' . $comm_more->comment_ID . '">';
                        $result .= '<span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id=' . $comm_more->comment_ID . '></span>';
                        $comment_rate = get_field('comment_rate', $comm_more);
                        if (!$comment_rate) {
                            $comment_rate = 0;
                        }
                        if ($comment_rate == 0) {
                            $rate_number_class = 'neutral';
                            $comment_rate_plus = '';
                        } elseif ($comment_rate > 0) {
                            $rate_number_class = 'positive';
                            $comment_rate_plus = '+';
                        } elseif ($comment_rate < 0) {
                            $rate_number_class = 'negative';
                            $comment_rate_plus = '';
                        }
                        $result .= '<div class="rate_number_container"><span class="rate_number ' . $rate_number_class . '">' . $comment_rate_plus . $comment_rate . '</span></div>';
                        $result .= '<span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id=' . $comm_more->comment_ID . '></span>';
                        $result .= '</div>';
                        $result .= '</div>';
                        $comment_post_id = $comm_more->comment_post_ID;

                        if ($new_o_v == 'new_odd') {
                            $trim_number = 22;
                        } else {
                            $trim_number = 22;
                        }

                        $comm_more_review_title = get_field('review_title','comment_'.$comm_more->comment_ID);

                        if($comm_more_review_title && $comm_more_review_title != '') {
                            $comm_rev_title = $comm_more_review_title;
                        } else {
                            $comm_rev_title = wp_trim_words($comm_more->comment_content, 7,'');
                        }
                        $com_review_title_last = substr($comm_rev_title, -1);
                        if(in_array($com_review_title_last,array(',','.'))) {
                            $comm_rev_title = substr($comm_rev_title,0, -1);
                        } elseif(in_array($com_review_title_last,array('!','?','...'))) {
                            $comm_rev_title = $comm_rev_title;
                        } else {
                            $comm_rev_title = $comm_rev_title.'...';
                        }
                        $result .= '<h3 class="comment_single_title">'.$comm_rev_title.'</h3>';
                        $comm_rev_text = wp_trim_words($comm_more->comment_content, $trim_number,'');
                        $comm_rev_text_last = substr($comm_rev_text, -1);
                        if(in_array($comm_rev_text_last,array(',','!','?','...','.'))) {
                            $comm_rev_text = substr($comm_rev_text,0, -1);
                        }

                        $comm_rev_text .= '...';

                        $result .= '<div class="comment_text color_dark_blue">' . $comm_rev_text . ' <a href="'.get_the_permalink($comm_more->comment_post_ID).'comment-'.$comm_more->comment_ID.'/" class="color_dark_gray">'.__('Читать далее','er_theme').'</a></div>';

                        $result .= '</div>';
                        $result .= '</li>';

                    }
                    $result .= '</ul>';
                    echo $result;
                }


                $term_list = wp_get_post_terms( $comment->comment_post_ID, 'affiliate-tags', array('fields' => 'ids') );
                $paid_args_new = array(
                    'post_type' => 'casino',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                    'exclude'      => array($comment->comment_post_ID),
                    'post_status' => 'publish',
                    'meta_query'	=> array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'reviews_count_reviews',
                            'value'	  	=> 0,
                            'compare' 	=> '>',
                        ),
                    ),

                );
                if(!empty($term_list)) {
                    $paid_args_new['tax_query'] = array(
                        'relation' => 'OR',
                    );
                    foreach ($term_list as $term_list_item) {
                        $paid_args_new['tax_query'][] = array(
                            'taxonomy' => 'affiliate-tags',
                            'field'    => 'id',
                            'terms'    => $term_list_item,
                        );
                    }

                }
                $more_posts_similar = get_posts($paid_args_new);
                ///print_r($more_posts_similar);
                if(!empty($more_posts_similar)) {
                    $result = '';
                    $result .= '<ul class="comments_widget_single_review">';
                    $result .= '<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30 m_t_20 single_comment_more_title">'.__('Отзывы о похожих компаниях','er_theme').'</div>';
                    foreach ($more_posts_similar as $post_item) {
                        //echo $post_item->ID;
                       // echo get_the_title($post_item->ID);
                        //echo '<br />';
                        $args_more_more = array(
                            'number' => 1,
                            'status' => 'approve',
                            'orderby'=>'comment_date',
                            'order'=>'DESC',
                            'post_id' => $post_item->ID,
                            'comment__not_in' => $comment->comment_ID,
                        );

                        $args_more_more['meta_query'] = array(
                            'relation'		=> 'AND',
                            array(
                                'key'	 	=> 'comment_type',
                                'value'	  	=> 'reviews',
                                'compare' 	=> '=',
                            ),
                        );

                        $comments_more_more = get_comments($args_more_more);
                        //print_r($comments_more_more);
                        foreach ($comments_more_more as $comm_more) {
                            $total_rating_value = '';
                            $data_percent = 0;
                            if (function_exists('get_rating_fields_group')) {
                                $rating_fields_group = get_rating_fields_group($comm_more->comment_post_ID);
                            } else {
                                $rating_fields_group = 0;
                            }
                            $rating_fields = get_comment_rating_fields($rating_fields_group, 'key');
                            if (!empty($rating_fields)) {
                                $total_rating = get_comment_rating_values($rating_fields, $comm_more, 'total');
                                $total_rating_value = 5 / 100 * $total_rating;
                                $data_percent = $total_rating / 100;
                                if ($total_rating >= 70) {
                                    $rating_color = 'green';
                                    $data_color = '#21B67B';
                                } elseif ($total_rating >= 40 && $total_rating < 70) {
                                    $rating_color = 'normal';
                                    $data_color = '#001640';
                                } elseif ($total_rating < 40) {
                                    $rating_color = 'red';
                                    $data_color = '#fc0100';
                                }
                            }
                            $count_o_v++;
                            $oddEven = ($count_o_v % 2) ? 'odd' : 'even';
                            $count_o_v_2++;
                            $oddEven_2 = ($count_o_v_2 % 3) ? 'third' : 'third';

                            if ($m < 2) {
                                $new_o_v = 'new_odd';
                            } elseif (($m > 1) && ($m < 4)) {

                                $new_o_v = 'new_even';
                            }


                            $m = ++$m;
                            if ($m == 4) {
                                $m = 0;
                            }
                            $result .= '<li class="white_block ' . $new_o_v . '">';

                            $comment_author = get_userdata($comm_more->user_id);
                            if (get_field('pub_profile', 'user_' . $comm_more->user_id) == 'yes') {
                                $pubprofile = ' data-pub="1" ';
                            } else {
                                $pubprofile = '';
                            }


                            $result .= '<div class="comment-body body_' . $comm_more->comment_ID . '" data-body-id="body_' . $comm_more->comment_ID . '" data-set="'.get_the_permalink($comm_more->comment_post_ID).'comment-'.$comm_more->comment_ID.'/">';
                            $attachment_id = get_field('photo_profile', 'user_' . $comm_more->user_id);
                            $result .= '<div class="comment_header flex flex_wrap">';
                            $result .= '<div class="comment_avatar"';
                            if ($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                                $result .= 'style="background-image: url(' . $attachment_id['sizes']['thumbnail'] . ')"';
                            };
                            $result .= ' ' . $pubprofile . ' data-link="https://etorazvod.ru/user/' . $comment_author->user_nicename . '/">';
                            if (is_registered_from_social($comm_more->user_id)['main'] && is_registered_from_social($comm_more->user_id)['main'] != 'none') {
                                $result .= '<div class="social_provider_registered ' . is_registered_from_social($comm_more->user_id)['main'] . '"></div>';
                            };
                            $result .= '</div>';
                            if ($comment_author->first_name && !$comment_author->last_name) {
                                $author_name = $comment_author->first_name;
                            } elseif (!$comment_author->first_name && $comment_author->last_name) {
                                $author_name = $comment_author->last_name;
                            } elseif ($comment_author->first_name && $comment_author->last_name) {
                                $author_name = $comment_author->first_name . ' ' . $comment_author->last_name;
                            } else {
                                $author_name = $comment_author->user_nicename;
                            }
                            $result .= '<div class="font_smaller color_dark_gray comment_meta ">';
                            if($comm_more->user_id != 0) {
                                $result .= '<span class="comment-author font_bold color_dark_blue" ' . $pubprofile . ' data-link="' . get_bloginfo('url') . '/user/' . $comment_author->user_nicename . '/">' . $author_name . '</span>';
                            } else {
                                $result .= '<span class="comment-author font_bold color_dark_blue">' . __('Анонимный пользователь','er_theme') . '</span>';
                            }

                            $b = human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comm_more->comment_ID)), current_time( 'timestamp' ) );
                            if (mb_strpos($b, 'месяц') !== false) {
                                $da = intval($b).' '.counted_text($b,'месяц','месяца','месяцев').' '.__( 'назад', 'er_theme' );
                            } else {
                                $da = human_time_diff( strtotime(get_comment_date('Y-m-d H:i:s',$comm_more->comment_ID)), current_time( 'timestamp' ) ).' '.__( 'назад', 'er_theme' );
                            }
                            $result .= ' <span class="comment-date">' . $da . '</span>';
                            $result .= '</div>';


                            if ($total_rating_value != '') {
                                $result .= '<div class="review_average_round progress small comment_total_rating ' . $rating_color . '" id="comment_rating_total_' . $comm_more->comment_ID . '" data-percent="' . $data_percent . '" data-color="' . $data_color . '">';
                                $result .= '<div class="inner color_dark_blue font_bold font_small pointer">' . round($total_rating_value, 1) . '</div>';
                                $result .= '</div>';
                            }
                            $result .= '<div class="comment_rate" id="rate-comment-' . $comm_more->comment_ID . '">';
                            $result .= '<span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id=' . $comm_more->comment_ID . '></span>';
                            $comment_rate = get_field('comment_rate', $comm_more);
                            if (!$comment_rate) {
                                $comment_rate = 0;
                            }
                            if ($comment_rate == 0) {
                                $rate_number_class = 'neutral';
                                $comment_rate_plus = '';
                            } elseif ($comment_rate > 0) {
                                $rate_number_class = 'positive';
                                $comment_rate_plus = '+';
                            } elseif ($comment_rate < 0) {
                                $rate_number_class = 'negative';
                                $comment_rate_plus = '';
                            }
                            $result .= '<div class="rate_number_container"><span class="rate_number ' . $rate_number_class . '">' . $comment_rate_plus . $comment_rate . '</span></div>';
                            $result .= '<span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id=' . $comm_more->comment_ID . '></span>';
                            $result .= '</div>';
                            $result .= '</div>';
                            $comment_post_id = $comm_more->comment_post_ID;

                            if ($new_o_v == 'new_odd') {
                                $trim_number = 22;
                            } else {
                                $trim_number = 22;
                            }

                            $comm_more_review_title = get_field('review_title','comment_'.$comm_more->comment_ID);

                            if($comm_more_review_title && $comm_more_review_title != '') {
                                $comm_rev_title = $comm_more_review_title;
                            } else {
                                $comm_rev_title = wp_trim_words($comm_more->comment_content, 7,'');
                            }
                            $com_review_title_last = substr($comm_rev_title, -1);
                            if(in_array($com_review_title_last,array(',','.'))) {
                                $comm_rev_title = substr($comm_rev_title,0, -1);
                            } elseif(in_array($com_review_title_last,array('!','?','...'))) {
                                $comm_rev_title = $comm_rev_title;
                            } else {
                                $comm_rev_title = $comm_rev_title.'...';
                            }
                            $company_name_more = '';
                            $company_name_more = get_field('company_name',$comm_more->comment_post_ID);
                            if(!$company_name_more || $company_name_more == '') {
                                $company_name_more = get_the_title($comm_more->comment_post_ID);
                            }
                            $result .= '<div class="color_dark_gray comment_to_post_single font_normal color_dark_gray">'.__('Отзыв о компании','er_theme').' <a href="'.get_the_permalink($comm_more->comment_post_ID).'" class="color_dark_blue link_no_underline hover_dark font_bold" target="_blank">'.$company_name_more.'</a></div>';
                            $result .= '<div class="comment_single_title">'.$comm_rev_title.'</div>';
                            $comm_rev_text = wp_trim_words($comm_more->comment_content, $trim_number,'');
                            $comm_rev_text_last = substr($comm_rev_text, -1);
                            if(in_array($comm_rev_text_last,array(',','!','?','...','.'))) {
                                $comm_rev_text = substr($comm_rev_text,0, -1);
                            }

                            $comm_rev_text .= '...';

                            $result .= '<div class="comment_text color_dark_blue">' . $comm_rev_text . ' <a href="'.get_the_permalink($comm_more->comment_post_ID).'comment-'.$comm_more->comment_ID.'/" class="color_dark_gray">'.__('Читать далее','er_theme').'</a></div>';
                            $result .= '</div>';
                            $result .= '</li>';

                        }
                    }
                    $result .= '</ul>';
                    echo $result;
                }
                ?>
                <div class="list_more_container">
                    <?php if (function_exists('list_more_included')) {
                        list_more_included($comment->comment_post_ID);
                    }; ?>
                </div>
            </div>
            <div class="container_side flex flex_column">
            <!--<div class="comment-wrapper__right_sub">-->
                <div class="white_block comment_single_author_block">
                    <?php $comment_author = get_userdata( $comment->user_id );
                    $attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );

                    ?>
                    <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
                        $pubprofile = ' data-pub="1" ';
                    } else {
                        $pubprofile = '';
                    } ?>
                    <div class="comment_avatar pointer"  <?php echo $pubprofile; ?> data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
                    <div class="comment_author_wrapper m_b_5" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <?php if($comment->user_id && $comment->user_id != 0) {?>
                            <?php $comment_author = get_userdata( $comment->user_id ); ?>
                            <span data-id="9" class="comment-author font_bold font_small color_dark_blue pointer" itemprop="name" data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { if($comment_author) { echo $comment_author->user_nicename; } else { echo __('Анонимный пользователь','er_theme');} } ?></span>
                            <?php echo $labelpro; ?><?php echo $user_status_label; ?>
                            <?php } else { ?>
                            <span class="comment-author font_bold font_small color_dark_blue pointer" itemprop="name"><?php  echo __('Анонимный пользователь','er_theme'); ?></span>
                        <?php }; ?>

                    </div>
                    <?php if($comment->user_id != 0) { ?>
                    <div class="register_time_days_user_profile"><?php echo get_user_reg_date($comment->user_id); ?></div>

                    <?php
                    $user_address = get_field('adress','user_'.$comment->user_id);
                    //print_r($user_address);
                    $user_country = $user_address['country2'];
                    $user_city = $user_address['city'];
                    if($user_country && $user_country != '') {
                        ?>
                            <div class="user_county_city color_dark_gray">
                                <?php echo $user_country;
                                if($user_city && $user_city != '') {
                                    echo ', '.$user_city;
                                }
                                ?>
                            </div>
                        <?
                    }

                    //print_r(profile_stats_count( $comment->user_id ));
                    $user_review_stats = profile_stats_count( $comment->user_id );

                    if(!empty($user_review_stats)) { ?>
                        <div class="user_review_stats">
                            <div class=""><?php _e('Отзывы:','er_theme'); echo ' '.$user_review_stats['review_count']; ?> • <?php _e('Жалобы:','er_theme'); echo ' '.$user_review_stats['abuse_count']; ?></div>
                            <?php $all_rates = get_field('all_rates','user_'.$comment->user_id);
                            $good_rates = intval(get_field('good_rates','user_' . $comment->user_id));

                            if (get_field('all_rates','user_'.$comment->user_id)) {
                            if (get_field('all_rates','user_'.$comment->user_id) > 0) {
                            $numberrate = '<span class="color_green">+'.get_field('all_rates','user_'.$comment->user_id).'</span>';
                            //$numberold = get_field('all_rates','user_'.$user_id);
                            } elseif (get_field('all_rates','user_'.$comment->user_id) < 0) {
                            $numberrate = '<span class="color_red">'.get_field('all_rates','user_'.$comment->user_id).'</span>';
                            //$numberold = get_field('all_rates','user_'.$user_id);
                            } else {
                            $numberrate = '<span class="color_medium_gray">0</span>';
                            //$numberold = 0;
                            }
                            } else {
                            $numberrate = '<span class="color_medium_gray">0</span>';
                            //$numberold = 0;
                            }
                            $resultss = '';
                            $resultss .= print_js_links()['user_profile'];
                            $resultss .= '<div class="profile_card">';
                                $resultss .= '<div class="number_profile">'.__('Рейтинг:','er_theme').' '.$numberrate.'</div>';
                                $resultss .= '<div class="user_site font_small">';
                                    $all_rates_minus = abs(intval($all_rates) - intval($good_rates));
                                    $resultss .= '<span class="profile_usermetr"></span><span class="color_dark_blue"><span class="this-number-profile_plus">'.$good_rates.'</span> <span class="plus_name">'.counted_text($good_rates,__('плюс','er_theme'),__('плюса','er_theme'),__('плюсов','er_theme')).'</span> и <span class="this-number-profile_minus">'.$all_rates_minus.'</span>  <span class="minus_name">'.counted_text($all_rates_minus,__('минус','er_theme'),__('минуса','er_theme'),__('минусов','er_theme')).'</span></span>';
                                    $resultss .= '</div>';
                                $resultss .= '</div>';
                                echo $resultss;
                            ?>
                        </div>
                    <?php }


                    ?>
                    <?php } ?>
                </div>
                <div class="white_block single_total_stats"><?php
                   echo comments_sidebar_company($comment->comment_post_ID,'single_review_page');

                   ?>
                </div>
                <?php echo widget_company_in_ratings($comment->comment_post_ID); ?>
                <div class="review_sidebar_banner"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){

            $('body').on('click', '.comment_reply_count.active', function () {
                $(this).removeClass('active');
                $(this).addClass('inactive');
                $('ul.children').removeClass('visible');
            });
            $('body').on('click', '.comment_reply_count.inactive', function () {
                $(this).removeClass('inactive');
                $(this).addClass('active');
                $('ul.children').addClass('visible');
            });
            $( ".comment_reply_count" ).trigger( "click" );
        });
    </script>
    <div class="page_after_content background_light"><?php if (function_exists('ajax_new_companies_block_included')) {
            ajax_new_companies_block_included($comment->comment_post_ID);
        }; ?></div>
<?php
echo print_css_links('review_content');
//do_action( 'template_redirect' );
get_footer();
?>