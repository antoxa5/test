<?php
date_default_timezone_set( 'Europe/Moscow' );
/**
 * Prices Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_list_services-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_list_services';
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
$array_ids = get_field('get_services');
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

global $post; 
$myposts = get_posts( array(
    'posts_per_page' => -1,
    'post_type'      => 'services',
    'post_status' => 'publish',
    'orderby' => 'post__in', 
    'post__in' =>  $array_ids
) );
$array_of_user = [];
$keydump = 0;
foreach( $myposts as $post ){
    setup_postdata( $post );    
    array_push($array_of_user, get_field('capabilities',$array_ids[$keydump]));
    $keydump = ++$keydump;
}

wp_reset_postdata();


$newarr = [];
foreach ($array_of_user as $arrkey => $arr) {
    foreach ($arr as $key => $val) {
        $newarr[$key][$arrkey] = $val;
    }
}

$array_unique_var = [];
foreach ($newarr as $key => $value) {
    array_push($array_unique_var, array_unique($value, SORT_REGULAR));
}
//левая колонка, меняем индексы
$array_unique_var_temp_left_side = [];
foreach ($array_unique_var as $key => $value) {
    $array_unique_var_temp_left_side[$key] = array_values($value);
}
$varofid = 0;
$tder = '';
$tder2 = '';
$numtdMainer = 0;
// if (is_user_logged_in()) {
//     $numtdMainer = 2;
// }
foreach ($myposts as $post) {
  $numtd = $varofid+2;
  if (get_field('price',get_the_ID())) {
      $priced = ' ('.get_field('price',get_the_ID()).' руб/мес.)';
  } else {
      $priced = '';
  }

  if (is_user_logged_in()) {
        if ((get_field('services_user_services','user_'.get_current_user_id())[0] == get_the_ID()) || (get_field('services_user_services','user_'.get_current_user_id()) == get_the_ID())) {
           //$button_table = '<span class="buy-btn-from-tariff dis-buy-btn-from-tariff">Выбран</span>';
            $button_table = '<span class="buy-btn-from-tariff" data-service="'.get_the_ID().'">Продлить</span>';    
            if (get_the_ID() == 84178) {
                echo '<style>span.buy-btn-from-tariff[data-service="84175"]{display:none;}</style>';
            }
        } else {
            if (get_field('services_user_services','user_'.get_current_user_id()) == '') {
                if ((get_field('price',get_the_ID()) == '') || (get_field('price',get_the_ID()) == 0) || (get_field('price',get_the_ID()) == '0')) {
                    $button_table = '<span class="buy-btn-from-tariff dis-buy-btn-from-tariff">Выбран</span>';
                } else {
                    $button_table = '<span class="buy-btn-from-tariff" data-service="'.get_the_ID().'">Подключить</span>';
                }
                
            } else {
                if ((get_field('price',get_the_ID()) == '') || (get_field('price',get_the_ID()) == 0) || (get_field('price',get_the_ID()) == '0')) {
                    $button_table = '';    
                } else {
                    $button_table = '<span class="buy-btn-from-tariff" data-service="'.get_the_ID().'">Подключить</span>';    
                }
                
            }            
        }
  } else {
      $button_table = '<span class="buy-btn-from-tariff" data-service="'.get_the_ID().'">Подключить</span>';
  }

  
  if (is_user_logged_in()) {
    if (get_field('services_user_services','user_'.get_current_user_id()) == '') {
        if ((get_field('price',get_the_ID()) == '') || (get_field('price',get_the_ID()) == 0) || (get_field('price',get_the_ID()) == '0')) {
            $tder .= '<th class="item_'.$numtd.'_s active_item_t">'.get_the_title(get_the_ID()).$priced.'</th>';
            $numtdMainer = $numtd;
        } else {
            $tder .= '<th class="item_'.$numtd.'_s">'.get_the_title(get_the_ID()).$priced.'</th>';
        }
    } else {
        if ((get_field('services_user_services','user_'.get_current_user_id())[0] == get_the_ID()) || (get_field('services_user_services','user_'.get_current_user_id()) == get_the_ID())) {
            $tder .= '<th class="item_'.$numtd.'_s active_item_t">'.get_the_title(get_the_ID()).$priced.'</th>';
            $numtdMainer = $numtd;
        } else {
            $tder .= '<th class="item_'.$numtd.'_s">'.get_the_title(get_the_ID()).$priced.'</th>';
        }
    }

  } else {
      $tder .= '<th class="item_'.$numtd.'_s">'.get_the_title(get_the_ID()).$priced.'</th>';
  }
  $tder2 .= '<td class="circle_set ctr-btn item2_'.$numtd.'_s">'.$button_table.'</td>';
  $varofid = ++$varofid;
}
$result .= '<link rel="stylesheet" type="text/css" href="/wp-content/themes/eto-razvod-1/template-parts/blocks/list_services/list-services-popup.css">';
//$result .= '<script src="/wp-content/themes/eto-razvod-1/template-parts/blocks/list_services/table-tariff.js"></script>';
if (    (    (    get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) || (get_field('services_user_services','user_'.get_current_user_id()) == 84175) || (    get_field('services_user_services','user_'.get_current_user_id())[0] == 84178) || (get_field('services_user_services','user_'.get_current_user_id()) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.get_current_user_id())[0];
    if (get_field('services_user_services','user_'.get_current_user_id())[0] == '') {
        $result .= '<div class="activated">Ваш тариф на сайте:  <span class="activated-name">'.get_the_title($namep).'</span> до <span class="activated-date">'. str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></div>';
    } else {
        $result .= '<div class="activated">Ваш тариф на сайте:  <span class="activated-name">'.get_the_title($namep).'</span> до <span class="activated-date">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></div>';
    }
    
}

$result .= '<table cellpadding="3" cellspacing="0" class="comptable er_newtable renewed sortable_table full_table table_tariff_main" align="center" id="table_fx"><thead class="tarif_thead"><tr><th class="item_first"></th>'.$tder.'</thead><tbody>';
foreach ($newarr as $key => $value) {
        if(($key % 2) == 0){
            $result .=  '<tr id="row_'.$key.'" class="odd td_tariff">';
        } else {
            $result .=  '<tr id="row_'.$key.'" class="even td_tariff">';
        }
        if ((get_term($array_unique_var_temp_left_side[$key][0],'capabilities')->name) == 'Публикация статей в Блог') {
            $question = '<span class="f-question-tariff"><i class="fas fa-question"> <span class="showadvice"><span>1 статья в месяц. Обязательная модерация со стороны редактора проекта при публикации статьи на сайт. Статья должна быть уникальной и соответвовать правилам сайта.</span></span></i></span>';
        } elseif ((get_term($array_unique_var_temp_left_side[$key][0],'capabilities')->name) == 'Возможность оставлять ссылки в комментариях') {
            $question = '<span class="f-question-tariff"><i class="fas fa-question"> <span class="showadvice"><span>Только со страниц блога. Предварительная модерация.</span></span></i></span>';
        } else {
            $question = '';
        }
        $result .=  '<td class="item_first name"><span class="title_lefter">'.get_term($array_unique_var_temp_left_side[$key][0],'capabilities')->name.' '.$question.'</span></td>';
        if (get_term($value[0],'capabilities')->name != '') {
            $result .=  '<td class="circle_set"><span class="circle"></span></td>';
        } else {
            $result .=  '<td class="circle_set"> </td>';
        }
        if (get_term($value[1],'capabilities')->name != '') {
            $result .=  '<td class="circle_set"><span class="circle"></span></td>';
        } else {
            $result .=  '<td class="circle_set"> </td>';
        }
        if (get_term($value[2],'capabilities')->name != '') {
            $result .=  '<td class="circle_set"><span class="circle"></span></td>';
        } else {
            $result .=  '<td class="circle_set"> </td>';
        }
        $result .=  "</tr>";
    }
    //if (is_user_logged_in()) {
        //if (( is_user_role( 'registereduser' ) )) {
            
        //} else {
        //if ($block['id'] == 'block_5fc1057fc0df1') {
            if(($key+1 % 2) == 0){
            $result .= '<tr id="row_'.$key.'" class="odd td_tariff"><td class="item_first name"><span class="title_lefter"> </span></td>'.$tder2.'</tr>';
            } else {
            $result .= '<tr id="row_'.$key.'" class="even td_tariff"><td class="item_first name"><span class="title_lefter"> </span></td>'.$tder2.'</tr>';
            }
        //}
        //}
    //}

    
$result .= '</tbody>';
$result .= '</table>';
$result .= '</div>';
echo $result;
?>
<style type="text/css">
.activated {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 20px;
    background: #0069ff;
    color: #FFF;
}

.activated-name {
    background: #FFF;
    color: #0069ff;
    padding: 5px 10px;
    border-radius: 20px;
}

.activated-date {
    background: #FFF;
    color: #0069ff;
    padding: 5px 10px;
    border-radius: 20px;
}
.circle {
    width: 10px;
    height: 10px;
    background: #2079fc;
    display: block;
    border-radius: 50%;
    margin: 0 auto;
}
.td_tariff > td {
    padding-top: 10px;
    padding-bottom: 10px;
}

.tarif_thead > tr > th.item_first {
    padding: 0;
    text-align: center;

}
.tarif_thead tr > th {
    width: calc((100% / 4)) !important;text-align: center;
}
.td_tariff > td {
    width: calc((100% / 4)) !important;text-align: center;
}
table.table_tariff_main .tarif_thead > tr > th.item_first {
    width: 400px !important;
}

table.table_tariff_main td.item_first.name {
    min-width: 250px;
    width: 400px !important;
    min-width: unset !important;
    padding-left: 0;
    padding-right: 0;
    max-width: 400px !important;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((1080px - 400px) / 3) !important;
    padding-left: 0;
    padding-right: 0;
}

table.table_tariff_main td.circle_set {
    width: calc((1080px - 400px) / 3) !important;
    max-width: unset;
    min-width: unset;
    padding: 0 !important;
    display: flex;
    align-items: center;
}


table.table_tariff_main .td_tariff {
    display: flex;
}

table.table_tariff_main tbody {
    display: flex;
    flex-direction: column;
}

table.table_tariff_main thead.tarif_thead {
    display: flex;
}

table.table_tariff_main {
    display: flex;
    flex-direction: column;
}
td.circle_set {
    position: relative;
}

td.circle_set:before {content: " ";width: 1px;height: 100%;background: rgb(0 0 0 / 10%);display: block;position: absolute;left: 0;}

th.item_2_s:before, th.item_3_s:before, th.item_4_s:before {
    content: " ";
    width: 1px;
    height: 100%;
    background: rgb(0 0 0 / 10%);
    display: block;
    position: absolute;
    top: 0;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    position: relative;
}

table.table_tariff_main tr {
    display: flex;
}
table.table_tariff_main tr th {
    display: flex;
    align-items: center;
    justify-content: center;
}
table.table_tariff_main tr th:before {
    left: 0;
}
div#middlecontent {
    margin-right: 0;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 400px) / 3) !important;
}

table.table_tariff_main td.circle_set {
    width: calc((100% - 400px) / 3) !important;
}
table.table_tariff_main tr {
    display: flex;
    width: 100%;
}

.circle_set.ctr-btn {
    text-align: center;
    justify-content: center;
}

.buy-btn-from-tariff {
    display: block;
    max-width: 200px;
    text-align: center;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 5px;
    background: #0069ff;
    color: #FFF;
    border-radius: 20px;
    cursor: pointer;
    width: 100%;
}

.circle_set.ctr-btn {
    justify-content: center;
}

.buy-btn-from-tariff:hover {
    background: #0059d9;
}

@media screen and (max-width: 930px) {
    table.table_tariff_main td.item_first.name,table.table_tariff_main .tarif_thead > tr > th.item_first {
    width: 280px !important;
    padding-left: 10px;
    padding-right: 10px;
}

table.table_tariff_main td.circle_set, table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 300px) / 3) !important;
}
}

@media screen and (max-width: 815px) {
    table.table_tariff_main td.item_first.name, table.table_tariff_main .tarif_thead > tr > th.item_first {
    width: 220px !important;
    padding-left: 10px;
    padding-right: 10px;
}

table.table_tariff_main td.circle_set, table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 240px) / 3) !important;
}
}

@media screen and (max-width: 730px) {
table.table_tariff_main td.circle_set, table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    white-space: unset;
}

table.table_tariff_main td.item_first.name, table.table_tariff_main .tarif_thead > tr > th.item_first {
    width: 150px !important;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 170px) / 3) !important;
}
table.table_tariff_main td.circle_set {
    width: calc((100% - 200px) / 3) !important
}
table.table_tariff_main td.circle_set {
    padding-left: 5px !important;
    padding-right: 5px !important;
}
}
@media screen and (max-width: 480px) {
    table.table_tariff_main td.item_first.name, table.table_tariff_main .tarif_thead > tr > th.item_first {
    padding-left: 5px !important;
    padding-right: 5px !important;
}

table.table_tariff_main td.circle_set {
    width: calc((100% - 190px) / 3) !important;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 160px) / 3) !important;
}
}

@media screen and (max-width: 470px) {
table.table_tariff_main td.item_first.name, table.table_tariff_main .tarif_thead > tr > th.item_first {
    width: 120px !important;
}

table.table_tariff_main td.circle_set {
    width: calc((100% - 160px) / 3) !important;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc((100% - 130px) / 3) !important;
}
}

@media screen and (max-width: 682px) {
    table.table_tariff_main .td_tariff {
    display: flex;
    flex-wrap: wrap;
    width: 100% !important;
}

table.table_tariff_main .td_tariff td.item_first.name {
    width: 100% !important;
    display: flex;
    padding-left: 0 !important;
    padding-right: 0 !important;
    max-width: unset !important;
    align-items: center;
    justify-content: center;
    border-top: 1px solid rgb(0 0 0 / 10%) !important;
    border-bottom: 1px solid rgb(0 0 0 / 10%) !important;
}

table.table_tariff_main td.circle_set {
    width: calc((100% / 3) - 10px) !important;
    padding-top: 20px !important;
    padding-bottom: 20px !important;
}

.table_tariff_main th.item_first {
    display: none !important;
}

thead.tarif_thead {}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    width: calc(100% / 3) !important;
}

td.item_first.name {
    height: unset;
}

table.table_tariff_main .td_tariff td.item_first.name {
    background: #F2F5F9;
}

table.table_tariff_main .td_tariff td.item_first.name {}

table.table_tariff_main .td_tariff 
 td.circle_set {
    background: #FFF;
}

table.table_tariff_main th.item_2_s, table.table_tariff_main th.item_3_s, table.table_tariff_main th.item_4_s {
    padding-left: 5px !important;
    padding-right: 5px !important;
    width: calc((100% / 3) - 10px) !important;
}

.tableset thead.tarif_thead {
    position: fixed;
    top: 56px;
    left: 0;
    margin: 0 auto;
    right: 0;
    height: 30px;
    width: 300px;
    z-index: 1;
        background: #0069ff;
    width: calc(100% - 40px);
    height: unset;
    border-radius: 50px;
}

.tableset  .td_tariff > td.item_first + td.circle_set:before {
    opacity: 0;
}

.tableset th.item_2_s:before {
    opacity: 0;
}

.tableset  thead.tarif_thead th {
    color: #FFF !important;
}

.tableset thead.tarif_thead {
    padding-left: 10px !important;
    padding-right: 10px !important;
}

.tableset th.item_3_s:before, .tableset th.item_4_s:before {
    content: " ";
    width: 1px;
    height: 100%;
    background: rgb(255 255 255 / 10%);
    display: block;
    position: absolute;
    top: 0;
}

.tableset tbody > .td_tariff:first-child {
    padding-top: 66px;
}
.tableset thead.tarif_thead {
    z-index: 1;
    box-shadow: 0px 13px 20px 1px rgb(0 105 255 / 0.30);
}
.tableset thead.tarif_thead {
    display: flex;
    padding: 0 !important;
    padding-right: 0 !important;
    border-radius: 0;
}
}
.buy-btn-from-tariff.dis-buy-btn-from-tariff {
    background: #0059d9;
    cursor: auto;
}
</style>
<script type="text/javascript">
jQuery(window).bind('load', function() {
    if ((jQuery(window).scrollTop() > jQuery('.table_tariff_main').offset().top) && (    jQuery(window).scrollTop() < (    jQuery('.table_tariff_main').offset().top + jQuery('.table_tariff_main').outerHeight()  - 66  ) ) ){
        jQuery('.table_tariff_main').addClass('tableset');
    } else {
        jQuery('.table_tariff_main').removeClass('tableset');
    }
jQuery(window).on('scroll', function() {
    if ((jQuery(window).scrollTop() > jQuery('.table_tariff_main').offset().top) && (    jQuery(window).scrollTop() < (    jQuery('.table_tariff_main').offset().top + jQuery('.table_tariff_main').outerHeight()  - 66  ) ) ){
        jQuery('.table_tariff_main').addClass('tableset');
    } else {
        jQuery('.table_tariff_main').removeClass('tableset');
    }
})
})
</script>
<?php if ($block['id'] == 'block_5fc1057fc0df1') { ?>

<div id="popup_price_modal"></div>
<script type="text/javascript">
$ = jQuery.noConflict();

function myFunction(id) {
//console.log('1st');  
  $.ajax({

      url: "https://etorazvod.ru/wp-admin/admin-ajax.php",
      type: "POST",
      data: "action=show_popup_serice_pager"+"&id="+id,
      beforeSend: function(xhr) {

                    },
      success: function( data ) {
          $("#popup_price_modal").html(data);
          $(".popup_container").show();
          $('.popup_container').css('visibility','visible');
          $('#filepdfsended').val();
          $('.input-number-mod-increment').click();
          $('.input-number-mod-decrement').click();
      }
  });
}

function myFunctionReload(){
    $("#popup_price_modal").empty();
    $("#popup_price_modal_footer").empty();
    myFunction();
}

$('.buy-btn-from-tariff').click(function(){
    //console.log($(this).attr('data-service'));
    //window.location.replace("https://etorazvod.ru/balance/?service_id="+$(this).attr('data-service'));
    //window.open("https://etorazvod.ru/balance-test/?service_id="+$(this).attr('data-service'), '_blank');
    if (typeof($(this).attr('data-service')) === "undefined") {
    } else {
        <?php if (is_user_logged_in()) { ?>
                            <?php $balancemain = intval(get_field('balance','user_'.get_current_user_id())); ?>
                            <?php if ($balancemain > 0) { ?>
                                    myFunction($(this).attr('data-service'));
                            <?php } else { ?>
                                    myFunction($(this).attr('data-service'));
                                    //window.open("https://etorazvod.ru/balance-test/?service_id="+$(this).attr('data-service'), '_blank');
                            <?php } ?>
        <?php } else { ?>        
                                    window.open("https://etorazvod.ru/registration", '_blank');
        <?php } ?>
    }   
})

// $(document).ready(function() {
// document.cookie = "loggedusertest=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
// });
</script>
<?php } else { ?>
<?php if (is_user_logged_in()) { ?>
    
<?php } else { ?>

<?php } ?>
<?php } ?>
<style type="text/css">
    .no-balance {
    text-align: left;
    background: #0059d9;
    padding: 10px;
    margin-bottom: 25px;
    margin-top: 25px;
    color: #FFF;
    display: block;
}

.balancer2 {
    background: #FFF;
    color: #0059d9;
    padding: 1px 10px;
    border-radius: 20px;
}

.nonebalance {
    background: #FFF;
    color: #0059d9;
    padding: 1px 10px;
    border-radius: 20px;
}
.nonebalance .rur, span.balancer2 .rur {
    color: #0059d9;
    font-size: 16px;
}
.no-balance {
    border-radius: 10px;
}
</style>
<?php if ($numtdMainer != 0) { ?>
<style type="text/css">
th.active_item_t {
    background: #F2F5F9;
}

.odd.td_tariff > td:nth-of-type(<?php echo $numtdMainer; ?>) {
    background: #dfe3ec;
}

.even.td_tariff > td:nth-of-type(<?php echo $numtdMainer; ?>) {
    background: #f2f5f9;
}
</style>
<?php } ?>
<?php if (is_user_logged_in()) { ?>
<?php $cur_user_id = get_current_user_id(); ?>
<?php $user_info = get_userdata($cur_user_id); ?>

<?php if (!($block['id'] == 'block_5fc1057fc0df1')) { ?>
    
<?php } else { ?>
<script type="text/javascript">
    var widget = new cp.CloudPayments();
    amountval = 0;

    this.pay3 = function () {
        amountval = parseInt(amountval);
        descriptionvar = 'Пополнение счёта';
        descriptionvar = 'Покупка тарифа '+$('.formed-wrapper-input[data-step="finish_him"] .title-service-accept.title-service-accept-fin').text()+' на '+ $('.formed-wrapper-input[data-step="finish_him"] .mounth-dater').text()+'';
        widget.pay('charge',
        { //options
        publicId: 'pk_9e9845c4d45b6acc7a06acc1a1841',
        description: descriptionvar,
        amount: parseInt(amountval),
        currency: 'RUB',
        invoiceId: <?php echo time(); ?>,
        accountId: '<?php echo $user_info->data->user_email; ?>',
        skin: "modern",
        data: {
        myProp: 'myProp value'
        }
        },
        {
        onSuccess: function (options) { // success
        invoiceId = options.invoiceId;

        dataid = $('.title-service.title-service-main').attr('data-id');
        inputnumbermod = $('.input-number-mod').val();

        //console.log('invoiceId: '+invoiceId);
        $.ajax({
        url: '<?php echo admin_url("admin-ajax.php") ?>',
        type: 'POST',
        data: 'action=balanceandcardpayforservice&invoceid='+invoiceId+'&resultid='+resultid+'&dataid='+dataid+'&inputnumbermod='+inputnumbermod,
        beforeSend: function(xhr) {                    
        },
        success: function(data) {
        result = $.parseJSON(data);
        location.reload();
        //alert(result.status + result.CardHolderMessage)
        //console.log(result);
        }
        }); 
        },
        onFail: function (reason, options) { // fail
        location.reload();
        },
        onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
        //например вызов вашей аналитики Facebook Pixel
        }
        }
        )
    };

    this.pay2 = function () {
        amountval = parseInt(amountval);
        descriptionvar = 'Пополнение счёта';
        descriptionvar = 'Покупка тарифа '+$('.formed-wrapper-input[data-step="finish_him"] .title-service-accept.title-service-accept-fin').text()+' на '+ $('.formed-wrapper-input[data-step="finish_him"] .mounth-dater').text()+'';

        widget.pay('charge',
        { //options
        publicId: 'pk_9e9845c4d45b6acc7a06acc1a1841',
        description: descriptionvar,
        amount: parseInt(amountval),
        currency: 'RUB',
        invoiceId: <?php echo time(); ?>,
        accountId: '<?php echo $user_info->data->user_email; ?>',
        skin: "modern",
        data: {
        myProp: 'myProp value'
        }
        },
        {
        onSuccess: function (options) { // success
        invoiceId = options.invoiceId;

        dataid = $('.title-service.title-service-main').attr('data-id');
        inputnumbermod = $('.input-number-mod').val();

        //console.log('invoiceId: '+invoiceId);
        $.ajax({
        url: '<?php echo admin_url("admin-ajax.php") ?>',
        type: 'POST',
        data: 'action=cardpayforservice&invoceid='+invoiceId+'&resultid='+resultid+'&dataid='+dataid+'&inputnumbermod='+inputnumbermod,
        beforeSend: function(xhr) {                    
        },
        success: function(data) {
        result = $.parseJSON(data);
        location.reload();
        //alert(result.status + result.CardHolderMessage)

        }
        }); 
        },
        onFail: function (reason, options) { // fail
        location.reload();
        },
        onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
        //например вызов вашей аналитики Facebook Pixel
        }
        }
        )
    };
</script>
<span class="bycardfunc2"></span>
<span class="bycardfunc3"></span>

<?php } ?>

<?php } ?>
<style type="text/css">
    span.f-question-tariff {
    display: inline-block;
    width: 18px;
    height: 18px;
    position: relative;
}

span.f-question-tariff > i {display: block;position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;display: flex;align-items: center;justify-content: center;}

span.title_lefter {
    display: flex;
    justify-content: center;
    align-items: center;
}

span.f-question-tariff {
    margin-left: 5px;
    border-radius: 50%;
    background: #0069ff;
    color: #FFF;
    font-size: 10px;
}

span.f-question-tariff:hover span.showadvice {
    display: block !important;
    width: 200px;
    position: absolute;
    top: -79px;
    left: -110px;
    right: -110px;
    margin: auto;
    background: white;
    font-family: 'Roboto', sans-serif;
    font-weight: normal;
    color: #929292;
    box-shadow: 0px -5px 20px 1px rgb(0 0 0 / 0.20);
    padding: 10px;
    border-radius: 9px;
}

span.f-question-tariff:hover span.showadvice:before {content: " ";width: 10px;height: 10px;background: white;position: absolute;bottom: -6px;left: 0;right: 0;margin: auto;transform: rotate(45deg);}

span.f-question-tariff {
    position: relative;
}

span.f-question-tariff:hover span.showadvice:before {
    box-shadow: 3px 3px 20px 1px rgb(0 0 0 / 50%);
    /* position: relative; */
    z-index: 0;
}
span.f-question-tariff:hover span.showadvice {
    padding: 0;
}

