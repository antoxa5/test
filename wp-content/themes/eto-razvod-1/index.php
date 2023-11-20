<?php
if(is_date() ||
    /* false !== strpos($_SERVER['REQUEST_URI'], '?') || */
    is_tax()) {
    // force 404
    $wp_query->set_404();
    status_header( 404 );
    nocache_headers();
    include("404.php");
    die;
}
get_header();

get_footer();

?>