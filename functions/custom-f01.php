<?php

//---------------------------------------------------------------------------
//	カスタムフィールド
//---------------------------------------------------------------------------

add_action('admin_menu', 'add_field');
add_action('save_post', 'save_field');

function add_field() {
	add_meta_box('cf01_01', 'カスタムフィールド01', 'insert_field01', 'post', 'normal', 'high');
}

function insert_field01() {
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'cf01_nonce');

	$cf01_01 = get_post_meta($post->ID, 'cf01_01', true);

	echo <<<EOF
	<div>
	</div>
EOF;
}

function save_field($post_id){
	$my_nonce = isset($_POST['cf01_nonce']) ? $_POST['cf01_nonce'] : null;

	if(!wp_verify_nonce($my_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}

	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }

	if(!current_user_can('edit_post', $post_id)) { return $post_id; }

	$data['cf01_01'] = $_POST['cf01_01'];

	foreach($data as $key => $value) {
		if(get_post_meta($post_id, $key) == ""){
			add_post_meta($post_id, $key, $value, true);
		}elseif($value != get_post_meta($post_id, $key, true)){
			update_post_meta($post_id, $key, $value);
		}elseif($value == ""){
			delete_post_meta($post_id, $key, get_post_meta($post_id, $key, true));
		}
	}
}

?>
