<?php
/**
 * The template for displaying the footer.
 * @package Wine
 */
global $logo_footer;

$body_style = get_custom_option('body_style');
$side_bar = 'fullWidth';
$fstyle = strpos(get_custom_option('blog_style'), 'portfolio') !== false;

echo ($body_style == 'boxed' && $side_bar != 'fullWidth' && !$fstyle) ? '</div><!-- /.main -->' : ''
?>
</div><!-- /.wrapContent > /.content -->
<?php // get_sidebar(); //sidebar ?>
</div><!-- /.wrapContent > /.wrapWide -->
</div><!-- /.wrapContent -->

<?php
// ----------------- Google map -----------------------
if (get_custom_option('googlemap_show') == 'yes') {
    $map_address = get_custom_option('googlemap_address');
    $map_latlng = get_custom_option('googlemap_latlng');
    $map_zoom = get_custom_option('googlemap_zoom');
    $map_scroll = get_custom_option('googlemap_scroll');
    $map_style = get_custom_option('googlemap_style');
    if (!empty($map_address) || !empty($map_latlng)) {

        echo do_shortcode('[trx_googlemap id="footer" latlng="' . $map_latlng . '" address="' . $map_address . '" zoom="' . $map_zoom . '" scroll="' . $map_scroll . '" style="' . $map_style . '" width="100%" height="350"]');
    }
}


// -------------- footer -------------- 
$footer_widget = (get_custom_option('show_sidebar_footer') == 'yes' && is_active_sidebar(get_custom_option('sidebar_footer')));
$copyright = sc_param_is_on(get_custom_option('show_copyright'));
if ($footer_widget || $copyright) {
    ?>  

    <div class="login_slot">
    <?php if (!is_front_page()) : ?> 
        <div class="footer_top_ext"><h2>Your best prints will tell lasting stories</h2></div>
    <?php endif; ?>   

        <div class="main">
            <div class="sc_columns_4 sc_columns_indent">
                <div class="sc_columns_item widget-number-1"><h3 class="sign_text">SIGNUP FOR SPECIALS!</h3></div>
                <div class="sc_columns_item widget-number-2">
                    <div class="sassy-textfiald">
                        <input type="text" placeholder="First Name" id="mce-FNAME" class="" name="FNAME" value="">
                    </div>
                </div>
                <div class="sc_columns_item widget-number-3">
                    <div class="sassy-textfiald ">
                        <input type="email" placeholder="Email Address" id="mce-EMAIL" class="required email" name="EMAIL" value="">
                    </div>
                </div>
                <div class="sc_columns_item widget-number-4">
                    <div class="sassy-submitfiald"><input type="submit" id="mc-embedded-subscribe" name="subscribe" value="GO">
                    </div>
                </div>
            </div>
        </div>	
    </div> 
    <footer <?php echo $footer_widget ? 'class="footerWidget"' : '' ?>>
        <div class="main">
            <div class="sc_columns_5 sc_columns_indent">
                <div class="widget_area">
                    <?php
                    // ---------------- Footer sidebar ----------------------
                    if ($footer_widget) {
                        global $THEMEREX_CURRENT_SIDEBAR;
                        $THEMEREX_CURRENT_SIDEBAR = 'footer';
                        do_action('before_sidebar');
                        if (!dynamic_sidebar(get_custom_option('sidebar_footer'))) {
                            // Put here html if user no set widgets in sidebar
                        }
                    }
                    ?>

                    <?php
                    $copy_footer = get_theme_option('footer_copyright');
                    if ($copy_footer != '' && $copyright) {
                        ?><div class="copy_text_left"><?php
                            print str_replace('[year]', date('Y'), $copy_footer);
                            ?></div><?php }
                        ?>
                    <?php
                        $credits_footer = get_theme_option('footer_credits');
                        if ($credits_footer != '' && $credits_footer) {
                            ?><div class="copyright_text"><?php
                        echo $credits_footer;
                        ?></div><?php }
                    ?>
                    <div class="clear"></div>	  
                </div>
            </div>
        </div>
        <!-- /footer.main -->
    </footer>
<?php } ?>


</div><!-- /.wrapBox -->
</div><!-- /.wrap -->


<div class="buttonScrollUp upToScroll icon-up-open-micro"></div>



<?php
require(get_stylesheet_directory() . '/templates/page-part-login.php');
require(get_template_directory() . '/templates/page-part-js-messages.php');
require(get_template_directory() . '/templates/page-part-customizer.php');
wp_footer();
?>
</body>
</html>
