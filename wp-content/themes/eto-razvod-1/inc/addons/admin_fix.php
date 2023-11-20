<?php

function wpassist_remove_block_library_css(){
wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );

if (!function_exists('hide_menu')) {
	
	function hide_menu(){
 global $current_user;
 $user_id = get_current_user_id();
 $userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;
									if ((in_array('admin2',$user_roles)  || in_array('beta_role',$user_roles))) {
echo '<style>.toplevel_page_list_edited_promocodes,.toplevel_page_loco {
    display: none !important;
}#wp-admin-bar-purge-all {
    display: none !important;
}</style>';



									}

																		if (in_array('moderator_plus',$user_roles)) {
echo '<style>li#wp-admin-bar-trp_edit_translation {
    display: none !important;
}</style>';
echo '<style>.toplevel_page_list_edited_promocodes,.toplevel_page_loco,li#wp-admin-bar-my-item {
    display: none !important;
}#wp-admin-bar-purge-all {
    display: none !important;
}</style>';
}

	if(is_admin() && !array_intersect(array('administrator'), $current_user->roles )){
		remove_menu_page( 'edit.php?post_type=leadforms' );
		remove_menu_page( 'edit.php?post_type=shortcoder' );


		remove_menu_page( 'edit.php?post_type=conversions' );
		remove_menu_page( 'edit.php?post_type=advertisers' );
		remove_menu_page( 'edit.php?post_type=request_add_company' );
		remove_menu_page( 'edit.php?post_type=notimails' );
		remove_menu_page( 'wpcf7' ); 
		remove_menu_page( 'capsman' ); 
		remove_menu_page( 'wp-mail-smtp' ); 
		remove_menu_page( 'admin.php?page=cptui_manage_post_types' ); 
		remove_menu_page( 'edit.php?post_type=widgets' );
		if (in_array('beta_role',$user_roles)) {

		} else {
		remove_menu_page( 'edit.php?post_type=tranzaktsii' );
		}

		remove_menu_page( 'edit.php?post_type=services' );
		remove_menu_page( 'themes.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'admin.php?page=cptui_manage_post_types' );
		remove_menu_page( 'theme-general-settings' );
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
		remove_menu_page( 'options-general.php' );
		remove_menu_page( 'tools.php' );
		if(array_intersect(array('moderator_plus'), $current_user->roles )){
			remove_menu_page( 'edit.php' );
			remove_menu_page( 'edit.php?post_type=page' );
			remove_menu_page( 'edit.php?post_type=promocodes' );
			remove_menu_page( 'edit.php?post_type=addpages' );
			remove_menu_page( 'edit.php?post_type=promocodes_cats' );
			remove_menu_page( 'edit.php?post_type=casino' );
		}
	}
		
	if(is_admin() && $user_id == 18022) {//elenag
		remove_menu_page( 'edit.php?post_type=promocodes_cats' );
		remove_menu_page( 'edit.php?post_type=promocodes' );
	}
    if($user_id == 18022) {//elenag
        remove_menu_page( 'upload.php' );
        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page( 'edit-tags.php' );
        //remove_menu_page( 'edit.php?post_type=casino' );
        remove_menu_page( 'edit.php?post_type=userblogpost' );
        remove_menu_page( 'admin.php?page=list_edited_promocodes' );
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'export-personal-data.php' );
        remove_menu_page( 'options-general.php?page=imagify' );
    }
	if(is_admin() && $user_id == 18022) {//elenag
		remove_menu_page( 'edit.php?post_type=addpages' );
	}
	
}

add_action('admin_head', 'hide_menu',9999);
if( !current_user_can( 'administrator' ) ) {
    remove_action( 'admin_menu', 'cptui_plugin_menu' );
}
	
}

//ссылки для редиректов
add_filter( 'manage_redirects_posts_columns', 'set_custom_edit_redirects_columns' );
function set_custom_edit_redirects_columns($columns) {
    $columns['redirects_author'] = __( 'Ссылка');

    return $columns;
}

add_action( 'manage_redirects_posts_custom_column' , 'custom_redirects_column', 10, 2 );
function custom_redirects_column( $column, $post_id ) {
    switch ( $column ) {

        case 'redirects_author' :
            $terms = get_the_term_list( $post_id , 'redirects_author' , '' , ',' , '' );
            if ( get_field('url',$post_id) )
                {echo '<a href="'.get_field('url',$post_id).'" target="_blank">'.get_field('url',$post_id).'</a>';}
            else
                {_e( 'Не установлена ссылка');}
            break;

    }
}

function crunchify_reorder_columns($columns) {
    $crunchify_columns = array();
    $title = 'date';
    foreach($columns as $key => $value) {
        if ($key==$title){
            $crunchify_columns['redirects_author'] = '';
        }
        $crunchify_columns[$key] = $value;
    }
    return $crunchify_columns;
}
add_filter('manage_redirects_posts_columns', 'crunchify_reorder_columns');
//ссылки для редиректов





function my_admin_page_promocodebanners_menu() {
    $curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;
    if(in_array($curr_user_id,array(9,1,2,17,27889)) || in_array('admin2',$user_roles) || in_array('beta_role',$user_roles)) {
        add_menu_page(
            __( 'Промокоды баннеры', 'er_theme' ),
            __( 'Промокоды баннеры', 'er_theme' ),
            'manage_options',
            'promocode_banners',
            'my_admin_page_promocode_banners',
            'dashicons-slides',
            3
        );
    }
}

add_action( 'admin_menu', 'my_admin_page_promocodebanners_menu' );
function my_admin_page_promocode_banners() {
    echo '<div class="wrap">';
    echo '<h1>';
    esc_html_e( 'Промокоды баннеры', 'er_theme' );
    echo '</h1>';
    ?>
    <?php
    function my_posts_where_pppp( $where ) {

        $where = str_replace("meta_key = 'promocodes_items_$", "meta_key LIKE 'promocodes_items_%", $where);

        return $where;
    }

    add_filter('posts_where', 'my_posts_where_pppp');

    echo '<table class="wp-list-table widefat fixed striped table-view-list posts" width="100%">';
    echo '<thead>';
    echo '<tr>';
    //echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Выделить все</label><input id="cb-select-all-1" type="checkbox"></td>';
    echo '<th scope="col" id="type" class="manage-column column-sendmails_type">'.__('Ссылка на редактирование','er_theme').'</th>';
    echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Просмотр страницы','er_theme').'</th>';
    echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Где выводится?','er_theme').'</th>';
    echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('id Метки','er_theme').'</th>';
    echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Дата','er_theme').'</th>';

    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="the-list">';


    // args
    $args = array(
        'post_type' => 'promocodes',
        'post_status' => array('publish','pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
        'posts_per_page' => -1,
        'meta_query'	=> array(
            array(
                'key'		=> 'promocodes_items_$_promocode_banner',
                'compare'	=> '==',
                'value'		=> 1,
            )
        )
    );


    // query
    $the_query = new WP_Query( $args );

    ?>
    <?php if( $the_query->have_posts() ): ?>

        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>



            <?php

            $promocodes = get_field('promocodes_items');
            if($promocodes && !empty($promocodes)) {
                $y = 0;
                foreach ($promocodes as $item) {
                    if ($item['promocode_banner'] == 1) { ?>
                        <?php if($item['date_end'] && $item['date_end'] != '') {
                            $date_end = $item['date_end'];
                        } else {
                            $date_end = 'Бессрочно';
                        }
                        $time_date_end = strtotime($date_end);
                        $newformat_date_end = date('d.m.Y',$time_date_end);

                        //echo $newformat;
                        $nowtimestamp = strtotime(date('Y-m-d'));


                        if ($time_date_end >= $nowtimestamp) { ?>
                            <tr>
                                <td>
                                    <a href="/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit" target="_blank"><?php the_title(); ?></a>
                                </td>
                                <td>
                                    <a href="<?php the_permalink(); ?>" target="_blank"><i class="far fa-eye"></i></a>
                                </td>
                                <td>

                                    <?php if (in_array('show_promocode', $item['where_to_show'])) {
                                        echo '<span class="promtag">Промокоды компании</span>';
                                    }
                                    if (in_array('show_tag', $item['where_to_show'])) {
                                        echo '<span class="promtag">По тэгу</span>';
                                    }
                                    if (in_array('show_review', $item['where_to_show'])) {
                                        echo '<span class="promtag">Обзор компании</span>';
                                    } ?>
                                </td>
                                <td><?php echo get_field('promocode_taxonomy'); ?></td>
                                <td><?php echo 'до '.$newformat_date_end; ?></td>
                            </tr>
                        <?php } ?>
                        <?php
                    }
                }
            }
            ?>

        <?php endwhile; ?>

    <?php endif; ?>

    <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
    <?php

    echo '</div>';
    echo   '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.css"><style>.promtag {
display:inline-block;background:#0073aa;padding:5px;margin:3px;color:#fff;margin-bottom:0;margin-top:0;border-radius:5px
}.promtag {
    margin: 3px;
}</style>';
}
function my_admin_page_top_comments() {
    $curr_user_id = get_current_user_id();

	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

    if(in_array($curr_user_id,array(17,27889,9,1,2))) {//9,1,2,
        add_menu_page(
            __( 'Топы по компаниям и комментам', 'er_theme' ),
            __( 'Топы по компаниям и комментам', 'er_theme' ),
            'manage_options',
            'top_companies',
            'my_admin_page_top_comments_lists',
            'dashicons-list-view',
            3
        );
    }
}

add_action( 'admin_menu', 'my_admin_page_top_comments' );
function my_admin_page_top_comments_lists() {
    $get_current_user_id = get_current_user_id();

    wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8'); ?>
    <style>
    #wpcontent {
        background: #eff4f6;
    }
    .block_big_links ul {
        flex-wrap: wrap;
    }
    .popular_cats li {
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        padding: 5px 0;
        cursor: pointer;
        margin: 5px !important;
    }
    .popular_cats li span {
        display: flex !important;
        align-items: center;
    }

    .popular_cats li span > span {
        border-bottom: unset;
        background: #2270b1;
        margin-left: 5px;
        display: inline-block;
        width: 25px;
        display: flex;
        justify-content: center;
        border-radius: 4px;
        font-size: 16px;
        color: #FFF;
        border-bottom: unset !important;
        height: 17px;
        font-size: 10px;
        line-height: 1;
    }
    .block_big_links {
        padding-top: 0 !important;
    }

    div#er_block_big_links-block_604e0955ec9f3 > div {
        padding-top: 10px;
    }
    .flex.flex_column.p_t_b_block.block_popular_cats {
        padding: 0 !important;
    }
    ul.popular_cats * {
        cursor: unset !important;
    }

    .usbar_t_wp_main {
    display: flex;
    border: 4px solid #eff4f6;
    margin: 10px;
}

.usbar_t_wp {
    display: flex;
    flex-direction: column;
    margin: 10px;
    width: 120px;
}

