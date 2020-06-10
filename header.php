<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php page_title(); ?></title>
<meta name="description" content="<?php echo get_meta_description(); ?>">
<meta name="Keywords" content="">

<?php get_template_part( 'ogp' ) ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- fontawesome -->

<!--
<script src="/js/jquery-1.11.2.min.js"></script> 最新版があればダウンロード ※~IE8対応の場合は、jQuery1.xの最新版 -->

<!-- /javascript -->

<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
<![endif]-->

<?php wp_head(); ?>
</head>
<body>
	<div class="wrap">
	
	<!-- テンプレート -->
	<header id="gHead">
		<div class="inner">
			<h1 class="header_tit">サイトヘッダー</h1>
		</div>
	</header>

	<?php
		if(function_exists('breadcrumb')) { breadcrumb(); }
	?>
	