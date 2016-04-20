<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. 
 *
 * @package Wine
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;

	if ( have_comments() ) {

	//avatar settings
	global $avatar_show;
	$avatar_show = get_custom_option('show_avatar_comments') == 'yes';
?>

	<section class="comments <?php echo $avatar_show ? 'avatars' : '' ?>" id="comments">
		<h2 class="commentsTitle"><?php echo $post_comments = get_comments_number(); ?> <?php echo $post_comments==1 ? __('Comment', 'themerex') : __('Comments', 'themerex'); ?></h2>
		<ul class="commentsList">
		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use vc_theme_comment() to format the comments.
			 */
			wp_list_comments( array( 'callback' => 'single_comment_output') );
		?>
		</ul><!-- .comments_list -->
		<?php if ( !comments_open() && get_comments_number()!=0 && post_type_supports( get_post_type(), 'comments' ) ) { ?>
			<p class="no_comments"><?php _e( 'Comments are closed.', 'themerex' ); ?></p>
		<?php }	?>
	</section><!-- .comments -->
<?php } ?>

<section class="formValid commForm">
		<h2>Leave a Reply</h2>
		<div class="sc_form"  data-formtype="comment">

			<?php
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? ' aria-required="true"' : '' );
			$comments_args = array(
					// change the id of send button 
					'id_submit'=>'send_comment',
					// change the title of send button 
					'label_submit'=>__('Post Comment', 'themerex'),
					// change the title of the reply section
					'title_reply'=>__('Reply', 'themerex'),
					// remove "Logged in as"
					'logged_in_as' => '',
					// remove text before textarea
					'comment_notes_before' => '',
					// remove text after textarea
					'comment_notes_after' => '',
					// redefine your own textarea (the comment body)
					'comment_field' => '<div class="sc_form_message">'
										.'<textarea placeholder="'. __('Your Message','themerex').'" id="comment" name="comment" class="textAreaSize" aria-required="true"></textarea>'
										.'</div>'
										.'<div class="sc_form_button">'
										.do_shortcode('[trx_button skin="dark" style="bg" link="#" size="big" fullsize="no" target="no" popup="no" text="'.__('Post comment', 'themerex').'"]')
										.'</div>'
										.'<div class="sc_result sc_infobox sc_infobox_closeable"></div>',
					'fields' => apply_filters( 'comment_form_default_fields', array(
						'author' => '<div class="sc_columns_3 sc_columns_indent">'
								. '<div class="sc_columns_item sc_form_username'.( $req ? ' required' : '' ).'">'
								. '<input placeholder="'. __('Name','themerex').'" id="author" name="author" type="text" value="'.esc_attr( isset($commenter['comment_author']) ? $commenter['comment_author'] : '' ).'" size="30"'.$aria_req.' />'
								. '</div>',
						'email' => '<div class="sc_columns_item sc_form_email'.( $req ? ' required' : '' ).'">'
								. '<input placeholder="'. __('Email','themerex').'" id="email" name="email" type="text" value="'.esc_attr(  isset($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '' ).'" size="30"'.$aria_req.' />'
								. '</div>',
						'url' => '<div class="sc_columns_item sc_form_site">'
								. '<input placeholder="'.__( 'Website','themerex').'" id="url" name="url" type="text" value="'.esc_attr(  isset($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '' ).'" size="30"'.$aria_req.' />'
								. '</div></div>'
					) )
			);
		
			comment_form($comments_args);
			?>
			<div class="nav_comments"><?php paginate_comments_links(); ?></div>
		</div>
</section><!-- .formValid -->
<?php 

function single_comment_output( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $avatar_show;
	switch ( $comment->comment_type ) :
		case 'pingback' :
			?>
			<li class="trackback">
				<p><?php _e( 'Trackback:', 'themerex' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'themerex' ), '<span class="edit-link">', '<span>' ); ?></p>
			<?php
			break;
		case 'trackback' :
			?>
			<li class="pingback">
				<p><?php _e( 'Pingback:', 'themerex' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'themerex' ), '<span class="edit-link">', '<span>' ); ?></p>
			<?php
			break;
		default :
			$author_id = $comment->user_id;
			$author_link = get_author_posts_url( $author_id );
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class('commItem'); ?>>
				
				<div class="commWrap">
				<?php if($avatar_show){ ?>
				<div class="commentAva"><?php 
					echo $author_id ? '<a href="'.$author_link.'">' : '';
					echo get_avatar( $comment, 60 );
					echo $author_id ? '</a>' : '' ;?>
				</div>
				<?php } ?>
				
				<div class="commentBody hoverUnderline">
				<div class="commentInfo">
					<span class="commAuthor">
						<?php
						$author_id ? print '<a href="'.$author_link.'">' : '';
						comment_author(); 
						$author_id ? print '</a>' : '';
						?>
					</span>
					<span class="commDate"><?php echo getDateOrDifference(get_comment_date('Y-m-d H:i:s')); ?></span>
					<span class="commReply"><?php 
						if ($depth < $args['max_depth']) { 
							comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
						} ?>
					</span>
				</div>

				<?php if ( $comment->comment_approved == 0 ) { ?>
					<div class="commentModeration"><span class="icon icon-attention"></span><?php _e( 'Your comment is awaiting moderation.', 'themerex' ); ?></div>
				<?php } ?>

				<div class="commentContent"> <?php comment_text(); ?> </div>
				</div>
				</div>
				
			<?php
			break;
	endswitch;
}
?>