.usbar_t_wp_title {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

.usbar_t_wp_count {
    display: flex;
    justify-content: center;
    font-size: 32px;
    font-weight: bold;
    font-style: italic;
    margin-top: 10px;
}

.usbar_t_wp_main > span:nth-of-type(1) {
    position: relative;
}

.usbar_t_wp_main > span:nth-of-type(1):before {content: " ";width: 4px;height: 100%;background: #eff4f6;position: absolute;right: -12px;}


.usbar_t_wp_main {}

.usbar_t_wp_main .dashicons-before {
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    text-align: center;
    z-index: 1;
    text-align: center;
    display: flex;
    justify-content: center;
    top: -20px;
}

.usbar_t_wp_main {
    position: relative;
}

.usbar_t_wp_main .dashicons-before:before {
    font-size: 30px;
    height: 40px;
    width: 40px;
    background: #eff4f6;
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pos_abs_badge {
    position: relative;
    background: #1d2327;
    color: #FFF;
    font-size: 10px;
    display: inline-block;
    border-radius: 50px;
    padding: 0px 5px;
    margin-right: 10px;
}
.trans_label {
    background: #f4eae1;
    border-radius: 5px;
    background-color: #F5EBE1;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    padding: 5px 10px;
}

.trans_label > a {
    border-bottom: unset;
    background: #2270b1;
    margin-left: 5px;
    display: inline-block;
    width: 25px;
    display: flex;
    justify-content: center;
    border-radius: 4px;
    font-size: 16px;
    color: #FFF;
    border-bottom: unset !important;
    font-size: 10px;
    line-height: 1;
    display: inline-block;
    width: unset;
    font-size: unset;
    text-decoration: none;
    font-size: 12px;
    display: flex;
    align-items: center;
    padding: 5px;
}

.trans_label {
    display: flex;
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.title_d {
    border-top: 1px solid #c3c3c3;
    padding-top: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.title_d {
    border-top: 1px solid #c3c3c3;
    padding-top: 15px;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-bottom: 5px;
}
.usbar_t_wp_main {
    width: 50%;
}
.usbar_t_wp_main > span:nth-of-type(1) {
    width: 100%;
}

.usbar_t_wp_main > span:nth-of-type(1):before {
    display: none;
}
span.get_comments_number {
    border-bottom: unset;
    background: #2270b1;
    margin-left: 5px;
    display: inline-block;
    width: 25px;
    display: flex;
    justify-content: center;
    border-radius: 4px;
    font-size: 16px;
    color: #FFF;
    border-bottom: unset !important;
    height: 17px;
    font-size: 10px;
    line-height: 1;
    display: inline-block;
    /* height: 100%; */
    top: 0;
    margin: 0;
    line-height: inherit;
    text-align: center;
    padding: 3px;
}
a.comp_list_top {
    display: flex;
    text-decoration: none;
    align-items: center;
    margin-bottom: 10px;
}

a.comp_list_top > span {
    display: flex;
    align-items: center;
    margin-right: 10px;
}
.usbar_t_wp_main {
    width: 100%;
}
td.popular_comm_user_2 {
    width: 20%;
}

tr.popular_comm_user_wrapper {
    display: flex;
}

tr.popular_comm_user_wrapper > td {
    display: flex;
    background: #FFF;
}

td.popular_comm_user_1 {
    width: 10%;
}
td.popular_comm_user_2 {
    width: 15%;
}

td.popular_comm_user_3 {
    width: 15%;
}

td.popular_comm_user_4 {
    width: 40%;
}

td.popular_comm_user_5 {
    width: 10%;
}
    </style>
    <div id="er_block_big_links-block_604e0955ec9f3" class="block_big_links background_light flex flex_column p_t_b_block">
	<div class="wrap flex_column">
		<div class="flex big_links_icons">
		<ul class="flex first_tabs active">

		<li class="white_block flex" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;">
		<div class="usbar_t_wp_main"><span class="usbar_t_wp"><span class="usbar_t_wp_title">Компании с наибольшем числом комментов:</span>
		<a href="/wp-admin/admin.php?page=top_companies&type=company" class="button button_bigger font_medium font_bold button_violet pointer link_no_underline">Самые популярные компании</a><a href="/wp-admin/admin.php?page=top_companies&type=user_comments" class="button button_bigger font_medium font_bold button_violet pointer link_no_underline">Самые активные комментаторы</a><a href="/wp-admin/admin.php?page=top_companies&type=user_comments_answears" class="button button_bigger font_medium font_bold button_violet pointer link_no_underline">Самые активные комментаторы (ответы на чужие сообщения)</a>
		</span>
		</div>
		<?php if ($_GET['type'] == 'company') { ?>
		    <div class="usbar_t_wp_main"><span class="usbar_t_wp"><span class="usbar_t_wp_title"></span>
                <?php
                $query = new WP_Query( 'orderby=comment_count&order=DESC&post_type=casino&posts_per_page=300' );
                if( $query->have_posts() ){
                	while( $query->have_posts() ){
                		$query->the_post();
                		?>
                        <table><tr><td><span class="get_comments_number"><?php echo get_comments_number( get_the_ID() ) ?></span> </td><?php echo '<td><a class="comp_list_top" href="'.get_the_permalink().'">'.get_the_title().'</a></td>'; ?></tr></table>
                		<?php //the_content(); ?>
                		<?php
                	}
                	wp_reset_postdata(); // сбрасываем переменную $post
                }
                else
                	{echo '';} ?>
            </span></div>
		<?php } ?>
		<?php if ($_GET['type'] == 'user_comments') { ?>
                <div class="usbar_t_wp_main"><span class="usbar_t_wp"><span class="usbar_t_wp_title">Самые активные комментаторы:</span>
        <?php } ?>
<?php $args = array(
	'type'   => 'comment',
	'status' => 'approve',
);
$array_childs = [];
$comment_arr = get_comments( $args );
foreach ( $comment_arr as $item ) {
    if ($item->comment_parent == 0) {

    } else {
	    $array_childs[] = $item;
    }
}
$list_users = wp_list_pluck( $comment_arr, 'user_id' );
$totals = array_count_values( $list_users );
arsort($totals);
if ($_GET['type'] == 'user_comments') {
echo '<table>';
echo '<tr class="popular_comm_user_wrapper"><td class="popular_comm_user_1">ID WP</td><td class="popular_comm_user_2">Логин в WP</td><td class="popular_comm_user_3">Логин публичный</td><td class="popular_comm_user_4">Email</td><td class="popular_comm_user_5">Количество комментов</td></tr>';
foreach ( $totals as $total => $item ) {
	//echo $total.' '.$item.' =';
	$user_obj = get_userdata( $total );
	//print_r($user_obj->data);

    echo '<tr class="popular_comm_user_wrapper"><td class="popular_comm_user_1">'.$user_obj->data->ID.'</td><td class="popular_comm_user_2">'.$user_obj->data->user_login.'</td><td class="popular_comm_user_3">'.$user_obj->data->user_nicename.'</td><td class="popular_comm_user_4">'.$user_obj->data->user_email.'</td><td class="popular_comm_user_5">'.$item.'</td></tr>';
    //break;
}
echo '</table>';
} ?>
<?php if ($_GET['type'] == 'user_comments') { ?>
                </span></div>
<?php } ?>
<?php if ($_GET['type'] == 'user_comments_answears') { ?>
<style>
.usbar_t_wp_main > span:nth-of-type(1) {
    width: 100%;
    overflow: scroll;
}
</style>
                <div class="usbar_t_wp_main"><span class="usbar_t_wp"><span class="usbar_t_wp_title">Самые активные комментаторы-которые оставляют ответы:</span>
                <?php }
                if ($_GET['type'] == 'user_comments_answears') {
                function comm_vision($userid) {
                    $args = [
                        'user_id' => $userid,
                        'number' => '10',
                        'orderby' => 'rand'
                    ];
                    $arr = [];
                    $arr_titles = [];
                    $comments = get_comments( $args );
                    foreach( $comments as $comment ){
                        if (in_array($comment->comment_post_ID,$arr)) {

                        } else {
                            $arr[] = $comment->comment_post_ID;
                            $arr_titles[] = get_the_title($comment->comment_post_ID);
                        }
                    }
                    $title = implode(",", $arr_titles);
                    return $title;
                }
                $list_users_childs = wp_list_pluck( $array_childs, 'user_id' );
$totals_childs = array_count_values( $list_users_childs );
arsort($totals_childs);

echo '<table>';
echo '<tr class="popular_comm_user_wrapper"><td class="popular_comm_user_1">ID WP</td><td class="popular_comm_user_4">Логин в WP</td><td class="popular_comm_user_4">Логин публичный</td><td class="popular_comm_user_4">Email</td><td class="popular_comm_user_5">Количество комментов</td><td class="popular_comm_user_4">Записи</td></tr>';
foreach ( $totals_childs as $total => $item ) {
	$user_obj = get_userdata( $total );
	echo '<tr class="popular_comm_user_wrapper"><td class="popular_comm_user_1">'.$user_obj->data->ID.'</td><td class="popular_comm_user_4">'.$user_obj->data->user_login.'</td><td class="popular_comm_user_4">https://etorazvod.ru/user/'.$user_obj->data->user_nicename.'/</td><td class="popular_comm_user_4">'.$user_obj->data->user_email.'</td><td class="popular_comm_user_5">'.$item.'</td><td class="popular_comm_user_4">'.comm_vision($user_obj->data->ID).'</td></tr>';
}
echo '</table>';
} ?>
<?php if ($_GET['type'] == 'user_comments_answears') { ?>
</span></div>
<?php } ?>
            </li>
		</ul>
		</div>
    </div>
    </div>
    <?php
}
function my_admin_page_clicks_menu() {
    $curr_user_id = get_current_user_id();
	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

    if(in_array($curr_user_id,array(9,1,2,17,27889))) {
        add_menu_page(
            __( 'Клики', 'er_theme' ),
            __( 'Клики', 'er_theme' ),
            'manage_options',
            'clicks_stats',
            'my_admin_page_clicks',
            'dashicons-schedule',
            3
        );
    }
}

add_action( 'admin_menu', 'my_admin_page_clicks_menu' );
function my_admin_page_clicks() {
	///вернутьMYDB
    /*$start = microtime(true);
    $mydb = new wpdb('clicks','2K7v8K8w','clicks','localhost');


    $date_from = $_GET['clicks_date_from'];
    if(isset($date_from) && $date_from != '') {
        $date_from_exists = 1;

    }
    $date_to = $_GET['clicks_date_to'];
    if(isset($date_to) && $date_to != '') {
        $date_to_exists = 1;

    }
    $clicks_views = $_GET['clicks_views'];
    if(!array_key_exists('filter_action',$_GET) || isset($clicks_views) && $clicks_views == 'on') {
        $clicks_views_exists = 1;

    }
    $clicks_clicks = $_GET['clicks_clicks'];
    if(!array_key_exists('filter_action',$_GET) || isset($clicks_clicks) && $clicks_clicks == 'on') {
        $clicks_clicks_exists = 1;

    }*/
    ?>
    <h1>
        <?php esc_html_e( 'Статистика по переходам', 'er_theme' ); ?>
    </h1>




    <?php

   /* wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_enqueue_style('jquery-ui');
    $wp_id = $_GET['wp_id'];
    if(isset($wp_id) && $wp_id != '') {*/
        ?>
        <div class="tablenav top">
            <div class="alignleft actions">
                <form id="posts-filter" method="get">
                    <input type="hidden" name="page" value="clicks_stats" />
                    <input type="hidden" name="wp_id" value="<?php echo $wp_id; ?>" />
                    <label for="clicks_date_from">
                        <span><?php _e('От','er_theme'); ?></span>
                        <input id="clicks_date_from" type="date" name="clicks_date_from" <?php if($date_from_exists == 1) { ?>value="<?php echo $date_from; ?>"<?php } ?> />
                    </label>
                    <label for="clicks_date_to">
                        <span><?php _e('до','er_theme'); ?></span>
                        <input id="clicks_date_to" type="date" name="clicks_date_to" <?php if($date_to_exists == 1) { ?>value="<?php echo $date_to; ?>"<?php } ?> />
                    </label>
                    <label for="clicks_views">
                        <input type="checkbox" id="clicks_views" name="clicks_views" <?php if($clicks_views_exists == 1) { ?>checked="checked"<?php } ?> />
                        <span><?php _e('Показы','er_theme'); ?></span>
                    </label>
                    <label for="clicks_clicks">
                        <input type="checkbox" id="clicks_clicks" name="clicks_clicks" <?php if($clicks_clicks_exists == 1) { ?>checked="checked"<?php } ?> />
                        <span><?php _e('Переходы','er_theme'); ?></span>
                    </label>
                    <input type="submit" id="post-query-submit" class="button" name="filter_action" value="<?php _e('Фильтр','er_theme'); ?>" />
                </form>
            </div>
        </div>
        <?php
        /*echo __('Показы и переходы по редиректу #').$wp_id;
        echo '<br />';
        echo '<a href="/wp-admin/admin.php?page=clicks_stats">'.__('Назад ко всем редиректам','er_theme').'</a>';
        echo '<br />';

        if($date_from_exists && !$date_to_exists && $clicks_views && $clicks_clicks || $date_from_exists && !$date_to_exists && !$clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from'");
        } elseif($date_from_exists && !$date_to_exists && $clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from' AND type = 'view'");
        } elseif($date_from_exists && !$date_to_exists && !$clicks_views && $clicks_clicks) {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from' AND type = 'click'");
        } elseif(!$date_from_exists && $date_to_exists && $clicks_views && $clicks_clicks || !$date_from_exists && $date_to_exists && !$clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time <= '$date_to'");
        } elseif(!$date_from_exists && $date_to_exists && $clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time <= '$date_to' AND type = 'view'");
        } elseif(!$date_from_exists && $date_to_exists && !$clicks_views && $clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time <= '$date_to' AND type = 'click'");
        } elseif($date_from_exists && $date_to_exists && $clicks_views && $clicks_clicks || $date_from_exists && $date_to_exists && !$clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from' AND time <= '$date_to'");
        } elseif($date_from_exists && $date_to_exists && $clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from' AND time <= '$date_to' AND type = 'view'");
        } elseif($date_from_exists && $date_to_exists && !$clicks_views && $clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND time >= '$date_from' AND time <= '$date_to' AND type = 'click'");
        } elseif(!$date_from_exists && !$date_to_exists && !$clicks_views && $clicks_clicks) {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND type = 'click'");
        } elseif(!$date_from_exists && !$date_to_exists && $clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id AND type = 'view'");
        } else {
            $rows = $mydb->get_results("select * FROM clicks WHERE wp_id = $wp_id");
        }



        //print_r($rows);
        $count_rows = count($rows);
        echo __('Всего:').' '.$count_rows;
        echo '<br />';
        echo '<br />';
        if(!empty($rows)) {
            echo '<table class="wp-list-table widefat fixed striped table-view-list posts" width="100%">';
            echo '<thead>';
            echo '<tr>';
            echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Выделить все</label><input id="cb-select-all-1" type="checkbox"></td>';
            echo '<th scope="col" id="mail_id" class="manage-column column-primary sortable desc" width="50px">'.__('ID','er_theme').'</th>';
            echo '<th scope="col" id="type" class="manage-column column-sendmails_type" >'.__('Редирект','er_theme').'</th>';
            echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Конечная ссылка','er_theme').'</th>';
            echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Yandex Click ID','er_theme').'</th>';
            echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Дата и время','er_theme').'</th>';
            echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Тип','er_theme').'</th>';
            echo '</tr>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody id="the-list">';
            $u=0;
            foreach ($rows as $row) {
                $u++;
                echo '<tr>';
                echo '<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-'.$u.'">'.__('Выбрать','er_theme').'</label>
				<input id="cb-select-'.$u.'" type="checkbox" name="click[]" value="'.$u.'">
				<div class="locked-indicator">
					<span class="locked-indicator-icon" aria-hidden="true"></span>

				</div>
				</th>';
                echo '<td>'.$u.'</td>';
                echo '<td>https://etorazvod.ru/'.$row->slug.'/</td>';
                echo '<td>'.$row->redirect_url.'</td>';
                echo '<td>'.$row->click_id.'</td>';
                echo '<td>'.$row->time.'</td>';
                echo '<td>'.$row->type.'</td>';
                echo '</tr>';

            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo __('Нет переходов по заданным параметрам','er_theme');
        }
    } else {*/
        ?>
        <div class="tablenav top">
            <div class="alignleft actions">
                <form id="posts-filter" method="get">
                    <input type="hidden" name="page" value="clicks_stats" />
                    <label for="clicks_date_from">
                        <span><?php _e('От','er_theme'); ?></span>
                        <input id="clicks_date_from" type="date" name="clicks_date_from" <?php if($date_from_exists == 1) { ?>value="<?php echo $date_from; ?>"<?php } ?> />
                    </label>
                    <label for="clicks_date_to">
                        <span><?php _e('до','er_theme'); ?></span>
                        <input id="clicks_date_to" type="date" name="clicks_date_to" <?php if($date_to_exists == 1) { ?>value="<?php echo $date_to; ?>"<?php } ?> />
                    </label>
                    <label for="clicks_views">
                        <input type="checkbox" id="clicks_views" name="clicks_views" <?php if($clicks_views_exists == 1) { ?>checked="checked"<?php } ?> />
                        <span><?php _e('Показы','er_theme'); ?></span>
                    </label>
                    <label for="clicks_clicks">
                        <input type="checkbox" id="clicks_clicks" name="clicks_clicks" <?php if($clicks_clicks_exists == 1) { ?>checked="checked"<?php } ?> />
                        <span><?php _e('Переходы','er_theme'); ?></span>
                    </label>
                    <input type="submit" id="post-query-submit" class="button" name="filter_action" value="<?php _e('Фильтр','er_theme'); ?>" />
                </form>
            </div>
        </div>
        <?php
       /* if($date_from_exists && !$date_to_exists && $clicks_views && $clicks_clicks || $date_from_exists && !$date_to_exists && !$clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif($date_from_exists && !$date_to_exists && $clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' AND type = 'view' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif($date_from_exists && !$date_to_exists && !$clicks_views && $clicks_clicks) {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' AND type = 'click' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif(!$date_from_exists && $date_to_exists && $clicks_views && $clicks_clicks || !$date_from_exists && $date_to_exists && !$clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time <= '$date_to' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif(!$date_from_exists && $date_to_exists && $clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time <= '$date_to' AND type = 'view' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif(!$date_from_exists && $date_to_exists && !$clicks_views && $clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time <= '$date_to' AND type = 'click' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif($date_from_exists && $date_to_exists && $clicks_views && $clicks_clicks || $date_from_exists && $date_to_exists && !$clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' AND time <= '$date_to' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif($date_from_exists && $date_to_exists && $clicks_views && !$clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' AND time <= '$date_to' AND type = 'view' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif($date_from_exists && $date_to_exists && !$clicks_views && $clicks_clicks) {
            $date_to = date('Y-m-d',strtotime($date_to . "+1 days"));
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE time >= '$date_from' AND time <= '$date_to' AND type = 'click' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif(!$date_from_exists && !$date_to_exists && !$clicks_views && $clicks_clicks) {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE type = 'click' GROUP BY wp_id ORDER BY count(*) DESC");
        } elseif(!$date_from_exists && !$date_to_exists && $clicks_views && !$clicks_clicks) {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks WHERE type = 'view' GROUP BY wp_id ORDER BY count(*) DESC");
        } else {
            $rows = $mydb->get_results("select *, COUNT(*) as 'counter' FROM clicks GROUP BY wp_id ORDER BY count(*) DESC");
        }

        if(!empty($rows)) {
            echo '<table class="wp-list-table widefat fixed striped table-view-list posts" width="100%">';
            echo '<thead>';
            echo '<tr>';
            echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Выделить все</label><input id="cb-select-all-1" type="checkbox"></td>';
            echo '<th scope="col" id="mail_id" class="manage-column column-primary sortable desc" width="50px">'.__('ID','er_theme').'</th>';
            echo '<th scope="col" id="type" class="manage-column column-sendmails_type" >'.__('Редирект','er_theme').'</th>';
            echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Конечная ссылка','er_theme').'</th>';
            echo '<th scope="col" id="email" class="manage-column column-sendmails_reg_date" >'.__('Кол-во переходов','er_theme').'</th>';
            echo '<th scope="col" id="status" class="manage-column column-sendmails_status" width="150px">'.__('Редактировать','er_theme').'</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody id="the-list">';
            $u=0;
            foreach ($rows as $row) {
                $u++;
                echo '<tr>';
                echo '<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-'.$u.'">'.__('Выбрать','er_theme').'</label>
				<input id="cb-select-'.$u.'" type="checkbox" name="click[]" value="'.$u.'">
				<div class="locked-indicator">
					<span class="locked-indicator-icon" aria-hidden="true"></span>

				</div>
				</th>';
                echo '<td>'.$u.'</td>';
                echo '<td>https://etorazvod.ru/'.$row->slug.'/</td>';
                echo '<td>'.$row->redirect_url.'</td>';
                echo '<td><a href="/wp-admin/admin.php?page=clicks_stats&wp_id='.$row->wp_id.'">'.$row->counter.'</a></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo __('Нет переходов по заданным параметрам','er_theme');
        }
    }
     echo 'Время генерации: ' . ( microtime(true) - $start ) . ' сек.';*/

///вернутьMYDB
}

function check_old_bonuses() {
    $curr_user_id = get_current_user_id();

	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

    if(in_array($curr_user_id,array(9,1,2, 31, 17,6, 19117, 19866,15128, 17326,27889, 12)) || in_array('admin2',$user_roles) || in_array('beta_role',$user_roles)){//
        add_menu_page(
            __( 'Проверка бонусов', 'er_theme' ),
            __( 'Проверка бонусов', 'er_theme' ),
            'manage_options',
            'check_old_bonuses',
            'check_old_bonuses_func',
            'dashicons-clipboard',
            3
        );
    }
}

add_action( 'admin_menu', 'check_old_bonuses' );
function check_old_bonuses_func() { ?>
<h1>Проверка бонусов</h1>
<style>
ul.ul_old_spans > li {display: flex;}

ul.ul_old_spans > li > span {margin: 10px;}

.data-old {background: #2270b1;color: #FFF;padding: 0px 15px;border-radius: 10px;}
span.data-old {background: #2270b1;color: #FFF;padding: 0px 15px;border-radius: 10px;}

ul.ul_old_spans {max-width: 900px;}

ul.ul_old_spans > li {justify-content: space-between;}
</style>
<?php
$the_query = new WP_Query( [
	'numberposts'=> -1,
	'post_type' => 'casino',
	'meta_query' => [
		[
			'key' => 'base_2_bonuses_$_date_remove',
			'value' => '',
			'compare' => '!=',
		]
	]
] );
?>
<?php if( $the_query->have_posts() ): ?>
	<ul class="ul_old_spans">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<?php
		$date_now = time();

		$base_2_bonuses = get_field('base_2_bonuses',get_the_ID());
		foreach ($base_2_bonuses as $item) {
			$date_convert = strtotime($item['date_remove']);
			if ($date_now > $date_convert && $date_convert != '') {
				echo '<li><span><a href="'.get_the_permalink().'">'.get_the_title().'</a></span><span>'.$item['comment'].'</span><span class="data-old">Истёк: <span>'.$item['date_remove'].'</span></span></li>';
			}
		}
	?>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

<?php }


function update_casino_data() {
    $curr_user_id = get_current_user_id();

	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

    if(in_array($curr_user_id,array(9,1,2, 31, 17,27889,6, 19117, 19866, 17326)) || in_array('admin2',$user_roles) || in_array('beta_role',$user_roles)){
        add_menu_page(
            __( 'Проверка данных обзора', 'er_theme' ),
            __( 'Проверка данных обзора', 'er_theme' ),
            'manage_options',
            'update_data_casino',
            'update_casino_data_func',
            'dashicons-update-alt',
            3
        );
    }
}

add_action( 'admin_menu', 'update_casino_data' );
function update_casino_data_func() { ?>
<?php
    if ($_POST) {
        $url_to_postid = url_to_postid( $_POST['checkinfo'] );
        echo 'URL страницы: '.$_POST['checkinfo'].'<br>';
        echo 'ID Страницы: '.$url_to_postid.'<br>';
        echo '<hr>';
        echo '<strong>Данные до обновления данных: </strong>';
        echo 'Рейтинг: '.get_field( 'reviews_rating_average', $url_to_postid ).'<br>';
        echo 'Кол-во отзывов: '.get_field( 'reviews_count_reviews', $url_to_postid ).'<br>';
        echo 'Кол-во положительных: '.get_field( 'reviews_count_good', $url_to_postid ).'<br>';
        echo 'Кол-во негативных: '.get_field( 'reviews_count_bad', $url_to_postid ).'<br>';
        echo 'Процент положительных: '.get_field( 'reviews_count_good_percent', $url_to_postid ).'<br>';
        echo 'Процент негативных: '.get_field( 'reviews_count_bad_percent', $url_to_postid ).'<br>';
        echo 'Кол-во жалоб: '.get_field( 'reviews_count_abuses', $url_to_postid ).'<br>';
        echo '<hr>';
        update_post_info($url_to_postid);
        echo '<strong>Данные после: </strong>';
        echo 'Рейтинг: '.get_field( 'reviews_rating_average', $url_to_postid ).'<br>';
        echo 'Кол-во отзывов: '.get_field( 'reviews_count_reviews', $url_to_postid ).'<br>';
        echo 'Кол-во положительных: '.get_field( 'reviews_count_good', $url_to_postid ).'<br>';
        echo 'Кол-во негативных: '.get_field( 'reviews_count_bad', $url_to_postid ).'<br>';
        echo 'Процент положительных: '.get_field( 'reviews_count_good_percent', $url_to_postid ).'<br>';
        echo 'Процент негативных: '.get_field( 'reviews_count_bad_percent', $url_to_postid ).'<br>';
        echo 'Кол-во жалоб: '.get_field( 'reviews_count_abuses', $url_to_postid ).'<br>';
    }
    ?>
<form action="/wp-admin/admin.php?page=update_data_casino" method="post">
  <p><input type="text" name="checkinfo" placeholder="Введите адрес обзора, например, https://etorazvod.ru/review/alpari/"></p>
  <p><input type="submit" value="Проверить и обновить!"></p>
 </form>


<?php }


function my_admin_page_sendmails_menu() {
    $curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;


    if(in_array($curr_user_id,array(9,1,2,17,27889))) {
        add_menu_page(
            __( 'E-mail рассылки', 'er_theme' ),
            __( 'E-mail рассылки', 'er_theme' ),
            'manage_options',
            'sendmails',
            'my_admin_page_sendmails',
            'dashicons-schedule',
            3
        );
    }
}

add_action( 'admin_menu', 'my_admin_page_sendmails_menu' );
function my_admin_page_sendmails() {
    wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css');
    ?>
        <div class="wrap">
    <h1>
        <?php esc_html_e( 'E-mail рассылки', 'er_theme' ); ?>
    </h1>

    <?php
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //echo $actual_link;
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $params);

    ?>

    <?php $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');

$selecter_status = $_GET['selecter_status'];
$selecter_type = $_GET['selecter_type'];
$clicks_date_from = $_GET['clicks_date_from'];
$clicks_date_to = $_GET['clicks_date_to'];

    //echo $selecter_status;

//        if ( $selecter_status == 'sent') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'sent' ORDER BY sent DESC");
//        } elseif ($selecter_status == 'opened') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'opened' ORDER BY sent DESC");
//        } elseif ($selecter_status == 'not_sent') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'not_sent' ORDER BY sent DESC");
//        } elseif ($selecter_status == 'clicked') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'clicked' ORDER BY sent DESC");
//        } elseif ($selecter_status == 'clicked_activated_noauth') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'clicked_activated_noauth' ORDER BY sent DESC");
//        } elseif ($selecter_status == 'clicked_activated_auth') {
//        $rows = $mydb->get_results("select * from mails WHERE status = 'clicked_activated_auth' ORDER BY sent DESC");
//        }

if ( $selecter_status != '') {
        $selecter_status_text = '&selecter_status='.$selecter_status;
        $rows = $mydb->get_results("select * from mails WHERE status = '$selecter_status' ORDER BY sent DESC");
} else {
        $selecter_status_text = '';
}

if ( $selecter_type != '') {
        $selecter_type_text = '&selecter_type='.$selecter_type;
        $rows = $mydb->get_results("select * from mails WHERE mail_type = '$selecter_type' ORDER BY sent DESC");
} else {
        $selecter_type_text = '';
}

if ( $clicks_date_from != '') {
        $clicks_date_from_text = '&clicks_date_from='.$clicks_date_from;
        $rows = $mydb->get_results("select * from mails WHERE sent >= '$clicks_date_from' ORDER BY sent DESC");
} else {
        $clicks_date_from_text = '';
}

if ( $clicks_date_to != '') {
        $timestamp = strtotime($clicks_date_to);
    $plus_one_day = strtotime('+1 day', $timestamp);
    $clicks_date_to_final = date('Y-m-d', $plus_one_day);
        $clicks_date_to_text = '&clicks_date_to='.$clicks_date_to;
        $rows = $mydb->get_results("select * from mails WHERE sent <= '$clicks_date_to_final' ORDER BY sent DESC");
} else {
        $clicks_date_to_text = '';
}



if (( $clicks_date_from != '') && ( $clicks_date_to != '') ) {
        $rows = $mydb->get_results("select * from mails WHERE sent >= '$clicks_date_from' AND sent <= '$clicks_date_to_final' ORDER BY sent DESC");
}

if (( $selecter_type == '') && ( $selecter_status == '') && ($clicks_date_from == '') && ($clicks_date_to == '')) {
    $rows = $mydb->get_results("select * from mails ORDER BY sent DESC");
}

if (( $selecter_type != '') && ( $selecter_status != '')) {
    $rows = $mydb->get_results("select * from mails WHERE status = '$selecter_status' AND  mail_type = '$selecter_type' ORDER BY sent DESC");
}


if (( $selecter_type != '') && ( $selecter_status == '')  && ( $clicks_date_to != '') && ( $clicks_date_from == '')) {
    $rows = $mydb->get_results("select * from mails WHERE sent <= '$clicks_date_to_final' AND  mail_type = '$selecter_type' ORDER BY sent DESC");
}

if (( $selecter_type != '') && ( $selecter_status == '')  && ( $clicks_date_from != '')  && ( $clicks_date_to == '')) {
    $rows = $mydb->get_results("select * from mails WHERE  sent >= '$clicks_date_from' AND  mail_type = '$selecter_type' ORDER BY sent DESC");
}

if (( $selecter_type != '') && ( $selecter_status == '')  && ( $clicks_date_from != '')  && ( $clicks_date_to != '')) {
    $rows = $mydb->get_results("select * from mails WHERE  sent >= '$clicks_date_from' AND sent <= '$clicks_date_to_final' AND  mail_type = '$selecter_type' ORDER BY sent DESC");
}



if (( $selecter_status != '') && ( $selecter_type == '') && ( $clicks_date_to != '') && ( $clicks_date_from == '')) {
    $rows = $mydb->get_results("select * from mails WHERE sent <= '$clicks_date_to_final' AND  status = '$selecter_status' ORDER BY sent DESC");
}

if (( $selecter_status != '') && ( $selecter_type == '') && ( $clicks_date_from != '')  && ( $clicks_date_to == '')) {
    $rows = $mydb->get_results("select * from mails WHERE  sent >= '$clicks_date_from' AND  status = '$selecter_status' ORDER BY sent DESC");
}

if (( $selecter_status != '') && ( $selecter_type == '') && ( $clicks_date_from != '')  && ( $clicks_date_to != '')) {
    $rows = $mydb->get_results("select * from mails WHERE  sent >= '$clicks_date_from' AND sent <= '$clicks_date_to_final' AND  status = '$selecter_status' ORDER BY sent DESC");
}




if (( $selecter_type != '') && ( $selecter_status != '') && ( $clicks_date_from == '') && ( $clicks_date_to != '') ) {
    $rows = $mydb->get_results("select * from mails WHERE status = '$selecter_status' AND  mail_type = '$selecter_type' AND sent <= '$clicks_date_to_final' ORDER BY sent DESC");
}

if (( $selecter_type != '') && ( $selecter_status != '') && ( $clicks_date_from != '')  && ( $clicks_date_to == '') ) {
    $rows = $mydb->get_results("select * from mails WHERE status = '$selecter_status' AND  mail_type = '$selecter_type' AND sent >= '$clicks_date_from'  ORDER BY sent DESC");
}

if (( $selecter_type != '') && ( $selecter_status != '') && ( $clicks_date_from != '') && ( $clicks_date_to != '') ) {
    $rows = $mydb->get_results("select * from mails WHERE status = '$selecter_status' AND  mail_type = '$selecter_type' AND sent >= '$clicks_date_from' AND sent <= '$clicks_date_to_final' ORDER BY sent DESC");
}

//WHERE sent >= '2021-01-18'
    $sent = $mydb->get_results("select * from mails WHERE status = 'sent'");
    $opened = $mydb->get_results("select * from mails WHERE status = 'opened'");
    $args_activated = array(
        'meta_query' => array(
            array(
                'key' => 'user_activation',
                'value' => 'yes',
                'compare' => '=='
            ),
            array(
                'key' => 'from_cackle',
                'value' => true,
                'compare' => '=='
            ),
        )
    );
    $activated = get_users($args_activated);
    if (($params['pager'] == '') || (intval($params['pager']) == 0) || (intval($params['pager']) == 1)) {
        $numfrom = 1;
        $numberpage = 1;
        $prevblock = "disabled";
        $nextblock = "";
    } else {
        if (round((count($rows) / 100), 0, PHP_ROUND_HALF_UP) >= intval($params['pager'])) {
            $numfrom = ( 100 * intval($params['pager']) ) - 100;
            $numberpage = intval($params['pager']);
            $prevblock = "";
            $nextblock = "";
            if (round((count($rows) / 100), 0, PHP_ROUND_HALF_UP) == intval($params['pager'])) {

            $nextblock = "disabled";
            }
        } else {
            $numberpage = 1;
            $prevblock = "";
            $nextblock = "disabled";
        }
    }



	wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_enqueue_style('jquery-ui');

    echo 'Всего писем: '.count($rows);
    echo '<br />Отправлено: '.count($sent);
    echo '<br />Открыто: '.count($opened);
    echo '<br />Активировали: '.count($activated);
	?>
		<div class="tablenav top">
				<div class="alignleft actions">
					<form id="posts-filter" method="get">
						<input type="hidden" name="page" value="sendmails" />
                        <label for="clicks_date_from">
							<span><?php _e('Дата отправки, от','er_theme'); ?></span>
							<input id="clicks_date_from" type="date" name="clicks_date_from" <?php if($clicks_date_from_text != '') { ?>value="<?php echo $clicks_date_from; ?>"<?php } ?> />
						</label>
						<label for="clicks_date_to">
							<span><?php _e('Дата отправки, до','er_theme'); ?></span>
							<input id="clicks_date_to" type="date" name="clicks_date_to" <?php if($clicks_date_to_text != '') { ?>value="<?php echo $clicks_date_to; ?>"<?php } ?> />
						</label>
						<label for="selecter_type"><span>Сортировка по типу</span>
                            <select name="selecter_type" id="selecter_type">
                                 <option value="">Не выбрано</option>
                                <?php if ($selecter_type == 'registration') { ?>
                                <option value="registration" selected>Регистрация</option>
                                <?php } else { ?>
                                <option value="registration">Регистрация</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'registration_cackle') { ?>
                                <option value="registration_cackle" selected>Регистрация из cackle</option>
                                <?php } else { ?>
                                <option value="registration_cackle">Регистрация из cackle</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'reset_password') { ?>
                                <option value="reset_password" selected>Восстановление пароля</option>
                                <?php } else { ?>
                                <option value="reset_password">Восстановление пароля</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'change_email') { ?>
                                <option value="change_email" selected>Сообщение о смене email</option>
                                <?php } else { ?>
                                <option value="change_email">Сообщение о смене email</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'change_email_accept_new') { ?>
                                <option value="change_email_accept_new" selected>Подтверждение смены email (новый email)</option>
                                <?php } else { ?>
                                <option value="change_email_accept_new">Подтверждение смены email (новый email)</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'change_email_accept_old') { ?>
                                <option value="change_email_accept_old" selected>Подтверждение смены email (старый email)</option>
                                <?php } else { ?>
                                <option value="change_email_accept_old">Подтверждение смены email (старый email)</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'comment_spam_form') { ?>
                                <option value="comment_spam_form" selected>Пожаловались на спам</option>
                                <?php } else { ?>
                                <option value="comment_spam_form">Пожаловались на спам</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'send_comment_abuse_form') { ?>
                                <option value="send_comment_abuse_form" selected>Жалоба на комментарий</option>
                                <?php } else { ?>
                                <option value="send_comment_abuse_form">Жалоба на комментарий</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'lead_form') { ?>
                                <option value="lead_form" selected>Отправлен ЛИД</option>
                                <?php } else { ?>
                                <option value="lead_form">Отправлен ЛИД</option>
                                <?php } ?>
                                <?php if ($selecter_type == 'password_changed') { ?>
                                <option value="password_changed" selected>Сообщение об изменении пароля</option>
                                <?php } else { ?>
                                <option value="password_changed">Сообщение об изменении пароля</option>
                                <?php } ?>

                            </select></label>
                            <label for="selecter_status"><span>Сортировка по статусу</span>
                            <select name="selecter_status" id="selecter_status">
                                <option value="">Не выбрано</option>
                                <?php if ($selecter_status == 'sent') { ?>
                                <option value="sent" selected>Отправлен и не прочитан</option>
                                <?php } else { ?>
                                <option value="sent">Отправлен и не прочитан</option>
                                <?php } ?>
                                <?php if ($selecter_status == 'opened') { ?>
                                <option value="opened" selected>Открыт</option>
                                <?php } else { ?>
                                <option value="opened">Открыт</option>
                                <?php } ?>
                                <?php if ($selecter_status == 'not_sent') { ?>
                                <option value="not_sent" selected>Не отправлен</option>
                                <?php } else { ?>
                                <option value="not_sent">Не отправлен</option>
                                <?php } ?>
                                <?php if ($selecter_status == 'clicked') { ?>
<option value="clicked" selected>Переход по ссылки регистрации (ошибка активации или неверная ссылка)</option>
                                <?php } else { ?>
<option value="clicked">Переход по ссылки регистрации (ошибка активации или неверная ссылка)</option>
                                <?php } ?>
                                <?php if ($selecter_status == 'clicked_activated_noauth') { ?>
<option value="clicked_activated_noauth" selected>Переход по ссылки регистрации и активация (Другой браузер)</option>
                                <?php } else { ?>
<option value="clicked_activated_noauth">Переход по ссылки регистрации и активация (Другой браузер)</option>
                                <?php } ?>
                                <?php if ($selecter_status == 'clicked_activated_auth') { ?>
<option value="clicked_activated_auth" selected>Переход по ссылки регистрации и активация</option>
                                <?php } else { ?>
<option value="clicked_activated_auth">Переход по ссылки регистрации и активация</option>
                                <?php } ?>

                            </select>
                            </label>
						<input type="submit" id="post-query-submit" class="button" name="filter_action" value="<?php _e('Фильтр','er_theme'); ?>" />
					</form>
				</div>

		<?php

    echo '
<style>.disabled.blocklinearrow * {
    color: #ccd0d4;
    border-color: #ccd0d4 !IMPORTANT;
}

.disabled.blocklinearrow {
    position: relative;
}

.disabled.blocklinearrow:before {content: " ";width: 100%;height: 100%;position: absolute;top: 0;left: 0;}
.tablenav-pages {
    display: flex;
}

form#posts-filter {
    display: flex;
}
.tablenav-pages {
    display: flex;
}

form#posts-filter {
    display: flex;
}

.tablenav.top {
    display: flex;
    align-items: center;
}

span.displaying-num {
    display: flex;
    align-items: center;
}
label[for="clicks_date_to"],label[for="clicks_date_from"] {
    display: flex;
    align-items: center;
    padding-left: 5px;
    /* padding-right: 3px; */
}

label[for="clicks_date_to"] {
    margin-right: 5px;
}

.tablenav-pages {
    display: flex;
    white-space: nowrap;
}
label[for="clicks_date_to"],label[for="clicks_date_from"],label[for="selecter_type"],label[for="selecter_status"] {
    display: flex;
    flex-direction: column;
}

.tablenav.top {
    height: unset;
    display: flex;
    /* align-items: flex-end; */
}
label[for="clicks_date_to"] span, label[for="clicks_date_from"] span, label[for="selecter_type"] span, label[for="selecter_status"] span {
    display: flex;
    width: 100%;
}
</style>

					
		<h2 class="screen-reader-text">Навигация по списку записей</h2><div class="tablenav-pages"><span class="displaying-num" style="opacity:0">Показано 100 элеметов</span>
<div class="blocklinearrow prevline '.$prevblock.'" style="display: inline-block;">
<a class="first-page button" href="/wp-admin/admin.php?page=sendmails'.$selecter_status_text.'&link=1'.$selecter_type_text.''.$clicks_date_to_text.''.$clicks_date_from_text.'"><span class="screen-reader-text">Первая страница</span><span aria-hidden="true">«</span></a> 
<a class="prev-page button" href="/wp-admin/admin.php?page=sendmails'.$selecter_status_text.'&pager='.($numberpage-1).'&link=1'.$selecter_type_text.''.$clicks_date_to_text.''.$clicks_date_from_text.'"><span class="screen-reader-text">Предыдущая страница</span><span aria-hidden="true">‹</span></a>
</div>
<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Текущая страница</label>

<form method="get" style="display:inline-block;">
<input type="text" name="page" style="display:none;" value="sendmails"/>
<input type="text" name="selecter_status" style="display:none;" value="'.$selecter_status.'"/>
<input type="text" name="selecter_type" style="display:none;" value="'.$selecter_type.'"/>

<input type="text" name="clicks_date_from" style="display:none;" value="'.$clicks_date_from_text.'"/>
<input type="text" name="clicks_date_to" style="display:none;" value="'.$clicks_date_to_text.'"/>

<input class="current-page" id="current-page-selector" type="text" name="pager" value="'.($numberpage).'" size="2" aria-describedby="table-paging"><input type="submit" style="display:none"></form>

<span class="tablenav-paging-text"> из <span class="total-pages">'.round((count($rows) / 100), 0, PHP_ROUND_HALF_UP).'</span></span></span>
<div class="blocklinearrow nextline '.$nextblock.'" style="display: inline-block;">
<a class="next-page button" href="/wp-admin/admin.php?page=sendmails'.$selecter_status_text.'&pager='.($numberpage+1).'&link=1'.$selecter_type_text.''.$clicks_date_to_text.''.$clicks_date_from_text.'"><span class="screen-reader-text">Следующая страница</span><span aria-hidden="true">›</span></a>
<a class="last-page button" href="/wp-admin/admin.php?page=sendmails'.$selecter_status_text.'&pager='.round((count($rows) / 100), 0, PHP_ROUND_HALF_UP).'&link=1'.$selecter_type_text.''.$clicks_date_to_text.''.$clicks_date_from_text.'"><span class="screen-reader-text">Последняя страница</span><span aria-hidden="true">»</span></a></span></div>
</div>		
		<br class="clear">
	</div>';
    echo '<table class="wp-list-table widefat fixed striped table-view-list posts" width="100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Выделить все</label><input id="cb-select-all-1" type="checkbox"></td>';
    echo '<th scope="col" id="mail_id" class="manage-column column-primary sortable desc" width="50px">'.__('ID','er_theme').'</th>';
    echo '<th scope="col" id="type" class="manage-column column-sendmails_type" width="100px">'.__('Тип письма','er_theme').'</th>';
    echo '<th scope="col" id="user" class="manage-column column-sendmails_user" >'.__('Пользователь','er_theme').'</th>';
    echo '<th scope="col" id="email" class="manage-column column-sendmails_reg_date" >'.__('Регистрация','er_theme').'</th>';
    echo '<th scope="col" id="status" class="manage-column column-sendmails_status" width="100px">'.__('Статус','er_theme').'</th>';
    echo '<th scope="col" id="date" class="manage-column column-sendmails_date" width="150px">'.__('Дата отправки','er_theme').'</th>';
    echo '<th scope="col" id="modified" class="manage-column column-sendmails_modified" width="150px">'.__('Дата обновления','er_theme').'</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="the-list">';
    $u = 0;			 //print_r($rows);



    if(!empty($rows)) {
        foreach ($rows as $row) {
            $u++;

            if ($u >= $numfrom) {
                if($u == ($numfrom + 100)) {
                    break;
                }
                echo '<tr>';
                echo '<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-'.$row->id.'">'.__('Выбрать','er_theme').'</label>
				<input id="cb-select-'.$row->id.'" type="checkbox" name="comment[]" value="'.$row->id.'">
				<div class="locked-indicator">
					<span class="locked-indicator-icon" aria-hidden="true"></span>

				</div>
				</th>';
                $user = get_user_by('id',$row->user_id);
                $attachment_id = get_field('photo_profile', 'user_'. $row->user_id);
                echo '<td>'.$row->id.'</td>';
                echo '<td>'.$row->mail_type.'</td>';
                echo '<td>'; ?>
                <div class="comment_avatar" <?php if($attachment_id['sizes']['avatarimage'] && $attachment_id['sizes']['avatarimage'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['avatarimage']; ?>)" <?php }; ?>><?php if(is_registered_from_social($row->user_id)['main'] && is_registered_from_social($row->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($row->user_id)['main'].'"></div>'; }; ?></div>
                <?php
                if($user->first_name && !$user->last_name) {
                    echo $user->first_name;
                } elseif(!$user->first_name && $user->last_name) {
                    echo $user->last_name;
                } elseif($user->first_name && $user->last_name) {
                    echo $user->first_name.' '.$user->last_name; } else {
                    echo $user->user_nicename;
                }
                echo '<br />';
                echo $user->user_email;
                echo '</td>';
                echo '<td>'.$row->reg_date.'</td>';
                echo '<td>'.$row->status.'</td>';
                echo '<td>'.$row->sent.'</td>';
                echo '<td>'.$row->updated.'</td>';
                echo '</tr>';
            }
        }
    }
    echo '</tbody>';
    echo '</table></div>';


}

function send_mail_function($data) {
    print_r($data);
    //if($data['type'] == 'registration_cackle') {
    $password = wp_generate_password();
    wp_set_password( $password, $data['user_id'] );

    $headers = array(
        'From: Это развод™ <check@eto-razvod.info>',
        'content-type: text/html',
    );

    $user_bio = $data['activation_key'];
    $linkact = get_site_url().'/activation/?activation='.$user_bio.'&user='.$data['user_nicename'];
    $message = 'Добрый день, '.$data['display_name'].'!<br /><br />
Ранее вы регистрировались и оставляли комментарий на нашем сайте eto-razvod.ru!
<br /><br />
Спешим сообщить вам об обновлении функционала нашего сайта и автоматическом создании вашего личного кабинета. Теперь на нашем сайте вас ждет масса полезного, новые тарифы, еще больше актуальной информации и отзывов. Будем рады видеть вас на нашем сайте.
Так как вы уже оставляли отзыв на нашем сайте, мы уже зарегистрировали для вас личный кабинет. Вот данные для входа в него:
<br /><br />
Логин: '.$data['user_email'].'<br />
Пароль: '.$password.'<br />
<br /><br />
Если вы планируете пользоваться нашим сайтом и далее, пожалуйста, активируйте свой аккаунт, пройдя по этой ссылке: <a href="'.$linkact.'">'.$linkact.'</a>
<img src="https://etorazvod.ru/engine/mail_update_status.php?key='.$data['mail_key'].'" style="width:1px; height:1px;" />
.';
if (get_field('from_site_send', 'user_'.$data['user_id'])) {
	if (intval(get_field('from_site_send', 'user_'.$data['user_id'])) != 0) {
		wp_mail( $data['user_email'], 'ВАЖНО! Вы оставляли отзыв на нашем сайте - мы создали ЛК для вас ', $message, $headers );
	}
} else {
	wp_mail( $data['user_email'], 'ВАЖНО! Вы оставляли отзыв на нашем сайте - мы создали ЛК для вас ', $message, $headers );
}

    //}
}
/*
add_filter( 'get_the_date', 'meks_convert_to_time_ago', 10, 1 ); //override date display
add_filter( 'the_date', 'meks_convert_to_time_ago', 10, 1 ); //override date display
add_filter( 'get_the_time', 'meks_convert_to_time_ago', 10, 1 ); //override time display
add_filter( 'the_time', 'meks_convert_to_time_ago', 10, 1 ); //override time display
 */
/* Callback function for post time and date filter hooks */
/*
function meks_convert_to_time_ago( $orig_time ) {
	global $post;
	$orig_time = strtotime( $post->post_date );
	return human_time_diff( $orig_time, current_time( 'timestamp' ) ).' '.__( 'назад' );
}
*/

if (!function_exists('er_remove_default_tax_metabox')) {
function er_remove_default_tax_metabox() {
    $remove = array('companyactivetypes', 'deliverycompanytypes', 'growfactors', 'paymentmethods', 'companyoptiontypes', 'companypossibilities', 'companytradingmethods', 'companyterminals', 'companyproviders', 'companyregulators', 'companydocuments', 'gamegenres', 'gametypes', 'gametechnologies', 'paymentsystems', 'creditcardtypes', 'cardspecifications', 'fondmarkets', 'fondlist', 'countries', 'businessservices', 'saleservices', 'currencyoperationsservices', 'immodules', 'cryptocurrencies', 'ratingsafety', 'actions', 'functions', 'channels', 'currencies', 'accounttypes', 'languages', 'ordertypes', 'paymenttypes', 'citizenship', 'regions', 'drugscategories', 'brands', 'drugforms', 'ingridients', 'domainzones', 'kitchentypes', 'bookingways', 'tourcompanies', 'medcategories', 'paymentstatus', 'courcescategories', 'courcestypes', 'periodity', 'offerscategories', 'tools', 'tool', 'paymentmodels', 'companytypes', 'deliverytypes', 'shopcategories', 'postmates', 'deliverycompanies', 'boarrds_themes', 'taxsystems', 'setuptypes', 'tourtypes', 'couriers','device_types','compability_list','commissiontypes','field_types','buildclass','buildobjects_types','buildingtypes','cabinets','areas','plarforms','aviaservices','aviatariffs','aviatypes','carlabels','new_widgets','browsers','ensscryptmethods','protocols','smarttvs','gamepads','smarthomes','hotelservices','therapy_methods','deseases','charge_types','connections','ports','threats','walletsec','operations','wallet_types','wallets','consultcategories','activitiestobuy','interests','reports','companycategories','formats','earntypes','legalpractice','licsence_types','freedocs','usercategory','seofunctions','typesofsites','categorysites','cms','routers','affiliate-tags','uktypespay','nftcategories','risks','fitnessprogramms','programminglanguages','coursespecialites','formatzanyatiy');
    foreach ($remove as $item) {
        remove_meta_box( 'tagsdiv-'.$item, 'casino', 'side' );
    }
}
add_action( 'admin_menu' , 'er_remove_default_tax_metabox' );
}
if (!function_exists('er_disable_feeds')) {

function er_disable_feeds() {
    wp_redirect( home_url() );
    die;
}
}

// Disable global RSS, RDF & Atom feeds.
add_action( 'do_feed',      'er_disable_feeds', -1 );
add_action( 'do_feed_rdf',  'er_disable_feeds', -1 );
add_action( 'do_feed_rss',  'er_disable_feeds', -1 );
add_action( 'do_feed_rss2', 'er_disable_feeds', -1 );
add_action( 'do_feed_atom', 'er_disable_feeds', -1 );

// Disable comment feeds.
add_action( 'do_feed_rss2_comments', 'er_disable_feeds', -1 );
add_action( 'do_feed_atom_comments', 'er_disable_feeds', -1 );

// Prevent feed links from being inserted in the <head> of the page.
add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
remove_action( 'wp_head', 'feed_links',       2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

if (!function_exists('wpaudit_disable_date_archives')) {
function wpaudit_disable_date_archives( $query ){
    if( is_date() ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'parse_query', 'wpaudit_disable_date_archives' );
}



function my_admin_page_user_stat_menu() {
    $curr_user_id = get_current_user_id();

	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

    if(in_array($curr_user_id,array(9,1,2,17,27889))) {//
        add_menu_page(
            __( 'Статистика по юзерам', 'er_theme' ),
            __( 'Статистика по юзерам', 'er_theme' ),
            'manage_options',
            'userstat',
            'user_stater',
            'dashicons-schedule',
            4
        );
    }
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu' );
function user_stater() {
$get_current_user_id = get_current_user_id();

	wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8');
    $args_activated = array(
        'meta_query' => array(
            array(
                'key' => 'user_activation',
                'value' => 'yes',
                'compare' => '=='
            )
        )
    );
	$args_skills = array(
		'meta_query' => array(
		        'relation' => 'AND',
			array(
				'key' => 'user_skills',
				'compare' => 'EXISTS'
			),
			array(
				'key' => 'user_skills',
				'value' => '',
				'compare' => '!='
			)
		)
	);
	$args_mail = array(
		'search_columns' => 'email',
        'search' => '*@eto.ru'
	);
	$args_activated_c = array(
		'meta_query' => array(
            'relation' => 'AND',
			array(
				'key' => 'user_activation',
				'value' => 'yes',
				'compare' => '=='
			),
			array(
				'key' => 'from_cackle',
				'value' => true,
				'compare' => '=='
			),
		)
	);

	$args_c = array(
		'meta_query' => array(
			array(
				'key' => 'from_cackle',
				'value' => true,
				'compare' => '=='
			),
		)
	);
	$args_mail_and_cackle = array(
		'search_columns' => 'email',
		'search' => '*@eto.ru',
        'meta_query' => array(
		array(
			'key' => 'from_cackle',
			'value' => true,
			'compare' => '=='
		)
        )
	);


	$comp_user = array(
		'meta_query' => array(
			array(
			        'key' => 'user_reg_type',
				'value' => 'company',
				'compare' => '=='
			)
		)
	);
$comp_user_m = get_users($comp_user);
	$activated_cackle = get_users($args_activated_c);
	$usercackle = get_users($args_c);
	$usercackle_noemailandcackle = get_users($args_mail_and_cackle);
    $activated = get_users($args_activated);
	$mailed = get_users($args_mail);
    $skilled = get_users($args_skills);

    $all = count_users();
    echo '<pre>';
    //print_r($skilled[11]->data->ID);
    echo '</pre>';
    $arr = [];
	foreach ( $skilled as $item ) {
        $arr[] = get_field('user_skills','user_'.$item->data->ID);
    }
	//print_r($arr);
	//$arr2 = call_user_func_array('array_merge', $arr);
	foreach($arr as $subArray){
		foreach($subArray as $val){
			$arr2[] = $val;
		}
	}
	$arr_v = [];
	foreach ($arr2  as $item ) {
		$arr_v[$item][] = $item;
	}
	array_multisort(array_map('count', $arr_v), SORT_DESC, $arr_v);

	?>
	<script type='text/javascript' src='https://etorazvod.ru/wp-includes/js/jquery/jquery.min.js?ver=3.6.0' id='jquery-core-js'></script>
    <script type='text/javascript' src='https://etorazvod.ru/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.3.2' id='jquery-migrate-js'></script>
    <style>
    #wpcontent {
        background: #eff4f6;
    }
    .block_big_links ul {
        flex-wrap: wrap;
    }
    .popular_cats li {
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        padding: 5px 0;
        cursor: pointer;
        margin: 5px !important;
    }
    .popular_cats li span {
        display: flex !important;
        align-items: center;
    }

    .popular_cats li span > span {
        border-bottom: unset;
        background: #2270b1;
        margin-left: 5px;
        display: inline-block;
        width: 25px;
        display: flex;
        justify-content: center;
        border-radius: 4px;
        font-size: 16px;
        color: #FFF;
        border-bottom: unset !important;
        height: 17px;
        font-size: 10px;
        line-height: 1;
    }
    .block_big_links {
        padding-top: 0 !important;
    }

    div#er_block_big_links-block_604e0955ec9f3 > div {
        padding-top: 10px;
    }
    .flex.flex_column.p_t_b_block.block_popular_cats {
        padding: 0 !important;
    }
    ul.popular_cats * {
        cursor: unset !important;
    }

    .usbar_t_wp_main {
    display: flex;
    border: 4px solid #eff4f6;
    margin: 10px;
}

.usbar_t_wp {
    display: flex;
    flex-direction: column;
    margin: 10px;
    width: 120px;
}

.usbar_t_wp_title {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

.usbar_t_wp_count {
    display: flex;
    justify-content: center;
    font-size: 32px;
    font-weight: bold;
    font-style: italic;
    margin-top: 10px;
}

.usbar_t_wp_main > span:nth-of-type(1) {
    position: relative;
}

.usbar_t_wp_main > span:nth-of-type(1):before {content: " ";width: 4px;height: 100%;background: #eff4f6;position: absolute;right: -12px;}


.usbar_t_wp_main {}

.usbar_t_wp_main .dashicons-before {
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    text-align: center;
    z-index: 1;
    text-align: center;
    display: flex;
    justify-content: center;
    top: -20px;
}

.usbar_t_wp_main {
    position: relative;
}

.usbar_t_wp_main .dashicons-before:before {
    font-size: 30px;
    height: 40px;
    width: 40px;
    background: #eff4f6;
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pos_abs_badge {
    position: relative;
    background: #1d2327;
    color: #FFF;
    font-size: 10px;
    display: inline-block;
    border-radius: 50px;
    padding: 0px 5px;
    margin-right: 10px;
}
.trans_label {
    background: #f4eae1;
    border-radius: 5px;
    background-color: #F5EBE1;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    padding: 5px 10px;
}

.trans_label > a {
    border-bottom: unset;
    background: #2270b1;
    margin-left: 5px;
    display: inline-block;
    width: 25px;
    display: flex;
    justify-content: center;
    border-radius: 4px;
    font-size: 16px;
    color: #FFF;
    border-bottom: unset !important;
    font-size: 10px;
    line-height: 1;
    display: inline-block;
    width: unset;
    font-size: unset;
    text-decoration: none;
    font-size: 12px;
    display: flex;
    align-items: center;
    padding: 5px;
}

.trans_label {
    display: flex;
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.title_d {
    border-top: 1px solid #c3c3c3;
    padding-top: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.title_d {
    border-top: 1px solid #c3c3c3;
    padding-top: 15px;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-bottom: 5px;
}
    </style>
    <div class="flex flex_column p_t_b_block block_popular_cats ">
        <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Популярные навыки</h2>
    </div>
    <ul class="popular_cats flex color_dark_blue">

        <?php $i = 0;foreach ( $arr_v as $item ) {
            $i = ++$i;
            $f = get_field('tag_human_title','term_'.$item[0]);
            if ((intval($item[0]) != 0) && ($f != '')) {
	            if ($i == 1) { ?>
                    <li class="active"><span><?php echo $f .' <span>'.count($item).'</span>'; ?></span></li>
	            <? } else { ?>
                    <li><span id="a<?php echo $item[0]; ?>"><?php echo $f .' <span>'.count($item).'</span>'; ?></span></li>
	            <?php }
            }
	    } ?>
    </ul>

    <?php
    $get_users = get_users( [
		'meta_key'     => 'company_user',
		'meta_value'   => '',
		'meta_compare' => '!=',
	] );
    /*echo '<pre>';
	print_r($get_users);
	echo '</pre>';*/

	date_default_timezone_set( 'Europe/Moscow' );


	$date = new DateTime();
	$date_yesterday = $date->modify("-1 days")->format('d.m.Y');
	$date_yesterday = explode('.',$date_yesterday);

	$args_ols = [
		'count' => true,
		'date_query' => [
			//'after'     => array('year' => '2021', 'month' => '5', 'day' => '28' ),

			'year' => $date_yesterday[2],
			'month' => $date_yesterday[1],
			'day' => $date_yesterday[0],
			'inclusive' => true,
		],
	];


	$args = [
		'count' => true,
		'date_query' => [
			//'after'     => array('year' => '2021', 'month' => '5', 'day' => '28' ),

			'year' => date("Y"),
			'month' => date("m"),
			'day' => date("d"),
			'inclusive' => true,
		],
	];



    ?>


    <div id="er_block_big_links-block_604e0955ec9f3" class="block_big_links background_light flex flex_column p_t_b_block">
	<div class="wrap flex_column">
		<div class="flex big_links_icons">
		<ul class="flex first_tabs active">
            <li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($skilled); ?> <span class="color_gray color_light_gray">/ <?php echo $all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры с заполненными навыками / Общее число юзеров</span></li>
			<li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($activated); ?> <span class="color_gray color_light_gray">/ <?php echo $all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры с активацией / Общее число юзеров</span></li>
            <li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($activated_cackle); ?> <span class="color_gray color_light_gray">/ <?php echo count($usercackle).' / '.$all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Активированные из Cackle / Всего из Cackle / Общее число юзеров</span></li>
            <li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($mailed) - count($usercackle_noemailandcackle); ?> <span class="color_gray color_light_gray">/ <?php echo count($mailed).' / '.$all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры с пустыми e-mail (*@eto.ru) из соц-сетей (у которых не указан email в соцсетке) и не из Cackle / Юзеры с пустыми e-mail (*@eto.ru) из соц-сетей (у которых не указан email в соцсетке) и из Cackle / Общее число юзеров</span></li>
            <li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($usercackle_noemailandcackle); ?> <span class="color_gray color_light_gray">/ <?php echo $all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры с пустыми e-mail (*@eto.ru) только из Cackle / Общее число юзеров</span></li>
            <li class="white_block flex flex_column "><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($get_users); ?> <span class="color_gray color_light_gray">/ <?php echo $all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры с привязанными компаниями (тестовые наши компании, компании которые привязаны за оплату-виджеты)</span></li>

            <li class="white_block flex flex_column " style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;"><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><?php echo count($comp_user_m); ?> <span class="color_gray color_light_gray">/ <?php echo $all['total_users']; ?></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">Юзеры-представители компании</span></li>

<li class="white_block flex" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex">
                <div class="usbar_t_wp_main"><div class="dashicons-before dashicons-admin-comments" aria-hidden="true"><br></div><span class="usbar_t_wp"><span class="usbar_t_wp_title">За вчера:</span><span class="usbar_t_wp_count"><?php echo get_comments( $args_ols );?></span></span><span class="usbar_t_wp"><span class="usbar_t_wp_title">За сегодня:</span><span class="usbar_t_wp_count"><?php echo get_comments( $args );?></span></span></div>
                <?php
                $args_ols = [
		'date_query' => [
			//'after'     => array('year' => '2021', 'month' => '5', 'day' => '28' ),

			'year' => $date_yesterday[2],
			'month' => $date_yesterday[1],
			'day' => $date_yesterday[0],
			'inclusive' => true,
		],
	];
	//echo count(get_users( $args_ols ));

	$args = [
		'date_query' => [
			//'after'     => array('year' => '2021', 'month' => '5', 'day' => '28' ),

			'year' => date("Y"),
			'month' => date("m"),
			'day' => date("d"),
			'inclusive' => true,
		],
	];
	//echo count(get_users( $args ));
                ?>

                <div class="usbar_t_wp_main"><div class="dashicons-before dashicons-admin-users" aria-hidden="true"><br></div><span class="usbar_t_wp"><span class="usbar_t_wp_title">За вчера:</span><span class="usbar_t_wp_count"><?php echo count(get_users( $args_ols ));?></span></span><span class="usbar_t_wp"><span class="usbar_t_wp_title">За сегодня:</span><span class="usbar_t_wp_count"><?php echo count(get_users( $args ));;?></span></span></div>
            </li>


            <li class="white_block flex" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;">
           <div style="display: block;position: relative;" class="title_d"><span style="margin-right: 10px;"><h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Список представителей компании (зарегистрировались как представители)</h2></span><span></span>
                <?php
	                foreach ($comp_user_m as $user) {
                        /*if (get_field('balance','user_'.$user->ID) == 0) {

                        } else {*/
                            if ((strpos($user->user_email, 'eto-razvod.ru') !== false) || (strpos($user->user_email, 'itinside.ru') !== false) || (strpos($user->user_email, 'dikobraz@ya.ru') !== false) || (strpos($user->user_email, 'indexindemo@gmail.com') !== false)) {
                                echo '<div style="display: block;position: relative;" class="title_d"><span class="pos_abs_badge">Наш аккаунт</span><span style="margin-right: 10px;"><a href="https://etorazvod.ru/wp-admin/user-edit.php?user_id='.$user->ID.'">' . $user->user_email . '</a></span><span></span></div>';
                            } else {
                                echo '<div style="display: block;position: relative;" class="title_d"><span style="margin-right: 10px;"><a href="https://etorazvod.ru/wp-admin/user-edit.php?user_id='.$user->ID.'">' . $user->user_email . '</a></span><span></span>';

                                	 // Restore global post data stomped by the_post().
                                echo '</div>';
                            }

                        //}

                    }
                ?>
            </li>

            <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Юзеры с балансами</h2>
            <li class="white_block flex" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;">
                <?php
                    $blogusers = get_users(
                        [
                            'meta_key'     => 'balance',
                            //'meta_value'   => '156690',
                            'meta_compare' => 'EXISTS',
                        ]
                     );
	                foreach ($blogusers as $user) {
                        if (get_field('balance','user_'.$user->ID) == 0) {

                        } else {
                            if ((strpos($user->user_email, 'eto-razvod.ru') !== false) || (strpos($user->user_email, 'itinside.ru') !== false) || (strpos($user->user_email, 'dikobraz@ya.ru') !== false) || (strpos($user->user_email, 'indexindemo@gmail.com') !== false)) {
                                echo '<div style="display: block;position: relative;" class="title_d"><span class="pos_abs_badge">Наш аккаунт</span><span style="margin-right: 10px;"><a href="https://etorazvod.ru/wp-admin/user-edit.php?user_id='.$user->ID.'">' . $user->user_email . '</a></span><span> ' . get_field('balance','user_'.$user->ID) . ' рублей</span></div>';
                            } else {
                                echo '<div style="display: block;position: relative;" class="title_d"><span style="margin-right: 10px;"><a href="https://etorazvod.ru/wp-admin/user-edit.php?user_id='.$user->ID.'">' . $user->user_email . '</a></span><span> ' . get_field('balance','user_'.$user->ID) . ' рублей</span>';

                                $post_v = array(
                                        'numberposts'	=> -1,
                                        'post_type'		=> 'tranzaktsii',
                                        'meta_query'	=> array(
                                            'relation'		=> 'AND',
                                            array(
                                                'key' => 'id_user',
                                                'value' => $user->ID,
                                                'compare' 	=> '=',
                                            ),
                                            array(
                                                'key' => 'add_options_status',
                                                'value' => 'yes',
                                                'compare' 	=> '=',
                                            ),
                                        ),
                                    );

                                $the_query = new WP_Query( $post_v );

                                ?>
                                <?php $i=0;

                                if( $the_query->have_posts() ): ?>
                                    <?php
                                    echo '<span class="trans_label">Транзации: ';
                                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                    $i = ++$i;
                                	//echo get_field('id_user',get_the_ID()).'<br>';
                                    echo '<a target="_blank" href="https://etorazvod.ru/wp-admin/post.php?post='.get_the_ID().'&action=edit">('.$i.') '.get_field('add_options_amount',get_the_ID()).' '.get_the_date('d-m-Y H:i:s',get_the_ID()).', </a>';
                                    endwhile;
                                    echo '</span>';


                                    echo '<span class="trans_label">Компании: ';
                                    $comp = get_field('company_user','user_'.$user->ID);
                                    $no_comp = '<a href="">Нет компании</a>';
                                    foreach ($comp as $item) {
                                        $no_comp = '';
                                        echo '<a target="_blank" href="'.get_the_permalink($item).'">'.get_the_title($item).'</a>';
                                    }
                                    echo $no_comp;
                                    echo '</span>';
                                    endif; ?>

                                <?php wp_reset_query();	 // Restore global post data stomped by the_post().
                                echo '</div>';
                            }

                        }

                    }
                ?>
            </li>
            <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Юзеры с email компаний (возможно)</h2>
            <li class="white_block flex" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;">
            <span class="turn_off button button_green button_medium  button_zero_radius font_small font_bold pointer">Скрыть со словом mail</span>
            </li>
            <li class="white_block flex email_lists" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));display: flex;flex-direction: column;">
                <?php
function find_users($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) {$chr[$needle] = $res;}
        }
        if(empty($chr)) {return false;}
        return min($chr);
}
$array_ban  = array('@ya.ru','@narod.ru','@myrambler.','@live.','@cmail.com', '@gmail.', '@mail.', '@yandex.','@icloud.','@itinside.ru','@eto.ru','@outlook.','@yahoo.','@postemail.','@tut.by','@ro.','@rambler.','@dropmail.','@list.','@bk.','@inbox.','@i.ua','@qip.ru','@autorambler','@freemail.','@ukr.','@mailforspam.com','@web.de','@master-mail.','@netmail8.com','@3mailapp.','@protonmail.','@bigmir.','@ngs.','@meta.','@eto-razvod.','@aol.com','@mailbox.org','@fexbox.org','@yopmail.com','biyac.','yaol.ru','mai.ru','@lenta.ru','emailo.pro','mailer2.net','@mailivw.com','@hotmail.com','@email.su','@fazmail.net','@aenmail.net','@googlemail.com','@xyu.su','@gmx.','@163');
                    $unique_mails = get_users(
                            array(
                                    'orderby' => 'ID',
                                    'order' => 'ASC'
                            )

                     );
	                foreach ($unique_mails as $item) {
	                    if (find_users(strtolower($item->user_email), $array_ban, 1)) {
	                    //if ((strpos($item->user_email, '@mail.') !== false) || (strpos($item->user_email, '@gmail.') !== false) || (strpos($item->user_email, '@ya.') !== false) || (strpos($item->user_email, '@ya.') !== false) || (strpos($item->user_email, '@yandex.') !== false)) {

	                    } else {
	                        if (get_field('user_activation','user_'.$item->ID) == 'yes') {
	                            $activ = '<span class="pos_abs_badge">Активирован</span>';
	                        } else {
	                            $activ = '';
	                        }
	                        $balance = get_field('balance','user_'.$item->ID);
	                        if ($balance) {
	                            $bal = $balance.' рублей';
	                        } else {
	                            $bal = '';
	                        }
	                        echo '<div style="display: block;position: relative;" class="title_d asfasf"><table><tr><td><span>'.$item->ID.'</span></td><td>'.$activ.'</td><td><span style="margin-right: 10px;"><a href="https://etorazvod.ru/wp-admin/user-edit.php?user_id='.$item->ID.'">' . $item->user_email . '</a></span></td><td><span>' .$bal. '</span></td></tr></table></div>';
	                    }
                    }
                ?>
            </li>
            <li class="white_block flex flex_column" style="width: calc(100% - (98px));flex: 0 0 calc(100% - (98px));"><span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline"><span class="color_gray color_light_gray"></span></span><span class="font_smaller color_dark_gray link_no_underline link_service_more">

            <?php
            if (count($get_users) > 0) {
                foreach ($get_users as $item) {
                    echo '<div class="get_u">';
                    echo '<span class="comps_a"><a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="https://etorazvod.ru/user/'.$item->data->user_nicename.'">'.$item->data->ID.'</a></span>'; //ID
                    echo '<span class="comps_a"><a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="https://etorazvod.ru/user/'.$item->data->user_nicename.'">'.$item->data->user_nicename.'</a></span>'; //ID
                    //echo $item->data->user_nicename; //username
                    echo '<span class="comps_a">'.$item->data->user_email.'</span>'; //user_email
                    echo '<div class="comps">';
                    foreach (get_field('company_user', 'user_'.$item->data->ID) as $item_l) {
                        echo '<a href="'.get_the_permalink().'">'.get_the_title($item_l).'</a>';
                    //print_r($item_l).'<br>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
            </span></li>
        </ul>
	</div>
</div>
<?php }

function my_admin_page_user_stat_menu_company_dashboards() {
	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

	if(in_array($curr_user_id,array(9,1,2,17,27889)) || in_array('beta_role',$user_roles)) {//
		add_menu_page(
			__( 'Заявки по компаниям', 'er_theme' ),
			__( 'Заявки по компаниям', 'er_theme' ),
			'manage_options',
			'company_dashboards',
			'user_stater_company_dashboards',
			'dashicons-schedule',
			4
		);
	}
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu_company_dashboards' );
function user_stater_company_dashboards() {
	wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8');
	wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css?ver=5.8');
	//https://etorazvod.ru/wp-content/themes/eto-razvod-1/css/rating.css?ver=5.8


	?>
    <style>
    .red_s {
    position: relative;
    /* background: red; */
}

.red_s:before {content: " ";width: 100%;height: 100%;position: absolute;background: rgb(110 104 104 / 18%);}

span.b_hide_test {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #2270b1;
    z-index: 1;
    border-radius: 4px;
    padding: 5px 10px;
    color: #FFF;
    font-weight: bold;
}
        #wpcontent {
            background: #eff4f6;
        }
        .block_big_links ul {
            flex-wrap: wrap;
        }
        span.type_contact_title {
    display: block;
    font-weight: 900;
}

span.type_contact_type {
    display: block;
}

span.type_contact_login {
    font-size: 20px;
}

.contact_t {
    /* margin-left: 20px; */
}

.contact_t > span {
    display: block;
    margin-left: 20px;
    background: #20b67c;
    color: #FFF;
    padding: 5px 20px;
    border-radius: 4px;
}
        .popular_cats li {
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            padding: 5px 0;
            cursor: pointer;
            margin: 5px !important;
        }
        .popular_cats li span {
            display: flex !important;
            align-items: center;
        }

        .popular_cats li span > span {
            border-bottom: unset;
            background: #2270b1;
            margin-left: 5px;
            display: inline-block;
            width: 25px;
            display: flex;
            justify-content: center;
            border-radius: 4px;
            font-size: 16px;
            color: #FFF;
            border-bottom: unset !important;
            height: 17px;
            font-size: 10px;
            line-height: 1;
        }
        .block_big_links {
            padding-top: 0 !important;
        }

        div#er_block_big_links-block_604e0955ec9f3 > div {
            padding-top: 10px;
        }
        .flex.flex_column.p_t_b_block.block_popular_cats {
            padding: 0 !important;
        }
        ul.popular_cats * {
            cursor: unset !important;
        }
        span.b_hide_test_2 {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: #21b57b;
    z-index: 1;
    border-radius: 4px;
    padding: 5px 10px;
    color: #FFF;
    font-weight: bold;
    }


.pos_rel {
    position: relative;
}
    </style>
    <div class="flex flex_column p_t_b_block block_popular_cats ">
        <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Заявки на привязку</h2>
    </div>
    <div class="wrap flex_column">
        <div class="white_block rating_table">
        <?php

			global $post;
$post_type = 'request_add_company';

    // Query parameters
        $paged = (isset($_GET['paged'])) ? max(1, intval($_GET['paged'])) : 1;
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 10,
        'paged'          => $paged,
    );
    $custom_query = new WP_Query($args);
            /*
$myposts = get_posts( [
'posts_per_page' => 10,
'post_type'=>'request_add_company',
'orderby' => 'date',
'order' => 'DESC',
] );*/

foreach( $custom_query->posts as $post ){


$status_m = '';
global $post_m;

$args_all = array(
	'posts_per_page'	=> -1,
	'post_type'		=> 'tranzaktsii',
	'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'		=> 'connect_company',
			'value'		=> get_the_ID(),
			'compare'	=> 'IN'
		)
	)
);

$myposts = get_posts($args_all);

foreach( $myposts as $post_m ){
	setup_postdata( $post_m );
	$status = get_field('add_options_status',$post_m->ID);
	if ($status == 'yes') {
	    $status_m = '<span class="paid_info" style="background: #3cb868;color: #FFF;padding: 5px;border-radius: 4px;">Оплачено</span>';
	} else {
	    $status_m = '<span class="paid_info" style="background: #FF0000;color: #FFF;padding: 5px;border-radius: 4px;white-space: nowrap;">Нет оплаты</span>';;
	}
}
wp_reset_postdata();


	setup_postdata( $post );
	$comp_id = get_field('comp_id',get_the_ID())[0];
    $type = get_field('type',get_the_ID());
    if ($type == 'pay') {
        $type_m = '<span class="type_m">Оплата</span>';
    } else {
        $type_m = '<span class="type_m">Виджет</span>';
    }
    $img = '';
    //wp_get_attachment_image_url( $attachment_id, $size, $icon );
    $image_array = get_field('image_array',get_the_ID());

    if (count($image_array) != 0) {
        foreach ($image_array as $item) {
            if ($item['image_set'] != '') {
                $img .= '<a href="'.wp_get_attachment_url( $item['image_set'] ).'" target="_blank"><img src="'.wp_get_attachment_image_url( $item['image_set'], 'full',true).'" alt=""></a>';
            }

    }
    }
    $status_real = '';
$company_ids2 = get_field('comp_statuses', 'user_'.get_field('user_id',get_the_ID()));
    foreach ($company_ids2  as $item ) {

                if ($item['id_conn_comp'][0] == get_the_ID()) {
                    $status_real = '<span class="status_m_main" data-id-v="'.get_the_ID().'">Статус:<br>'.$item['status']['label'].'</span>';
                }

			}
    if  (get_field('user_id',get_the_ID()) == 17) {
            $testb = 'red_s';
            $testa = '<span class="b_hide_test">Тестовая заявка</span>';

        $testa = '';
        if (get_field('add_or_connect',get_the_ID()) == 'Заявка') {
            $testa = '<span class="b_hide_test">Тестовая заявка</span><span class="b_hide_test_2">Заявка-добавление</span>';
        } else {
            $testa = '<span class="b_hide_test">Тестовая заявка</span><span class="b_hide_test_2">Привязка существующей</span>';
        }
    } else {
        $testb = 'pos_rel';
        $testa = '';
        if (get_field('add_or_connect',get_the_ID()) == 'Заявка') {
            $testa = '<span class="b_hide_test_2">Заявка-добавление</span>';
        } else {
            $testa = '<span class="b_hide_test_2">Привязка существующей</span>';
        }
    }
	?>
<div class="main_row rating_table_row font_smaller <?php echo $testb; ?>" id="row_1"><?php echo $testa; ?><div class="rating_table_td rating_field_number font_bold"><?php echo get_the_date('j.n.Y',get_the_ID()); ?></div><div class="rating_table_td item_first rating_field_name"><?php echo review_logo($comp_id); ?><div class="company_title line_big"><a href="<?php echo get_the_permalink($comp_id); ?>" class="link_no_underline company_name font_bold font_new_medium color_dark_blue m_b_10"><?php echo get_field('company_name',get_the_ID());?></a><div class="rating_table_link_more pointer color_dark_gray"><?php echo get_user_by('ID', get_field('user_id',get_the_ID()))->data->user_email; echo $type_m; ?></div></div></div><div class="rating_table_td item_2 blueh rating_field_system_count_reviews"><span class="color_dark_blue"><?php echo get_field('comment_company',get_the_ID()); ?></span></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"><?php echo $status_m; ?></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"></div><div class="rating_table_td item_5 rating_field_system_rating"><?php echo $status_real; ?></div><!--<div class="rating_table_td item_6 rating_field_free_demo"> </div>--><div class="rating_table_td item_last bright rating_field_actives"><div class="img_wrap"><?php echo $img; ?></div></div><div class="rating_table_td item_2 blueh contact_t"><?php if (    get_field('contact_type', get_the_ID()) || get_field('messanger_login', get_the_ID())   ) { ?><span class="color_dark_blue"><span class="type_contact_title">Способ связи:</span><span class="type_contact_type"><?php echo get_field('contact_type', get_the_ID()); ?></span><span class="type_contact_login"><?php echo get_field('messanger_login', get_the_ID()); ?></span></span><?php } ?></div><div class="rating_row_more flex flex_column"><div class="rating_sub_row flex rating_sub_row_first"><div class="rating_add_signature"><span class="color_dark_gray font_smaller font_underline_dotted">Форекс брокер</span></div><div class="rating_sub_row_td rating_field_min_dep"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Мин. первый депозит</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">От 1 USD</div></div><div class="rating_sub_row_td rating_field_withdrawal_methods"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Способы вывода</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><div class="list_style_2">Наличные, Банковский перевод</div></div></div><div class="rating_sub_row_td rating_field_terminals_list"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Терминалы</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">MetaTrader 4, FinamTrade, QUIK, Transaq</div></div><div class="rating_sub_row_td rating_field_system_count_percents"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Общий рейтинг</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><span class="font_bold icon_rating_good">0%</span><span class="font_bold icon_rating_bad">100%</span></div></div></div><div class="rating_sub_row row_mini flex"><div class="rating_sub_row_td flex rating_field_regulators_list"><div class="rating_sub_row_td_title color_medium_gray">Регуляторы</div><div class="rating_sub_row_td_content color_dark_blue font_small ">ЦБ РФ, ФСФР России</div></div><div class="rating_sub_row_td flex rating_field_company_established"><div class="rating_sub_row_td_title color_medium_gray">Дата основания</div><div class="rating_sub_row_td_content color_dark_blue font_small ">2015 год</div></div><div class="rating_sub_row_td flex rating_field_affiliate_program"><div class="rating_sub_row_td_title color_medium_gray">Партнерка</div><div class="rating_sub_row_td_content color_dark_blue font_small "><a class="field_link" href="https://etorazvod.ru/visit/forex-finam/" target="_blank" rel="nofollow">Открыть</a><span class="field_exist yes">Есть</span></div></div></div><div class="rating_sub_row row_buttons flex"><a href="https://etorazvod.ru/review/forex-finam/" class="button inline_block button_green pointer font_small font_bold link_no_underline" target="_blank">Обзор Финам Форекс</a><a class="button inline_block button_violet pointer font_small font_bold link_no_underline" href="https://etorazvod.ru/visit/forex-finam/" target="_blank">forex.finam.ru</a></div></div></div>
	<?php
}
        $total_pages = $custom_query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="pagination">';
            echo paginate_links(array(
                'base'      => admin_url('admin.php?page=company_dashboards&paged=%#%'),
                'format'    => '&paged=%#%',
                'current'   => $paged,
                'total'     => $total_pages,
            ));
            echo '</div>';
        }
        wp_reset_postdata();
        ?>
        </div>
    </div>
<?php }


function my_admin_page_user_stat_menu_company_dashboards_change_info() {
	$curr_user_id = get_current_user_id();

	if(in_array($curr_user_id,array(17))) {//9,1,2,
		add_menu_page(
			__( 'Изменение данных по компании', 'er_theme' ),
			__( 'Изменение данных по компании', 'er_theme' ),
			'manage_options',
			'company_dashboards_change_info',
			'user_stater_company_dashboards_change_info',
			'dashicons-schedule',
			4
		);
	}
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu_company_dashboards_change_info' );
function user_stater_company_dashboards_change_info() {
    acf_form_head();
	wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8');
	wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css?ver=5.8');
	//https://etorazvod.ru/wp-content/themes/eto-razvod-1/css/rating.css?ver=5.8
echo '<div class="w_50_wrapper"><div class="w_50">';
$acf_form_settings = array(
	                'post_id'      => 95,
	                'post_title'   => false,
	                'post_content' => false,
	                'submit_value' => __( 'Обновить' ),
                );
                acf_form( $acf_form_settings );
                echo '</div>';
                echo '<div class="w_50">';
$acf_form_settings = array(
	                'post_id'      => 156139,
	                'post_title'   => false,
	                'post_content' => false,
	                'form' => false,
	                'submit_value' => __( 'Обновить' ),
                );
                acf_form( $acf_form_settings );
                echo '</div></div>';


	?>
    <style>
        #wpcontent {
            background: #eff4f6;
        }
        .block_big_links ul {
            flex-wrap: wrap;
        }
        .popular_cats li {
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            padding: 5px 0;
            cursor: pointer;
            margin: 5px !important;
        }
        .popular_cats li span {
            display: flex !important;
            align-items: center;
        }

        .popular_cats li span > span {
            border-bottom: unset;
            background: #2270b1;
            margin-left: 5px;
            display: inline-block;
            width: 25px;
            display: flex;
            justify-content: center;
            border-radius: 4px;
            font-size: 16px;
            color: #FFF;
            border-bottom: unset !important;
            height: 17px;
            font-size: 10px;
            line-height: 1;
        }
        .block_big_links {
            padding-top: 0 !important;
        }

        div#er_block_big_links-block_604e0955ec9f3 > div {
            padding-top: 10px;
        }
        .flex.flex_column.p_t_b_block.block_popular_cats {
            padding: 0 !important;
        }
        ul.popular_cats * {
            cursor: unset !important;
        }
    </style>
    <div class="flex flex_column p_t_b_block block_popular_cats ">
        <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Заявки на привязку</h2>
    </div>
    <div class="wrap flex_column">
        <div class="white_block rating_table">
        <?php

			global $post;

$myposts = get_posts( [
'posts_per_page' => -1,
'post_type'=>'request_add_company',
'orderby' => 'date',
'order' => 'DESC',
] );

foreach( $myposts as $post ){


$status_m = '';
global $post_m;

$args_all = array(
	'posts_per_page'	=> -1,
	'post_type'		=> 'tranzaktsii',
	'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'		=> 'connect_company',
			'value'		=> get_the_ID(),
			'compare'	=> 'IN'
		)
	)
);

$myposts = get_posts($args_all);

foreach( $myposts as $post_m ){
	setup_postdata( $post_m );
	$status = get_field('add_options_status',$post_m->ID);
	if ($status == 'yes') {
	    $status_m = '<span class="paid_info" style="background: #3cb868;color: #FFF;padding: 5px;border-radius: 4px;">Оплачено</span>';
	} else {
	    $status_m = '<span class="paid_info" style="background: #FF0000;color: #FFF;padding: 5px;border-radius: 4px;white-space: nowrap;">Нет оплаты</span>';;
	}
}
wp_reset_postdata();


	setup_postdata( $post );
	$comp_id = get_field('comp_id',get_the_ID())[0];
    $type = get_field('type',get_the_ID());
    if ($type == 'pay') {
        $type_m = '<span class="type_m">Оплата</span>';
    } else {
        $type_m = '<span class="type_m">Виджет</span>';
    }
    $img = '';
    //wp_get_attachment_image_url( $attachment_id, $size, $icon );
    $image_array = get_field('image_array',get_the_ID());

    if (count($image_array) != 0) {
        foreach ($image_array as $item) {
            if ($item['image_set'] != '') {
                $img .= '<a href="'.wp_get_attachment_url( $item['image_set'] ).'" target="_blank"><img src="'.wp_get_attachment_image_url( $item['image_set'], 'full',true).'" alt=""></a>';
            }

    }
    }
    $status_real = '';
$company_ids2 = get_field('comp_statuses', 'user_'.get_field('user_id',get_the_ID()));
    foreach ($company_ids2  as $item ) {

                if ($item['id_conn_comp'][0] == get_the_ID()) {
                    $status_real = '<span class="status_m_main">Статус:<br>'.$item['status']['label'].'</span>';
                }

			}
	?>

<div class="main_row rating_table_row font_smaller" id="row_1"><div class="rating_table_td rating_field_number font_bold"><?php echo get_the_date('j.n.Y',get_the_ID()); ?></div><div class="rating_table_td item_first rating_field_name"><?php echo review_logo($comp_id); ?><div class="company_title line_big"><a href="<?php echo get_the_permalink($comp_id); ?>" class="link_no_underline company_name font_bold font_new_medium color_dark_blue m_b_10"><?php echo get_field('company_name',get_the_ID());?></a><div class="rating_table_link_more pointer color_dark_gray"><?php echo get_user_by('ID', get_field('user_id',get_the_ID()))->data->user_email; echo $type_m; ?></div></div></div><div class="rating_table_td item_2 blueh rating_field_system_count_reviews"><span class="color_dark_blue"><?php echo get_field('comment_company',get_the_ID()); ?></span></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"><?php echo $status_m; ?></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"></div><div class="rating_table_td item_5 rating_field_system_rating"><?php echo $status_real; ?></div><!--<div class="rating_table_td item_6 rating_field_free_demo"> </div>--><div class="rating_table_td item_last bright rating_field_actives"><div class="img_wrap"><?php echo $img; ?></div></div><div class="rating_row_more flex flex_column"><div class="rating_sub_row flex rating_sub_row_first"><div class="rating_add_signature"><span class="color_dark_gray font_smaller font_underline_dotted">Форекс брокер</span></div><div class="rating_sub_row_td rating_field_min_dep"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Мин. первый депозит</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">От 1 USD</div></div><div class="rating_sub_row_td rating_field_withdrawal_methods"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Способы вывода</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><div class="list_style_2">Наличные, Банковский перевод</div></div></div><div class="rating_sub_row_td rating_field_terminals_list"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Терминалы</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">MetaTrader 4, FinamTrade, QUIK, Transaq</div></div><div class="rating_sub_row_td rating_field_system_count_percents"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Общий рейтинг</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><span class="font_bold icon_rating_good">0%</span><span class="font_bold icon_rating_bad">100%</span></div></div></div><div class="rating_sub_row row_mini flex"><div class="rating_sub_row_td flex rating_field_regulators_list"><div class="rating_sub_row_td_title color_medium_gray">Регуляторы</div><div class="rating_sub_row_td_content color_dark_blue font_small ">ЦБ РФ, ФСФР России</div></div><div class="rating_sub_row_td flex rating_field_company_established"><div class="rating_sub_row_td_title color_medium_gray">Дата основания</div><div class="rating_sub_row_td_content color_dark_blue font_small ">2015 год</div></div><div class="rating_sub_row_td flex rating_field_affiliate_program"><div class="rating_sub_row_td_title color_medium_gray">Партнерка</div><div class="rating_sub_row_td_content color_dark_blue font_small "><a class="field_link" href="https://etorazvod.ru/visit/forex-finam/" target="_blank" rel="nofollow">Открыть</a><span class="field_exist yes">Есть</span></div></div></div><div class="rating_sub_row row_buttons flex"><a href="https://etorazvod.ru/review/forex-finam/" class="button inline_block button_green pointer font_small font_bold link_no_underline" target="_blank">Обзор Финам Форекс</a><a class="button inline_block button_violet pointer font_small font_bold link_no_underline" href="https://etorazvod.ru/visit/forex-finam/" target="_blank">forex.finam.ru</a></div></div></div>
	<?php
}
        wp_reset_postdata();
        ?>
        </div>
    </div>
<?php }


function my_admin_page_user_stat_menu_company_dashboards_change_info_new_promocodes() {
	$curr_user_id = get_current_user_id();
	if(in_array($curr_user_id,array(17))) {//9,1,2,
		add_menu_page(
			__( 'Промокоды от компаний', 'er_theme' ),
			__( 'Промокоды от компаний', 'er_theme' ),
			'manage_options',
			'company_dashboards_new_promos',
			'user_stater_company_dashboards_change_info_new_promocodes',
			'dashicons-megaphone',
			4
		);
	}
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu_company_dashboards_change_info_new_promocodes' );
function user_stater_company_dashboards_change_info_new_promocodes() {
    acf_form_head();
	wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8');
	wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css?ver=5.8');
	//https://etorazvod.ru/wp-content/themes/eto-razvod-1/css/rating.css?ver=5.8



	?>
    <style>
        #wpcontent {
            background: #eff4f6;
        }
        .block_big_links ul {
            flex-wrap: wrap;
        }
        .popular_cats li {
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            padding: 5px 0;
            cursor: pointer;
            margin: 5px !important;
        }
        .popular_cats li span {
            display: flex !important;
            align-items: center;
        }

        .popular_cats li span > span {
            border-bottom: unset;
            background: #2270b1;
            margin-left: 5px;
            display: inline-block;
            width: 25px;
            display: flex;
            justify-content: center;
            border-radius: 4px;
            font-size: 16px;
            color: #FFF;
            border-bottom: unset !important;
            height: 17px;
            font-size: 10px;
            line-height: 1;
        }
        .block_big_links {
            padding-top: 0 !important;
        }

        div#er_block_big_links-block_604e0955ec9f3 > div {
            padding-top: 10px;
        }
        .flex.flex_column.p_t_b_block.block_popular_cats {
            padding: 0 !important;
        }
        ul.popular_cats * {
            cursor: unset !important;
        }
    </style>
    <div class="flex flex_column p_t_b_block block_popular_cats ">
        <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Новые промокоды</h2>
    </div>
    <div class="wrap flex_column">
        <div class="white_block rating_table">
        <?php

function my_posts_where_promocodes( $where ) {

			$where = str_replace( "meta_key = 'promocodes_items_$", "meta_key LIKE 'promocodes_items_%", $where );

			return $where;
		}

		add_filter( 'posts_where', 'my_posts_where_promocodes' );
		$args = array(
			'post_type'      => 'promocodes',
			'post_status'    => array(
				'publish',
				'pending',
				'draft',
				'auto-draft',
				'future',
				'private',
				'inherit',
				'trash'
			),
			'posts_per_page' => - 1,
			'meta_query'     => array(
                'relation' => 'OR',
				array(
					'key'     => 'promocodes_items_$_hide_promos',
					'compare' => '==',
					'value'   => 'yes',
				),
				array(
					'key'     => 'promocodes_items_$_hide_promos',
					'compare' => '==',
					'value'   => 'removed',
				)
			)
		);


// query
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ):while ( $the_query->have_posts() ) : $the_query->the_post();
			echo '<div class="rower"><span>'.get_the_title().'</span>';
			$num = 0;
			foreach (get_field('promocodes_items') as $item) {
			    $num = ++$num;
			    if ($item['hide_promos'] == 'yes') {
			        echo '<span>'.$item['title'].'</span>';
			        echo '<span>'.$num.'</span>';
			        echo '<span>Подтвердить добавление нового</span>';
			    }

			    if ($item['hide_promos'] == 'removed') {
			        echo '<span>'.$item['title'].'</span>';
			        echo '<span>'.$num.'</span>';
			        echo '<span>Подтвердить удаление промо</span>';
			    }
			}
			echo '</div>';
		endwhile;
		endif;
        ?>
        </div>
    </div>
