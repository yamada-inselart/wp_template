<?php get_header(); ?>
  
<div class="content">
	<div class="inner clearfix">
  	
		<div class="mainContent">
			<?php get_template_part('loop', 'main'); ?>
		</div>

		<aside class="sideContent">
			<?php get_template_part('sidebar'); ?>
		</aside>
		
	</div>
</div>
    
<?php get_footer(); ?>