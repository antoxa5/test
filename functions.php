<?php
#remove_action('template_redirect', 'redirect_canonical');

include_once(TEMPLATEPATH .'/includes/custom-type-templates.php');
include_once(TEMPLATEPATH .'/includes/options.lib.php');
include_once(TEMPLATEPATH .'/includes/design-options.php');
include_once(TEMPLATEPATH .'/includes/theme-options.php');
include_once(TEMPLATEPATH .'/includes/seo-options.php');
include_once(TEMPLATEPATH .'/includes/gambling-options.php');
include_once(TEMPLATEPATH .'/includes/breadcrumbs.php');
include_once(TEMPLATEPATH .'/includes/topsites_widget.php');
include_once(TEMPLATEPATH .'/includes/sitelistings_widget.php');
include_once(TEMPLATEPATH .'/includes/custom_meta_boxes.php');
include_once(TEMPLATEPATH .'/includes/banner-manager.php');
include_once(TEMPLATEPATH .'/includes/shortcodes.php');
include_once(TEMPLATEPATH .'/includes/featured_widget.php');
include_once(TEMPLATEPATH .'/includes/redirects.php');
include_once(TEMPLATEPATH .'/includes/shortcode_builder.php');
include_once(TEMPLATEPATH .'/includes/excerpt_shortcode_builder.php');
include_once(TEMPLATEPATH .'/includes/ftable_shortcode_builder.php');
include_once(TEMPLATEPATH .'/includes/hitcounter.php');
include_once(TEMPLATEPATH .'/includes/review_widget.php');

function jb_pre_get_posts( WP_Query $wp_query ) {
	if ( in_array( $wp_query->get( 'post_type' ), array( 'post', 'page', 'casino' ) ) ) {
		$wp_query->set( 'update_post_meta_cache', false );
	}
}

// Only do this for admin.
if ( is_admin() ) {
	add_action( 'pre_get_posts', 'jb_pre_get_posts' );
}
/*

function fix_missing_404_on_paginated_page() {
    global $wp_query,$page,$paged;
 
    if (!isset($page)) $page = get_query_var('page');
    if (!isset($paged)) $paged = get_query_var('paged');
    if (is_page() || is_single()) {
        $realpagescount = count( explode( '<!--nextpage-->', $wp_query->post->post_content ) );
 
        if ( (isset($page) && isset($realpagescount) && $page >= $realpagescount) || (is_paged() && isset($paged) && $paged >=0 ) ){
        //wp_redirect( home_url() );
            nocache_headers();
            status_header( '404' );
            $wp_query->is_404=true;
            $wp_query->is_single=false;
            $wp_query->is_singular=false;
            $wp_query->post_count=0;
            $wp_query->page=0;
            $wp_query->query['page']='';
            $wp_query->query['posts']=array();
            $wp_query->query['post']=array();
            $wp_query->posts=array();
            $wp_query->post=array();
            $wp_query->queried_object=array();
            $wp_query->queried_object_id=0;
            locate_template('404.php', true);
            exit;
        }
    }
}
add_action('template_redirect', 'fix_missing_404_on_paginated_page'); */

function update_event_date($post_id){

    $post_type = get_post_type($post_id);
    

    if ($post_type == 'casino'){
    $new_table = $_POST['acf']['field_5d836da741c44'];
    if($new_table) {
        $redirect_key = $_POST['acf']['field_5d7117b72fb4c']['field_5d77d83bcaee1'];
        $redirect_url = $_POST['acf']['field_5d7117b72fb4c']['field_5d77d821caee0'];
        update_post_meta($post_id, '_as_redirectkey', $redirect_key);
        update_post_meta($post_id, '_as_roomurl', $redirect_url);
    }

    }

}
add_action('save_post', 'update_event_date');


function remove_default_event_category_metabox() {
	remove_meta_box( 'tagsdiv-companyactivetypes', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-paymentmethods', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companyoptiontypes', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companypossibilities', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companytradingmethods', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companyterminals', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companyproviders', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companyregulators', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-companydocuments', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-gamegenres', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-gametypes', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-gametechnologies', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-paymentsystems', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-creditcardtypes', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-cardspecifications', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-fondmarkets', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-fondlist', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-countries', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-businessservices', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-saleservices', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-currencyoperationsservices', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-immodules', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-cryptocurrencies', 'casino', 'side' );
	remove_meta_box( 'tagsdiv-ratingsafety', 'casino', 'side' );
}
add_action( 'admin_menu' , 'remove_default_event_category_metabox' );


 function casino_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Title",
    "description" => "Description",
     "type" => "Minimum Deposit",
    "bonus" => "Bonus Amount",
    "rating" => "Rating"
  );
 
  return $columns;
}
function casino_custom_columns($column){
  global $post;
 
  switch ($column) {
    case 'description':
        the_excerpt();
      break;
    case 'type':
        echo get_post_meta( $post->ID , '_as_mindep' , true ); 
      break;
    case 'bonus':
         echo get_post_meta( $post->ID , '_as_bonusamount' , true ); 
      break;
    case 'rating':
       echo get_post_meta( $post->ID , '_as_rating' , true ); 
      break;
  }
}
add_action("manage_posts_custom_column",  "casino_custom_columns");
add_filter("manage_edit-casino_columns", "casino_edit_columns");


