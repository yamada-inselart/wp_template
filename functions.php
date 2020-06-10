<?php



/*------------------------------
	設定
------------------------------*/

$custom_post = 0; // カスタム投稿タイプを利用するなら 1
$custom_field = 0; // カスタムフィールドを利用するなら 1
$widget = 1; // ウィジェットを利用するなら 1
$theme_options = 0; // テーマオプションページを利用するなら 1
$quick_edit = 0; // クイックエディットを利用するなら 1
$change_post_name = 0; // menu「投稿」の名前を変えるなら 1
$rss_img = 0; // rssに画像を出力するなら 1
$shortcode = 0; // shortcodeを利用するなら 1



/*------------------------------
	外部ファイル読み込み
------------------------------*/

require_once ( dirname(__FILE__) . '/functions/breadcrumb.php' ); // パンくず
require_once ( dirname(__FILE__) . '/functions/func.php' ); // 関数

if($custom_post) {
	require_once ( dirname(__FILE__) . '/functions/custom-post.php' );
}
if($custom_field) {
	require_once ( dirname(__FILE__) . '/functions/custom-f01.php' );
}
if($widget) {
	require_once ( dirname(__FILE__) . '/functions/widget.php' ); // ウィジェットエリアの追加
	require_once ( dirname(__FILE__) . '/widget/My_Widget01.php' ); // ウィジェット読み込み
}
if($theme_options) {
	require_once ( dirname(__FILE__) . '/admin/theme-options.php' );
}
if($quick_edit) {
	require_once ( dirname(__FILE__) . '/functions/quick-edit.php' );
}
if($shortcode) {
	require_once ( dirname(__FILE__) . '/functions/shortcode.php' );
}



/*------------------------------
	CSS,JSの読み込み
------------------------------*/

add_action( 'wp_enqueue_scripts', 'add_files' );

function add_files() {

	// CSSファイル
	wp_enqueue_style( 'reset',  get_template_directory_uri() . '/css/reset.css', '' , '');
	wp_enqueue_style( 'style',  get_template_directory_uri() . '/css/style.css', array('reset') , '');

	// JSファイル
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'common-js',  get_template_directory_uri() . '/js/common.js', array( 'jquery' ) , '', true);
}



/*------------------------------
	管理画面 CSSの読み込み
------------------------------*/

add_action( 'admin_enqueue_scripts', 'my_admin_style' );

function my_admin_style(){
    wp_enqueue_style( 'my_admin_style', get_template_directory_uri().'/admin/css/admin.css' );
}

/*------------------------------
	管理画面 JSの読み込み
------------------------------*/

add_action( 'admin_print_scripts', 'my_admin_scripts' );

// メディアアップローダー
function my_admin_scripts() {

	wp_enqueue_script( 'custom-uploader',  get_template_directory_uri() . '/admin/js/custom-uploader.js', array( 'jquery' ) , '', true);

    /* メディアアップローダの javascript API */
    wp_enqueue_media();

    /* 作成した javascript */
    wp_enqueue_script( 'custom-uploader' );

}


/*------------------------------
	アイキャッチ画像の設定
------------------------------*/

add_theme_support('post-thumbnails');
add_image_size('size01', 640, 360, true);


// RSSフィードに投稿のサムネイル画像を出力
if($rss_img) {
	add_image_size( 'rss_thumb', 240, 175, true);
	add_filter('the_excerpt_rss', 'post_thumbnail_feeds');
	add_filter('the_content_feed', 'post_thumbnail_feeds');

	function post_thumbnail_feeds($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = '<div>' . get_the_post_thumbnail($post->ID, 'pickup_thumb') . '</div>' . $content;
		}
		return $content;
	}
}



/*------------------------------
	excerpt 文字数
------------------------------*/

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length ) {
     return 120;
}
function new_excerpt_more($more) {
        return ' ... ';
}



/*------------------------------
	エディタ設定
------------------------------*/

add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );

// 見出し設定
function custom_editor_settings( $initArray ){
    $initArray['block_formats'] = "見出し1=h2; 見出し2=h3; 見出し3=h4; 段落=p; グループ=div;";
    return $initArray;
}



/*------------------------------
	投稿名を変更
------------------------------*/

if($change_post_name) {
	add_action( 'init', 'change_post_object_label' );
	add_action( 'admin_menu', 'change_post_menu_label' );

	function change_post_menu_label() {
		global $menu;
		global $submenu;
		$menu[5][0] = 'POST';
		$submenu['edit.php'][5][0] = 'POST一覧';
		$submenu['edit.php'][10][0] = '新しいPOST';
		$submenu['edit.php'][16][0] = 'タグ';
		//echo ";
	}
	function change_post_object_label() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'POST';
		$labels->singular_name = 'POST';
		$labels->add_new = _x('追加', 'POST');
		$labels->add_new_item = 'POSTの新規追加';
		$labels->edit_item = 'POSTの編集';
		$labels->new_item = '新規POST';
		$labels->view_item = 'POSTを表示';
		$labels->search_items = 'POSTを検索';
		$labels->not_found = '記事が見つかりませんでした';
		$labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
	}
}



?>