<?php }




function my_admin_page_mass_update_reviews() {
	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

	if(in_array($curr_user_id,array(9,2,1,12))) {//9,1,2,
		add_menu_page(
            __( 'Обновление обзоров', 'er_theme' ),
            __( 'Обновление обзоров', 'er_theme' ),
            'manage_options',
            'mass_update_reviews',
            'my_admin_page_mass_update_reviews_template',
            'dashicons-schedule',
            3
        );
	}
}


if(!function_exists('mass_update_reviews_show_field_values')) {
    add_action('wp_ajax_mass_update_reviews_show_field_values', 'mass_update_reviews_show_field_values');
    add_action('wp_ajax_nopriv_mass_update_reviews_show_field_values', 'mass_update_reviews_show_field_values');
    function mass_update_reviews_show_field_values() {

        $data = $_POST;
        $result = '';
       if($data['field_to_update'] == 'none') {
           $result .= 'none';
       } elseif($data['field_to_update'] == 'education_specialities') {
            $result .= '<div class="admin_autocomplete_select" data-type="taxonomy" data-field="'.$data['field_to_update'].'" data-name="coursespecialites">';
            $field_values = get_terms( 'coursespecialites', [
                'hide_empty' => false,
            ] );
            if(!empty($field_values)) {
                $result .= '<select size="5" multiple name="field_values_list">';
                    foreach ($field_values as $item) {
                        $result .= '<option value="'.$item->term_id.'">'.$item->name.'</option>';
                    }
                $result .= '</select>';
               // print_r($company_types);
               /* $result .= '<ul class="field_values">';
                $result .= '<li data-id="none">'.__('Выберите','er_theme').'</li>';
                foreach ($field_values as $item) {
                    $result .= '<li data-id="'.$item->term_id.'">'.$item->name.'</li>';
                }
                $result .= '</ul>';*/
            }
            $result .= '<div class="insert_field_values"></div>';
            $result .= '</div>';

       } elseif($data['field_to_update'] == 'education_programming_languages') {
           $result .= '<div class="admin_autocomplete_select" data-type="taxonomy" data-field="'.$data['field_to_update'].'" data-name="programminglanguages">';
            $field_values = get_terms( 'programminglanguages', [
                'hide_empty' => false,
            ] );
            if(!empty($field_values)) {
               // print_r($company_types);
                $result .= '<select size="5" multiple name="field_values_list">';
                    foreach ($field_values as $item) {
                        $result .= '<option value="'.$item->term_id.'">'.$item->name.'</option>';
                    }
                $result .= '</select>';
                /*$result .= '<ul class="field_values">';
                $result .= '<li data-id="none">'.__('Выберите','er_theme').'</li>';
                foreach ($field_values as $item) {
                    $result .= '<li data-id="'.$item->term_id.'">'.$item->name.'</li>';

                }
                $result .= '</ul>';*/
            }
            $result .= '<div class="insert_field_values"></div>';
            $result .= '</div>';
       }

        echo $result;
        die;
    }

}

