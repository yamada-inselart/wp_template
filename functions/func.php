<?php

/*------------------------------
	関数定義
------------------------------*/

function page_title(){ //ページタイトル
	if ( !is_home() ){
		wp_title('|', true, 'right');
	}
	bloginfo('name');
}

function get_meta_description() {
  global $post;
  $description = "";
  if ( is_home() ) {
    // ホームでは、ブログの説明文を取得
    $description = get_bloginfo( 'description' );
  }
  elseif ( is_category() ) {
    // カテゴリーページでは、カテゴリーの説明文を取得
    $description = category_description();
  }
  elseif ( is_single() ) {
    if ($post->post_excerpt) {
      // 記事ページでは、記事本文から抜粋を取得
      $description = $post->post_excerpt;
    } else {
      // post_excerpt で取れない時は、自力で記事の冒頭100文字を抜粋して取得
      $description = strip_tags($post->post_content);
      $description = str_replace("\n", "", $description);
      $description = str_replace("\r", "", $description);
      $description = mb_substr($description, 0, 100) . "...";
    }
  } else {
    ;
  }
 
  return $description;
}

function my_post_title () {
	global $post;
	if (mb_strlen($post->post_title, 'UTF-8')>80){
		$title= mb_substr($post->post_title, 0, 80, 'UTF-8');
		echo $title.'…';
	} else {
		echo $post->post_title;
	}
}

function my_thumbnail($size = 'size01', $default = true){ // アーカイブページ サムネ
    if ( has_post_thumbnail()){
        the_post_thumbnail('size01');
    } elseif ( $default ) {
        echo '<img src="' . get_template_directory_uri() . '/image_common/no-image01.png">';
    }
}

// カテゴリー関連
function return_category($type = 'id') {
	$cat = get_the_category();
	$cat_id = $cat[0]->cat_ID;
	$cat_name = $cat[0]->name;
	switch ($type) {
		case 'id':
			return $cat_id;
			break;
		case 'name':
			return $cat_name;
			break;
		default:
			break;
	}
}

// タクソノミー
function return_taxonomy($taxonomy, $type = 'id') {
	$post_id = get_the_ID();
	$terms = get_the_terms($post_id, $taxonomy);
	$terms_id = $terms[0]->term_id;
	$terms_name = $terms[0]->name;
	switch ($type) {
		case 'id':
			return $terms_id;
			break;
		case 'name':
			return $terms_name;
			break;
		default:
			break;
	}
}

// 
function return_index($num) {
	if($num < 9) {
		$new_num = '0' . ($num + 1);
	} else {
		$new_num = $num + 1;
	}
	return $new_num;
}

/*------------------------------
	ユーザーエージェントを判定するための関数
------------------------------*/
function is_mobile() {

 //タブレットも含める場合はwp_is_mobile()

 $match = 0;

 $ua = array(
   'iPhone', // iPhone
   'iPod', // iPod touch
   'Android.*Mobile', // 1.5+ Android *** Only mobile
   'Windows.*Phone', // *** Windows Phone
   'dream', // Pre 1.5 Android
   'CUPCAKE', // 1.5+ Android
   'BlackBerry', // BlackBerry
   'BB10', // BlackBerry10
   'webOS', // Palm Pre Experimental
   'incognito', // Other iPhone browser
   'webmate' // Other iPhone browser
 );

 $pattern = '/' . implode( '|', $ua ) . '/i';
 $match   = preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] );

 if ( $match === 1 ) {
   return TRUE;
 } else {
   return FALSE;
 }

}

/*------------------------------
	デバッグ
------------------------------*/

function my_var_dump($expression) {
	echo '<pre>';
	var_dump($expression);
	echo '</pre>';
}

?>