function flytonic_widgets() {
	// Sidebar 1
	register_sidebar( array(
		'name' => 'Sidebar 1',
		'id' => 'sidebar1-widgets',
		'description' =>  'Right Sidebar',
		'before_widget' => '<div class="block">',
		'after_widget' => '</div>',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );

	// Footer Widget 1
	register_sidebar( array(
		'name' => 'Footer Widget 1',
		'id' => 'footer1-widgets',
		'description' => 'Footer Widget Area 1',
                'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );

	// Footer Widget 2
	register_sidebar( array(
		'name' => 'Footer Widget 2',
		'id' => 'footer2-widgets',
		'description' => 'Footer Widget Area 2',
                'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );

	// Footer Widget 3
	register_sidebar( array(
		'name' => 'Footer Widget 3',
		'id' => 'footer3-widgets',
		'description' => 'Footer Widget Area 3',
                'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );

   // Footer Widget 4
	register_sidebar( array(
		'name' => 'Footer Widget 4',
		'id' => 'footer4-widgets',
		'description' => 'Footer Widget Area 4',
                'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );
	
	// Home Comments
	register_sidebar( array(
		'name' => 'Home Comments',
		'id' => 'home-comments',
		'description' => 'Home Comments for Cackle',
                'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="er_widget_title">',
		'after_title' => '</p>'
	) );
	
}

add_action('widgets_init', 'flytonic_widgets');

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	    add_theme_support( 'post-thumbnails' );
	    set_post_thumbnail_size( 100, 100, true ); // Normal post thumbnails
	}


add_theme_support( 'menus' );// Added in 3.0

register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'forextheme' ),
'topheader' => __( 'Top Header Navigation', 'forextheme' ),
	'topfooter' => __( 'Footer Top', 'forextheme' ),
'footer_1' => __( 'Footer 1', 'forextheme' ),
'footer_2' => __( 'Footer 2', 'forextheme' ),
'footer_3' => __( 'Footer 3', 'forextheme' ),

	) );


function my_wpmenu(){ ?>
<div class="left">
    <ul id="nav">
 	<?php wp_list_pages('title_li=');
 	$this_category = get_category($cat);
 	if (get_category_children($this_category->cat_ID) != "") {
 		echo "<ul>";
wp_list_categories('orderby=name&show_count=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID);
 		echo "</ul>";
 	}
	?>
   </ul>

</div>
<?php }


function my_wpmenu2(){ ?>
<div class="left">
    <ul>
 	<?php wp_list_pages('title_li=');
 	$this_category = get_category($cat);
 	if (get_category_children($this_category->cat_ID) != "") {
 		echo "<ul>";
wp_list_categories('orderby=name&show_count=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID);
 		echo "</ul>";
 	}
	?>
   </ul>

</div>
<?php }


// -----------------------Excerpt Length-------------------------

function custom_excerpt_length( $length ) {

$exc=30;

if (get_theme_option ('excerpt-length') != ""):
$exc= get_theme_option ('excerpt-length');
endif;
return $exc;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more($more) {
       global $post;
	return '...<a href="'. get_permalink($post->ID) . '"> Подробнее</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


//---------------------End of Excerpt Trim----------------------


function home_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );


//---------------------Add Stylesheets----------------------

function flytonic_my_stylesheets() {
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/includes/custom.css');
 wp_enqueue_style('media-css', get_stylesheet_directory_uri() . '/media.css');
}
add_action('wp_enqueue_scripts', 'flytonic_my_stylesheets');

//---------------------Check Custom.css----------------------

/* Installation Check */
function flytonict_showMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="message" class="error">';
	}
	else {
		echo '<div id="message" class="updated fade">';
	}

	echo "<p><strong>$message</strong></p></div>";
}    

function flytonict_showAdminMessages()
{
    // Shows as an error message. You could add a link to the right page if you wanted.
	if (!file_exists(TEMPLATEPATH . '/includes/custom.css')) {
		flytonict_showMessage("WARNING - Forex Theme - A file with the name custom.css must be created and writeable in the includes directory for custom design options and custom layout widths to be saved", true);
	} elseif (!is_writeable(TEMPLATEPATH . '/includes/custom.css')) {
		flytonict_showMessage("WARNING - Forex Theme - The file custom.css in the forextheme/includes directory must be made writeable for custom design options and custom layout widths to be saved.", true);
	}   
}

add_action('admin_notices', 'flytonict_showAdminMessages'); 


//---------------------- Pagination ---------------

function kriesi_pagination($pages = '', $range = 4)
{  
     $showitems = ($range)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'> &laquo;</a>";
         if($paged > 1 ) echo "<a class='last' href='".get_pagenum_link($paged - 1)."'>&laquo; ".__('Предыдущая','er_theme')."</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages ) echo "<a class='last' href='".get_pagenum_link($paged + 1)."'>".__('Следующая','er_theme')." &raquo;</a>";  
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

//---------------------- Add Profile Fields ---------------

add_action( 'show_user_profile', 'flytonic_profile_fields' );
add_action( 'edit_user_profile', 'flytonic_profile_fields' );

function flytonic_profile_fields( $user ) { ?>

	<h3>Additional profile information</h3>

	<table class="form-table">

                <tr>
			<th><label for="authimg">Author Image Link</label></th>

			<td>
				<input type="text" name="authimg" id="authimg" value="<?php echo esc_attr( get_the_author_meta( 'authimg', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter the url for you author avatar image shown in bio (80x80 pixels)</span>
			</td>
		</tr>

		<tr>
			<th><label for="twitter">Twitter Username</label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Ennter your Twitter username.</span>
			</td>
		</tr>

	</table>
<?php }


add_action( 'personal_options_update', 'save_flytonic_profile_fields' );
add_action( 'edit_user_profile_update', 'save_flytonic_profile_fields' );

function save_flytonic_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
        update_usermeta( $user_id, 'authimg', $_POST['authimg'] );
}
function disable_feeds() {
	wp_redirect( home_url() );
	die;
}

// Disable global RSS, RDF & Atom feeds.
add_action( 'do_feed',      'disable_feeds', -1 );
add_action( 'do_feed_rdf',  'disable_feeds', -1 );
add_action( 'do_feed_rss',  'disable_feeds', -1 );
add_action( 'do_feed_rss2', 'disable_feeds', -1 );
add_action( 'do_feed_atom', 'disable_feeds', -1 );

// Disable comment feeds.
add_action( 'do_feed_rss2_comments', 'disable_feeds', -1 );
add_action( 'do_feed_atom_comments', 'disable_feeds', -1 );

// Prevent feed links from being inserted in the <head> of the page.
add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
remove_action( 'wp_head', 'feed_links',       2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
//---------------------- Custom Comment List ---------------

function flytonic_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<?php printf(__('<cite class="fn"> %s </cite> &bull;  <span class="says"></span>'), get_comment_author_link()) ?>

                  <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
			?>


		</div>
<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
		<br />
<?php endif; ?>

		

		<?php comment_text() ?>

		<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
        }
        
function get_the_user_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters('wpb_get_ip', $ip);
}

//this creates the shortcode you can use in posts, pages and widgets
add_shortcode('show_user_ip', 'get_the_user_ip');



function lead_form($place,$post_id) {
	$reverse_query = get_posts(array(
							'post_type' => 'leadforms',
			        		'posts_per_page' => 1,
        	                'orderby' => 'rand',
							'meta_query' => array(
							    'relation'		=> 'AND',
								array(
									'key' => 'er_form_posts', // name of custom field
									'value' => serialize( strval( $post_id ) ), // matches exactly "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
								),
								array(
                        			'key'	 	=> 'er_form_place',
                        			'value'	  	=> $place,
                        			'compare' 	=> '=',
                        		),
							)
						));
    $term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
        // print_r($term_list); 
        // echo $post_id;
        // echo $place;
        if($reverse_query && !empty($reverse_query)) {
    if($place == 3) { ?><div class="block" id="sidebar_form<?php if (!get_field('disable_floating',$reverse_query[0]->ID)) { echo '_fixed'; }; ?>"><?php };
    //echo 'unique_form';
    //echo $reverse_query[0]->ID; ?>
    <div class="er_form er_form_place_<?php echo $place; ?>">
        <?php
            if (get_field('er_form_title',$reverse_query[0]->ID)) { ?>
               <?php if($place == 3) { ?>
               <p class="er_widget_title"><?php echo get_field('er_form_title',$reverse_query[0]->ID); ?></p>
               <?php } else { ?>
               <h2><?php echo get_field('er_form_title',$reverse_query[0]->ID); ?></h2>
                <?php } ?>
            <?php 
            }
            if (get_field('er_form_title',$reverse_query[0]->ID)) { ?>
                <div class="er_form_subtext"><?php echo get_field('er_form_subtitle',$reverse_query[0]->ID); ?></div>
            <?php 
            } if( have_rows('er_form_fields',$reverse_query[0]->ID) ): ?>
                                <form class="order-form" id="<?php echo $reverse_query[0]->ID; ?>">
                                    <div class="form_result"></div>
                                    <input type="hidden" name="form_id" value="<?php echo $reverse_query[0]->ID; ?>">
                                    <input type="hidden" name="form_type" value="<?php echo get_field('er_form_type',$reverse_query[0]->ID); ?>">
                                    <input type="hidden" name="advertiser_offer_id" value="<?php echo get_field('er_form_offer_id',$reverse_query[0]->ID); ?>">
                                    <input type="hidden" name="subid" value="<?php echo wp_generate_uuid4(); ?>">
                                    <input type="hidden" name="ip" value="<?php echo get_the_user_ip(); ?>">
                                    <?php if(get_field('er_form_integration',$reverse_query[0]->ID)) { 
                        			$post_object = get_field('er_form_integration',$reverse_query[0]->ID); ?>
                        			<input type="hidden" name="offer_advertizer" value="<?php echo $post_object->ID; ?>">
                        			<?php  }; ?>
                        			<?php 
                        			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
                        				$utm_source = $_REQUEST['utm_source']; 
                        			} else { 
                        				$utm_source = "no_utm_source"; 
                        			} 
                        			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
                        				$utm_medium = $_REQUEST['utm_medium']; 
                        			} else { 
                        				$utm_medium = "no_utm_medium"; 
                        			}
                        			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
                        				$utm_campaign = $_REQUEST['utm_campaign']; 
                        			} else { 
                        				$utm_campaign = "no_utm_campaign"; 
                        			} 
                        			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
                        				$utm_content = $_REQUEST['utm_content']; 
                        			} else { 
                        				$utm_content = "no_utm_content"; 
                        			}
                        			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
                        				$utm_term = $_REQUEST['utm_term']; 
                        			} else { 
                        				$utm_term = "no_utm_term"; 
                        			} 
                        			?>
                        			<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                        			<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>">
                        			<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>">
                        			<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>">
                        			<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>">
                        			<?php if (get_field('er_form_success_action',$reverse_query[0]->ID) && get_field('er_form_success_action',$reverse_query[0]->ID) == 'redirect' && get_field('er_form_redirect_links',$reverse_query[0]->ID)) { 
                        			    $rows = get_field('er_form_redirect_links',$reverse_query[0]->ID); 
                                      if($rows) $i = 0; { 
                                        shuffle( $rows ); 
                                        foreach($rows as $row) { 
                                          $link_active = $row['form_redirect_active'];
                                          
                                          if ($link_active == 1) {
                                          $i++; if($i==2) break; 
                                          $link = $row['form_redirect_link']; ?>
                                    
                                          <?php //echo $link; ?>
                                    <?php
                                          } else {
                                              continue;
                                          }
                                              
                                          } }
                        			?>
                        			
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action',$reverse_query[0]->ID); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo $link; ?>">
                        			    
                        			<?php } elseif (get_field('er_form_success_action',$reverse_query[0]->ID) && get_field('er_form_success_action',$reverse_query[0]->ID) == 'alert' && get_field('er_form_success_text',$reverse_query[0]->ID)) { ?>
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action',$reverse_query[0]->ID); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo get_field('er_form_success_text',$reverse_query[0]->ID); ?>">
                        			<?php } else { ?>
                        			    <input type="hidden" name="form_success_action" value="default">
                        			<?php }; ?>
                                    <?php
                                while ( have_rows('er_form_fields',$reverse_query[0]->ID) ) : the_row(); ?>
                                <?php
                                if (get_sub_field('er_form_field_title_required',$reverse_query[0]->ID) == 1) {
                                    $required = 'required';
                                } else {
                                    $required = '';
                                }
                                if (get_sub_field('er_form_field_type',$reverse_query[0]->ID) != 'textarea' && get_sub_field('er_form_field_title_placeholder',$reverse_query[0]->ID) != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title',$reverse_query[0]->ID)) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title',$reverse_query[0]->ID); ?></div><?php }; ?>
                                    <div class="er_form_input_container <?php if (get_sub_field('er_form_field_type',$reverse_query[0]->ID) == 'hidden') { ?>hidden<?php }; ?>"><input type="<?php echo get_sub_field('er_form_field_type',$reverse_query[0]->ID); ?>" class="<?php echo $required; ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name',$reverse_query[0]->ID); ?>]" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_placeholder',$reverse_query[0]->ID); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') == 1) { ?>
                                    <div class="er_form_input_container"><input type="<?php echo get_sub_field('er_form_field_type',$reverse_query[0]->ID); ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name',$reverse_query[0]->ID); ?>]" class="<?php echo $required; ?>" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_title',$reverse_query[0]->ID); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type',$reverse_query[0]->ID) == 'textarea' && get_sub_field('er_form_field_title_placeholder',$reverse_query[0]->ID) != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title',$reverse_query[0]->ID)) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title',$reverse_query[0]->ID); ?></div><?php }; ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name',$reverse_query[0]->ID); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_placeholder',$reverse_query[0]->ID); ?>"></textarea></div>
                               <?php } else { ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name',$reverse_query[0]->ID); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_title',$reverse_query[0]->ID); ?>"></textarea></div>
                               <?php };
                                   // $er_form_field_type = get_sub_field('er_form_field_type');
                                   // $er_form_field_name = get_sub_field('er_form_field_name');
                                   // $er_form_field_title = get_sub_field('er_form_field_title');
                                   // $er_form_field_title_placeholder = get_sub_field('er_form_field_title_placeholder');
                                   // $er_form_field_placeholder = get_sub_field('er_form_field_placeholder');
                                   // $er_form_field_title_required = get_sub_field('er_form_field_title_required');
                                   // echo $er_form_field_type;
                                   // echo '<br />';
                                   // echo $er_form_field_name;
                                   // echo '<br />';
                                   // echo $er_form_field_title;
                                   // echo '<br />';
                                   // echo $er_form_field_title_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                endwhile;
                                 if (get_field('er_form_button_text',$reverse_query[0]->ID)) { ?>
                                <input type="submit" name="submit" value="<?php echo get_field('er_form_button_text',$reverse_query[0]->ID); ?>" class="er_form_submit" />
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Отправить" class="er_form_submit" />
                            <?php } ?>
                            </form>
                            <?php 
                            else :
                                // no rows found
                            endif;
        ?>
    </div>
    <?php if($place == 3) { ?></div><?php };
} elseif($term_list) { 
        
	    //$er_tags = get_field('er_post_tags');
	    //print_r($er_tags); 
	    //echo 'метки у страницы есть';
	    $er_forms = new WP_Query( array(
        	'post_type' => 'leadforms',
        	'posts_per_page' => 1,
        	'orderby' => 'rand',
        	'meta_query'	=> array(
        		'relation'		=> 'AND',
        		array(
        			'key'	 	=> 'er_form_place',
        			'value'	  	=> $place,
        			'compare' 	=> '=',
        		),
        	),
        	'tax_query' => array(
                array(
                    'taxonomy' => 'affiliate-tags',
                    'field'    => 'id',
                    'terms'    => $term_list,
                ),
            ),
        ) );
        //print_r($er_forms);
            if ( $er_forms->have_posts() ) {
                //echo 'формы есть';
                while ( $er_forms->have_posts() ) {
                        $er_forms->the_post(); ?>
                        <?php if($place == 3) { ?><div class="block" id="sidebar_form<?php if (!get_field('disable_floating')) { echo '_fixed'; }; ?>"><?php }; ?>
                        <div class="er_form er_form_place_<?php echo $place; ?>">
                            <?php
                            if (get_field('er_form_title')) { ?>
                               <?php if($place == 3) { ?>
							   <p class="er_widget_title"><?php echo get_field('er_form_title'); ?></p>
							   <?php } else { ?>
                                <h2><?php echo get_field('er_form_title'); ?></h2>
                               <?php }; ?>
                            <?php 
                            }
                            if (get_field('er_form_title')) { ?>
                                <div class="er_form_subtext"><?php echo get_field('er_form_subtitle'); ?></div>
                            <?php 
                            } 
                            if( have_rows('er_form_fields') ): ?>
                                <form class="order-form" id="<?php echo get_the_ID(); ?>">
                                    <div class="form_result"></div>
                                    <input type="hidden" name="form_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="form_type" value="<?php echo get_field('er_form_type'); ?>">
                                    <input type="hidden" name="advertiser_offer_id" value="<?php echo get_field('er_form_offer_id'); ?>">
                                    <input type="hidden" name="subid" value="<?php echo wp_generate_uuid4(); ?>">
                                    <input type="hidden" name="ip" value="<?php echo get_the_user_ip(); ?>">
                                    <?php if(get_field('er_form_integration')) { 
                        			$post_object = get_field('er_form_integration'); ?>
                        			<input type="hidden" name="offer_advertizer" value="<?php echo $post_object->ID; ?>">
                        			<?php  }; ?>
                        			<?php 
                        			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
                        				$utm_source = $_REQUEST['utm_source']; 
                        			} else { 
                        				$utm_source = "no_utm_source"; 
                        			} 
                        			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
                        				$utm_medium = $_REQUEST['utm_medium']; 
                        			} else { 
                        				$utm_medium = "no_utm_medium"; 
                        			}
                        			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
                        				$utm_campaign = $_REQUEST['utm_campaign']; 
                        			} else { 
                        				$utm_campaign = "no_utm_campaign"; 
                        			} 
                        			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
                        				$utm_content = $_REQUEST['utm_content']; 
                        			} else { 
                        				$utm_content = "no_utm_content"; 
                        			}
                        			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
                        				$utm_term = $_REQUEST['utm_term']; 
                        			} else { 
                        				$utm_term = "no_utm_term"; 
                        			} 
                        			?>
                        			<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                        			<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>">
                        			<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>">
                        			<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>">
                        			<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>">
                        			<?php if (get_field('er_form_success_action') && get_field('er_form_success_action') == 'redirect' && get_field('er_form_redirect_links')) { 
                        			    $rows = get_field('er_form_redirect_links'); 
                                      if($rows) $i = 0; { 
                                        shuffle( $rows ); 
                                        foreach($rows as $row) { 
                                          $link_active = $row['form_redirect_active'];
                                          
                                          if ($link_active == 1) {
                                          $i++; if($i==2) break; 
                                          $link = $row['form_redirect_link']; ?>
                                    
                                          <?php //echo $link; ?>
                                    <?php
                                          } else {
                                              continue;
                                          }
                                              
                                          } }
                        			?>
                        			
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo $link; ?>">
                        			    
                        			<?php } elseif (get_field('er_form_success_action') && get_field('er_form_success_action') == 'alert' && get_field('er_form_success_text')) { ?>
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo get_field('er_form_success_text'); ?>">
                        			<?php } else { ?>
                        			    <input type="hidden" name="form_success_action" value="default">
                        			<?php }; ?>
                                    <?php
                                while ( have_rows('er_form_fields') ) : the_row(); ?>
                                <?php
                                if (get_sub_field('er_form_field_title_required') == 1) {
                                    $required = 'required';
                                } else {
                                    $required = '';
                                }
                                if (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_input_container <?php if (get_sub_field('er_form_field_type') == 'hidden') { ?>hidden<?php }; ?>"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" class="<?php echo $required; ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') == 1) { ?>
                                    <div class="er_form_input_container"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" class="<?php echo $required; ?>" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_title'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') == 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>"></textarea></div>
                               <?php } else { ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_title'); ?>"></textarea></div>
                               <?php };
                                   // $er_form_field_type = get_sub_field('er_form_field_type');
                                   // $er_form_field_name = get_sub_field('er_form_field_name');
                                   // $er_form_field_title = get_sub_field('er_form_field_title');
                                   // $er_form_field_title_placeholder = get_sub_field('er_form_field_title_placeholder');
                                   // $er_form_field_placeholder = get_sub_field('er_form_field_placeholder');
                                   // $er_form_field_title_required = get_sub_field('er_form_field_title_required');
                                   // echo $er_form_field_type;
                                   // echo '<br />';
                                   // echo $er_form_field_name;
                                   // echo '<br />';
                                   // echo $er_form_field_title;
                                   // echo '<br />';
                                   // echo $er_form_field_title_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                endwhile;
                                 if (get_field('er_form_button_text')) { ?>
                                <input type="submit" name="submit" value="<?php echo get_field('er_form_button_text'); ?>" class="er_form_submit" />
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Отправить" class="er_form_submit" />
                            <?php } ?>
                            </form>
                            <?php 
                            else :
                                // no rows found
                            endif;
                            
                            ?>
                        </div>
                        <?php if($place == 3) { ?></div><?php }; ?>
                        <?php
                }
            } else {
               // echo 'форм нет, берем по умолчанию';
                $er_forms = new WP_Query( array(
            	'post_type' => 'leadforms',
            	'posts_per_page' => 1,
            	'orderby' => 'rand',
            	'meta_query'	=> array(
            		'relation'		=> 'AND',
            		array(
            			'key'	 	=> 'er_form_default',
            			'value'	  	=> 1,
            			'compare' 	=> '=',
            		),
            		array(
            			'key'	 	=> 'er_form_place',
            			'value'	  	=> $place,
            			'compare' 	=> '=',
            		),
            	
            	),
            ) );
            
                //print_r($er_forms);
                if ( $er_forms->have_posts() ) {
                    while ( $er_forms->have_posts() ) {
                        $er_forms->the_post(); ?>
                        <?php if($place == 3) { ?><div class="block" id="sidebar_form<?php if (!get_field('disable_floating')) { echo '_fixed'; }; ?>"><?php }; ?>
                        <div class="er_form er_form_place_<?php echo $place; ?>">
                            <?php
                            if (get_field('er_form_title')) { ?>
                                <h2><?php echo get_field('er_form_title'); ?></h2>
                            <?php 
                            }
                            if (get_field('er_form_title')) { ?>
                                <div class="er_form_subtext"><?php echo get_field('er_form_subtitle'); ?></div>
                            <?php 
                            } 
                            if( have_rows('er_form_fields') ): ?>
                                <form class="order-form" id="<?php echo get_the_ID(); ?>">
                                    <div class="form_result"></div>
                                    <input type="hidden" name="form_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="form_type" value="<?php echo get_field('er_form_type'); ?>">
                                    <input type="hidden" name="advertiser_offer_id" value="<?php echo get_field('er_form_offer_id'); ?>">
                                    <input type="hidden" name="subid" value="<?php echo wp_generate_uuid4(); ?>">
                                    <input type="hidden" name="ip" value="<?php echo get_the_user_ip(); ?>">
                                    <?php if(get_field('er_form_integration')) { 
                        			$post_object = get_field('er_form_integration'); ?>
                        			<input type="hidden" name="offer_advertizer" value="<?php echo $post_object->ID; ?>">
                        			<?php  }; ?>
                        			<?php 
                        			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
                        				$utm_source = $_REQUEST['utm_source']; 
                        			} else { 
                        				$utm_source = "no_utm_source"; 
                        			} 
                        			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
                        				$utm_medium = $_REQUEST['utm_medium']; 
                        			} else { 
                        				$utm_medium = "no_utm_medium"; 
                        			}
                        			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
                        				$utm_campaign = $_REQUEST['utm_campaign']; 
                        			} else { 
                        				$utm_campaign = "no_utm_campaign"; 
                        			} 
                        			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
                        				$utm_content = $_REQUEST['utm_content']; 
                        			} else { 
                        				$utm_content = "no_utm_content"; 
                        			}
                        			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
                        				$utm_term = $_REQUEST['utm_term']; 
                        			} else { 
                        				$utm_term = "no_utm_term"; 
                        			} 
                        			?>
                        			<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                        			<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>">
                        			<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>">
                        			<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>">
                        			<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>">
                        			<?php if (get_field('er_form_success_action') && get_field('er_form_success_action') == 'redirect' && get_field('er_form_redirect_links')) {
                        			    $rows = get_field('er_form_redirect_links'); 
                                      if($rows) $i = 0; { 
                                        shuffle( $rows ); 
                                        foreach($rows as $row) { 
                                          $link_active = $row['form_redirect_active'];
                                          
                                          if ($link_active == 1) {
                                          $i++; if($i==2) break; 
                                          $link = $row['form_redirect_link']; ?>
                                    
                                          <?php //echo $link; ?>
                                    <?php
                                          } else {
                                              continue;
                                          }
                                              
                                          } }
                        			?>
                        			
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo $link; ?>">
                        			<?php } elseif (get_field('er_form_success_action') && get_field('er_form_success_action') == 'alert' && get_field('er_form_success_text')) { ?>
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo get_field('er_form_success_text'); ?>">
                        			<?php } else { ?>
                        			    <input type="hidden" name="form_success_action" value="default">
                        			<?php }; ?>
                                    <?php
                                while ( have_rows('er_form_fields') ) : the_row(); ?>
                                <?php
                                if (get_sub_field('er_form_field_title_required') == 1) {
                                    $required = 'required';
                                } else {
                                    $required = '';
                                }
                                if (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_input_container <?php if (get_sub_field('er_form_field_type') == 'hidden') { ?>hidden<?php }; ?>"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" class="<?php echo $required; ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') == 1) { ?>
                                    <div class="er_form_input_container"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" class="<?php echo $required; ?>" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_title'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') == 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>"></textarea></div>
                               <?php } else { ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_title'); ?>"></textarea></div>
                               <?php };
                                   // $er_form_field_type = get_sub_field('er_form_field_type');
                                   // $er_form_field_name = get_sub_field('er_form_field_name');
                                   // $er_form_field_title = get_sub_field('er_form_field_title');
                                   // $er_form_field_title_placeholder = get_sub_field('er_form_field_title_placeholder');
                                   // $er_form_field_placeholder = get_sub_field('er_form_field_placeholder');
                                   // $er_form_field_title_required = get_sub_field('er_form_field_title_required');
                                   // echo $er_form_field_type;
                                   // echo '<br />';
                                   // echo $er_form_field_name;
                                   // echo '<br />';
                                   // echo $er_form_field_title;
                                   // echo '<br />';
                                   // echo $er_form_field_title_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                endwhile;
                                 if (get_field('er_form_button_text')) { ?>
                                <input type="submit" name="submit" value="<?php echo get_field('er_form_button_text'); ?>" class="er_form_submit" />
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Отправить" class="er_form_submit" />
                            <?php } ?>
                            </form>
                            <?php 
                            else :
                                // no rows found
                            endif;
                            
                            ?>
                        </div>
                        <?php if($place == 3) { ?></div><?php }; ?>
                        <?php
                }
                }
                wp_reset_postdata();
            }
            wp_reset_postdata();
        } else {
            //echo 'меток у страницы нет, берем форму по умолчанию';
       
           $er_forms = new WP_Query( array(
            	'post_type' => 'leadforms',
            	'posts_per_page' => 1,
            	'orderby' => 'rand',
            	'meta_query'	=> array(
            		'relation'		=> 'AND',
            		array(
            			'key'	 	=> 'er_form_default',
            			'value'	  	=> 1,
            			'compare' 	=> '=',
            		),
            		array(
            			'key'	 	=> 'er_form_place',
            			'value'	  	=> $place,
            			'compare' 	=> '=',
            		),
            	
            	),
            ) );
            //print_r($er_forms);
            if ( $er_forms->have_posts() ) {
                while ( $er_forms->have_posts() ) {
                        $er_forms->the_post(); ?>
                        <?php if($place == 3) { ?><div class="block" id="sidebar_form<?php if (!get_field('disable_floating')) { echo '_fixed'; }; ?>"><?php }; ?>
                        <div class="er_form er_form_place_<?php echo $place; ?>">
                            <?php
                            if (get_field('er_form_title')) { ?>
                                <h2><?php echo get_field('er_form_title'); ?></h2>
                            <?php 
                            }
                            if (get_field('er_form_title')) { ?>
                                <div class="er_form_subtext"><?php echo get_field('er_form_subtitle'); ?></div>
                            <?php 
                            } 
                            if( have_rows('er_form_fields') ): ?>
                                <form class="order-form" id="<?php echo get_the_ID(); ?>">
                                    <div class="form_result"></div>
                                    <input type="hidden" name="form_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="form_type" value="<?php echo get_field('er_form_type'); ?>">
                                    <input type="hidden" name="advertiser_offer_id" value="<?php echo get_field('er_form_offer_id'); ?>">
                                    <input type="hidden" name="subid" value="<?php echo wp_generate_uuid4(); ?>">
                                    <input type="hidden" name="ip" value="<?php echo get_the_user_ip(); ?>">
                                    <?php if(get_field('er_form_integration')) { 
                        			$post_object = get_field('er_form_integration'); ?>
                        			<input type="hidden" name="offer_advertizer" value="<?php echo $post_object->ID; ?>">
                        			<?php  }; ?>
                        			<?php 
                        			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
                        				$utm_source = $_REQUEST['utm_source']; 
                        			} else { 
                        				$utm_source = "no_utm_source"; 
                        			} 
                        			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
                        				$utm_medium = $_REQUEST['utm_medium']; 
                        			} else { 
                        				$utm_medium = "no_utm_medium"; 
                        			}
                        			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
                        				$utm_campaign = $_REQUEST['utm_campaign']; 
                        			} else { 
                        				$utm_campaign = "no_utm_campaign"; 
                        			} 
                        			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
                        				$utm_content = $_REQUEST['utm_content']; 
                        			} else { 
                        				$utm_content = "no_utm_content"; 
                        			}
                        			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
                        				$utm_term = $_REQUEST['utm_term']; 
                        			} else { 
                        				$utm_term = "no_utm_term"; 
                        			} 
                        			?>
                        			<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                        			<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>">
                        			<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>">
                        			<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>">
                        			<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>">
                        			<?php if (get_field('er_form_success_action') && get_field('er_form_success_action') == 'redirect' && get_field('er_form_redirect_links')) { 
                        			$rows = get_field('er_form_redirect_links'); 
                                      if($rows) $i = 0; { 
                                        shuffle( $rows ); 
                                        foreach($rows as $row) { 
                                          $link_active = $row['form_redirect_active'];
                                          
                                          if ($link_active == 1) {
                                          $i++; if($i==2) break; 
                                          $link = $row['form_redirect_link']; ?>
                                    
                                          <?php //echo $link; ?>
                                    <?php
                                          } else {
                                              continue;
                                          }
                                              
                                          } }
                        			?>
                        			
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo $link; ?>">
                        			<?php } elseif (get_field('er_form_success_action') && get_field('er_form_success_action') == 'alert' && get_field('er_form_success_text')) { ?>
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo get_field('er_form_success_text'); ?>">
                        			<?php } else { ?>
                        			    <input type="hidden" name="form_success_action" value="default">
                        			<?php }; ?>
                                    <?php
                                while ( have_rows('er_form_fields') ) : the_row(); ?>
                                <?php
                                if (get_sub_field('er_form_field_title_required') == 1) {
                                    $required = 'required';
                                } else {
                                    $required = '';
                                }
                                if (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_input_container <?php if (get_sub_field('er_form_field_type') == 'hidden') { ?>hidden<?php }; ?>"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" class="<?php echo $required; ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') == 1) { ?>
                                    <div class="er_form_input_container"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" class="<?php echo $required; ?>" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_title'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') == 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>"></textarea></div>
                               <?php } else { ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_title'); ?>"></textarea></div>
                               <?php };
                                   // $er_form_field_type = get_sub_field('er_form_field_type');
                                   // $er_form_field_name = get_sub_field('er_form_field_name');
                                   // $er_form_field_title = get_sub_field('er_form_field_title');
                                   // $er_form_field_title_placeholder = get_sub_field('er_form_field_title_placeholder');
                                   // $er_form_field_placeholder = get_sub_field('er_form_field_placeholder');
                                   // $er_form_field_title_required = get_sub_field('er_form_field_title_required');
                                   // echo $er_form_field_type;
                                   // echo '<br />';
                                   // echo $er_form_field_name;
                                   // echo '<br />';
                                   // echo $er_form_field_title;
                                   // echo '<br />';
                                   // echo $er_form_field_title_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                endwhile;
                                 if (get_field('er_form_button_text')) { ?>
                                <input type="submit" name="submit" value="<?php echo get_field('er_form_button_text'); ?>" class="er_form_submit" />
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Отправить" class="er_form_submit" />
                            <?php } ?>
                            </form>
                            <?php 
                            else :
                                // no rows found
                            endif;
                            
                            ?>
                        </div>
                        <?php if($place == 3) { ?></div><?php }; ?>
                        <?php
                }
            }
            wp_reset_postdata();
        }
}


