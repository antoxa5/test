<?php
/**
 * List Categories Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_list_categories-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_list_categories';
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
$nav_id = get_field('nav_id');
$description = get_field('description');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
if($title) {
    $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
}
if($description) {
    $result .= '<'.$description_tag.' class="block_description">'.$description.'</'.$description_tag.'>';
}
if($nav_id && $nav_id != '') {
    $nav = wp_get_menu_array($nav_id);
    //echo '<pre>';
    //print_r($nav);
    //echo '</pre>';
    $result .= '<div class="list_categories_wrapper">';
    if($nav && !empty($nav)) {
        $result .= '<ul class="list_categories_slider">';
        foreach ($nav as $item) {
            if($item['icon'] && $item['icon'] != '') {
                $icon = $item['icon'];
            } else {
                $icon = 'fas fa-hashtag';
            }
            $result .= '<li data-id="' . $item['ID'] . '" onclick=\'showbar(jQuery(this).attr("data-id"))\'>';
            $result .= '<div class="list_categories_image '.$icon.'"></div>';
            $result .= '<div class="list_categories_title">' . $item['title'] . '</div>';

            // if ($item['children'] && !empty($item['children'])) {
            //     $result .= '<div class="nav_children">';
            //     foreach ($item['children'] as $child) {
            //         $result .= '<a href="' . $child['url'] . '" target="_blank" id="' . $child['ID'] . '">' . $child['title'] . '</a>';
            //     }
            //     $result .= '</div>';
            // }

            $result .= '</li>';
        }
    }
    $result .= '</ul>';


    if($nav && !empty($nav)) {
       $result .= '<ul class="list_categories_slider2">';
        foreach ($nav as $item) {
            //$result .= '<li id="' . $item['ID'] . '">';
            //$result .= '<div class="list_categories_image"></div>';
            //$result .= '<div class="list_categories_title">' . $item['title'] . '</div>';
            $result .= '<div class="nav_children" data-id="' . $item['ID'] . '">';
            if ($item['children'] && !empty($item['children'])) {
                
                foreach ($item['children'] as $child) {
                    //print_r($child);
                    if($child['icon'] && $child['icon'] != '') {
                        $icon = $child['icon'];
                    } else {
                        $icon = 'fas fa-hashtag';
                    }
                    $result .= '<a href="' . $child['url'] . '" target="_blank" id="' . $child['ID'] . '"><i class="'.$icon.'"></i><span>' . $child['title'] . '</span></a>';
                }               
            }
            $result .= '</div>';

            //$result .= '</li>';
        }
        $result .= '</ul>';
    }
    $result .= '</div>';

}

$result .= '</div>';
echo $result;




?>
<script type="text/javascript">
  
  jQuery(window).on('load resize orientationchange', function() {
        jQuery('.list_categories_slider').each(function(){
            var $list_categories_slider = jQuery(this);
            //var $list_categories_slider2 = jQuery('.list_categories_slider2');
            jQuery('.list_categories_slider')
            if ( (jQuery(window).width() > 1150) ) {
                    jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider li').parent().removeAttr('act-item','act-item');
              if ($list_categories_slider.hasClass('slick-initialized')) {
                $list_categories_slider.slick('unslick');
              }
              // if ($list_categories_slider2.hasClass('slick-initialized')) {
              //   $list_categories_slider2.slick('unslick');
              // }
              if (!$list_categories_slider.hasClass('slick-initialized')) {
                $list_categories_slider.slick({
                  slidesToShow: 8,
                  slidesToScroll: 1,
                  autoplay: false,
                  autoplaySpeed: 2000,
                  infinite: true,
                  mobileFirst: true,
                  //asNavFor: $list_categories_slider2
                });
                // $('.list_categories_slider2').slick({
                //     slidesToShow: 8,
                //     slidesToScroll: 1,
                //     autoplay: false,
                //     autoplaySpeed: 2000,
                //     infinite: true,
                //     mobileFirst: true,
                //     asNavFor: $list_categories_slider
                // });
              }



            }
            else{
                if ( (jQuery(window).width() > 575) ) {
                                        jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider li').parent().removeAttr('act-item','act-item');
                  if ($list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick('unslick');
                  }
                  if (!$list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 2000,
                    infinite: true,
                    mobileFirst: true,
                    });
                  }
                  
                } else {
                                        jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider li').parent().removeAttr('act-item','act-item');
                  if ($list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick('unslick');
                  }
                }

            }
        });
    });
</script>
<style type="text/css">
    .er_block_list_categories .slick-list {
    width: calc(100% - 100px);
    margin: 0 auto;
}

.er_block_list_categories .slick-prev.slick-arrow {
    position: absolute;
    background: transparent;
    border: 0;
    font-size: 0;
    background: url(/wp-content/themes/eto-razvod-1/img/arrow_button.svg);
    width: 40px;
    height: 40px;
    transform: rotate(90deg);
    /* top: 0; */
    /* bottom: 0; */
    margin: auto;
    left: 15px;
}

