<?php 

/* Template Name: Member Dashbord */

get_header(); ?>
	
	<?php if(have_posts()) : ?>
		
		<div class="content"> 
		
			<div class="main">
			
			<section>
			
				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-6 text-center" style="float:right;">
				<div class="header_tab list-group list-group-horizontal">
					<ul>
						<li class="list-group-item"><a href="http://localhost/printedwine/member-dashboard/edit-account/">My Profile</a></li>
                                                <li class="list-group-item"><a href="http://localhost/printedwine/member-dashboard/artist_profile/">Artist Profile</a></li>
						<li class="list-group-item"><a href="http://localhost/printedwine/member-dashboard/my_gallery/">My Gallery</a></li>
						<li class="list-group-item"><a href="#">Sales</a></li>
						<li class="list-group-item"><a href="#">Purchase History</a></li>
						<li class="list-group-item active"><a href="#">My Details</a></li>
					</ul>
				</div>
				</div>
			<article>
				
				<h4 class="postTitle"><?php the_title(); ?></h4>
 
			<?php the_content(); ?>
			</article>
			</section>
			</div>
		</div>
	
	<?php endif; ?>
 
 <?php get_footer(); ?>