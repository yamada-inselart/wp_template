<?php get_header(); ?>
  
<div class="content">
	<div class="inner clearfix">
  	
		<div class="mainContent">
			<p class="search_tit mb15">「<?php the_search_query(); ?>」の検索結果</p>
			<?php get_template_part('loop', 'main'); ?>
		</div>

		<aside class="sideContent">
			<?php get_template_part('sidebar'); ?>
		</aside>
		
	</div>
</div>
    
<?php get_footer(); ?>