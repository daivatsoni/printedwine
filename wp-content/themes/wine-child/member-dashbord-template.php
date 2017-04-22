<?php 

/* Template Name: Member Dashbord */

get_header(); ?>
	
	<?php if(have_posts()) : ?>
		
		<div class="content"> 
		
			<div class="main">
			
			<section>
			
			<article>
				
				<h4 class="postTitle"><?php the_title(); ?></h4>
 
			<?php the_content(); ?>
			</article>
			</section>
			</div>
		</div>
	
	<?php endif; ?>
 
 <?php get_footer(); ?>