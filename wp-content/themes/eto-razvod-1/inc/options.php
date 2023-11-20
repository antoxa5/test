<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Auth Settings',
		'menu_title'	=> 'Auth',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

if( !function_exists('social_providers') ) {
	function social_providers() {

		$providers = get_field('social_providers','option');

		$result = array();
		if(!empty($providers)) {
			foreach($providers as $provider) {
				$term = get_term($provider['provider'],'social_providers');

				if(isset($term->term_id)) {
					$provider_for_domain = get_field('social_provider_domain_for','term_'.$term->term_id);			
				}

				if($provider_for_domain != $_SERVER['HTTP_HOST']) {
					continue;
				}

				$provider_term_id = get_field('provider_id','term_'.$term->term_id);

				if($provider_term_id && $provider_term_id != '') {
					$provider_id = $provider_term_id;
				} else {
					$provider_id = $term->slug;
				}
				$provider_keys = $provider['keys'][0];
				$keys = array();
				if(!empty($provider_keys)) {
					foreach ($provider_keys as $key => $value) {
						if($value != '') {
							$keys[$key] = $value;
						}
					}
					
				}
				$result[$provider_id]['title'] = $term->name;
				$result[$provider_id]['settings']['enabled'] = $provider['enabled'];
				$result[$provider_id]['settings']['keys'] = $keys;
				$result[$provider_id]['settings']['scope'] = $provider['scope'];
			}
		} 

		return $result;
	}
	
}

if( !function_exists('h_auth_config') ) {
	function h_auth_config() {
		$result = array();
		$result['callback'] = 'https://' . $_SERVER['HTTP_HOST'] . get_field('provider_callback_url','option');
		$social_providers = social_providers();
		if(!empty($social_providers)) {
			foreach ($social_providers as $key => $value) {
				$result['providers'][$key] = $value['settings'];
			}
		}
		return $result;
	}
}


if( !function_exists('social_login_icons') ) {
	function social_login_icons($type) {
		$result = '';
		$providers = social_providers();
		if(!empty($providers)) {
			$result .= print_css_links('social_login');
			$result .= '<ul class="social_login_icons flex type_'.$type.'">';
			foreach ($providers as $key => $value) {
				if($value['settings']['enabled']) {
					$result .= '<li data-provider-id="'.$key.'" class="pointer font_small '.$key.'">';
					$result .= '<span class="social_icon"></span>';
					if($type == 'full') {
					$result .= '<span class="social_title">'.$value['title'].'</span>';
					}
					$result .= '</li>';
				}
			}
			$result .= '</ul>';
		}
		return $result;
	}
}