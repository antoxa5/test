<?php wp_head();
$current = get_query_var('current');
$result .= '<div id="message" class="updated"><p><b>Подозрительная активность:</b> Пожалуйста, докажите, что вы не бот, нажав на кнопку ниже.</p></div>';
$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="check_cuez">';
$result .= '<input type="hidden" name="action" value="check_cuez" />';
$result .= '<input type="hidden" name="current" value="'.$current.'" />';
$result .= '<input class="button button_big button_green m_b_10 pointer" type="submit" value="'.__('Пройти проверку','er_theme').'" />';
$result .= '</form>';
echo $result;
echo get_the_permalink();
global $wp;

wp_footer(); ?>