function lead_form_shordcode($atts)
{
	
	$form_id = $atts['form_id'];
	$post = get_post( $form_id );
	ob_start();
	//echo $form_id;	
	if($post) :
		echo '<div class="er_form er_form_place_4">';
		if (get_field('er_form_title',$post->ID)) {
			echo '<h2>'.get_field('er_form_title',$post->ID).'</h2>';
		}
		if (get_field('er_form_title',$post->ID)) {
			echo '<div class="er_form_subtext">'.get_field('er_form_subtitle',$post->ID).'</div>';
		}
		if( have_rows('er_form_fields',$post->ID) ):
			echo '<form class="order-form" id="'.$post->ID.'">';
	
			if( have_rows('subscribe_lists',$post->ID) ):
				echo '<div id="bla">';
				while(have_rows('subscribe_lists',$post->ID)) : the_row();
					echo '<div class="checkbox">';
						echo '<input type="checkbox" name="subscribes[]" value="'.get_sub_field('er_form_offer_id',$post->ID).'" class="game"></input>';
						echo '<div class="right_checkbox">';
							echo '<span class="er_form_check_title">'.get_sub_field('er_form_offer_title',$post->ID).'</span>';
							echo '<span class="er_form_check_text">'.get_sub_field('er_form_offer_text',$post->ID).'</span>';
						echo '</div>';
						echo '<div class="clear"></div>';
					echo '</div>';
				endwhile;
				echo '</div>';
			endif;
			echo '<div class="form_result"></div>';
			echo '<input type="hidden" name="form_id" value="'.$post->ID.'">';
			echo '<input type="hidden" name="form_type" value="'.get_field('er_form_type',$post->ID).'">';
			echo '<input type="hidden" name="advertiser_offer_id" value="'.get_field('er_form_offer_id',$post->ID).'">';
			echo '<input type="hidden" name="subid" value="'.wp_generate_uuid4().'">';
			echo '<input type="hidden" name="ip" value="'.get_the_user_ip().'">';
			if(get_field('er_form_integration',$post->ID)) : 
            	$post_object = get_field('er_form_integration',$post->ID);
                echo '<input type="hidden" name="offer_advertizer" value="'.$post_object->ID.'">';
            endif;
			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
				$utm_source = $_REQUEST['utm_source']; 
			} else { 
				$utm_source = "no_utm_source"; 
			} 
			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
				$utm_medium = $_REQUEST['utm_medium']; 
			} else { 
				$utm_medium = "no_utm_medium"; 
			}
			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
				$utm_campaign = $_REQUEST['utm_campaign']; 
			} else { 
				$utm_campaign = "no_utm_campaign"; 
			} 
			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
				$utm_content = $_REQUEST['utm_content']; 
			} else { 
				$utm_content = "no_utm_content"; 
			}
			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
				$utm_term = $_REQUEST['utm_term']; 
			} else { 
				$utm_term = "no_utm_term"; 
			} 
			echo '<input type="hidden" name="utm_source" value="'.$utm_source.'">';
			echo '<input type="hidden" name="utm_medium" value="'.$utm_medium.'">';
			echo '<input type="hidden" name="utm_campaign" value="'.$utm_campaign.'">';
			echo '<input type="hidden" name="utm_content" value="'.$utm_content.'">';
			echo '<input type="hidden" name="utm_term" value="'.$utm_term.'">';
			if (get_field('er_form_success_action',$post->ID) && get_field('er_form_success_action',$post->ID) == 'redirect' && get_field('er_form_redirect_links',$post->ID)) : 
				$rows = get_field('er_form_redirect_links',$post->ID); 
				if($rows) : $i = 0; 
					shuffle( $rows ); 
					foreach($rows as $row) : 
						$link_active = $row['form_redirect_active'];
						if ($link_active == 1) :
							$i++; if($i==2) break; 
							$link = $row['form_redirect_link']; 
						else :
							continue;
						endif;
					endforeach; 
				endif;
				

				echo '<input type="hidden" name="form_success_action" value="'.get_field('er_form_success_action',$post->ID).'">';
				echo '<input type="hidden" name="form_success_value" value="'.$link.'">';
			elseif (get_field('er_form_success_action',$post->ID) && get_field('er_form_success_action',$post->ID) == 'alert' && get_field('er_form_success_text',$post->ID)) :
				echo '<input type="hidden" name="form_success_action" value="'.get_field('er_form_success_action',$post->ID).'>">';
				echo '<input type="hidden" name="form_success_value" value="'.get_field('er_form_success_text',$post->ID).'">';
			else :
				echo '<input type="hidden" name="form_success_action" value="default">';
			endif;
			while ( have_rows('er_form_fields',$post->ID) ) : the_row();
				if (get_sub_field('er_form_field_title_required',$post->ID) == 1) :
					$required = 'required';
				else :
					$required = '';
				endif;
				if (get_sub_field('er_form_field_type',$post->ID) != 'textarea' && get_sub_field('er_form_field_title_placeholder',$post->ID) != 1) :
					if(get_sub_field('er_form_field_title',$post->ID)) : 
					echo '<div class="er_form_field_title">'.get_sub_field('er_form_field_title',$post->ID).'</div>';
					endif;
					echo '<div class="er_form_input_container';
					if (get_sub_field('er_form_field_type',$post->ID) == 'hidden') :
						echo 'hidden';
					endif;
					echo '">';
					echo '<input type="'.get_sub_field('er_form_field_type',$post->ID).'>" class="'.$required.'" name="form_fields['.get_sub_field('er_form_field_name',$post->ID).']" '.$required.' placeholder="'.get_sub_field('er_form_field_placeholder',$post->ID).'" />';
					echo '</div>';
			   elseif (get_sub_field('er_form_field_type',$post->ID) != 'textarea' && get_sub_field('er_form_field_title_placeholder',$post->ID) == 1) :
					echo '<div class="er_form_input_container">';
					echo '<input type="'.get_sub_field('er_form_field_type',$post->ID).'" name="form_fields['.get_sub_field('er_form_field_name',$post->ID).']" class="'.$required.'" '.$required.' placeholder="'.get_sub_field('er_form_field_title',$post->ID).'" />';
					echo '</div>';
			   elseif (get_sub_field('er_form_field_type',$post->ID) == 'textarea' && get_sub_field('er_form_field_title_placeholder',$post->ID) != 1) :
					if(get_sub_field('er_form_field_title',$post->ID)) :
						echo '<div class="er_form_field_title">'.get_sub_field('er_form_field_title',$post->ID).'</div>';
					endif;
					echo '<div class="er_form_textarea_container"><textarea rows="5" name="form_fields['.get_sub_field('er_form_field_name',$post->ID).']" '.$required.' class="'.$required.'" placeholder="'.get_sub_field('er_form_field_placeholder',$post->ID).'"></textarea></div>';
			   else :
					echo '<div class="er_form_textarea_container"><textarea rows="5" name="form_fields['.get_sub_field('er_form_field_name',$post->ID).']" '.$required.' class="'.$required.'" placeholder="'.get_sub_field('er_form_field_title',$post->ID).'"></textarea></div>';
			   endif;
				  
			endwhile;
			if (get_field('er_form_button_text',$post->ID)) :
				echo '<input type="submit" name="submit" value="'.get_field('er_form_button_text',$post->ID).'" class="er_form_submit" />';
			else :
					echo '<input type="submit" name="submit" value="Отправить" class="er_form_submit" />';
			endif;
			echo '</form>';
		endif;
		echo '</div>';
	endif;
	
	
	$output = ob_get_clean();
	return $output;
	/*
	$er_forms = new WP_Query( array(
            	'post_type' => 'leadforms',
				'p'         => $form_id,
            ) );
            //print_r($er_forms);
            if ( $er_forms->have_posts() ) {
                while ( $er_forms->have_posts() ) {
                        $er_forms->the_post(); ?>
                        <div class="er_form er_form_place_4">
                            <?php
                            if (get_field('er_form_title')) { ?>
                                <h2><?php echo get_field('er_form_title'); ?></h2>
                            <?php 
                            }
                            if (get_field('er_form_title')) { ?>
                                <div class="er_form_subtext"><?php echo get_field('er_form_subtitle'); ?></div>
                            <?php 
                            } 
							
                            if( have_rows('er_form_fields') ): ?>
                                <form class="order-form" id="<?php echo get_the_ID(); ?>">
                                 <?php 
					
					if( have_rows('subscribe_lists') ):
								while(have_rows('subscribe_lists')) : the_row();
								?>
								<div class="checkbox"><input type="checkbox" name="subscribes[]" value="<?php echo get_sub_field('er_form_offer_id'); ?>"><div class="right_checkbox"><span class="er_form_check_title"><?php echo get_sub_field('er_form_offer_title'); ?></span><span class="er_form_check_text"><?php echo get_sub_field('er_form_offer_text'); ?></span></div>
								<div class="clear"></div>
								</div>
								<?php
								endwhile;
							endif;
					
					?>
                                    <div class="form_result"></div>
                                    <input type="hidden" name="form_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="form_type" value="<?php echo get_field('er_form_type'); ?>">
                                    <input type="hidden" name="advertiser_offer_id" value="<?php echo get_field('er_form_offer_id'); ?>">
                                    <input type="hidden" name="subid" value="<?php echo wp_generate_uuid4(); ?>">
                                    <input type="hidden" name="ip" value="<?php echo get_the_user_ip(); ?>">
                                    <?php if(get_field('er_form_integration')) { 
                        			$post_object = get_field('er_form_integration'); ?>
                        			<input type="hidden" name="offer_advertizer" value="<?php echo $post_object->ID; ?>">
                        			<?php  }; ?>
                        			<?php 
                        			if (isset($_REQUEST['utm_source']) && $_REQUEST['utm_source'] !="") { 
                        				$utm_source = $_REQUEST['utm_source']; 
                        			} else { 
                        				$utm_source = "no_utm_source"; 
                        			} 
                        			if (isset($_REQUEST['utm_medium']) && $_REQUEST['utm_medium'] !="") { 
                        				$utm_medium = $_REQUEST['utm_medium']; 
                        			} else { 
                        				$utm_medium = "no_utm_medium"; 
                        			}
                        			if (isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] !="") { 
                        				$utm_campaign = $_REQUEST['utm_campaign']; 
                        			} else { 
                        				$utm_campaign = "no_utm_campaign"; 
                        			} 
                        			if (isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] !="") { 
                        				$utm_content = $_REQUEST['utm_content']; 
                        			} else { 
                        				$utm_content = "no_utm_content"; 
                        			}
                        			if (isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] !="") { 
                        				$utm_term = $_REQUEST['utm_term']; 
                        			} else { 
                        				$utm_term = "no_utm_term"; 
                        			} 
                        			?>
                        			<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                        			<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>">
                        			<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>">
                        			<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>">
                        			<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>">
                        			<?php if (get_field('er_form_success_action') && get_field('er_form_success_action') == 'redirect' && get_field('er_form_redirect_links')) { 
                        			$rows = get_field('er_form_redirect_links'); 
                                      if($rows) $i = 0; { 
                                        shuffle( $rows ); 
                                        foreach($rows as $row) { 
                                          $link_active = $row['form_redirect_active'];
                                          
                                          if ($link_active == 1) {
                                          $i++; if($i==2) break; 
                                          $link = $row['form_redirect_link']; ?>
                                    
                                          <?php //echo $link; ?>
                                    <?php
                                          } else {
                                              continue;
                                          }
                                              
                                          } }
                        			?>
                        			
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo $link; ?>">
                        			<?php } elseif (get_field('er_form_success_action') && get_field('er_form_success_action') == 'alert' && get_field('er_form_success_text')) { ?>
                        			    <input type="hidden" name="form_success_action" value="<?php echo get_field('er_form_success_action'); ?>">
                        			    <input type="hidden" name="form_success_value" value="<?php echo get_field('er_form_success_text'); ?>">
                        			<?php } else { ?>
                        			    <input type="hidden" name="form_success_action" value="default">
                        			<?php }; ?>
                                    <?php
                                while ( have_rows('er_form_fields') ) : the_row(); ?>
                                <?php
                                if (get_sub_field('er_form_field_title_required') == 1) {
                                    $required = 'required';
                                } else {
                                    $required = '';
                                }
                                if (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_input_container <?php if (get_sub_field('er_form_field_type') == 'hidden') { ?>hidden<?php }; ?>"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" class="<?php echo $required; ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') != 'textarea' && get_sub_field('er_form_field_title_placeholder') == 1) { ?>
                                    <div class="er_form_input_container"><input type="<?php echo get_sub_field('er_form_field_type'); ?>" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" class="<?php echo $required; ?>" <?php echo $required; ?> placeholder="<?php echo get_sub_field('er_form_field_title'); ?>" /></div>
                               <?php } elseif (get_sub_field('er_form_field_type') == 'textarea' && get_sub_field('er_form_field_title_placeholder') != 1) {  ?>
                                    <?php if(get_sub_field('er_form_field_title')) { ?><div class="er_form_field_title"><?php echo get_sub_field('er_form_field_title'); ?></div><?php }; ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_placeholder'); ?>"></textarea></div>
                               <?php } else { ?>
                                    <div class="er_form_textarea_container"><textarea rows="5" name="form_fields[<?php echo get_sub_field('er_form_field_name'); ?>]" <?php echo $required; ?> class="<?php echo $required; ?>" placeholder="<?php echo get_sub_field('er_form_field_title'); ?>"></textarea></div>
                               <?php };
                                   // $er_form_field_type = get_sub_field('er_form_field_type');
                                   // $er_form_field_name = get_sub_field('er_form_field_name');
                                   // $er_form_field_title = get_sub_field('er_form_field_title');
                                   // $er_form_field_title_placeholder = get_sub_field('er_form_field_title_placeholder');
                                   // $er_form_field_placeholder = get_sub_field('er_form_field_placeholder');
                                   // $er_form_field_title_required = get_sub_field('er_form_field_title_required');
                                   // echo $er_form_field_type;
                                   // echo '<br />';
                                   // echo $er_form_field_name;
                                   // echo '<br />';
                                   // echo $er_form_field_title;
                                   // echo '<br />';
                                   // echo $er_form_field_title_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_placeholder;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                   // echo '<br />';
                                   // echo $er_form_field_title_required;
                                endwhile;
                                 if (get_field('er_form_button_text')) { ?>
                                <input type="submit" name="submit" value="<?php echo get_field('er_form_button_text'); ?>" class="er_form_submit" />
                            <?php } else { ?>
                                <input type="submit" name="submit" value="Отправить" class="er_form_submit" />
                            <?php } ?>
                            </form>
                            <?php 
                            else :
                                // no rows found
                            endif;
                            
                            ?>
                        </div>
                        <?php
                }
            }
            wp_reset_postdata(); */
   
}

