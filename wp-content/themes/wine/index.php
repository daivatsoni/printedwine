<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wine
 */

get_header(); 

global $THEMEREX_only_reviews, $THEMEREX_only_video, $THEMEREX_only_audio, $THEMEREX_only_gallery, $THEMEREX_ajaxcrop;
global $wp_query, $post;

$blog_style = get_custom_option('blog_style');
$show_sidebar_main = get_custom_option('show_sidebar_main');
$ppp = (int) get_custom_option('posts_per_page');
$cube_ajax = sc_param_is_on(get_custom_option('cube_ajax')) ? ' singeAjaxLoad' : '';

$page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
$wp_query_need_restore = false;
$pagination_style = get_custom_option('blog_pagination');
$ajax_load = $pagination_style == 'viewmore' || $pagination_style == 'infinite'  ? ' ajaxContainer' : '';


$args = $wp_query->query_vars;

if ( is_page() || isset($THEMEREX_only_reviews) || isset($THEMEREX_only_video) || isset($THEMEREX_only_audio) || isset($THEMEREX_only_gallery) ) {
	$args['post_type'] = 'post';
	$args['post_status'] = current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish';
	unset($args['p']);
	unset($args['page_id']);
	unset($args['pagename']);
	unset($args['name']);
	$args['posts_per_page'] = $ppp;
	if ($page_number > 1) {
		$args['paged'] = $page_number;
		$args['ignore_sticky_posts'] = 1;
	}
	if (isset($THEMEREX_only_reviews)) {
		$args['meta_query'] = array(
			   array(
				   'key' => 'reviews_avg',
				   'value' => 0,
				   'compare' => '>',
				   'type' => 'NUMERIC'
			   )
		);
	} else if (isset($THEMEREX_only_video)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-video' )
			)
		);
	} else if (isset($THEMEREX_only_audio)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-audio' )
			)
		);
	} else if (isset($THEMEREX_only_gallery)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-gallery' )
			)
		);
	}
	$args = addSortOrderInQuery($args);
	query_posts( $args );
	$wp_query_need_restore = true;
}

$per_page = count($wp_query->posts);

$post_number = 0;

$parent_cat_id = (int) get_custom_option('category_id');
$accent_color = '';

$flt_ids = array();

if ((themerex_strpos($blog_style, 'masonry')!==false || themerex_strpos($blog_style, 'portfolio')!==false ) && !is_404() && have_posts() ) {
	$filtr = sc_param_is_on(get_custom_option('show_filters'));

	$folio_size = array(
			'portfolio_mini' => '300', 
			'portfolio_medium' => '450', 
			'portfolio_big' => '600'
			);
?>
	<div class="masonryWrap">
		<?php if($filtr) { ?><div class="isotopeFiltr"></div><?php } ?>
		<section class="masonryStyle isotopeWrap  <?php echo esc_attr($blog_style.$cube_ajax.$ajax_load); ?>" data-foliosize="<?php echo esc_attr( (int) $folio_size[$blog_style]); ?>">
<?php
} else { ?>
	<section class="<?php echo esc_attr($ajax_load); ?>">
<?php }

$THEMEREX_ajaxcrop = themerex_strpos($blog_style, 'portfolio')!==false ? false : true;
while ( have_posts() ) { the_post(); 
	
	$post_number++;

	//clear_dedicated_content();
	$args2 = array(
		'layout' =>  in_array(themerex_substr($blog_style, 0, 7), array('excerpt', 'masonry', 'portfol')) ? themerex_substr($blog_style, 0, 7) : $blog_style,
		'number' => $post_number,
		'add_view_more' => false,
		'posts_on_page' => $per_page,
		// Get post data
		'thumb_size' => 'image_large',
		'thumb_crop' => themerex_strpos($blog_style, 'masonry')===false,
		'strip_teaser' => false,
		'parent_cat_id' => $parent_cat_id,
		'sidebar' => !in_array($show_sidebar_main, array('none', 'fullwidth'))
	);
	$post_data = getPostData($args2);
	showPostLayout($args2, $post_data);

	//clear_dedicated_content();

	if (get_custom_option('show_filters')=='yes') {
		if (get_custom_option('filter_taxonomy')=='tags') {			// Use tags as filter items
			if (count($post_data['post_tags_list']) > 0 && $post_data['post_tags_list'] != false) {
				foreach ($post_data['post_tags_list'] as $tag) {
					$flt_ids[$tag->term_id] = $tag->name;
				}
			}
		}
	}
}

