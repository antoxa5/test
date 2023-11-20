<?php
function create_metaboxes(){
    add_meta_box("room-meta", "Broker Site Properties", "name_type_metabox", "casino", "normal", "low");

    add_meta_box("blog-meta", "Blog Page Options", "blog_type_metabox", "page", "advanced", "low");


        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "post", "advanced", "low");
        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "page", "advanced", "low");
        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "casino", "advanced", "low");
        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "addpages", "advanced", "low");
        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "promocodes", "advanced", "low");
        add_meta_box("seo-meta", "SEO Options", "seo_type_metabox", "promocodes_cats", "advanced", "low");


}


function blog_type_metabox() {
    global $post;
    $custom = get_post_custom($post->ID);
    $numblogs = $custom["_numblogs"][0];
    $blogexcerpts = $custom["_blogexcerpts"][0];
    $blogcat = $custom["_blogcat"][0];

    ?>

    <input type="hidden" name="blog_type_noncename" id="blog_type_noncename" value="<?php echo wp_create_nonce( 'blog_type'.$post->ID );?>" />
    <table cellpadding="5" cellspacing="10" width="100%" style="font-size:10px;">

        <tr>
            <th width="40%" align="left"><label>Show Excerpts Instead of Full Posts:</label></th>
            <td>
                <select name="_blogexcerpts" class="smallmetatwo">
                    <option value="">Select</option>
                    <option <?php if ($blogexcerpts == "Yes") echo 'SELECTED'; ?>>Yes</option>
                    <option <?php if ($blogexcerpts == "No") echo 'SELECTED'; ?>>No</option>
                </select>
            </td>
        </tr>

        <tr>
            <th align="left"><label>Show Posts From This Cat ID Only (Leave blank for all):</label></th>
            <td><input class="minimeta" type="text" name="_blogcat" value="<?php echo $blogcat; ?>" /></td>
        </tr>

        <tr>
            <th align="left"><label>Number of Posts To Show:</label></th>
            <td><input class="minimeta" type="text" name="_numblogs" value="<?php echo $numblogs; ?>" /></td>
        </tr>
    </table>

<?php  }

function save_blogmetaboxes($post_id) {
    if ( !wp_verify_nonce( $_POST['blog_type_noncename'], 'blog_type'.$post_id )) {
        return $post_id;
    }

    $fields = array('_numblogs', '_blogexcerpts', '_blogcat');
    foreach ($fields as $field) {
        modify_post_meta($post_id, $field, $_POST[$field]);
    }

}

function seo_type_metabox() {
    global $post;
    $custom = get_post_custom($post->ID);
    $seo_title = $custom["seo_title"][0];
    $seo_desc = $custom["seo_desc"][0];
    $seo_keywords = $custom["seo_keywords"][0];

    ?>
    <input type="hidden" name="seo_type_noncename" id="seo_type_noncename" value="<?php echo wp_create_nonce( 'seo_type'.$post->ID );?>" />
    <table cellpadding="5" cellspacing="10" width="100%" style="font-size:10px;">
        <tr>
            <th width="30%" align="left"><label>Title:</label></th>
            <td> <textarea class="smallmetatwo" name="seo_title" cols="50" rows="2"><?php echo $seo_title; ?></textarea></td>
        </tr>
        <tr>
            <th align="left"><label>Description:</label></th>
            <td> <textarea class="smallmetatwo" name="seo_desc" cols="50" rows="4"><?php echo $seo_desc; ?></textarea></td>
        </tr>
        <tr>
            <th align="left"><label>Keywords (Separate by Comma):</label></th>
            <td> <textarea class="smallmetatwo" name="seo_keywords" cols="50" rows="4"><?php echo $seo_keywords; ?></textarea></td>
        </tr>


    </table>




    <?php
}

function save_seometaboxes($post_id) {
    if ( !wp_verify_nonce( $_POST['seo_type_noncename'], 'seo_type'.$post_id )) {
        return $post_id;
    }

    $fields = array('seo_title', 'seo_desc', 'seo_keywords');
    foreach ($fields as $field) {
        modify_post_meta($post_id, $field, $_POST[$field]);
    }

}

function save_casinometaboxes($post_id) {
    global $post;

    if ( !wp_verify_nonce( $_POST['casino_type_noncename'], 'casino_type'.$post_id )) {
        return $post_id;
    }


    $fields = array('_as_roomurl','_as_redirectkey');
    foreach ($fields as $field) {
        modify_post_meta($post_id, $field, $_POST[$field]);
    }

}

function modify_post_meta($id, $key, $value)
{
    delete_post_meta($id, $key);
    if ($value != "") {
        add_post_meta($id, $key, $value);
    }

}





