<?php

add_action('admin_menu', 'my_theme_option');
add_action('admin_init', 'my_theme_option_setting' );

function my_theme_option() {
  add_theme_page( 'テーマ設定', 'テーマ設定', 'edit_pages','theme_option','theme_option_file' );
}

function my_theme_option_setting() {
    register_setting( 'my-group01', 'my_options' );
}



/*------------------------------
	テーマ設定のページを作成
------------------------------*/

function theme_option_file(){
?>

<div class="wrap slide-option-page">
 
	<h2>テーマ設定</h2>
 
	<form method="post" action="options.php">
	 <?php settings_fields( 'my-group' ); do_settings_sections( 'my-group' ); ?>

	<ul class="theme-options">

		
	<?php submit_button(); ?>
	
	</ul>

	</form>

</div>


<?php
}
?>