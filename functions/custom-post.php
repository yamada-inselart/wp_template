<?php



/*------------------------------
	カスタム投稿タイプの追加
------------------------------*/

add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'custom01',
		array(
			'labels' => array(
				'name' => __( 'Custom01' ),
				'singular_name' => __( 'custom01' ),
			),
			'public' => true,
			'menu_position' =>5,
      		'has_archive' => true,
			'supports' => array('title','editor')
		)
	);
}



/*------------------------------
	カスタムタクソノミー
------------------------------*/

add_action( 'init', 'create_terms' );
function create_terms() {
	register_taxonomy(
		'category-custom01',// 新規カスタムタクソノミー名
		'custom01',// 新規カスタムタクソノミーを反映させる投稿タイプの定義名
		array(
			'label' => __( 'category' ),// 表示するカスタムタクソノミー名
			'rewrite' => array( 'slug' => 'category-custom01' ),// カスタムタクソノミースラッグ名
			'hierarchical' => true
		)
	);
}


?>