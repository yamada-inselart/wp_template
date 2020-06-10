<?php
if(have_posts() ):
	while(have_posts() ): the_post();
?>

<article class="archive_list wp_article mb60">
	<header class="article_head mb15">
		<div class="article_info clearfix mb5">
			<p class="article_date"><time datetime="<?php the_time('Y-n-j') ?>"><?php the_time('Y.n.j'); ?></time></p>
			<div class="article_cat"><?php the_category(); ?></div>
		</div>
		<h1 class="article_tit"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</header>
	<div class="article_content">
		<p class="article_txt01"><?php the_excerpt(); ?></p>
	</div>
</article>

<?php
	endwhile;
	if(function_exists('wp_pagenavi')):
		wp_pagenavi();
	endif;
else:
?>

<p class="no-article">記事はありません。</p>

<?php
endif;
?>
 