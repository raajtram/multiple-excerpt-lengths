<?php

/*
Plugin Name: Multiple Excerpt Lengths
Plugin URI: https://raajtram.com/plugins/mel
Description: Allows you to change the lengths of excerpts that are present at variours pages/templates throughout your site.
Version: 1.0
Author: Raaj Trambadia
Author URI: https://raajtram.com/
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

function mel_init() {
	register_setting( 'mel_settings_group', 'mel_settings' );

	add_settings_section(
		'mel_section',
		'',
		'mel_cb',
		'multiple-excerpt-lengths'
	);

	add_settings_field(
		'mel_front',
		'Front Page',
		'mel_front_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

	add_settings_field(
		'mel_home',
		'Blog Page',
		'mel_home_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

	add_settings_field(
		'mel_cat',
		'Category Archives',
		'mel_cat_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

	add_settings_field(
		'mel_tag',
		'Tag Archives',
		'mel_tag_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

	add_settings_field(
		'mel_author',
		'Author Archives',
		'mel_author_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

	add_settings_field(
		'mel_tax',
		'Custom Taxinomy Archives',
		'mel_tax_cb',
		'multiple-excerpt-lengths',
		'mel_section'
	);

}

add_action( 'admin_init', 'mel_init');

function mel_cb() {}

function mel_front_cb() {

	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_front'] ) ) $options['on_front'] = '';
	echo '<input type="number" name="mel_settings[on_front]" value="' . $options['on_front'] . '" placeholder="55" min="1" max="9999">';

}

function mel_home_cb() {
	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_home'] ) ) $options['on_home'] = '';
	echo '<input type="number" name="mel_settings[on_home]" value="' . $options['on_home'] . '" placeholder="55" min="1" max="999">';
}

function mel_cat_cb() {
	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_cat'] ) ) $options['on_cat'] = '';
	echo '<input type="number" name="mel_settings[on_cat]" value="' . $options['on_cat'] . '" placeholder="55" min="1" max="999">';
}

function mel_tag_cb() {
	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_tag'] ) ) $options['on_tag'] = '';
	echo '<input type="number" name="mel_settings[on_tag]" value="' . $options['on_tag'] . '" placeholder="55" min="1" max="999">';
}

function mel_author_cb() {
	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_author'] ) ) $options['on_author'] = '';
	echo '<input type="number" name="mel_settings[on_author]" value="' . $options['on_author'] . '" placeholder="55" min="1" max="999">';
}

function mel_tax_cb() {
	$options = get_option( 'mel_settings' );
	if( !isset( $options['on_tax'] ) ) $options['on_tax'] = '';
	echo '<input type="number" name="mel_settings[on_tax]" value="' . $options['on_tax'] . '" placeholder="55" min="1" max="999">';
}

function mel_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

?>

	<div class="wrap mel_options">
		<h2>Multiple Excerpt Lengths - Settings </h2>
		<p>Listed below are some commonly used pages and templates. If that page/template contains excerpts (inside wp_loop or wp_query), the length of the excerpt will be trimmed down to the number you specify. For e.g., if you specify "20" as the length for the "Front Page", all the excerpts present on that particular page (whether they are inside a wp_loop or a wp_query), will be trimmed down to 20 words.</p>
		<form method="post" action="options.php">
		<?php
			settings_fields( 'mel_settings_group' );
			do_settings_sections( 'multiple-excerpt-lengths' );
			submit_button();
		?>
	</div>

	<?php
}

function mel_menu() {
	add_options_page(
		'Multiple Excerpt Lengths',
		'Excerpt Lengths',
		'manage_options',
		'multiple-excerpt-lengths',
		'mel_options'
	);
}

add_action( 'admin_menu', 'mel_menu' );

function multiple_excerpt_lengths($length) {

	global $post;

	$options = get_option( 'mel_settings' );

	$is_front = !empty( $options['on_front'] ) ? $options['on_front'] : '55';
	$is_home = !empty( $options['on_home'] ) ? $options['on_home'] : '55';
	$is_cat = !empty( $options['on_cat'] ) ? $options['on_cat'] : '55';
	$is_tag = !empty( $options['on_tag'] ) ? $options['on_tag'] : '55';
	$is_author = !empty( $options['on_author'] ) ? $options['on_author'] : '55';
	$is_tax = !empty( $options['on_tax'] ) ? $options['on_tax'] : '55';

	if(is_front_page()) {
		return '' . $is_front . '';
	}
	elseif(is_home()) {
		return '' . $is_home . '';
	}
	elseif(is_category()) {
		return '' . $is_cat . '';
	}
	elseif(is_tag()) {
		return '' . $is_tag . '';
	}
	elseif(is_author()) {
		return '' . $is_author . '';
	}
	elseif(is_tax()) {
		return '' . $is_tax . '';
	}
	else
		return 55;

}

add_filter('excerpt_length', 'multiple_excerpt_lengths');