<?php
$post_title_tag = $opt['style']=='list' ? 'li' : 'h5';

$reviewsBlock = '';
if ( !in_array($opt['style'], array('accordion_1', 'accordion_2', 'accordion_3', 'list')) && $opt['reviews'] && get_custom_option('show_reviews', null, $post_data['post_id'])=='yes' ) {
	$avg_author = $post_data['post_reviews_'.(get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
	if ($avg_author > 0) {
		$reviewsBlock .= '<div class="reviews_summary blog_reviews">'
			.'<div class="criteria_summary criteria_row">' . getReviewsSummaryStars($avg_author) . '</div>'
			.'</div>';
	}
}

$title = '<' . $post_title_tag .' class="sc_blogger_title sc_title'.(in_array($opt['style'], array('accordion_1', 'accordion_2', 'accordion_3')) ? ' sc_toggl_title' : '').'">'
		.(in_array($opt['style'], array('accordion_1', 'accordion_2', 'accordion_3')) ? '' : '<a href="'.$post_data['post_link'].'">')
		.$post_data['post_title'] 
		.(in_array($opt['style'], array('accordion_1', 'accordion_2', 'accordion_3')) ? '' : '</a>')
	.'</'.$post_title_tag.'>';

$thumb = $post_data['post_thumb'] && themerex_strpos($opt['style'], 'image')!==false
			? ('<div class="thumb">'.($post_data['post_link']!='' ? '<a href="'.$post_data['post_link'].'">'.$post_data['post_thumb'].'</a>' : $post_data['post_thumb']).'</div>')
			: '';
$info = sc_param_is_on($opt['info']) ? '<div class="sc_blogger_info">'
	.(themerex_strpos($opt['style'], 'image')!==false || themerex_strpos($opt['style'], 'accordion')!==false ?
		'<div class="sc_blogger_author">'.__('Posted by', 'themerex')
		: __('Posted by', 'themerex')).' <a href="'.$post_data['post_author_url'].'" class="post_author">'.$post_data['post_author'].'</a>'
	.($opt['counters']!='none' 
		? (' <span class="separator">|</span> '
			.($opt['orderby']=='comments' || $opt['counters']=='comments' ? __('Comments', 'themerex') : __('Views', 'themerex'))
			.' <span class="comments_number">'.($opt['orderby']=='comments' || $opt['counters']=='comments' ? $post_data['post_comments'] : $post_data['post_views']).'</span>'
		  )
		: '')
	.(themerex_strpos($opt['style'], 'image')!==false || themerex_strpos($opt['style'], 'accordion')!==false ? '</div>'.do_shortcode('[trx_button link="'.$post_data['post_link'].'" skin="dark" style="line" size="mini" text="'.($opt['readmore'] ? $opt['readmore'] : __('Read more', 'themerex')).'"]') : '').'</div>' : '';

if ($opt['style'] == 'list') {
	echo $title;
} else {
	if ($opt['dir'] == 'horizontal') { ?>
		<div class="sc_columns_item column_item_<?php echo esc_attr($opt['number']); ?><?php 
			echo ($opt['number'] % 2 == 1 ? ' odd' : ' even')
				.($opt['number'] == 1 ? ' first' : '')
				.($opt['number'] == $opt['posts_on_page'] ? ' last' : '')
				.(sc_param_is_on($opt['scroll']) ? ' sc_scroll_slide swiper-slide' : '');
				?>">
		<?php
	}
?>
<article class="sc_blogger_item <?php
	echo (in_array($opt['style'], array('accordion_1', 'accordion_2','accordion_3')) ? ' sc_toggl_item' : '')
		.($opt['number'] == $opt['posts_on_page'] ? ' sc_blogger_item_last' : '')
		.(sc_param_is_on($opt['scroll']) && ($opt['dir'] == 'vertical' || $opt['style'] == 'date') ? ' sc_scroll_slide swiper-slide' : '');
		?>">

	<?php
	if ($opt['style'] == 'date') {
	?>
		<div class="sc_blogger_date">
			<span class="day_month"><?php echo date('d.m', strtotime($post_data['post_date_sql'])); ?></span>
			<span class="year"><?php echo date('Y', strtotime($post_data['post_date_sql'])); ?></span>
		</div>
	<?php 
	}

	if (in_array($opt['style'], array('image_large', 'image_tiny')) && $thumb) {
		echo $thumb;
	}

	//if (get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')))
		echo $title;

	if ($opt['style'] != 'date') {
		?>
		<div class="sc_<?php echo in_array($opt['style'], array('accordion_1', 'accordion_2','accordion_3')) ? 'toggl' : 'blogger'; ?>_content">
		<?php
	}
	
	if (in_array($opt['style'], array('date'))) {
		echo $info;
	}

	if (in_array($opt['style'], array('image_small', 'image_medium')) && $thumb) {
		echo $thumb;
	}

	if ($opt['style']!='date' && $opt['descr'] > 0) {
		if (!in_array($post_data['post_format'], array('quote', 'link')) && themerex_strlen($post_data['post_excerpt']) > $opt['descr']) {
			$post_data['post_excerpt'] = getShortString(strip_tags($post_data['post_excerpt']), $opt['descr'], $opt['readmore'] ? '' : '...');
		}
		echo $post_data['post_excerpt'];
	}

	if (in_array($opt['style'], array('accordion_1', 'accordion_2','accordion_3'))) {
		echo $info;
	}

	if ($opt['style'] != 'date') {
		?>
		</div>
		<?php
	}

	if (!in_array($opt['style'], array('date', 'accordion_1', 'accordion_2','accordion_3'))) {
		echo $info;
	}
	?>
</article>
<?php
	if ($opt['dir'] == 'horizontal') {
		echo '</div>';
	}
}
?>