<meta property="og:type" content="blog">
<?php
if (is_single()){
if(have_posts()): while(have_posts()): the_post();
  echo '<meta property="og:description" content="'.mb_substr(get_the_excerpt(), 0, 100).'">';echo "\n";
endwhile; endif;
  echo '<meta property="og:title" content="';
  $post_title_array = get_post_meta($post->ID,'title');

  if (isset($post_title_array[0]) and ($post_title_array[0] != "")) {
      $page_title = $post_title_array[0];
      echo($page_title);
  } else {
      page_title();
  }
  echo '">';echo "\n";
  echo '<meta property="og:url" content="'; the_permalink(); echo '">';echo "\n";
} else {
  echo '<meta property="og:description" content="'; bloginfo('description'); echo '">';echo "\n";
  echo '<meta property="og:title" content="'; bloginfo('name'); echo '">';echo "\n";
  echo '<meta property="og:url" content="'; bloginfo('url'); echo '">';echo "\n";
}
$str = $post->post_content;
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
$ogp_image = get_template_directory_uri() . '/image_common/ogp.png';
if (is_single()){	
  if (has_post_thumbnail()){
    $image_id = get_post_thumbnail_id();
    $image = wp_get_attachment_image_src( $image_id, 'full');
	  
    echo '<meta property="og:image" content="'.$image[0].'">';echo "\n";
  } else if ( preg_match( $searchPattern, $str, $imgurl ) && !is_archive()) {
    echo '<meta property="og:image" content="'.$imgurl[2].'">';echo "\n";
  } else {
    echo '<meta property="og:image" content="'.$ogp_image.'">';echo "\n";
  }
} else {
  echo '<meta property="og:image" content="'.$ogp_image.'">';echo "\n";
}
?>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="ja_JP" />
<!--<meta property="fb:app_id" content="App-ID（15文字の半角数字）">-->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@shuwriters">