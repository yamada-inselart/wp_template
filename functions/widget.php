<?php

	/*------------------------------
		ウィジェット設定
	------------------------------*/

	// ウィジェットの有効化
	if (function_exists('register_sidebar')) {
		register_sidebar(array(
			'name' => 'サイドバー01',
			'id' => 'sidebar01',
			'description' => '説明1',
			'before_widget' => '<section class="wp_widget">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget_tit">',
			'after_title' => '</h3>'
		));
	}

?>