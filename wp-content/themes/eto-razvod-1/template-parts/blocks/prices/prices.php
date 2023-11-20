<?php
/**
 * Prices Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_prices-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_prices';
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
$description = get_field('description');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
if($title) {
    $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
}
if($description) {
    $result .= '<'.$description_tag.' class="block_description">'.$description.'</'.$description_tag.'>';
}
$result .= '<ul class="price_slider">';
$result .= '<li id="price_1">';
$result .= '<div class="prices_title">Бесплатный</div>';
$result .= '<div class="prices_sum">0 руб.</div>';
$result .= '<div class="prices_period">в месяц</div>';
$result .= '<a class="prices_button" target="_blank" data-formid="74781">Регистрация</a>';
//$result .= '<a class="prices_sublink" href="#">Или напишите нам</a>';
$result .= '<div class="prices_description">Сотрудничайте с нами абсолютно бесплатно! Разместите обзор на сайте, реагируйте на жалобы, используйте инструменты для работы с клиентами и привлекайте новых. Выберите один из вариантов бесплатной публикации обзора прямо сейчас!</div>';
$result .= '</li>';
$result .= '<li id="price_2">';
$result .= '<div class="prices_title">Стандарт</div>';
$result .= '<div class="prices_sum">1 990 руб.</div>';
$result .= '<div class="prices_period">в месяц</div>';
$result .= '<a class="prices_button" target="_blank" data-formid="74783">Регистрация</a>';
//$result .= '<a class="prices_sublink" href="#">Или напишите нам</a>';
$result .= '<div class="prices_description">Еще больше возможностей для вас! Разместите подробный обзор о компании, добавьте промо-материалы к нему (баннеры, попапы) и дополнительные страницы (промокоды, акции). Оптимальный вариант заявить о себе ярко и без вопросов!</div>';
$result .= '</li>';
$result .= '<li id="price_3">';
$result .= '<div class="prices_title">Максимальный</div>';
$result .= '<div class="prices_sum">6 990 руб.</div>';
$result .= '<div class="prices_period">в месяц</div>';
$result .= '<a class="prices_button" target="_blank" data-formid="74784">Регистрация</a>';
//$result .= '<a class="prices_sublink" href="#">Или напишите нам</a>';
$result .= '<div class="prices_description">Максимально выгодное решение для вашего бизнеса! Опубликуйте подробный обзор с промо-материалами, работайте с аналитикой, рекомендациями по продажам, позициями рейтинга и отзывами клиентов, чтобы первыми реагировать на негатив.</div>';
$result .= '</li>';
$result .= '<li id="price_4">';
$result .= '<div class="prices_title">Персональный</div>';
//$result .= '<div class="prices_sum">цена</div>';
$result .= '<div class="prices_period">рассчитывается индивидуально</div>';
$result .= '<a class="prices_button" target="_blank" data-formid="74785">Связаться с нами</a>';
//$result .= '<a class="prices_sublink" href="#">Или напишите нам</a>';
$result .= '<div class="prices_description">Бизнесу нужны персональные условия? Цена по согласованию. Все, что включено в другие тарифы. Любые пожелания по согласованию (таргетинг рекламы для большего охвата и т.д.). Бизнес заслуживает лучшего? Самое время начать!</div>';
$result .= '</li>';
$result .= '</ul>';
$result .= '</div>';
$result .= '<div id="popup_price_modal"></div>';
echo $result;




?>
<?php $blockId = $block['id'] ?>
<div class="dots_wrapper_<?php echo $blockId; ?>"></div>

<style type="text/css">
@media screen and (max-width: 1200px) {
  .er_block_prices ul > li {
    max-width: calc( (100% / 4) - 30px);
    width: 100%;
}
}
.dots_wrapper_<?php echo $blockId ?> > ul {
    padding: 0;
    margin: 0;
    list-style: none;
}

.dots_wrapper_<?php echo $blockId ?> > ul > li > button {
    font-size: 0;
    border: 0;
    background: transparent;
}

.dots_wrapper_<?php echo $blockId ?> > ul {
    display: flex !important;
    justify-content: center;
}

.dots_wrapper_<?php echo $blockId ?> > ul > li > button {
    width: 16px;
    height: 16px;
    background: rgba(0, 0, 0, 0.3);
    padding: 0;
    margin: 0;
    display: block;
    border-radius: 50%;
    border: 4px solid #FFF;
}

.dots_wrapper_<?php echo $blockId ?> > ul > li {
    margin: 0 2px;
}

.dots_wrapper_<?php echo $blockId ?> > ul > li.slick-active > button {
    background: #0069FF;
    border-color: #0069FF;
}
@media screen and (max-width: 768px) {

.dots_wrapper_<?php echo $blockId ?> {
    margin-bottom: 30px;
}
.er_block_prices ul.price_slider.slick-slider li {
    margin: 0;
}

ul.price_slider.slick-slider .slick-slide > div {
    margin: 10px;
}
}
@media screen and (max-width: 575px) {
  .price_slider {
    padding: 0;
}

.er_block_prices {
    padding-bottom: 10px;
}
}
@media screen and (max-width: 375px) {
  .price_slider {
    margin-left: -35px;
}
}


</style>
<script type="text/javascript">
  jQuery(window).on('load resize orientationchange', function() {
        jQuery('.price_slider').each(function(){
            var $list_categories_slider = jQuery(this);
            if ( (jQuery(window).width() > 768) ) {
              if ($list_categories_slider.hasClass('slick-initialized')) {
                $list_categories_slider.slick('unslick');
              }
            } else{
                if ( (jQuery(window).width() > 575) ) {
                  if ($list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick('unslick');
                  }
                  if (!$list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick({
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        autoplay: false,
                        autoplaySpeed: 2000,
                        rows: 1,
                        infinite: true,
                        arrows: false,
                        dots: true,
                        accessibility: false,
                        appendDots: '.dots_wrapper_<?php echo $blockId ?>'
                    });
                  }
                } else {
                  $('.price_slider').on('click', 'a.prices_button', function() {

                    var id = $(this).attr("data-formid");
                    $.ajax({
                    url: "https://etorazvod.ru/wp-admin/admin-ajax.php",
                    type: "POST",
                    data: "action=show_popup_form&id="+id+"&action_page=https://etorazvod.ru/",
                    beforeSend: function(xhr) {
                    },
                    success: function( data ) {
                    var cookies_exist = data;
                    $("#popup_price_modal").html(data);
                    $(".popup_container").show();
                    }
                    });
                  });
                  if ($list_categories_slider.hasClass('slick-initialized')) {
                    $list_categories_slider.slick('unslick');
                  }
                  if (!$list_categories_slider.hasClass('slick-initialized')) {
                  $list_categories_slider.slick({
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  autoplay: false,
                  autoplaySpeed: 2000,
                  rows: 1,
                  infinite: true,
                  arrows: false,
                  dots: true,
                  accessibility: false,
                  appendDots: '.dots_wrapper_<?php echo $blockId ?>'
                  });
                  }
                }

            }
        });
    });
  jQuery(document).ready(function($){
      /*$('#'+form_id+' .required').each(function () {
          var cur = $(this);
          alert(cur);
      }); */
      $('.prices_button').click(function() {
          var id = $(this).attr("data-formid");
         // $( "#"+id ).toggleClass( 'visible' );
        //  alert(id);

          <?php
          $action_page = esc_url( 'https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
          echo '
          
          $.ajax({
              url: "'.admin_url("admin-ajax.php").'",
              type: "POST",
              data: "action=show_popup_form&id="+id+"&action_page='.$action_page.'",
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