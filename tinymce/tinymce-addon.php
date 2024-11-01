<?php
add_filter('tiny_mce_version', 'wp_spatialtree_change_tinymce_version');
function wp_spatialtree_change_tinymce_version($ver) {
	$ver += 3;
	return $ver;
}

add_action('init', 'wp_spatialtree_add_button');
function wp_spatialtree_add_button() {
    wp_register_style('btnStyle', WP_PLUGIN_URL.'/spatialtree/assets/css/style.css','', '', 'all');
    wp_enqueue_style('btnStyle');
	if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;
	if (get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'wp_spatialtree_tinymce_plugin');
		add_filter('mce_buttons', 'wp_spatialtree_register_button');
	}
}

function wp_spatialtree_tinymce_plugin($plugin_array) {
	$plugin_array['wpSpatialTree'] = WP_PLUGIN_URL.'/spatialtree/tinymce/editor-plugin.js';
	return $plugin_array;
}

function wp_spatialtree_register_button($buttons) {
	array_push($buttons, '|', 'wpSpatialTreeArticles', 'wpSpatialTreeSetupData', 'wpSpatialTreeAddVisualization');
	return $buttons;
}

?>