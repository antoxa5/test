<?php


require ('/var/www/eto/data/www/eto-razvod.ru/auth/src/autoload.php');

use Hybridauth\Hybridauth;

$config = [
    'callback' => 'https://etorazvod.ru/auth/callback.php',
    'providers' => [

        'Google' => [
            'enabled' => true,
            'keys' => [
                'id' => '687992469804-h3cj7ngahdqd39gs48hc6qthmdovtf08.apps.googleusercontent.com',
                'secret' => 'pj2LDXySjyjgLrLGyT67gM-Q',
            ],
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        ],
    'Vkontakte' => [
            'enabled' => true,
            'keys' => [
                'id' => '4579539',
                'secret' => '1n30bOqA2boDJfNJRePz',
            ],
            
        ],
    'Yandex' => [
            'enabled' => true,
            'keys' => [
                'id' => 'f1fbd00a333e4218898b442b089e364f',
                'secret' => 'd4ec8800ce164be2bb39431273c40255',
            ],
            
        ],


    ],
];
$hybridauth = new Hybridauth($config);
$reg_new = 0;
$adapters = $hybridauth->getConnectedAdapters();
if ($adapters) : 
     foreach ($adapters as $name => $adapter) : 
                    $adapter_data = $hybridauth->getAdapter($name);
        $userProfile = $adapter_data->getUserProfile();
        $accessToken = $adapter_data->getAccessToken();
        $data = [
            'token' => $accessToken,
            'identifier' => $userProfile->identifier,
            'email' => $userProfile->email,
            'first_name' => $userProfile->firstName,
            'last_name' => $userProfile->lastName,
            'photoURL' => strtok($userProfile->photoURL, '?'),
        ];
$existing_user = get_users(
                array(
                    //'role' => 'editor',
                    'meta_key' => 'provider_'.$name,
                    'meta_value' => $data['identifier']
                
                )
            );
            
            if(!empty($existing_user[0])) {
                $user = $existing_user[0];
                //echo '<pre>';
                //print_r($user);
                //echo '</pre>';
                wp_clear_auth_cookie();
                wp_set_current_user ( $user->ID );
                wp_set_auth_cookie  ( $user->ID );
                
            } else {
                $reg_new = 1;
            }
endforeach;
endif;
get_header(); ?>
<?php if (have_posts()) :
    while (have_posts()) : the_post();
        $er_tags = er_tags($post->ID,'page');
?>
        <div class="page_header page_style">
            <div class="wrap">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>

        <div class="page">
            <?php show_breadcrumbs(); ?>
            <div class="wrap">
                <div class="content">
                    <?php the_content(); ?>
                    <?php if(!get_field('disable_top_brokers')) { ?>
                        <div id="bottom_brokers_list">
                            <?php echo bottom_brokers_new($er_tags); ?>
                        </div>
                    <?php } ?>

        <?php if (comments_open()) { ?>
                    <h2 id="comments">Комментарии</h2>
                    <?php if(is_page(87408)) { comments_template(); } else { ?>
                    <div id="mc-container"></div>
                    <script type="text/javascript">
                        cackle_widget = window.cackle_widget || [];
                        cackle_widget.push({widget: 'Comment', id: 39578});
                        (function() {
                            var mc = document.createElement('script');
                            mc.type = 'text/javascript';
                            mc.async = true;
                            mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
                        })();
                    </script>
                    <?php }; ?>
                    <?php// comments_template(); // Get comments template ?>
            <?php }; ?>
                </div>
            </div>
        </div>
   <?php endwhile;
endif; ?>
<?php 
function getName($n) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomString = '';