if(!function_exists('mass_update_reviews_form')) {
    add_action('wp_ajax_mass_update_reviews_form', 'mass_update_reviews_form');
    add_action('wp_ajax_nopriv_mass_update_reviews_form', 'mass_update_reviews_form');
    function mass_update_reviews_form() {
        $data = $_POST;
        //print_r($data);
        $errors = array();
        if(!$data['field_to_update'] || $data['field_to_update'] == '') {
            $errors[] = __('Укажите поле','er_theme');
        }
        if(!$data['field_values'] || empty($data['field_values'])) {
            $errors[] = __('Укажите хотя бы одно значение','er_theme');
        }
        if(!$data['field_companies'] || empty($data['field_companies'])) {
            $errors[] = __('Укажите хотя бы одну компанию','er_theme');
        }
        if(!empty($errors)) {
            $result['status'] = 'error';
            $message_errors = '<ul>';
            foreach ($errors as $error) {
                $message_errors .= '<li>'.$error.'</li>';
            }
            $message_errors .= '</ul>';
            $result['message'] = $message_errors;

        } else {


            foreach ($data['field_companies'] as $company_id) {

                $current_values = get_field($data['field_to_update'],$company_id);
                echo 'curr:';
                print_r($current_values);
                $current_values_count = count($current_values);
                if(empty($current_values)) {
                    update_field($data['field_to_update'],$data['field_values'],$company_id);
                } else {
                    foreach ($data['field_values'] as $field_value) {
                        if(!in_array($field_value,$current_values)) {
                            $current_values[] = $field_value;
                        }
                    }
                }
                $current_values_count_new = count($current_values);
                if($current_values_count_new != $current_values_count) {
                    update_field($data['field_to_update'],$current_values,$company_id);
                }

            }

            $result['status'] = 'ok';
            $result['message'] = 'ok';
        }
        echo json_encode($result);
        die;
    }
}
if(!function_exists('mass_update_reviews_show_fields')) {
    add_action('wp_ajax_mass_update_reviews_show_fields', 'mass_update_reviews_show_fields');
    add_action('wp_ajax_nopriv_mass_update_reviews_show_fields', 'mass_update_reviews_show_fields');
    function mass_update_reviews_show_fields() {

        $data = $_POST;
        $result = '';
       // $result .= $data['selected_company'];
       if($data['selected_company'] == 'none') {
           $result .= 'none';
       } elseif($data['selected_company'] == 'learn') {
            $result .= '<select name="field_to_update">';
                $result .= '<option value="none" selected>'.__('Выберите поле','er_theme').'</option>';
                $result .= '<option value="education_specialities">'.__('Специальности','er_theme').'</option>';
                $result .= '<option value="education_programming_languages">'.__('Языки прогрммирования','er_theme').'</option>';
            $result .= '</select>';
       } else {
           $result .= '<div class="default_text">'.__('На данный момент массовое обновление доступно только для метки learn','er_theme').'</div>';
       }

        echo $result;
        die;
    }

}