//this creates the shortcode you can use in posts, pages and widgets
add_shortcode('er_leadform', 'lead_form_shordcode');
        
function banner_sidebar($place,$post_id) {
    $term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
        //print_r($term_list); 
        //echo $post_id;
    if($term_list) { 
        //echo 'metki est';
    } else {
        //echo 'metok net';
    }
    if($term_list) { 
        
	    //$er_tags = get_field('er_post_tags');
	    //print_r($er_tags); 
	    //echo 'метки у страницы есть';
	    $er_banners = new WP_Query( array(
        	'post_type' => 'banners',
        	'posts_per_page' => 1,
        	'orderby' => 'rand',
        	'meta_query'	=> array(
        		'relation'		=> 'AND',
        		array(
        			'key'	 	=> 'banner_place',
        			'value'	  	=> $place,
        			'compare' 	=> '=',
        		),
        	),
        	'tax_query' => array(
                array(
                    'taxonomy' => 'affiliate-tags',
                    'field'    => 'id',
                    'terms'    => $term_list,
                ),
            ),
        ) );
        //print_r($er_banners);
   // The Loop
        if ( $er_banners->have_posts() ) {
            while ( $er_banners->have_posts() ) {
                    $er_banners->the_post();
                    $rows = get_field('banner_links'); 
                      if($rows) $i = 0; { 
                        shuffle( $rows ); 
                        foreach($rows as $row) { 
                          $link_active = $row['banner_link_active'];
                          
                          if ($link_active == 1) {
                          $i++; if($i==2) break; 
                          $link = $row['banner_link']; ?>
                    
                          <?php //echo $link; ?>
                    <?php
                          } else {
                              continue;
                          }
                              
                          } }
                    if (get_field('banner_type') && get_field('banner_type') == 'image') {
                        if (get_field('banner_file')) {
                            $banner_content = '<img src="'.get_field('banner_file')['url'].'" />';
                        } else {
                            $banner_content = get_the_title();
                        }
                         
                    } else {
                        if (get_field('banner_code')) {
                            $banner_content = get_field('banner_code');
                        } else {
                            $banner_content = get_the_title();
                        }
                    }
                    ?>
                    <a rel="nofollow" target="_blank" href="<?php echo $link; ?>"><?php echo $banner_content; ?></a>
                    <?php
                    //the_title();
            }
        } else {
           // echo 'no banners found';
            $er_banners = new WP_Query( array(
        	'post_type' => 'banners',
        	'posts_per_page' => 1,
        	'orderby' => 'rand',
        	'meta_query'	=> array(
        		'relation'		=> 'AND',
        		array(
        			'key'	 	=> 'banner_default',
        			'value'	  	=> 1,
        			'compare' 	=> '=',
        		),
        		array(
        			'key'	 	=> 'banner_place',
        			'value'	  	=> $place,
        			'compare' 	=> '=',
        		),
        		/* array(
        			'key'	  	=> 'featured',
        			'value'	  	=> '1',
        			'compare' 	=> '=',
        		),*/
        	),
        ) );
        //print_r($er_banners);
   // The Loop
        if ( $er_banners->have_posts() ) {
            while ( $er_banners->have_posts() ) {
                    $er_banners->the_post();
                    $rows = get_field('banner_links'); 
                      if($rows) $i = 0; { 
                        shuffle( $rows ); 
                        foreach($rows as $row) { 
                          $link_active = $row['banner_link_active'];
                          
                          if ($link_active == 1) {
                          $i++; if($i==2) break; 
                          $link = $row['banner_link']; ?>
                    
                          <?php //echo $link; ?>
                    <?php
                          } else {
                              continue;
                          }
                              
                          } }
                    if (get_field('banner_type') && get_field('banner_type') == 'image') {
                        if (get_field('banner_file')) {
                            $banner_content = '<img src="'.get_field('banner_file')['url'].'" />';
                        } else {
                            $banner_content = get_the_title();
                        }
                         
                    } else {
                        if (get_field('banner_code')) {
                            $banner_content = get_field('banner_code');
                        } else {
                            $banner_content = get_the_title();
                        }
                    }
                    ?>
                    <a rel="nofollow" target="_blank" href="<?php echo $link; ?>"><?php echo $banner_content; ?></a>
                    <?php
                   // the_title();
            }
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();
        }
        /* Restore original Post Data */
        wp_reset_postdata();
   } else {
       //echo 'меток у страницы нет';
       
       $er_banners = new WP_Query( array(
        	'post_type' => 'banners',
        	'posts_per_page' => 1,
        	'orderby' => 'rand',
        	'meta_query'	=> array(
        		'relation'		=> 'AND',
        		array(
        			'key'	 	=> 'banner_default',
        			'value'	  	=> 1,
        			'compare' 	=> '=',
        		),
        		array(
        			'key'	 	=> 'banner_place',
        			'value'	  	=> $place,
        			'compare' 	=> '=',
        		),
        	
        	),
        ) );
        //print_r($er_banners);
   // The Loop
        if ( $er_banners->have_posts() ) {
            while ( $er_banners->have_posts() ) {
                    $er_banners->the_post();
                    $rows = get_field('banner_links'); 
                      if($rows) $i = 0; { 
                        shuffle( $rows ); 
                        foreach($rows as $row) { 
                          $link_active = $row['banner_link_active'];
                          
                          if ($link_active == 1) {
                          $i++; if($i==2) break; 
                          $link = $row['banner_link']; ?>
                    
                          <?php //echo $link; ?>
                    <?php
                          } else {
                              continue;
                          }
                              
                          } }
                    if (get_field('banner_type') && get_field('banner_type') == 'image') {
                        if (get_field('banner_file')) {
                            $banner_content = '<img src="'.get_field('banner_file')['url'].'" />';
                        } else {
                            $banner_content = get_the_title();
                        }
                         
                    } else {
                        if (get_field('banner_code')) {
                            $banner_content = get_field('banner_code');
                        } else {
                            $banner_content = get_the_title();
                        }
                    }
                    ?>
                    <a rel="nofollow" target="_blank" href="<?php echo $link; ?>"><?php echo $banner_content; ?></a>
                    <?php
                    //the_title();
            }
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();
   }
   
   
  
}

function loop_er_search_box() { ?>
    <div class="er_search_box">
         <form role="search" method="get" action="<?php echo home_url( '/' ) ?>">
             
            <div class="search_box">
                <h2>Поиск по всему сайту</h2><a href="<?php bloginfo('url'); ?>?s=&page=company" class="search_switcher">Расширенный поиск по обзорам компаний</a>
             <div class="clear"></div>
                <div class="as_search_main_field">
                    <div class="form_text">
                        <!--<div class="as_search_company_type">
            				<select style="display:none"  name="as_search_company_type" id="as_search_company_type"></select>
            			</div>-->
            			<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Поиск.." />
                    </div>
                </div>
                <div class="clear"></div>
                <input type="submit" class="submit_button" name="search_submit" value="Найти" />
			    <div class="clear"></div>
            </div>
         </form>
    </div>
    
  <?php 
	$list_services = get_terms( array(
		'taxonomy' => 'companyproviders',
		'hide_empty' => false,
	) ); 
	$list_drugs_categories = get_terms( array(
		'taxonomy' => 'affiliate-tags',
		'hide_empty' => true,
	) );
?>
  <script>
  

    $('.as_search_company_type').dropdown({
      data: [
          {name: "Весь сайт", id: 'not_set', <?php if(!isset($_REQUEST['as_search_company_type']) || isset($_REQUEST['as_search_company_type']) && $_REQUEST['as_search_company_type'] == 'not_set') { ?>"selected": true<?php } ?>},
          {name: "Блог", id: 'blog', <?php if(isset($_REQUEST['as_search_company_type']) && $_REQUEST['as_search_company_type'] == 'blog') { ?>"selected": true<?php } ?>},
          <?php
		$drug_form_types = get_field_object('field_5d70eedb74c36');
		if( $drug_form_types['choices'] ): ?>
			
				<?php foreach( $drug_form_types['choices'] as $key => $value ): ?>
					{name: "<?php echo $value; ?>", id: "<?php echo $key; ?>", <?php if(isset($_REQUEST['as_search_company_type']) && $_REQUEST['as_search_company_type'] == $key) { ?>"selected": true<?php } ?> },
				<?php endforeach; ?>
			
		<?php endif; ?>
	  ],
      input: '<input type="text" maxLength="20" placeholder="Поиск в списке...">'
    });
	
</script>
  
  
  
<?php }

function er_search_fields($company_type) {
    echo $company_type;
}

function loop_search_er($company_type, $show_title, $page_title_text) { ?>
<div class="er_search_box">
         <form role="search" method="GET" action="<?php bloginfo('url'); ?>/">
            <div class="search_box">
                <?php if ($show_title) { 
                if($page_title_text && $page_title_text !='') { ?>
                <h2><?php echo $page_title_text; ?></h2>
                <div class="clear"></div>
                <?php } else { ?>
                <h2>Расширенный поиск по обзорам компаний</h2><a href="<?php bloginfo('url'); ?>?s" class="search_switcher">Поиск по всему сайту</a>
                <div class="clear"></div>
                <?php } }; ?>
                <?php if ($company_type == 'none' || $company_type == '') { ?>
                <div class="as_search_company_type">
                    <label>Выберите тип компании для поиска:</label>
            		<select style="display:none"  name="as_search_company_type" id="as_search_company_type"></select>
            	</div>
            	<div class="clear"></div>
            	<?php } else { ?>
            	<div class="as_search_company_type" style="display:none;">
            		<select style="display:none"  name="as_search_company_type" id="as_search_company_type"></select>
            	</div>
            	<?php } ?>
            	<div id="as_search_company_fields"></div>
                <input type="hidden" name="page" value="company" />
                <input type="submit" class="submit_button" name="search_submit_company" value="Найти" />
                <a class="er_search_reset">Сбросить фильтры</a>
			    <div class="clear"></div>
            </div>
         </form>
    </div>
    
  <?php 
	$as_search_providers = get_terms( array(
		'taxonomy' => 'companyproviders',
		'hide_empty' => false,
	) ); 
	$as_search_action_types = get_terms( array(
		'taxonomy' => 'companyactivetypes',
		'hide_empty' => false,
	) ); 
	$as_search_options_types = get_terms( array(
		'taxonomy' => 'companyoptiontypes',
		'hide_empty' => false,
	) ); 
	
	$as_search_options_terminals = get_terms( array(
		'taxonomy' => 'companyterminals',
		'hide_empty' => false,
	) ); 
	
	$as_search_regulators = get_terms( array(
		'taxonomy' => 'companyregulators',
		'hide_empty' => false,
	) ); 
	
	$as_search_company_currency_list = get_field_object('field_5d711a5748552');
	//	print_r($as_search_company_currency_list);
	
	//print_r($as_search_providers);
?>
  <script>
  
  $('.as_search_company_type').dropdown({
      data: [
          <?php
		$drug_form_types = get_field_object('field_5d70eedb74c36');
		if( $drug_form_types['choices'] ): ?>
			
				<?php foreach( $drug_form_types['choices'] as $key => $value ): ?>
					{name: "<?php echo $value; ?>", id: "<?php echo $key; ?>", <?php if(isset($_REQUEST['as_search_company_type']) && $_REQUEST['as_search_company_type'] == $key || !isset($_REQUEST['as_search_company_type']) && $key == $company_type || !isset($_REQUEST['as_search_company_type']) && $key == 'bi' ) { ?>"selected": true<?php } ?> },
				<?php endforeach; ?>
			
		<?php endif; ?>
	  ],
      input: '<input type="text" maxLength="20" placeholder="Поиск в списке...">'
    });
	$(document).ready(function(){

       
            var er_search_company_type = $("#as_search_company_type").children("option:selected").val();
            
            //alert("You have selected the country - " + er_search_company_type);
            /* $("#as_search_company_fields").detach();
            $("#as_search_company_fields_"+er_search_company_type).appendTo("#as_search_company_fields");
            $("#as_search_company_fields_"+er_search_company_type).show() */
            
            var as_search_terminals_ids = <?php print_r(json_encode($_REQUEST['as_search_terminals'])); ?>;
            var as_search_regulators_ids = <?php print_r(json_encode($_REQUEST['as_search_regulators'])); ?>;
            var as_search_options_types_ids = <?php print_r(json_encode($_REQUEST['as_search_options_types'])); ?>;
            var as_search_action_types_ids = <?php print_r(json_encode($_REQUEST['as_search_action_types'])); ?>;
            var as_search_providers_ids = <?php print_r(json_encode($_REQUEST['as_search_providers'])); ?>;
            var as_search_credit_shoulder_ids = <?php print_r(json_encode($_REQUEST['as_search_credit_shoulder'])); ?>;
            var as_search_min_dep_ids = <?php print_r(json_encode($_REQUEST['as_search_min_dep'])); ?>;
            var as_search_min_lot_ids = <?php print_r(json_encode($_REQUEST['as_search_min_lot'])); ?>;
            var as_search_min_deal_ids = <?php print_r(json_encode($_REQUEST['as_search_min_deal'])); ?>;
            var as_search_min_bet_ids = <?php print_r(json_encode($_REQUEST['as_search_min_bet'])); ?>;
            var as_search_payouts_ids = <?php print_r(json_encode($_REQUEST['as_search_payouts'])); ?>;
            var as_search_expiration_ids = <?php print_r(json_encode($_REQUEST['as_search_expiration'])); ?>;
			var as_search_order_types_ids = <?php print_r(json_encode($_REQUEST['as_search_order_types'])); ?>;
          //  alert(as_search_order_types_ids);
		//alert(as_search_regulators_ids);
            function current_ids(ids){
				  return ids;
				};
				
				
            var data_cities = {
                company_type:er_search_company_type,
            <?php if(isset($_REQUEST['s'])) { ?>
                s:'<?php echo $_REQUEST['s']; ?>',
            <?php }; ?>
            <?php /* if(isset($_REQUEST['as_search_order_types'])) { ?>
                as_search_order_types:'<?php echo $_REQUEST['as_search_order_types']; ?>',
            <?php }; */?>
			<?php if(isset($_REQUEST['as_search_order_types'])) { ?>
                as_search_order_types:current_ids(as_search_order_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_company_language'])) { ?>
                as_search_company_language:'<?php echo $_REQUEST['as_search_company_language']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_company_currency'])) { ?>
                as_search_company_currency:'<?php echo $_REQUEST['as_search_company_currency']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_regulators'])) { ?>
                as_search_regulators:current_ids(as_search_regulators_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_terminals'])) { ?>
                as_search_terminals:current_ids(as_search_terminals_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_options_types'])) { ?>
                as_search_options_types:current_ids(as_search_options_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_action_types'])) { ?>
                as_search_action_types:current_ids(as_search_action_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_providers'])) { ?>
                as_search_providers:current_ids(as_search_providers_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_credit_shoulder'])) { ?>
                as_search_credit_shoulder:current_ids(as_search_credit_shoulder_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_dep'])) { ?>
                as_search_min_dep:current_ids(as_search_min_dep_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_lot'])) { ?>
                as_search_min_lot:current_ids(as_search_min_lot_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_deal'])) { ?>
                as_search_min_deal:current_ids(as_search_min_deal_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_bet'])) { ?>
                as_search_min_bet:current_ids(as_search_min_bet_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_payouts'])) { ?>
                as_search_payouts:current_ids(as_search_payouts_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_expiration'])) { ?>
                as_search_expiration:current_ids(as_search_expiration_ids),
            <?php }; ?>
            <?php /* if(isset($_REQUEST['as_search_order_types'])) { ?>
                as_search_order_types:'<?php echo $_REQUEST['as_search_order_types']; ?>',
            <?php }; */?>
            <?php if(isset($_REQUEST['as_search_spreds'])) { ?>
                as_search_spreds:'<?php echo $_REQUEST['as_search_spreds']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_bonus'])) { ?>
                as_search_exist_bonus:'<?php echo $_REQUEST['as_search_exist_bonus']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_mtraiding'])) { ?>
                as_search_exist_mtraiding:'<?php echo $_REQUEST['as_search_exist_mtraiding']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_analytics'])) { ?>
                as_search_exist_analytics:'<?php echo $_REQUEST['as_search_exist_analytics']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_learning'])) { ?>
                as_search_exist_learning:'<?php echo $_REQUEST['as_search_exist_learning']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_license'])) { ?>
                as_search_exist_license:'<?php echo $_REQUEST['as_search_exist_license']; ?>',
            <?php }; ?>
            };
            //alert(data_cities);
            $.ajax({
						type: 'get',
						url: 'https://eto-razvod.ru/engine/search_fields.php',
						datatype : "json",
						contentType: "application/json",
						data:  data_cities,
						success: function(data){
							//	alert(data);
								$("#as_search_company_fields").empty();
								$("#as_search_company_fields").append(data);
						}
				}); 
				
	$('.er_search_reset').click(function() { 
	    $("input:text").val("");
	    $("input:checkbox").prop( "checked", false );
	    $('.dropdown-multiple-label .dropdown-chose-list .dropdown-selected .del').each(function(index, option) {
            $(option).trigger('click')
        });
        $('#as_search_company_fields .dropdown-single .dropdown-main li[data-value=not_set]').each(function(index, option) {
            $(option).trigger('click')
        });
	}); 
    $('.as_search_company_type .dropdown-main ul li').click(function() { 
            
            var er_search_company_type = $(this).attr("data-value");
            //alert(er_search_company_type);
            //alert('<?php echo 'hello '.$_REQUEST['as_search_company_type'];?>');
            var fields = "<?php er_search_fields('"+er_search_company_type+"'); ?>";
            //alert(fields);
            var data_cities = {
                company_type:er_search_company_type,
            <?php if(isset($_REQUEST['s'])) { ?>
                s:'<?php echo $_REQUEST['s']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_company_language'])) { ?>
                as_search_company_language:'<?php echo $_REQUEST['as_search_company_language']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_company_currency'])) { ?>
                as_search_company_currency:'<?php echo $_REQUEST['as_search_company_currency']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_regulators'])) { ?>
                as_search_regulators:current_ids(as_search_regulators_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_terminals'])) { ?>
                as_search_terminals:current_ids(as_search_terminals_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_options_types'])) { ?>
                as_search_options_types:current_ids(as_search_options_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_action_types'])) { ?>
                as_search_action_types:current_ids(as_search_action_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_providers'])) { ?>
                as_search_providers:current_ids(as_search_providers_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_credit_shoulder'])) { ?>
                as_search_credit_shoulder:current_ids(as_search_credit_shoulder_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_dep'])) { ?>
                as_search_min_dep:current_ids(as_search_min_dep_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_lot'])) { ?>
                as_search_min_lot:current_ids(as_search_min_lot_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_deal'])) { ?>
                as_search_min_deal:current_ids(as_search_min_deal_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_min_bet'])) { ?>
                as_search_min_bet:current_ids(as_search_min_bet_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_payouts'])) { ?>
                as_search_payouts:current_ids(as_search_payouts_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_expiration'])) { ?>
                as_search_expiration:current_ids(as_search_expiration_ids),
            <?php }; ?>
            <?php /* if(isset($_REQUEST['as_search_order_types'])) { ?>
                as_search_order_types:'<?php echo $_REQUEST['as_search_order_types']; ?>',
            <?php }; */ ?>
			<?php if(isset($_REQUEST['as_search_order_types'])) { ?>
                as_search_order_types:current_ids(as_search_order_types_ids),
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_spreds'])) { ?>
                as_search_spreds:'<?php echo $_REQUEST['as_search_spreds']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_bonus'])) { ?>
                as_search_exist_bonus:'<?php echo $_REQUEST['as_search_exist_bonus']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_mtraiding'])) { ?>
                as_search_exist_mtraiding:'<?php echo $_REQUEST['as_search_exist_mtraiding']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_analytics'])) { ?>
                as_search_exist_analytics:'<?php echo $_REQUEST['as_search_exist_analytics']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_learning'])) { ?>
                as_search_exist_learning:'<?php echo $_REQUEST['as_search_exist_learning']; ?>',
            <?php }; ?>
            <?php if(isset($_REQUEST['as_search_exist_license'])) { ?>
                as_search_exist_license:'<?php echo $_REQUEST['as_search_exist_license']; ?>',
            <?php }; ?>
            };
            //alert(data_cities);
            $.ajax({
						type: 'get',
						url: 'https://eto-razvod.ru//engine/search_fields.php',
						datatype : "json",
						contentType: "application/json",
						data:  data_cities,
						success: function(data){
							//	alert(data);
								$("#as_search_company_fields").empty();
								$("#as_search_company_fields").append(data);
						}
				}); 
            /* $("#as_search_company_fields_bi").hide();
            $("#as_search_company_fields_fx").hide();
            $("#as_search_company_fields_crypto").hide();
            $("#as_search_company_fields").detach();
            $("#as_search_company_fields_"+er_search_company_type).appendTo("#as_search_company_fields");
            //$("#as_search_company_fields").append("<?php er_search_fields('"+er_search_company_type+"'); ?>");
            $("#as_search_company_fields_"+er_search_company_type).show() */
		});
        });
    
    
    jQuery(document).ready(function($){
        		    
    });
