<?php


add_action( 'wp_ajax_show_popup_img', 'show_popup_img' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action( 'wp_ajax_nopriv_show_popup_img', 'show_popup_img' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей

function show_popup_img() {
    print_r($_POST);
    $result .= '<div class="popup_container" id="popup_img_1">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
    $result .= '<img src="'.$_POST['img_url'].'" />';
    $result .= '</div>';
    $result .= '</div>';
    echo $result;
    echo '
    <script type="text/javascript">
    jQuery(document).ready(function($){
      //  alert("go");
        $(\'#popup_img_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_img_modal").empty();
      });
    });
    
    </script>
    ';
    die;
}

?>