add_action( 'admin_menu', 'my_admin_page_mass_update_reviews' );
if(!function_exists('my_admin_page_mass_update_reviews_template')) {
    function my_admin_page_mass_update_reviews_template() {
        wp_enqueue_script( 'mass_update_reviews', get_template_directory_uri() . '/js/mass_update_reviews.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/mass_update_reviews.js') );
        wp_enqueue_style('mass_update_reviews', get_template_directory_uri() . '/css/mass_update_reviews.css?ver=5.8');
        $result = '';
        $result .= '<div id="wpbody" role="main">';
            $result .= '<div id="wpbody-content">';
                $result .= '<div class="wrap">';
                    $result .= '<h1>'.__('Массовое обновление обзоров','er_theme').'</h1>';
                    $result .= '<div>';
                        $result .= '<form id="mass_update_reviews_form" action="'.admin_url( 'admin-ajax.php' ).'" method="post" class="inactive">';
                        $result .= '<input type="hidden" name="action" value="mass_update_reviews_form" />';
                        $result .= '<h4>'.__('Выберите тип компании','er_theme').'</h4>';
                        $result .= '<div class="mass_update_reviews_company_type">';
                        $company_types = get_terms( 'companytypes', [
                            'hide_empty' => false,
                        ] );
                        if(!empty($company_types)) {
                           // print_r($company_types);
                            $result .= '<select name="company_type">';
                            $result .= '<option value="none">'.__('Выберите тип компании','er_theme').'</option>';
                            foreach ($company_types as $company_type) {
                                $tag_new = get_term_by('slug',$company_type->name,'affiliate-tags');
                                $result .= '<option data-new-id="'.$tag_new->term_id.'" value="'.$company_type->name.'">'.$company_type->name.'</option>';
                            }
                            $result .= '</select>';
                        }

                        $result .= '</div>';

                        $result .= '<div class="mass_update_reviews_field_name">';
                        $result .= '<h4>'.__('Выберите поле','er_theme').'</h4>';
                        $result .= '</div>';

                        $result .= '<div class="mass_update_reviews_field_values">';
                            $result .= '<h4>'.__('Укажите значения','er_theme').'</h4>';

                        $result .= '</div>';

                        $result .= '<div class="mass_update_reviews_reviews_list" id="mass_update_reviews_reviews_list">';
                            $result .= '<h4>'.__('Укажите обзоры для добавления значений в выбранное поле','er_theme').'</h4>';
                            $result .= '<div class="admin_autocomplete_select" data-type="reviews" data-name="education">';
                            $result .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
                                $result .= '<input name="autocomplete_text" type="text" value="" placeholder="'.__('Введите название компании','er_theme').'" />';
                                    $result .= '<input name="autocomplete_result" type="hidden" value="" />';
                                    $result .= '<div class="autocomplete_icon_search"></div>';
                                    $result .= '<div class="autocomplete_icon_close"></div>';
                                    $result .= '<div class="autocomplete_search_results"></div>';
                                $result .= '</div>';
                                $result .= '<div class="outside_form_container"></div>';
                                $result .= '<div class="insert_field_companies"></div>';
                            $result .= '</div>';

                        $result .= '</div>';
                        $result .= '<div class="mass_update_reviews_submit_container">';
                        $result .= '<input type="submit" class="button-primary" value="'.__('Добавить значения в указанные обзоры','er_theme').'" />';
                        $result .= '</div>';
                        $result .= '</form>';
                    $result .= '</div>';
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</div>';
        echo $result;

    }
}


