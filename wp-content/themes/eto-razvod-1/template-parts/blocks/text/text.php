<?php
/**
 * CTA Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_text-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_text';
if(get_field('title_tag')) {
    $title_tag = get_field('title_tag');
} else {
    $title_tag = 'div';
}
if(get_field('description_tag')) {
    $description_tag = get_field('description_tag');
} else {
    $description_tag = 'div';
}
$style = get_field('style');
$title = get_field('title');
$text = get_field('text');
$link = get_field('link');
$left = get_field('left');
$right = get_field('right');
$link_text = get_field('link_text');
$description = get_field('description');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
$result .= '<div class="block_content">';
if($title) {
    $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
}
if($description && $style == 'style2') {
    $result .= '<div class="block_description">'.$description.'</div>';
}
if($text && $style == 'style1') {
    $result .= '<'.$description_tag.' class="block_description">'.$text.'</'.$description_tag.'>';
}
if(!empty($left) && !empty($right)) {
    $result .= '<div class="er_block_text_columns">';
    $result .= '<div class="er_block_text_column_left" style="background-image: url('.$left[0]['image'].')">';
    if($left[0]['title']) {
        $result .= '<div class="er_block_text_columns_title">'.$left[0]['title'].'</div>';
    }
    if(!empty($left[0]['list'])) {
        $result .= '<ul>';
        foreach ($left[0]['list'] as $item) {
            $result .= '<li>'.$item['item'].'</li>';
        }
        $result .= '</ul>';
    }
    if($left[0]['end_text']) {
        $result .= '<div class="er_block_text_columns_comment">'.$left[0]['end_text'].'</div>';
    }
    $result .= '</div>';
    $result .= '<div class="er_block_text_column_right" style="background-image: url('.$right[0]['image'].')">';
    if($right[0]['title']) {
        $result .= '<div class="er_block_text_columns_title">'.$right[0]['title'].'</div>';
    }
    if(!empty($right[0]['list'])) {
        $result .= '<ul>';
        foreach ($right[0]['list'] as $item) {
            $result .= '<li>'.$item['item'].'</li>';
        }
        $result .= '</ul>';
    }
    if($right[0]['end_text']) {
        $result .= '<div class="er_block_text_columns_comment">'.$right[0]['end_text'].'</div>';
    }
    $result .= '</div>';
    $result .= '</div>';
}
if ($link && $link_text) {
    if($style == 'style1') {
        $result .= '<a class="block_button_link" target="_blank" data-formid="74781">' . $link_text . '</a>';
    } else {
        $result .= '<a class="block_button_link" target="_blank" href="' . $link . '">' . $link_text . '</a>';
    }
}
$result .= '</div>';
$result .= '</div>';
echo $result;
if($style == 'style1') { ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#<?php echo esc_attr($id);?> .block_button_link').click(function () {
            var id = $(this).attr("data-formid");
            // $( "#"+id ).toggleClass( 'visible' );
            //  alert(id);

            <?php
            $action_page = esc_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            echo '
          
          $.ajax({
              url: "' . admin_url("admin-ajax.php") . '",
              type: "POST",
              data: "action=show_popup_form&id="+id+"&action_page=' . $action_page . '",
              beforeSend: function(xhr) {

                            },
              success: function( data ) {
                  var cookies_exist = data;
                 // alert( cookies_exist );
                  $("#popup_price_modal").html(data);
                  $(".popup_container").show();
              }
          }); ';
            ?>
        });
    });
      </script>
<?php }



?>