if (!$post_number) { 
	if ( is_404() ) {
		showPostLayout( array('layout' => '404'), false );
	} else if ( is_search() ) {
		showPostLayout( array('layout' => 'no-search-results'), false );
	} else {
		showPostLayout( array('layout' => 'no-articles'), false );
	}
} else {
	// Isotope filters list
	$ppp = (int) get_custom_option('posts_per_page');
	$filters = '';
	if (get_custom_option('show_filters')=='yes') {
		if (get_custom_option('filter_taxonomy')=='categories') {			// Use categories as filter items
			$cat_id = (int) get_query_var('cat');
			$portfolio_parent = max(0, is_category() ? getParentCategoryByProperty($cat_id, 'show_filters', 'yes') : 0);
			$args = array(
				'type'          => 'post',
				'child_of'      => $portfolio_parent,
				'orderby'       => 'name',
				'order'         => 'ASC',
				'hide_empty'    => 1,
				'hierarchical'  => 0,
				'exclude'       => '',
				'include'       => '',
				'number'        => '',
				'taxonomy'      => 'category',
				'pad_counts'    => false );
			$portfolio_list = get_categories($args);
			if (count($portfolio_list) > 0) {
				$filters .= '<li class="'.($portfolio_parent==$cat_id ? ' active' : '').'"><a href="#" data-filter="*">'.__('All', 'themerex').'</a></li>';
				foreach ($portfolio_list as $cat) {
					$filters .= '<li class="'.($cat->term_id==$cat_id ? ' active' : '').'"><a href="#" data-filter=".flt_'.$cat->term_id.'">'.$cat->name.'</a></li>';
				}
			}
		} else {															// Use tags as filter items
			if (count($flt_ids) > 0) {
				$filters .= '<li class="active"><a href="#" data-filter="*">'.__('All', 'themerex').'</a></li>';
				foreach ($flt_ids as $flt_id=>$flt_name) {
					$filters .= '<li><a href="#" data-filter=".flt_'.$flt_id.'">'.$flt_name.'</a></li>';
				}
			}
		}
		if ($filters) {
			$filters = '<ul>'.$filters.'</ul>';
			?>
			<script type="text/javascript">
				var ppp = <?php echo esc_attr((int)$ppp); ?>;
				jQuery(document).ready(function () {
					jQuery(".isotopeFiltr").append('<?php echo $filters; ?>');
				});
			</script>
			<?php
		}
	}



if ((themerex_strpos($blog_style, 'masonry')!==false || themerex_strpos($blog_style, 'portfolio')!==false ) &&  !is_404() && have_posts() ) { ?>
		</section>
	</div>
<?php
} else { ?>
	</section>
<?php }

	// Pagination
	if (in_array($pagination_style, array('viewmore', 'infinite'))) {
		if ($page_number < $wp_query->max_num_pages) {
			?>
			<div id="viewmore_link" class="viewmore pagination_<?php echo esc_attr($pagination_style); ?>">

				<?php echo '<a href="#" class="sc_button  sc_button_skin_global sc_button_style_line sc_button_size_big"><span class="viewmore_text">'.__('View more', 'themerex').'</span></a>'; ?>
				<div class="viewmore_loader">
					<span class="viewmore_preloader sc_loader_show"></span>
				</div>

				<script type="text/javascript">
					var THEMEREX_VIEWMORE_PAGE = <?php echo esc_attr( (int) $page_number); ?>;
					var THEMEREX_VIEWMORE_DATA = '<?php echo serialize($args); ?>';
					var THEMEREX_VIEWMORE_VARS = '<?php echo serialize(array(
					'blog_style' => $blog_style,
					'show_sidebar_main' => $show_sidebar_main,
					'parent_cat_id' => $parent_cat_id,
					'ppp' => $ppp
					)); ?>';
				</script>
			</div>
			<?php
		}
	} else
		showPagination();
	}



if ( $wp_query_need_restore ) wp_reset_query();
wp_reset_postdata();

get_footer();
?>