function my_admin_page_user_stat_menu_company_dashboards_pub_to_blog() {
	$curr_user_id = get_current_user_id();

	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

	if(in_array($curr_user_id,array(9,1,2,17,27889)) || in_array('beta_role',$user_roles)) {//9,1,2,
		add_menu_page(
			__( 'Статьи для публикации в блоге', 'er_theme' ),
			__( 'Статьи для публикации в блоге', 'er_theme' ),
			'manage_options',
			'pub_to_blog',
			'user_stater_pub_to_blog',
			'dashicons-schedule',
			4
		);
	}
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu_company_dashboards_pub_to_blog' );






function user_stater_pub_to_blog() {
	wp_enqueue_style('comments', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css?ver=5.8');
	wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css?ver=5.8');
	//https://etorazvod.ru/wp-content/themes/eto-razvod-1/css/rating.css?ver=5.8


	?>
    <style>
    .red_s {
    position: relative;
    /* background: red; */
}

.red_s:before {content: " ";width: 100%;height: 100%;position: absolute;background: rgb(110 104 104 / 18%);}

span.b_hide_test {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #2270b1;
    z-index: 1;
    border-radius: 4px;
    padding: 5px 10px;
    color: #FFF;
    font-weight: bold;
}
        #wpcontent {
            background: #eff4f6;
        }
        .block_big_links ul {
            flex-wrap: wrap;
        }
        span.type_contact_title {
    display: block;
    font-weight: 900;
}

span.type_contact_type {
    display: block;
}

span.type_contact_login {
    font-size: 20px;
}

.contact_t {
    /* margin-left: 20px; */
}

.contact_t > span {
    display: block;
    margin-left: 20px;
    background: #20b67c;
    color: #FFF;
    padding: 5px 20px;
    border-radius: 4px;
}
        .popular_cats li {
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            padding: 5px 0;
            cursor: pointer;
            margin: 5px !important;
        }
        .popular_cats li span {
            display: flex !important;
            align-items: center;
        }

        .popular_cats li span > span {
            border-bottom: unset;
            background: #2270b1;
            margin-left: 5px;
            display: inline-block;
            width: 25px;
            display: flex;
            justify-content: center;
            border-radius: 4px;
            font-size: 16px;
            color: #FFF;
            border-bottom: unset !important;
            height: 17px;
            font-size: 10px;
            line-height: 1;
        }
        .block_big_links {
            padding-top: 0 !important;
        }

        div#er_block_big_links-block_604e0955ec9f3 > div {
            padding-top: 10px;
        }
        .flex.flex_column.p_t_b_block.block_popular_cats {
            padding: 0 !important;
        }
        ul.popular_cats * {
            cursor: unset !important;
        }

        .company_title.line_big {
    display: flex;
    margin-left: 10px;
    align-items: center;
}

span.text_pub_to_blog {
    display: block;
    font-size: 10px;
    line-height: 1;
    font-weight: normal;
}

.company_title.line_big > a {
    display: flex;
    flex-direction: column;
}

.company_title.line_big > a {
    display: flex;
    margin: 0;
    margin-right: 20px;
}
    </style>
    <div class="flex flex_column p_t_b_block block_popular_cats ">
        <h2 class="font_new_medium_2 font_bold m_b_25 color_dark_blue">Заявки на привязку</h2>
    </div>
    <div class="wrap flex_column">
        <div class="white_block rating_table">
        <?php

			global $post;

$myposts = get_posts( [
'posts_per_page' => -1,
'post_type'=>'userblogpost',
'orderby' => 'date',
'order' => 'DESC',
] );

foreach( $myposts as $post ){


$status_m = '';



	setup_postdata( $post );
	$status = get_field('stastus',get_the_ID());
	if ($status == 'yes') {
	    $status_m = '<span class="paid_info" style="background: #3cb868;color: #FFF;padding: 5px;border-radius: 4px;">Оплачено</span>';
	} else {
	    $status_m = '<span class="paid_info" style="background: #FF0000;color: #FFF;padding: 5px;border-radius: 4px;white-space: nowrap;">На модерации</span>';;
	}
	?>
<div class="main_row rating_table_row font_smaller <?php echo $testb; ?>" id="row_1"><?php echo $testa; ?><div class="rating_table_td rating_field_number font_bold"><?php echo get_the_date('j.n.Y',get_the_ID()); ?></div><div class="rating_table_td item_first rating_field_name"><div class="company_title line_big"><a href="https://etorazvod.ru/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&action=edit" class="link_no_underline company_name font_bold font_new_medium color_dark_blue m_b_10"><?php echo get_the_title(get_the_ID());?><span class="text_pub_to_blog">(перейти по ссылке, чтобы прочитать текст статьи)</span></a><div class="rating_table_link_more pointer color_dark_gray"><?php echo get_user_by('ID', get_field('user_id',get_the_ID()))->data->user_email; echo $type_m; ?></div></div></div><div class="rating_table_td item_2 blueh rating_field_system_count_reviews"><span class="color_dark_blue"><?php echo get_field('comment_company',get_the_ID()); ?></span></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"><?php echo $status_m; ?></div><div class="rating_table_td item_3 hideme1 rating_field_system_count_good"></div><div class="rating_table_td item_5 rating_field_system_rating"><?php echo $status_real; ?></div><!--<div class="rating_table_td item_6 rating_field_free_demo"> </div>--><div class="rating_table_td item_last bright rating_field_actives"><div class="img_wrap"><?php echo $img; ?></div></div><div class="rating_table_td item_2 blueh contact_t"><?php if (    get_field('contact_type', get_the_ID()) || get_field('messanger_login', get_the_ID())   ) { ?><span class="color_dark_blue"><span class="type_contact_title">Способ связи:</span><span class="type_contact_type"><?php echo get_field('contact_type', get_the_ID()); ?></span><span class="type_contact_login"><?php echo get_field('messanger_login', get_the_ID()); ?></span></span><?php } ?></div><div class="rating_row_more flex flex_column"><div class="rating_sub_row flex rating_sub_row_first"><div class="rating_add_signature"><span class="color_dark_gray font_smaller font_underline_dotted">Форекс брокер</span></div><div class="rating_sub_row_td rating_field_min_dep"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Мин. первый депозит</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">От 1 USD</div></div><div class="rating_sub_row_td rating_field_withdrawal_methods"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Способы вывода</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><div class="list_style_2">Наличные, Банковский перевод</div></div></div><div class="rating_sub_row_td rating_field_terminals_list"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Терминалы</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">MetaTrader 4, FinamTrade, QUIK, Transaq</div></div><div class="rating_sub_row_td rating_field_system_count_percents"><div class="rating_sub_row_td_title m_b_10 color_medium_gray">Общий рейтинг</div><div class="rating_sub_row_td_content color_dark_blue font_18 font_bold"><span class="font_bold icon_rating_good">0%</span><span class="font_bold icon_rating_bad">100%</span></div></div></div><div class="rating_sub_row row_mini flex"><div class="rating_sub_row_td flex rating_field_regulators_list"><div class="rating_sub_row_td_title color_medium_gray">Регуляторы</div><div class="rating_sub_row_td_content color_dark_blue font_small ">ЦБ РФ, ФСФР России</div></div><div class="rating_sub_row_td flex rating_field_company_established"><div class="rating_sub_row_td_title color_medium_gray">Дата основания</div><div class="rating_sub_row_td_content color_dark_blue font_small ">2015 год</div></div><div class="rating_sub_row_td flex rating_field_affiliate_program"><div class="rating_sub_row_td_title color_medium_gray">Партнерка</div><div class="rating_sub_row_td_content color_dark_blue font_small "><a class="field_link" href="https://etorazvod.ru/visit/forex-finam/" target="_blank" rel="nofollow">Открыть</a><span class="field_exist yes">Есть</span></div></div></div><div class="rating_sub_row row_buttons flex"><a href="https://etorazvod.ru/review/forex-finam/" class="button inline_block button_green pointer font_small font_bold link_no_underline" target="_blank">Обзор Финам Форекс</a><a class="button inline_block button_violet pointer font_small font_bold link_no_underline" href="https://etorazvod.ru/visit/forex-finam/" target="_blank">forex.finam.ru</a></div></div></div>
	<?php
}
        wp_reset_postdata();
        ?>
        </div>
    </div>
<?php }