for ($i = 0; $i < $n; $i++) {
$index = rand(0, strlen($characters) - 1);
$randomString .= $characters[$index];
}
return $randomString;
}
$param = $_GET['auth'];
if($reg_new == 1 && $param == 'new' && !is_user_logged_in()) {
if ($adapters) : 
foreach ($adapters as $name => $adapter) : 
$adapter_data = $hybridauth->getAdapter($name);
$userProfile = $adapter_data->getUserProfile();
$accessToken = $adapter_data->getAccessToken();
$data = [
'token' => $accessToken,
'identifier' => $userProfile->identifier,
'email' => $userProfile->email,
'first_name' => $userProfile->firstName,
'last_name' => $userProfile->lastName,
'photoURL' => strtok($userProfile->photoURL, '?'),
];
$nameprovider = $name;
//print_r($data);
$social_username = strtolower($nameprovider).'_'.$data['identifier'];
if (($name == 'Vkontakte') ) {
//$urler = str_replace("impg/", "",$data['photoURL']);
$n = 10;
$json = file_get_contents('https://api.vk.com/method/photos.get?owner_id='.$data['identifier'].'&album_id=profile&access_token='.$data['token']['access_token'].'&v=5.21&rev=1');
$obj = json_decode($json);
// echo "<pre>";
// print_r($obj);
// echo "</pre>";
$urler = $obj->response->items[0]->photo_604;
if ($urler == '') {
$urler = $obj->response->items[0]->photo_130;
}

$dir = '/var/www/eto/data/www/eto-razvod.ru/imgtemp'; // Full Path
$namesocialnetworkavatar = 'userlogo_'.getName($n).'.jpg';


is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
copy($urler, $dir . DIRECTORY_SEPARATOR . $namesocialnetworkavatar);
$urler = 'http://eto-razvod.ru/imgtemp/'.$namesocialnetworkavatar;

} elseif ($name == 'Yandex') {
$n = 10;
$json = file_get_contents('https://login.yandex.ru/info?format=json&with_openid_identity=1&oauth_token='.$data['token']['access_token']);
$obj = json_decode($json);
if ($obj->is_avatar_empty == true) {

} else {

$url = 'https://avatars.yandex.net/get-yapic/'.$obj->default_avatar_id.'/islands-200';
$dir = '/var/www/eto/data/www/eto-razvod.ru/imgtemp'; // Full Path
$namesocialnetworkavatar = 'userlogo_'.getName($n).'.png';


is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
copy($url, $dir . DIRECTORY_SEPARATOR . $namesocialnetworkavatar);
$urler = 'http://eto-razvod.ru/imgtemp/'.$namesocialnetworkavatar;
}
}  elseif ($name == 'Google') {
$n = 10;
//echo $data['photoURL'];   
if ($data['photoURL'] != '') {
$url = $data['photoURL'];
$dir = '/var/www/eto/data/www/eto-razvod.ru/imgtemp'; // Full Path
$namesocialnetworkavatar = 'userlogo_'.getName($n).'.jpg';


is_dir($dir) || @mkdir($dir) || die("Can't Create folder");
copy($url, $dir . DIRECTORY_SEPARATOR . $namesocialnetworkavatar);
$urler = 'http://eto-razvod.ru/imgtemp/'.$namesocialnetworkavatar;
} 
}

endforeach;
endif;



?>

<script type="text/javascript">
$ = jQuery.noConflict();
$(document).ready(function() {
$.ajax({
url: "<?php echo admin_url("admin-ajax.php"); ?>",
type: "POST",
data: "action=popup_registration_final_social&identifier=<?php echo $data['identifier']; ?>&email=<?php echo $data['email']; ?>&first_name=<?php echo $data['first_name']; ?>&last_name=<?php echo $data['last_name']; ?>&provider=<?php echo $nameprovider; ?>&urler=<?php echo $urler; ?>&social_username=<?php echo $social_username; ?>",
beforeSend: function(xhr) {

},
success: function( data ) {
$("#popup_comment_modal").html(data);
$("#popup_comment_modal .popup_container").show();
}
});
});
</script>
<?php
} ?>
<?php if (is_user_logged_in()) { ?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        if (document.cookie.indexOf('loggedusertest=') != '-1') {
            valercoockie = document.cookie.replace(/(?:(?:^|.*;\s*)loggedusertest\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            document.cookie = "loggedusertest=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            if ((valercoockie == "84175") || (valercoockie == "84178")) {
                window.location.replace("https://etorazvod.ru/tariff/?service_id="+valercoockie);
            }
             else {
                    window.location.reload();
                }
            
        } else {
            $('.buy-btn-from-tariff').click(function(){
                valercoockie = $(this).attr('data-service');
                if ((valercoockie == "84175") || (valercoockie == "84178")) {
                    window.location.replace("https://etorazvod.ru/tariff/?service_id="+valercoockie);
                }
            })
        }
    });
