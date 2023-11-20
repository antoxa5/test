<?php
wp_enqueue_style('popup_forms', get_template_directory_uri() . '/css/popup_forms.css', [], filemtime(TEMPLATEPATH . '/css/popup_forms.css'));
get_header();

if (have_posts()) :
        while (have_posts()) : the_post();

the_content();

if($_GET['id'] != '') {
	$post = get_page_by_path( $_GET['id'], OBJECT, 'casino' );
	$id = $post->ID;
	if(!$id) {
		$id = 0;
	}
} else {
	$id = 0;
}
			/*if($_GET['new'] == 'new') {
				review_form_separate_new($id);
			} else {
				review_form_separate($id);
			}*/
			review_form_separate_new($id);

		?>
		
		
		
		
		
		<?php
		endwhile;
endif;


get_footer();

?>