function my_admin_page_user_stat_menu_company_promocodes() {
	$curr_user_id = get_current_user_id();
	$userid_logged = get_current_user_id();
									$user_data = get_userdata( $userid_logged );
									$user_roles = $user_data->roles;

	if(in_array($curr_user_id,array(9,1,2,17,31,6,19117, 19866, 17326,27889)) || in_array('admin2',$user_roles) || in_array('beta_role',$user_roles)) {//9,1,2,
		add_menu_page(
			__( 'Истекшие промокоды (в ручную)', 'er_theme' ),
			__( 'Истекшие промокоды (в ручную)', 'er_theme' ),
			'manage_options',
			'promocodes_by_hands',
			'user_stater_promocodes',
			'dashicons-star-filled',
			4
		);
	}
}

add_action( 'admin_menu', 'my_admin_page_user_stat_menu_company_promocodes' );






function user_stater_promocodes() {
    $get_current_user_id = get_current_user_id();

    function check_old_promo(){
    global $wpdb;
    $date =  date('Y-m-d H:i:s', strtotime('-1 day'));
    $query = "SELECT DISTINCT(`post_id`) FROM `wp_postmeta` 
        WHERE `meta_key` LIKE 'promocodes\_items\__\_date\_end' AND `meta_value` < '".$date."'";
    $arr = $wpdb->get_results($query, ARRAY_A);
    $str = implode(',', array_map(function($el){ return $el['post_id']; }, $arr));
    $query = "SELECT `post_id`,`meta_value` FROM `wp_postmeta`
        WHERE `meta_key` LIKE 'promocodes_items' AND `meta_value` IS NOT NULL AND `meta_value` !=' ' AND `meta_value` !='' 
        AND `post_id` IN (".$str.")";
    $id_array = $wpdb->get_results($query, ARRAY_A);
    echo "<h1>Осталось компаний добавленых вручную с просрочеными промо</h1>";
    echo '<style>.this_block_a {
    border: 1px solid #E9F0F3 !important;
    padding: 10px;
    border-bottom: 10px;
    margin: 10px;
    flex-direction: column-reverse;
}

.link_promocode_show_more_text_popup.button_green.button_centered.m_t_20.pointer.font_smaller.font_bold {
    padding: 10px;
    border-radius: 20px;
}

.header_a {
    display: flex;
}

.header_a br {
    display: none;
}

.header_a b {
    margin: 0 10px;
    background: #21b57b;
    padding: 0 10px;
    color: #FFF;
    border-radius: 10px;
}

.header_a {
    margin-bottom: 10px;
}';

    echo '</style>';
    return $id_array;
}
$array = check_old_promo();
$time_now_1 = strtotime('-1 day');
$date_now_1 =  date('Y-m-d H:i:s', $time_now_1);
foreach ($array as $company){
    $count_del = 0;
    $curent_promo_count = $company['meta_value'];
    $post = get_post($company['post_id']);

    if ($post->post_type == 'promocodes') {
	    if ($curent_promo_count > 50) {
		    $a = '<strong>!!!</strong>';
	    } else {
		    $a = '';
	    }
	    //echo '<hr>'.$a.'<b>'.$post->post_title.'</b> всего промо '.$curent_promo_count.'<br>'.$post->ID.'<br>';
	    //print_r();
	    $array_system = [];
	    $array_to_delete = [];
	    $ik = 0;
	    $ik_dn = 'style="display:none;"';
	    for ($i=0; $i<$curent_promo_count; $i++){
		    $ap = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_date_end',true);
		    $time_end = strtotime($ap);
		    $system = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_system',true);

		    if($time_end < $time_now_1 && !empty($ap) && $ap != 'None') {

			    $count_del++;
                if ($system == 'manual') {
                    $ik = 1;
                    $ik_dn = 'style="display:flex;"';
                }

		    }


	    }
	    echo '<div class="this_block_a" '.$ik_dn.'>';
	    echo '<div class="body_a">';
	    $ik = 0;
	    for ($i=0; $i<$curent_promo_count; $i++){
		    $ap = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_date_end',true);
		    $time_end = strtotime($ap);
		    $system = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_system',true);

		    if($time_end < $time_now_1 && !empty($ap) && $ap != 'None') {

			    $count_del++;
                if ($system == 'manual') {
                    $ik = 1;
                    echo '<ul class="flex list_promocodes single_promocodes_list">';
			        $array_system[] = $i;
			        $item = [];
			        $item['text'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_text',true);
			        $item['discount_size'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_discount_size',true);
			        $item['discount_currency'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_discount_currency',true);
			        $item['type'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_type',true);
			        $item['title'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_title',true);
			        $item['description'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_description',true);
                    $item['visits'] = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_visits',true);

			        	if($item['text'] != '' && $item['text'] != 'Не нужен') {
									$border = 'border_green';
								} else {
									$border = 'border_biolet';
								}
			        	$y = 1;
								if($y > 9) {
									$hidden_default = ' hidden';
								} else {
									$hidden_default = '';
								}
								$result_promo = '<li class="white_block flex '.$border.''.$hidden_default.'" id="single_promocodes_'.$post->ID.'_'.$y.'">';
								if($item['discount_size'] != '' & $item['discount_currency'] == '%') {
									$size = $item['discount_size'].$item['discount_currency'];
								} elseif($item['discount_size'] != '' & $item['discount_currency'] != '%') {
									$size = $item['discount_size'].' '.$item['discount_currency'];
								} else {
									$size = '';
								}
								if ($item['type'] == 'discount') {
									$item_type = __('Скидка на заказ','er_theme');
								} elseif($item['type'] == 'reg') {
									$item_type = __('Бонус при регистрации','er_theme');
								} elseif($item['type'] == 'demo') {
									$item_type = __('Бесплатный демо-счет','er_theme');
								} elseif($item['type'] == 'gift') {
									$item_type = __('Подарок','er_theme');
								} elseif($item['type'] == 'delivery') {
									$item_type = __('Бесплатная доставка','er_theme');
								}
								if($item['discount_currency'] && $item['discount_currency'] == '%') {
									$faq_discounts[] = array('x' => $item['discount_size'],'y' => $item['discount_currency']);

								}
								if ($y < 4) {

									$faq_discount_titles .= $item['title'].', ';
								}
								$result_promo .='<div class="promocode_block_content flex">';
								$result_promo .= '<div class="promocode_list_single_left">';
								if($size != '') {
									$result_promo .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
								} else {
									$result_promo .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
								}
								$terms = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->slug;
								$result_promo .= '<div class="promocode_item_title color_dark_blue link_no_underline font_bold">'.$company_name.'</div>';


								$result_promo .='</div>';
								$result_promo .= '<div class="promocode_list_single_right">';
								if($item['title'] != '') {
									$result_promo .= '<div class="promo_title color_dark_blue font_18 font_bold">' . $item['title'] . '</div>';
								}

								if($item['description'] != '') {
									$result_promo .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
								}
								$result_promo .= '<div class="promocode_button_container">';
								if($item['text'] != '' && $item['text'] != 'Не нужен') {
									$result_promo .= '<div class="promocode_text_container">';
									$result_promo .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$y.'">'.$item['text'].'</div>';
									$result_promo .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$y.'/" target="_blank">'.__('Получить','er_theme').'</a>';
									$result_promo .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
									$result_promo .= '</div>';
									$result_promo .= '<div class="link_promocode_show_more_text_popup button_green button_centered m_t_20 pointer font_smaller font_bold">'.$item['text'].'</div>';
								} else {
									$result_promo .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$y.'/" target="_blank">'.__('Получить','er_theme').'</a>';
								}
								$result_promo .='</div>';
								$result_promo .='<div class="promocode_block_footer flex">';
								if($item['description'] != '') {
									$result_promo .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
								}
								$count_used = 1;
								if($item['visits'] && $item['visits'] != '' && $item['visits'] != 0) {
									$count_used = $item['visits'];
								}
								$result_promo .= '<span class="promo_used font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
								$result_promo .='</div>';
								$result_promo .='</div>';
								$result_promo .='</div>';


								$result_promo .= '</li>';
								echo $result_promo;
			        echo '</ul>';
		        }
		    }


	    }

	    echo '</div>';

	    if (count($array_system) == 0) {

	    } else {


	    }
	    if ($ik != 0) {
	        echo '<div class="header_a">';
        echo $a.'<b>'.$post->post_title.'</b> всего промо '.$curent_promo_count.' <br>';
	    echo 'просроченных <b>'.$count_del.'</b>';
	    echo '</div>';
	    }
	    echo '</div>';

    }

}


}

add_action( 'admin_enqueue_scripts', 'misha_admin_js' );
function misha_admin_js(){
	wp_enqueue_script(
		'anyidhere',
		get_stylesheet_directory_uri() . '/js/ajax_change_parent_id.js',
		array('jquery')
	);
}



 add_action('wp_ajax_misha_change_comment_parent', 'misha_change_comment_parent');
    add_action('wp_ajax_nopriv_misha_change_comment_parent', 'misha_change_comment_parent');

function misha_change_comment_parent(){

	// if you're using ajax nonce
	// check_ajax_referer( 'anystring', 'myajaxnonce' );

	// if comment is updated, the function returns 1, if isn't - 0
	echo wp_update_comment( array(
		'comment_ID' => intval($_POST['comment_id']),
		'comment_post_ID' => intval($_POST['parent_id'])
	) );

	wp_die();

}

add_action('admin_head', 'my_custom_fonts235235'); // admin_head is a hook my_custom_fonts235235 is a function we are adding it to the hook

function my_custom_fonts235235() {
  echo '<style>
    .change {
    background: #2270b1;
    padding: 5px;
    color: #FFF;
    border-radius: 5px;
    margin-left: 5px;
}

.change {
    display: block;
    text-align: center;
    margin-top: 10px;
}
.change_post_ID {
    background: #daa618;
    padding: 5px;
    border-radius: 5px;
    color: #FFF;
    margin-bottom: 10px !important;
}

.change {
    background: #896709;
    padding: 5px;
    color: #FFF;
    border-radius: 5px;
    margin-left: 5px;
}
span.change {
    cursor: pointer;
}

.change_post_ID {
    background: none !important;
    padding: 0 !important;
}

span.change {
    color: #2271C8;
    background: none;
    text-align: left;
    margin: 0;
    padding: 0;
    text-decoration: underline;
}
  </style>';
}

if(!function_exists('sa_new_form_for_add_company_submit')) {
    add_action('wp_ajax_sa_new_form_for_add_company_submit', 'sa_new_form_for_add_company_submit');
    add_action('wp_ajax_nopriv_sa_new_form_for_add_company_submit', 'sa_new_form_for_add_company_submit');
    function sa_new_form_for_add_company_submit() {
        $data = $_POST;
        //print_r($data);
        $result = array();
        $errors = array();
        if(!$data['add_company_name'] || $data['add_company_name'] == ''
        || strlen($data['add_company_name']) > 0 && strlen(trim($data['add_company_name'])) == 0) {
            $errors[] = __('Укажите название компании','er_theme');
        }
        if(!$data['select_contact'] || $data['select_contact'] == '' || $data['select_contact'] == 'none') {
            $errors[] = __('Выберите мессенджер для связи','er_theme');
        }
        if(!$data['contact_name'] || $data['contact_name'] == ''
        || strlen($data['contact_name']) > 0 && strlen(trim($data['contact_name'])) == 0) {
            $errors[] = __('Укажите ваш контакт в выбранном мессенджере','er_theme');
        }
        if(!empty($errors)) {
            $result['status'] = 'error';
            $result['message'] = '<ul>';
            foreach ($errors as $error) {
                $result['message'] .= '<li>';
                $result['message'] .= $error;
                $result['message'] .= '</li>';
            }
            $result['message'] .= '</ul>';
        } else {
            $slug = wp_generate_uuid4();
            $post_data = array(
                'post_type'     => 'request_add_company',
                'post_title'    => wp_strip_all_tags($data['add_company_name']),
                'post_status'   => 'publish',
                'post_name' => $slug,
            );
            $new_post_id = wp_insert_post( $post_data, true );

            if( is_wp_error($new_post_id) ){
                $result['status'] = 'error';
                $result['message'] = $new_post_id->get_error_message();
            } else {
                $result['status'] = 'ok';
                $result['message'] = __('Спасибо! Ваша заявка отправлена','er_theme');
                update_field( 'user_id', $data['user_id'], $new_post_id );
                update_field( 'company_name', wp_strip_all_tags($data['add_company_name']), $new_post_id );
                update_field( 'contact_type', $data['select_contact'], $new_post_id );
                update_field( 'messanger_login', $data['contact_name'], $new_post_id );
                update_field('add_or_connect','Заявка',$new_post_id);
            }

        }
        //print_r($result);
        echo json_encode($result);
        die;
    }
}

if(!function_exists('sa_new_form_for_add_company')) {
    function sa_new_form_for_add_company($user_id) {
        $result = '';
        $result = '<form class="flex flex_column inactive_form" id="sa_new_form_for_add_company" action="'.admin_url( 'admin-ajax.php' ).'" method="post">';
        $result .= '<input type="hidden" name="action" value="sa_new_form_for_add_company_submit" />';
        $result .= '<input type="hidden" name="user_id" value="'.$user_id.'" />';
        $result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Добавить компанию', 'er_theme' ) . '</div>';
        $result .= '<span class="add_company_title m_b_10" style="display: block;font-weight: bold;padding: 0;">'.__('Название компании','er_theme').'<span class="acf_star_m">*</span></span>';
        $result .= '<div class="acf-input"><div class="acf-input-wrap"><input type="text"  name="add_company_name" style="width: calc(100% - 46px);"></div></div>';
        $result .= '<span class="add_company_title m_b_10 m_t_20" style="display: block;font-weight: bold;padding: 0;">'.__('Оставьте свой контакт для связи','er_theme').'<span class="acf_star_m">*</span></span>';
        $result .= '<div class="select_contact_inside" style="margin-bottom: 0;">
    <select name="select_contact" class="select_big m_b_10 border_radius_4px select_arrow">
		<option selected="selected" value="none">Мессенджер для связи</option>
		<option value="telegram">Telegram</option>
		<option value="skype">Skype</option>
		<option value="email">E-mail</option>
		<option value="whatsapp">WhatsApp</option>
		<option value="viber">Viber</option>
		</select>
<input type="text" name="contact_name" placeholder="Логин" class="input_big m_b_10 placeholder_dark border_radius_4px" value="" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false">
</div>';
        $result .= '<div class="acf-form-submit m_t_20"><input type="submit" class="acf-button button button-primary button-large" style="width: 100% !important;" value="'.__('Отправить на модерацию','er_theme').'"><span class="acf-spinner"></span></div>';
        $result .= '</form>';
        $result .= '
        
        
        
        ';

        return $result;
    }
}