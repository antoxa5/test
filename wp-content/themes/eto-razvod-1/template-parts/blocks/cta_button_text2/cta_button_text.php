<?php
/**
 * List Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
?>
    <div class="expert_wrap <?=get_field('style')?>">
        <div class="main_text">
			<?php if (get_field('title')) {
				echo '<span class="expert_title">'.get_field('title').'</span>';
			} ?>
			<?=get_field('textmain')?>
        </div>
        <div class="expert_author">
			<?php if (get_field('izobrazhenie')) {
				echo '<img src="'.get_field('izobrazhenie').'" alt="">';
			} ?>

            <div class="expert_author_desc">
				<?php if (get_field('fio')) {
					echo '<span class="expert_lastname">'.get_field('fio').'</span>';
				} ?>
				<?php if (get_field('podpis')) {
					echo '<span class="expert_desc">'.get_field('podpis');
					if (get_field('link')) {
						$url = parse_url(get_field('link'))["host"];
						if (get_field('text_link')) {
						    $url = get_field('text_link');
                        }
						echo '<a href="'.get_field('link').'" class="expernt_url">'.$url.'</a>';
					}
				} ?>
				<?php
                if (gettype(get_field('social_networks')) == 'array') {
	                if (count(get_field('social_networks')) != 0) {
	                    echo '<div class="social_expernt">';
					}
					foreach ( get_field('social_networks') as $item ) {
						echo '<a href="'.$item['link'].'">'.get_term($item['channel'])->name.'</a>';
					}
					if (count(get_field('social_networks')) != 0) {
						echo '</div>';
					}
				}
				
				?>
            </div>

        </div>
    </div>
