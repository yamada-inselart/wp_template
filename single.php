<?php get_header(); ?>
  
<div class="content">
	<div class="inner clearfix">
  	
		<main class="mainContent">
			<?php
			if(have_posts() ):
				while(have_posts() ): the_post();
			?>
			<article class="article_single wp_article">
				<header class="article_head">
					<div class="article_info clearfix mb15">
						<p class="article_date"><time datetime="<?php the_time('Y-n-j') ?>"><?php the_time('Y.n.j'); ?></time></p>
						<div class="article_cat"><?php the_category(); ?></div>
						<div class="article_tags"><?php the_tags('Tags '); ?></div>
					</div>
					<h1 class="article_tit"><?php the_title(); ?></h1>
				</header>
				<section class="article_content wp_content">
					<?php the_content(); ?>
				</section>
			</article>
			<?php
				endwhile;
			endif;
			?>
		</main>

		<aside class="sideContent">
			<?php get_template_part('sidebar'); ?>
		</aside>
		
	</div>
</div>
    
<?php get_footer(); ?>