</script>
<?php };

function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }

function er_search_company( $atts ){
	loop_search_er($atts['company_type'],$atts['show_title'],$atts['title']);
	
}
add_shortcode('search_company', 'er_search_company');
function monoprog_get_menu_by_location($location) {
    if(empty($location)) return false;

    $locations = get_nav_menu_locations();
    if(!isset($locations[$location])) return false;

    return get_term( $locations[$location], 'nav_menu' );
}

function er_footer() {
    ?>
<div class="footer_top">
    <div class="footer_top_inside">
        <?php wp_nav_menu( array( 'theme_location' => 'topfooter', 'menu_id' => '', 'sort_column' => 'menu_order' ) ); ?>
        <div class="clear"></div>
    </div>
</div>
<div id="footerout">
    <div id="footer">
        <div class="footer_columns">
            <div class="footer_column footer_column_1">
                <div class="footer_logo"></div>
                <div class="footer_subscribe"></div>
            </div>
            <div class="footer_column footer_column_2">
                <?php $menu_obj_1 = monoprog_get_menu_by_location('footer_1'); ?>
                <div class="footer_nav_title"><?php echo esc_html($menu_obj_1->name); ?></div>
                <?php wp_nav_menu( array( 'theme_location' => 'footer_1', 'menu_id' => '', 'sort_column' => 'menu_order' ) ); ?>
            </div>
            <div class="footer_column footer_column_3">
                <?php $menu_obj_2 = monoprog_get_menu_by_location('footer_2'); ?>
                <div class="footer_nav_title"><?php echo esc_html($menu_obj_2->name); ?></div>
                <?php wp_nav_menu( array( 'theme_location' => 'footer_2', 'menu_id' => '', 'sort_column' => 'menu_order' ) ); ?>
            </div>
            <div class="footer_column footer_column_4">
                <div class="footer_nav_title">Контакты</div>
                <ul class="footer_contacts">
                    <li><i class="fas fa-phone"></i><span><a href="#callback" rel="nofollow">Запросить обратный звонок</a></span></li>
                    <li><i class="fas fa-envelope"></i><span><a href="mailto:info@eto-razvod.ru" rel="nofollow">info@eto-razvod.ru</a></span></li>
                    <li><i class="fas fa-edit"></i><span><a href="/feedback/" target="blank">Отправить нам сообщение</a></span></span></li>
                </ul>
                <!--noindex-->
                <div class="footer_social"></div>
                <script>
                    var mySecondDiv='<a href="https://twitter.com/etorazvodru" target="_blank" rel="nofollow" title="Twitter"><i class="fab fa-twitter"></i></a><a href="https://vk.com/etorazvod" target="_blank" rel="nofollow" title="Vkontakte"><i class="fab fa-vk"></i></a><a href="https://www.facebook.com/etorazvod/" target="_blank" rel="nofollow" title="Facebook"><i class="fab fa-facebook-f"></i></a><a href="https://ok.ru/etorazvod" target="_blank" rel="nofollow" title="Odnoklassniki"><i class="fab fa-odnoklassniki"></i></a><a href="http://zen.yandex.ru/id/5c066820817f780400714af2" target="_blank" rel="nofollow" title="Yandex"><i class="fab fa-yandex"></i></a><a href="https://www.pinterest.ru/etorazvod/" target="_blank" rel="nofollow" title="Pinterest"><i class="fab fa-pinterest"></i></a><a href="https://www.instagram.com/eto.razvod/" target="_blank" rel="nofollow" title="Instagram"><i class="fab fa-instagram"></i></a><a href="https://www.youtube.com/channel/UCibinJburN_Qe9w4r04SdeQ" target="_blank" rel="nofollow" title="Youtube"><i class="fab fa-youtube"></i></a><div class="clear"></div>';
                    $('.footer_social').append(mySecondDiv);
                </script>
                <!--/noindex-->
            </div>
            <div class="clear"></div>
        </div>
        <div class="footer_risks">
            <div class="footer_risks_copyrights">&copy; <?php _e('Copyright','er_theme'); ?> <?php _e('2015','er_theme'); ?>&mdash;<?php echo date('Y'); ?> &laquo;<?php bloginfo('name'); ?>&raquo; </div>
            <div class="clear"></div>
            <div class="footer_counters"><img width="1" height="1"  border="0" alt="Форекс каталог" src="https://www.fxmag.ru/cat/blank.php?cid=43730750186"/>
  	  <!--LiveInternet counter--><script type="text/javascript"><!--
	document.write("<a href='//www.liveinternet.ru/click' "+
	"target=_blank rel='nofollow'><img src='//counter.yadro.ru/hit?t39.11;r"+
	escape(document.referrer)+((typeof(screen)=="undefined")?"":
	";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
	screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
	";"+Math.random()+
	"' alt='' title='LiveInternet' "+
	"border='0' width='31' height='31'><\/a>")
	//--></script><!--/LiveInternet-->
	
		<!-- Rating@Mail.ru counter -->
	<script type="text/javascript">
	var _tmr = _tmr || [];
	_tmr.push({id: "2700476", type: "pageView", start: (new Date()).getTime()});
	(function (d, w, id) {
	  if (d.getElementById(id)) return;
	  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
	  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
	  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
	  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
	})(document, window, "topmailru-code");
	</script><noscript><div style="position:absolute;left:-10000px;">
	<img src="//top-fwz1.mail.ru/counter?id=2700476;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
	</div></noscript>
	<!-- //Rating@Mail.ru counter -->
	
		<!-- Rating@Mail.ru logo -->
	<a href="https://top.mail.ru/jump?from=2700476" rel="nofollow" target="_blank">
	<img src="https://top-fwz1.mail.ru/counter?id=2700476;t=295;l=1" 
	style="border:0;" height="31" width="38" alt="Рейтинг@Mail.ru" /></a>
	<!-- //Rating@Mail.ru logo -->
	
	
	<a title="Форекс рейтинг" target="_blank" href="https://www.fxmag.ru" rel="nofollow"><img border="0" alt="Форекс рейтинг" title="Форекс рейтинг" width="88" height="31" src="https://www.fxmag.ru/counter.php?id=2v91x30750Y7k61&t=1" /></a>
				
	<!-- begin of Top100 code -->

	<script id="top100Counter" type="text/javascript" src="https://counter.rambler.ru/top100.jcn?3138792"></script>
	<noscript>
	<a href="https://top100.rambler.ru/navi/3138792/" target="_blank">
	<img src="https://counter.rambler.ru/top100.cnt?3138792" alt="Rambler's Top100" border="0" />
	</a>

	</noscript>
	<!-- end of Top100 code --></div>
        </div>
    </div><!--End of Footer -->
</div><!--End of Footer Outer -->
   <!-- Begin LeadBack code {literal} -->
<script>
    var _emv = _emv || [];
    _emv['campaign'] = '4e2e81310c1a60a6104a16f4';
    
    (function() {
        var em = document.createElement('script'); em.type = 'text/javascript'; em.async = true;
        em.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'leadback.ru/js/leadback.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(em, s);
    })();
</script>
<!-- End LeadBack code {/literal} -->
    <?php
}
function list_menu($atts, $content = null) {
	extract(shortcode_atts(array(  
		'menu'            => '', 
		'container'       => 'div', 
		'container_class' => 'content_tree', 
		'container_id'    => '', 
		'menu_class'      => 'menu', 
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => '',
		'theme_location'  => ''), 
		$atts));
 
 
	return wp_nav_menu( array( 
		'menu'            => $menu, 
		'container'       => $container, 
		'container_class' => $container_class, 
		'container_id'    => $container_id, 
		'menu_class'      => $menu_class, 
		'menu_id'         => $menu_id,
		'echo'            => false,
		'fallback_cb'     => $fallback_cb,
		'before'          => $before,
		'after'           => $after,
		'link_before'     => $link_before,
		'link_after'      => $link_after,
		'depth'           => $depth,
		'walker'          => $walker,
		'theme_location'  => $theme_location));
}
//Create the shortcode
add_shortcode("listmenu", "list_menu");



function top_button() { ?>
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="far fa-arrow-alt-circle-up fa-4x"></i></button> 
<script type="text/javascript">
	mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 
	</script>
<?php }
?>