function theme_options_page_title()
{
    global $post;

    if (is_front_page()) {
        $title = get_seo_option('home-title');
        if ($title != "") {
            echo $title;
            return;
        } else {
            $title = get_post_meta($post->ID, 'seo_title', true);
            if ($title != "") {
                echo $title;
                return;
            }
        }
    } elseif ( is_single() || is_page() ) {
        $title = get_post_meta($post->ID, 'seo_title', true);
        if ($title != "") {
            echo $title;
            return;
        }
    }

    wp_title('|',true,'right');
    bloginfo('name');
}


function theme_options_page_description() {
    if (is_front_page()) {
        $description = get_seo_option('home-description');
        if ($description != "") {
            echo $description;
            return;
        }
    }

    global $post;
    $description = get_post_meta($post->ID,'seo_desc',true);

    if ($description=="") {
        the_post();
        echo strip_tags(get_the_excerpt());
        rewind_posts();
    } else {
        echo $description;
    }
}

add_filter('robots_txt', 'er_robots_txt', 100,  2);
function er_robots_txt($output, $public) {

    status_header( 204 );
    return '';



    $host = $_SERVER['HTTP_HOST'];

    $f = '';
    $g = '';

    $current_language = get_locale();

// return $host . ' ' . $current_language;
    if($current_language == 'en_US') {
        $link = 'https://revieweek.com/wp-sitemap-en.xml';
    } elseif($current_language == 'fr_FR'){
        $link = 'https://revieweek.fr/wp-sitemap-fr.xml';
    } elseif($current_language == 'de_DE'){
        $link = 'https://revieweek.de/wp-sitemap-de.xml';
    } elseif($current_language == 'es_ES'){
        $link = 'https://revieweek.es/wp-sitemap-es.xml';
    } elseif($current_language == 'pl_PL'){
        $link = 'https://pl.revieweek.com/wp-sitemap-pl.xml';
    } elseif($current_language == 'fi'){
        $link = 'https://fi.revieweek.com/wp-sitemap-fi.xml';
    } elseif($current_language == 'id_ID'){
        $link = 'https://id.revieweek.com/wp-sitemap-id.xml';
    } else {
        $link = 'https://etorazvod.ru/wp-sitemap.xml';
    }

    if ($current_language == 'ru_RU') {
    	$g = 'User-agent: YandexImages
Allow: /wp-content/uploads/
User-agent: Mediapartners-Google
Disallow:
User-Agent: YaDirectBot
Disallow:';
    	$f = "User-agent: Yandex
Clean-param: preview&post_type&view&auth&nowprocket
Disallow: /wp-admin 
Disallow: /registration/
Disallow: /wp-includes
Disallow: /wp-login.php 
Disallow: /wp-register.php 
Disallow: /xmlrpc.php 
Disallow: /search 
Disallow: */trackback/ 
Disallow: */feed/
Disallow: */attachment/*
Disallow: */print/
Disallow: *?print=*
Disallow: */embed*
Disallow: */?*
Disallow: /?s=*
Disallow: /wp-json/
Disallow: /activation/*
Disallow: */dashboard/*
Disallow: /user/*
Allow: /wp-content/uploads/ 
Host: https://$host/
User-agent: Mail.Ru
Disallow: /wp-admin 
Disallow: /registration/
Disallow: /wp-includes
Disallow: /wp-login.php 
Disallow: /wp-register.php 
Disallow: /xmlrpc.php 
Disallow: /search 
Disallow: */trackback/ 
Disallow: */feed/
Disallow: */attachment/*
Disallow: */print/
Disallow: *?print=*
Disallow: */embed*
Disallow: */?*
Disallow: /?s=*
Disallow: /wp-json/
Disallow: /activation/*
Disallow: /user/*
Disallow: */dashboard/*
Allow: /wp-content/uploads/ ";
	}

    $text = "User-agent: Googlebot 
Disallow: /wp-admin 
Disallow: /registration/
Disallow: /wp-login.php
Disallow: /wp-register.php 
Disallow: /xmlrpc.php 
Disallow: /search 
Disallow: */trackback/ 
Disallow: */feed/
Disallow: */attachment/*
Disallow: */print/
Disallow: *?print=*
Disallow: */embed*
Disallow: */?*
Disallow: /?s=*
Disallow: /wp-json/
Disallow: /activation/*
Disallow: /user/*
Disallow: */dashboard/*
Allow: /wp-content/uploads/ 
$f
User-agent: * 
Disallow: /wp-admin 
Disallow: /registration/
Disallow: /wp-includes
Disallow: /wp-login.php 
Disallow: /wp-register.php 
Disallow: /xmlrpc.php 
Disallow: /search 
Disallow: */trackback/ 
Disallow: */feed/
Disallow: */attachment/*
Disallow: */print/
Disallow: *?print=*
Disallow: */embed*
Disallow: */?*
Disallow: /?s=*
Disallow: /wp-json/
Disallow: /activation/*
Disallow: /user/*
Disallow: */dashboard/*
Allow: /wp-content/uploads/ 
User-agent: Googlebot-Image
Allow: /wp-content/uploads/
$g
Sitemap: $link";
    return $text;
}



?>