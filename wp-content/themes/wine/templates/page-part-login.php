<?php if (!is_user_logged_in() && get_theme_option('show_login')=='yes') { 
			themerex_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
			themerex_enqueue_script('jquery-effects-slide', false, array('jquery','jquery-effects-core'), null, true);
	?>
	<div id="user-popUp" class="user-popUp mfp-with-anim mfp-hide">
		<div class="sc_tabs sc_tabs sc_tabs_style_1 sc_tabs_effects ">
			<ul class="sc_tabs_titles">
				<li><a href="#loginForm" class="loginFormTab">Log In</a></li>
				<li><a href="#registerForm" class="registerFormTab"><?php _e('Create an Account', 'themerex'); ?></a></li>
			</ul>
			
			<div class="sc_tabs_array">
			<div id="loginForm" class="formItems loginFormBody sc_columns_2">
				<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="formValid">
				<div class="sc_columns_item">
						<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />
						<ul class="formList">
							<li class="formLogin"><input type="text" id="login" name="log" value="" placeholder="<?php _e('Email', 'themerex'); ?>"></li>
							<li class="formPass"><input type="password" id="password" name="pwd" value="" placeholder="<?php _e('Password', 'themerex'); ?>"></li>
							<li class="remember">
								<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgotPwd"><?php _e('Forgot password?', 'themerex'); ?></a>
								<input type="checkbox" value="forever" id="rememberme" name="rememberme">
								<label for="rememberme"><?php _e('Remember me', 'themerex'); ?></label>
							</li>
							<li class="formButton"><a href="#" class="sendEnter enter sc_button sc_button_skin_global sc_button_style_bg sc_button_size_medium"><?php _e('Login', 'themerex'); ?></a></li>
						</ul>
				</div>

				<div class="sc_columns_item">
					<ul class="formList">
						<li>You can login using your social profile</li>
						<li class="loginSoc">
							<a href="#" class="iconLogin fb icon-facebook"></a>
							<a href="#" class="iconLogin tw icon-twitter"></a>
							<a href="#" class="iconLogin gg icon-gplus"></a>
						</li>
						<li><a href="#">Problem with login?</a></li>
					</ul>
				</div>
				<div class="sc_result result sc_infobox sc_infobox_closeable"></div>
				</form>
			</div>

			<div id="registerForm" class="formItems registerFormBody sc_columns_2">
				<form name="register_form" method="post" class="formValid">
					<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>"/>
					<div class="sc_columns_item">
						<ul class="formList">
							<li class="formUser"><input type="text" id="registration_username" name="registration_username"  value="" placeholder="<?php _e('User name (login)', 'themerex'); ?>"></li>
							<li class="formLogin"><input type="text" id="registration_email" name="registration_email" value="" placeholder="<?php _e('E-mail', 'themerex'); ?>"></li>
							<li class="i-agree">
								<input type="checkbox" value="forever" id="i-agree" name="i-agree">
								<label for="i-agree"><?php _e('I agree with', 'themerex'); ?></label> <a href="#"><?php _e('Terms & Conditionst', 'themerex'); ?></a>
							</li>
							<li class="formButton"><a href="" class="sendEnter enter sc_button sc_button_skin_dark sc_button_style_bg sc_button_size_medium">Sing UP</a></li>
						</ul>
					</div>
					<div class="sc_columns_item">
						<ul class="formList">
							<li class="formPass"><input type="password" id="registration_pwd" name="registration_pwd" value="" placeholder="<?php _e('Password', 'themerex'); ?>"></li>
							<li class="formPass"><input type="password" id="registration_pwd2" name="registration_pwd2" value="" placeholder="<?php _e('Confirm Password', 'themerex'); ?>"></li>
						</ul>
					</div>
					<div class="sc_result result sc_infobox sc_infobox_closeable"></div>
				</form>
			</div>
			</div>
		</div>	<!-- /.sc_tabs -->
	</div>		<!-- /.user-popUp -->
<?php } ?>
