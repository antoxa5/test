<?php
$user_login = get_query_var('user_login');
$userid = get_query_var('user_id');
if ($userid == 1) {
	header("Location: https://etorazvod.ru/user/admin/");
	die();
}
$counters = profile_stats_count( $userid );
get_header();
echo profile_top($userid,$counters);
?>

    <div class="page_content background_light visible profile_container">
        <div class="wrap">
            <div class="container_left page_container review_container_about visible">
				<?php
				echo profile_container_about( $userid, $counters );
				echo '<div class="feed-info"></div>';

				?>
            </div>
            <div class="container_left page_container review_container_comments_profile">
				<?php echo review_container_comments_profile(); ?>
            </div>
            <div class="container_left page_container review_container_reviews_profile">
				<?php
				echo review_container_reviews_profile($userid);
				//echo get_user_posts($userid);
				?>
            </div>
            <div class="container_left page_container review_container_abuses_profile">
				<?php echo review_container_abuses_profile(); ?>
            </div>
            <div class="container_side flex flex_column">
				<?php
				if(function_exists('user_contacts_sidebar')) {
					echo user_contacts_sidebar($userid);
				}
				?>
            </div>
        </div>
    </div>

<?php

get_footer();

?>