.er_block_list_categories .slick-next.slick-arrow {
    position: absolute;
    background: transparent;
    border: 0;
    font-size: 0;
    background: url(/wp-content/themes/eto-razvod-1/img/arrow_button.svg);
    width: 40px;
    height: 40px;
    transform: rotate(-90deg);
    /* top: 0; */
    /* bottom: 0; */
    margin: auto;
    right: 15px;
}

.er_block_list_categories .slick-arrow {
    top: 33px;
    bottom: unset;
}

.er_block_list_categories ul {
    background: #F2F5F9;
    box-shadow: none !important;
    border-radius: 0 !important;
}
.list_categories_wrapper {
    background: #F2F5F9;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.25);
    border-radius: 20px;
    overflow: hidden;
}
.nav_children {
    display: none;
}
.nav_children {
    width: 100%;
}

ul.list_categories_slider2 {
    /* padding: 0; */
    background: #FFF !important
}
.er_block_list_categories ul.list_categories_slider2 {
    display: none;
}


.nav_children > a {
    background: #f2f5f9;
    padding-right:12px;
    border-radius: 50px;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    font-family: 'Roboto', sans-serif;
    font-style: normal;
    font-weight: normal;
    font-size: 17px !important;
    line-height: 28px;
    align-items: center;
    text-decoration: none !important;

/* Темно-серый */
    color: #444444 !important;
    margin-right: 16px;
}
.nav_children > a i {
    background-color: #444;
    color:#FFF;
    width: 26px;
    height: 26px;
    margin-left: 1px;
    margin-top: 1px;
    border-radius: 50px;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    float: left;
    text-align: center;
    line-height: 26px;
    margin-right: 8px;
    font-size: 0.8em;
}
.nav_children > a {
    cursor: pointer;
}

.nav_children > a:hover {
    background: #444444 !important;
    color: #FFF !important;
}

.list_categories_slider2 {
    padding: 0 !important;
    background: #f2f5f9 !important;
}
.er_block_list_categories ul.list_categories_slider2 {
    display: block;
}
.nav_children {
    width: 100%;
    padding: 15px;
}
.er_block_list_categories ul {
    padding-bottom: 0 !important;
}

ul.list_categories_slider .slick-slide > div {
    padding-bottom: 16px;
}
ul.list_categories_slider .slick-slide > div {
    /* background: #FFF; */
    padding-top: 16px;
}

.er_block_list_categories ul {
    padding-top: 0;
}

ul.list_categories_slider .slick-slide > div {
    position: relative;
}

ul.list_categories_slider .slick-slide > div[act-item] {
    background: #FFF;
}

ul.list_categories_slider .slick-slide > div {
    padding-left: 20px;
    padding-right: 20px;
}

/*ul.list_categories_slider .slick-slide.slick-current.slick-active > div:before {content: " ";width: 20px;height: 100%;background: red;position: absolute;top: 0;left: 0;}*/

.er_block_list_categories .slick-list {
    width: 100%;
}
.er_block_list_categories ul {
    padding-top: 0 !important;
}

ul.list_categories_slider .slick-slide > div:before {
    content: " ";
    width: 5px;
    height: 100%;
    background: #f2f5f9;
    position: absolute;
    top: 0;
    left: 0;
    border-bottom-right-radius: 50px;
}

ul.list_categories_slider .slick-slide > div:after {
    content: " ";
    width: 5px;
    height: 100%;
    background: #f2f5f9;
    position: absolute;
    top: 0;
    right: 0;
    border-bottom-left-radius: 50px;
}

ul.list_categories_slider .slick-slide > div:before {
    content: " ";
    width: 5px;
    height: 100%;
    background: #f2f5f9;
    position: absolute;
    top: 0;
    left: 0;
    border-bottom-right-radius: 50px;
}

