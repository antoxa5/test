<?php

if (!function_exists('check_cuez')) {
    add_action('wp_ajax_check_cuez', 'check_cuez');
    add_action('wp_ajax_nopriv_check_cuez', 'check_cuez');
    function check_cuez() {
        $result = array();
      //  print_r($_POST);
        $link = get_bloginfo('url').$_POST['current'];
        //echo $link;
        //print_r($_COOKIE);
        setcookie("cuez_white",'1',time()+31556926 ,'/');
        $result = array(
            'status' => 'ok',
            'redirect' => $link
        );
        echo json_encode($result);
        die;
    }
}