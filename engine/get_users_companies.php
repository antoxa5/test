<?php
require('../wp-load.php');
// User Query arguments
$args = array(
    'meta_query' => array(
        array(
            'key'     => 'company_user',
            'compare' => 'EXISTS',
        ),
        array(
            'key'     => 'company_user',
            'value'   => '',
            'compare' => '!=',
        ),
        // array(
        //     'key'     => 'company_user',
        //     'value'   => 'Тетрика',
        //     'compare' => 'LIKE',
        // ),
    ),
);

// User Meta Query
$args['meta_query'][] = array(
    'key'     => 'company_user', // Ищем по полю "company_user"
    'value'   => '36488', // Ищем компанию с ID = 36488
    'compare' => 'LIKE',
);

// The User Query
$user_query = new WP_User_Query($args);

// Check if there are any users found
if (!empty($user_query->get_results())) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>#</th>';
    echo '<th>Email</th>';
    echo '<th>Компании</th>';
    echo '<th>Компании ID</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $x = 0;
    foreach ($user_query->get_results() as $user) {
        // Get the related companies
        $related_companies = get_field('company_user', 'user_' . $user->ID);
        $company_names = array();
        if ($related_companies) {
            foreach ($related_companies as $post_id) {
                $company_name = get_the_title($post_id);
                $company_name_get = get_field('company_name',$post_id);
                if($company_name_get && $company_name_get != '') {
                    $company_name = $company_name_get;
                }
                $company_names[] = $company_name;
                
                // Get the related companies' IDs
                $related_company_ids = array();
                if ($related_companies) {
                    foreach ($related_companies as $post_id) {
                        $related_company_ids[] = $post_id;
                    }
                }
            }
        }
        $x++;
        // Display user info in a table
        echo '<tr>';
        echo '<td>'.$x.'</td>';
        echo '<td>' . esc_html($user->user_email) . '</td>';
        echo '<td>' . esc_html(join(' / ', $company_names)) . '</td>';
        echo '<td>' . esc_html(join(' / ', $related_company_ids)) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No users found.';
}