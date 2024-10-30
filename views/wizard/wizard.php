<?php
/**
 * This Template is used for Wizard
 *
 * @author  Tech Banker
 * @package limit-attempts-booster/views/wizard
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! is_user_logged_in() ) {
	return;
} else {
	$access_granted = false;
	foreach ( $user_role_permission as $permission ) {
		if ( current_user_can( $permission ) ) {
			$access_granted = true;
			break;
		}
	}
	if ( ! $access_granted ) {
		return;
	} else {
		$limit_attempts_check_status = wp_create_nonce( 'limit_attempts_check_status' );
		?>
		<html>
			<body>
				<div><div><div>
				<div class="page-container header-wizard">
					<div class="page-content">
						<div class="row row-custom">
							<div class="col-md-12 textalign">
								<p><?php echo esc_attr( _e( 'Hi there!', 'limit-attempts-booster' ) ); ?></p>
								<p><?php echo esc_attr( _e( 'Don\'t ever miss an opportunity to opt in for Email Notifications / Announcements about exciting New Features and Update Releases', 'limit-attempts-booster' ) ); ?></p>
								<p><?php echo esc_attr( _e( 'Contribute in helping us making our plugin compatible with most plugins and themes by allowing to share non-sensitive information about your website', 'limit-attempts-booster' ) ); ?></p>
								<p><?php echo esc_attr( _e( 'If you opt in, some data about your usage of Limit Attempts Booster Plugin will be sent to our servers for Compatiblity Testing Purposes and email notifications.', 'limit-attempts-booster' ) ); ?></p>
							</div>
						</div>
						<div class="row row-custom">
							<div class="col-md-12">
								<div style="padding-left: 40px;">
									<label style="font-size:16px;" class="control-label">
										<?php echo esc_attr( _e( 'Email Address for Notifications', 'limit-attempts-booster' ) ); ?>:
										</label>
										<span id="ux_txt_validation_gdpr_limit_attempt_booster" style="display:none;vertical-align:middle;">*</span>
										<input type="text" style="width: 90%;" class="form-control" name="ux_txt_email_address_notifications" id="ux_txt_email_address_notifications" value="">
									</div>
									<div class="textalign">
										<p><?php echo esc_attr( _e( 'If you\'re not ready to Opt-In, that\'s ok too!', 'limit-attempts-booster' ) ); ?></p>
										<p><strong><?php echo esc_attr( _e( 'Limit Attempts Booster will still work fine', 'limit-attempts-booster' ) ); ?></strong></p>
									</div>
									<a class="permissions" onclick="show_hide_details_limit_attempts();"><?php echo esc_attr( _e( 'What permissions are being granted?', 'limit-attempts-booster' ) ); ?></a>
								</div>
								<div class="col-md-12" style="display:none;" id="ux_div_wizard_set_up">
									<div class="col-md-6">
										<ul>
											<li>
												<i class="dashicons dashicons-admin-users lab-dashicons-admin-users"></i>
												<div class="admin">
													<span><strong><?php echo esc_attr( _e( 'User Details', 'limit-attempts-booster' ) ); ?></strong></span>
													<p><?php echo esc_attr( _e( 'Name and Email Address', 'limit-attempts-booster' ) ); ?></p>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-md-6 align align2">
										<ul>
											<li>
												<i class="dashicons dashicons-admin-plugins lab-dashicons-admin-plugins"></i>
												<div class="admin-plugins">
													<span><strong><?php echo esc_attr( _e( 'Current Plugin Status', 'limit-attempts-booster' ) ); ?></strong></span>
													<p><?php echo esc_attr( _e( 'Activation, Deactivation and Uninstall', 'limit-attempts-booster' ) ); ?></p>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-md-6">
										<ul>
											<li>
												<i class="dashicons dashicons-testimonial lab-dashicons-testimonial"></i>
												<div class="testimonial">
													<span><strong><?php echo esc_attr( _e( 'Notifications', 'limit-attempts-booster' ) ); ?></strong></span>
													<p><?php echo esc_attr( _e( 'Updates &amp; Announcements', 'limit-attempts-booster' ) ); ?></p>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-md-6 align2">
										<ul>
											<li>
												<i class="dashicons dashicons-welcome-view-site lab-dashicons-welcome-view-site"></i>
												<div class="settings">
													<span><strong><?php echo esc_attr( _e( 'Website Overview', 'limit-attempts-booster' ) ); ?></strong></span>
													<p><?php echo esc_attr( _e( 'Site URL, WP Version, PHP Info, Plugins &amp; Themes Info', 'limit-attempts-booster' ) ); ?></p>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-12 allow">
									<div class="tech-banker-actions">
										<a onclick="plugin_stats_limit_attempts('opt_in');" class="button button-primary-wizard">
											<strong><?php echo esc_attr( _e( 'Opt-In &amp; Continue', 'limit-attempts-booster' ) ); ?> </strong>
											<i class="dashicons dashicons-arrow-right-alt lab-dashicons-arrow-right-alt"></i>
										</a>
										<a onclick="plugin_stats_limit_attempts('skip');" class="button button-secondary-wizard" tabindex="2">
											<strong><?php echo esc_attr( _e( 'Skip &amp; Continue', 'limit-attempts-booster' ) ); ?> </strong>
											<i class="dashicons dashicons-arrow-right-alt lab-dashicons-arrow-right-alt"></i>
										</a>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="col-md-12 terms">
									<a href="https://tech-banker.com/privacy-policy/" target="_blank"><?php echo esc_attr( _e( 'Privacy Policy', 'limit-attempts-booster' ) ); ?></a>
									<span> - </span>
									<a href="https://tech-banker.com/terms-and-conditions/" target="_blank"><?php echo esc_attr( _e( 'Terms &amp; Conditions', 'limit-attempts-booster' ) ); ?></a>
								</div>
							</div>
					</div>
				</div>
			</body>
		</html>
		<?php
	}
}