span.f-question-tariff:hover span.showadvice span {
    padding: 10px;
    display: block;
    background: #FFF;
    border-radius: 50px;
    position: relative;
}

span.f-question-tariff {
}

span.f-question-tariff span.showadvice {
    width: 220px !important;
}
span.f-question-tariff:hover .showadvice {
    visibility: visible !important;
}
span.f-question-tariff span.showadvice {
    padding: 0;
}
span.f-question-tariff span.showadvice span {
    padding: 10px;
    display: block;
    background: #FFF;
    border-radius: 50px;
    position: relative;
}

span.f-question-tariff span.showadvice {
    display: block;
    position: absolute;
    top: -79px;
    left: -110px;
    right: -110px;
    margin: auto;
    background: white;
    font-family: 'Roboto', sans-serif;
    font-weight: normal;
    color: #929292;
    box-shadow: 0px -5px 20px 1px rgb(0 0 0 / 0.20);
    border-radius: 9px;
}

@media screen and (max-width: 620px) {

span.showadvice {
    left: -180px !important;
}

span.f-question-tariff:hover span.showadvice:before {
    right: -68px !important;
}
}

@media screen and (max-width: 535px) {

span.showadvice {
    left: -280px !important;
}

span.f-question-tariff:hover span.showadvice:before {
    right: -168px !important;
}
}

@media screen and (max-width: 445px) {
span.showadvice {
    left: -300px !important;
}

span.f-question-tariff:hover span.showadvice:before {
    right: -190px !important;
}
span.f-question-tariff {
    flex-basis: 18px;
    flex-grow: 0;
    flex-shrink: 0;
}
span.title_lefter {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100% !important;
    padding-left: 20px;
    padding-right: 20px;
}
}
</style>
<script type="text/javascript">
$ = jQuery.noConflict();
$(document).ready(function(){
    $('.f-question-tariff span.showadvice').each(function(){
        $(this).attr('style','width: 220px !important;display:block;visibility:hidden;position:absolute;');
        heighttop = $(this).find('span').height()+30;
        console.log(heighttop);
        heighttopminus = '-'+heighttop+'px';
        $(this).css('height',$(this).find('span').height()+20);
        $(this).css('top',heighttopminus);
        $(this).css('visibility','visible');
        $(this).css('display','none');
    })
})    
</script>