ul.list_categories_slider .slick-slide > div:after {
    content: " ";
    width: 5px;
    height: 100%;
    background: #f2f5f9;
    position: absolute;
    top: 0;
    right: 0;
    border-bottom-left-radius: 50px;
}

ul.list_categories_slider .slick-slide > div {
    padding-left: 15px;
    padding-right: 15px;
}
.er_block_list_categories ul li .list_categories_title {
    font-size: 16px;
}
.er_block_list_categories ul li .list_categories_title {
    font-size: 16px !important;
}

.er_block_list_categories ul li .list_categories_title {
    height: 80px;
}
ul.list_categories_slider .slick-slide > div {
    padding-bottom: 0;
}
.nav_children {
    width: calc(100% - 30px) !important;
    padding: 15px;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    flex-wrap: wrap;
}
.nav_children {
    display: none;
}
.nav_children {
    padding-bottom: 5px;
}

.nav_children > a {
    margin-bottom: 6px;
}
@media screen and (max-width: 1150px) {
    .er_block_list_categories ul.list_categories_slider2 {
    width: 100% !important;
    margin: 0 !important;
}
.er_block_list_categories ul li .list_categories_title {
    height: 49px;
}
.er_block_list_categories .slick-list {
    width: calc(100% - 100px);
    margin: 0 auto;
}
}
    @media screen and (max-width: 768px) {
        .er_block_list_categories ul.list_categories_slider2 {
            width: auto !important;
            margin: 0 -20px !important;
    }
@media screen and (max-width: 767px) {
    .er_block_list_categories .slick-prev.slick-arrow {
        left: 24px;
    }

        .er_block_list_categories .slick-next.slick-arrow {
        right: 24px;
    }
}

@media screen and (max-width: 576px) {
    ul.list_categories_slider {
    padding-top: 20px !important;
}


}

.er_block_list_categories ul li {
    cursor: pointer;
}


ul.list_categories_slider > li {
    padding-top: 16px;
}
</style>


<script type="text/javascript">
// jQuery(document).ready(function(){
// jQuery( 'ul.list_categories_slider > li' ).toggle(function() {
//     thisID = jQuery(this).attr('id');
//     jQuery('.list_categories_slider2 .nav_children').slideUp();
//     if ( (jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').text()) != '') {
//         jQuery('.list_categories_slider2').slideDown();
//         jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideDown();
//     }

// }, function() {
//     thisID = jQuery(this).attr('id');
//     jQuery('.list_categories_slider2 .nav_children').slideUp();
//     if ( (jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').text()) != '') {
//         jQuery('.list_categories_slider2').slideUp();
//         jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideUp();
//     }
// });
// });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.list_categories_slider > dfgdgdgli').click(function() {
            thisID = jQuery(this).attr('data-id');
            
            if (    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').hasClass('act')    ) {
                jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').removeClass('act');
                jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideUp();
            } else {
                if ( (jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').text()) != '') {
                    jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').addClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideDown();
                } else {
                    jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                }
            }

// if ( (jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').text()) != '') {

//     jQuery('.list_categories_slider2').slideToggle();

//     jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideToggle();
// }

        })
    })

function showbar(id) {
                thisID = id;
            
            if (    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').hasClass('act')    ) {
                jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').removeClass('act');
                jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideUp();
                jQuery('li[data-id="'+thisID+'"]').parent().removeAttr('act-item');
            } else {
                if ( (jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').text()) != '') {
                    jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').addClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider2 .nav_children[data-id="'+thisID+'"]').slideDown({
  start: function () {
    jQuery(this).css({
      display: "flex"
    })
  }
});

                    jQuery('.list_categories_slider li').parent().removeAttr('act-item','act-item');
                    jQuery('li[data-id="'+thisID+'"]').parent().attr('act-item','act-item');
                    if ( (jQuery(window).width() < 576) ) {
                        jQuery([document.documentElement, document.body]).animate({
        scrollTop: jQuery('li[data-id="'+thisID+'"]').offset().top
    }, 200);
                    }
                } else {
                    jQuery('.list_categories_slider2 .nav_children').removeClass('act');
                    jQuery('.list_categories_slider2 .nav_children').slideUp();
                    jQuery('.list_categories_slider li').parent().removeAttr('act-item','act-item');
                    jQuery('li[data-id="'+thisID+'"]').parent().removeAttr('act-item');
                }
            }
};
</script>