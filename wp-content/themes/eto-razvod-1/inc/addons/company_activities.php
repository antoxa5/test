<?php




if (!function_exists('ajax_company_activities_abuses')) {
	add_action( 'wp_ajax_ajax_company_activities_abuses', 'ajax_company_activities_abuses' );
	add_action( 'wp_ajax_nopriv_ajax_company_activities_abuses', 'ajax_company_activities_abuses' );
	function ajax_company_activities_abuses() {
		$data = $_POST;
		$post_id = $data['post_id'];
		//echo $post_id;
		$result = '';		
		$result .= '<div class="company_activity_abuses">';
		$result .= '<div class="side_block white_block">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Активность','er_theme').'</div>';
				$result .= '<div class="block_content">';
				$count_all = get_field('reviews_count_abuses',$post_id);
				if(!$count_all || $count_all == '') {
					$count_all = 0;
				}
				$result .= '<div class="m_b_20"><span class="font_medium_new color_dark_blue font_bold m_right_10">'.$count_all.'</span><span class="color_dark_gray font_small">'.counted_text($count_all,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></div>';
				$count_abuses = abuse_stats($post_id, 'post');
		//print_r($count_abuses);
				if(!empty($count_abuses)) {
					$result .= '<ul class="company_activity_abuses_sorter flex font_smaller color_dark_gray">';
						$result .= '<li class="active" data-type="onlynew"><span class="list_text">'.__('Новые','er_theme').'</span><span class="list_number">'.$count_abuses['onlynew'].'</span></li>';
					$result .= '<li data-type="solved"><span class="list_text">'.__('Решено','er_theme').'</span><span class="list_number">'.$count_abuses['solved'].'</span></li>';
					$result .= '<li class="last" data-type="unsolved"><span class="list_text">'.__('Не решено','er_theme').'</span><span class="list_number">'.$count_abuses['unsolved'].'</span></li>';
					$result .= '</ul>';
				}
				$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}


function ajax_company_activities_abuses_php() {
	$post_id = get_the_ID();
	//echo $post_id;
	$result = '';
	$result .= '<div class="company_activity_abuses">';
	$result .= '<div class="side_block white_block">';
	$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Активность','er_theme').'</div>';
	$result .= '<div class="block_content">';
	$count_all = get_field('reviews_count_abuses',$post_id);
	if(!$count_all || $count_all == '') {
		$count_all = 0;
	}
	$result .= '<div class="m_b_20"><span class="font_medium_new color_dark_blue font_bold m_right_10">'.$count_all.'</span><span class="color_dark_gray font_small">'.counted_text($count_all,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></div>';
	$count_abuses = abuse_stats($post_id, 'post');
	//print_r($count_abuses);
	if(!empty($count_abuses)) {
		$result .= '<ul class="company_activity_abuses_sorter flex font_smaller color_dark_gray">';
		$result .= '<li class="active" data-type="onlynew"><span class="list_text">'.__('Новые','er_theme').'</span><span class="list_number">'.$count_abuses['onlynew'].'</span></li>';
		$result .= '<li data-type="solved"><span class="list_text">'.__('Решено','er_theme').'</span><span class="list_number">'.$count_abuses['solved'].'</span></li>';
		$result .= '<li class="last" data-type="unsolved"><span class="list_text">'.__('Не решено','er_theme').'</span><span class="list_number">'.$count_abuses['unsolved'].'</span></li>';
		$result .= '</ul>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}