</script>
<?php } else { ?>
<script>
        function auth_popup(provider) {
            // replace 'path/to/hybridauth' with the real path to this script
            var authWindow = window.open('https://etorazvod.ru/auth/callback.php?provider=' + provider+'&type=front_reg', 'authWindow', 'width=600,height=400,scrollbars=yes');
            window.closeAuthWindow = function () {
              authWindow.close();
            }

            return false;
        }
    </script>
<?php wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css'); ?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        if ($('.comments_list > li').length <= 5) {
        $('.autoload_posts_button').css('display','none');
        }
        $('.autoload_posts_button').click(function() {
            var i = 0;
            var howmanycomments = 5;
            $('.comments_list > li').each(function() {
                if ($(this).is(":visible")) {

                } else {
                    if (i < howmanycomments) {
                        $(this).css('display','block');
                    } else {
                        $(this).css('display','none');
                    }
                    i = ++i; 
                }

            });
            if (i <= howmanycomments) {
                $('.autoload_posts_button').css('display','none');
                $('.comments_list > li').css('display','block');
            }
        });
        $('.comment-body').hover(function() {
            //alert('sdfdsf');
            var header_hovered = $(this).attr("data-body-id");
            var comment_id = $(this).closest('li').attr('data-commentid');
            //alert(header_hovered);
            //alert(comment_id);
            $('.hovered_'+comment_id).toggleClass('visible');
        });
        $('.comments_dashboard_subscribe').click(function() {
            var subscribe_action = $(this).attr('data-current-status');
            //alert(subscribe_action);
            if(subscribe_action === 'not_auth') {
                //alert('not_auth');
                $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=popup_login",
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            $("#popup_comment_modal").html(data);
                            $("#popup_comment_modal .popup_container").show();
                        }
                    });
            } else {
                $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=comment_subscribtion&subscribe_action="+subscribe_action+"&post_id=<?php echo $post->ID; ?>",
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            
                            result = JSON.parse(data);
                            if(result.status === 'ok') {
                                $( ".comments_dashboard_subscribe" ).removeClass( subscribe_action );
                                $( ".comments_dashboard_subscribe" ).addClass( result.new_result );
                                $( ".comments_dashboard_subscribe" ).attr( "data-current-status", result.new_result );
                                if(result.new_result === 'subscribed') {
                                    $( ".comments_dashboard_subscribe span" ).text( "<?php _e('Вы подписаны','er_theme'); ?>" );
                                } else {
                                    $( ".comments_dashboard_subscribe span" ).text( "<?php _e('Подписаться','er_theme'); ?>" );
                                }
                            }
                        }
                    });
            }
        });
        
        $('body').on('change', '#fileavatar_comment', function() {
            //alert('sdfdsf');
            $this = $(this);
            var form_id = $(this).closest('.form-group').attr('data-form-id');
            file_data = $(this).prop('files')[0];
            //alert(file_data);
            console.log(file_data);
            form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('action', 'file_upload_comment');
            console.log(form_data);
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    //alert(form_data);
                    $this.val('');
                    result = $.parseJSON(response);
                    //$('.fileUpload').slideUp();
                    console.log(result.status);
                      console.log(result.uploadedfile);
                    //alert(result.uploadedfile);
                    //alert(result.status);
                    //alert(result.image_url);
                    $('.form_textarea.'+form_id).addClass('files_visible');
                    $('.form_attached_files.'+form_id).addClass('visible');
                    $('.form_attached_files.'+form_id+' ul').append('<li style="background-image:url('+result.image_url+')"><input type="hidden" name="files[]" value="'+result.uploadedfile+'"></li>');
                    //$('.form-edit-user-info__useravatar').attr('src',result.uploadedfile);
                }
            });
        });    
        $('.form_file_icon').click(function() {
            //alert('form_file_icon');
            $('.form_file_links').toggleClass('visible');
        });
        $('.form_file_link_web').click(function() {
            //alert('form_file_icon');
            $('.form_file_link_web_form').toggleClass('visible');
            
        });
        $('input[name="submit_link"]').click(function(e) {
            e.preventDefault();
            //alert('send link');
            var parse_link = $('textarea[name="form_file_link_web_form_textarea"]').val();
            //alert(parse_link);
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=add_file_by_link&parse_link="+parse_link,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    //alert(data);
                    result = $.parseJSON(data);
                    //$('.fileUpload').slideUp();
                    console.log(result.status);
                      console.log(result.file);
                    //alert(result.file);
                    //alert(result.status);
                    //alert(result.message);
                    //alert(result.type);
                    //alert(result.image_url);
                    
                    if(result.status === 'ok') {
                        $('.form_textarea.form_review').addClass('files_visible');
                        $('.form_attached_files.form_review').addClass('visible');
                        if(result.type === 'url') {
                            $('.form_attached_files.form_review ul').append('<li style="background-image:url('+result.image_url+')"><input type="hidden" name="files[]" value="'+result.file+'"><input type="hidden" name="links['+result.file+']" value="'+result.video+'"></li>');
                        } else {
                            $('.form_attached_files.form_review ul').append('<li style="background-image:url('+result.image_url+')"><input type="hidden" name="files[]" value="'+result.file+'"></li>');
                        }
                    }
                }
            });
        });
        $('a.youtube_link').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var comment_id = $(this).closest('li.comment').attr('data-commentid');
            //alert(comment_id);
            $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=youtube_link_append&url="+url,
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            //alert(data);
                            $("#popup_comment_modal").html(data);
                            $("#popup_comment_modal .popup_container").show();
                        }
                    });
        });
        
        $('.comments_dashboard_sort li').click(function() {
            var sort_type = $(this).attr('data-sort-type');
            //alert(sort_type);
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=resort_comments&sort_type="+sort_type+"&post_id=<?php echo $post->ID; ?>&rating_fields_group=<?php echo $rating_fields_group; ?>",
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    //alert(data);
                    $('.comments_dashboard_sort li.active').removeClass('active');
                    $('.comments_dashboard_sort li.sort_'+sort_type).addClass('active');
                    $('ul.comments_list').empty();
                    $('ul.comments_list').append(data);
                    $('.autoload_posts_button').css('display','block');
                    if ($('.comments_list > li').length <= 5) {
                        $('.autoload_posts_button').css('display','none');
                        }
                    //$("#popup_comment_modal").html(data);
                    //$("#popup_comment_modal .popup_container").show();
                    /*i = 0;
                    $('.comments_list > li').each(function() {
                        if (i < 5) {
                            $(this).css('display','block');
                        } else {
                            $(this).css('display','none');
                        }
                        i = ++i;
                        $(this).parent().removeClass('initial_sorted');

                    })*/
                }
            });
        });
        $('.comment_more_actions_link_spam').click(function() {
            
            <?php if(!is_user_logged_in()) { ?>
            $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=popup_login",
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            $("#popup_comment_modal").html(data);
                            $("#popup_comment_modal .popup_container").show();
                        }
                    });
            <?php } else { ?>
            var comment_id = $(this).closest('li.comment').attr('data-commentid');
            //alert(comment_id);
            $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=comment_spam_form&comment_id="+comment_id,
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            result = JSON.parse(data);
                            $('.comment_more_actions_links_'+comment_id).toggleClass('visible');
                            $( ".comment_text_"+comment_id ).append( '<p class="spam_result_message style_'+result.status+'">'+result.message+'</p>' );
                            $('.spam_result_message').delay(5000).hide(0);
                            
                        }
                    });
            <?php } ?>
        });
        $('.comment_more_actions_link_abuse').click(function() {
            
            <?php if(!is_user_logged_in()) { ?>
            $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=popup_login",
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            $("#popup_comment_modal").html(data);
                            $("#popup_comment_modal .popup_container").show();
                        }
                    });
            <?php } else { ?>
            var comment_id = $(this).closest('li.comment').attr('data-commentid');
            $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        data: "action=comment_abuse_form&comment_id="+comment_id,
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            $("#popup_comment_modal").html(data);
                            $("#popup_comment_modal .popup_container").show();
                        }
                    });
            <?php } ?>
        });
        $('.comment_permalink').click(function() {
            var comment_id = $(this).closest('li').attr('data-commentid');
            //alert(comment_id);
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=comment_popup_actions&action_type=comment_permalink&comment_id="+comment_id,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    $("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                    $("#popup_comment_modal input[type='text']").select();
                }
            });
        });
        $('.social_login_links .Email').click(function() {
            //alert('alert');
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=popup_login",
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    $("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                }
            });
        });
        $('.comments_dashboard_share').click(function() {
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=post_share&post_id=<?php echo $post->ID?>",
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    //alert(data);
                    $("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                }
            });
        });
        $('.comment_share').click(function() {
            var comment_id = $(this).closest('li').attr('data-commentid');
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=comment_popup_actions&action_type=comment_share&comment_id="+comment_id,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    //alert(data);
                    $("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                }
            });
        });
        $('.comment_more_actions').click(function() {
            var comment_id = $(this).closest('li').attr('data-commentid');
            //alert(comment_id);
            $('.comment_more_actions_links_'+comment_id).toggleClass('visible');
        });
        $('a.comment-reply-link').click(function() {
            var post_id = $(this).attr("data-postid");
            var parent_id = $(this).attr("data-commentid");
            var appendto = $(this).attr("data-appendto");
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=show_reply_form&form_id=reply_form&post_id="+post_id+"&parent_id="+parent_id,
                success: function( data ) {
                    $( "li .comment_form" ).remove();
                    $( "#comment-"+appendto ).append( data );
                    //$( data ).first().after( "#comment-"+appendto+" .comment-body" );
                }
            });
        });
        $('.comment_total_rating').click(function() {
            var id = $(this).closest('li').attr("id");
            $('#'+id+' .comment_rating_details').toggleClass('visible');
        });
        $('.comment_rate .rate_action').click(function() {
        var cookie_class = $(this).attr("data-commentaction");
       // alert(cookie_class);
        var id = $(this).closest('li').attr("id");
        var id_num = $(this).closest('li').attr("data-commentid");
        var comment_action = $(this).attr("data-commentaction");
           var comment_number_container = $(this).closest('.comment_rate').attr("id");
        $.ajax({
            url: "<?php echo admin_url("admin-ajax.php"); ?>",
            type: "POST",
            data: "action=set_cookie_rate&cookie_id="+cookie_class+"_"+id_num+"&cookie_time="+172800,
            success: function( data ) {
               // alert( data );
                var cookies_exist = data;
                if (cookies_exist == "no") {
                    $.ajax({
                        url: "<?php echo admin_url("admin-ajax.php"); ?>",
                        type: "POST",
                        dataType: "text json",
                        data: "action=update_comment_rate&id="+id+"&comment_id="+id_num+"&comment_action="+comment_action,
                        beforeSend: function(xhr) {

                        },
                        success: function( data ) {
                            //alert( data );
                            $('#'+comment_number_container+' .rate_number_container span').removeClass();
                            $('#'+comment_number_container+' .rate_number_container span').addClass('rate_number '+data['new_class']);
                            $('#'+comment_number_container+' .rate_number').html(data['new_rate']);
                        }
                    });
                } else {
                    alert('<?php _e('Вы уже голосовали за этот комментарий!', 'sa_theme'); ?>');
                }
            }
        });


    });
    });
</script>
<script type="text/javascript">
    $ = jQuery.noConflict();

    $('.buy-btn-from-tariff').click(function() {
            ds = $(this).attr('data-service');
            //alert('alert');
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php") ?>',
                type: "POST",
                data: "action=popup_login",
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    $("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();

                    document.cookie = "loggedusertest="+ds+"; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
                }
            });
        });
    //.click(function(){
        //console.log($(this).attr('data-service'));
        //window.location.replace("https://etorazvod.ru/balance/?service_id="+$(this).attr('data-service'));
        //window.open("https://etorazvod.ru/balance/?service_id="+$(this).attr('data-service'), '_blank');
    //})

</script>
<div id="popup_comment_modal"></div>
<?php } ?>
<?php get_footer();
?>