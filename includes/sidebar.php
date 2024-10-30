<?php
/**
 * This file is used to display sidebar menu.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
if ( ! is_user_logged_in() ) {
	return;
} else {
	$access_granted = false;
	if ( isset( $user_role_permission ) && count( $user_role_permission ) > 0 ) {
		foreach ( $user_role_permission as $permission ) {
			if ( current_user_can( $permission ) ) {
				$access_granted = true;
				break;
			}
		}
	}
	if ( ! $access_granted ) {
		return;
	} else {
		?>
		<div class="page-sidebar-wrapper-tech-banker">
			<div class="page-sidebar-tech-banker navbar-collapse collapse">
				<div class="sidebar-menu-tech-banker">
					<ul class="page-sidebar-menu-tech-banker" data-slide-speed="200">
						<div class="sidebar-search-wrapper" style="padding:20px;text-align:center">
							<a class="plugin-logo" href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank">
								<img src="<?php echo esc_attr( plugins_url( 'assets/global/img/logo.png', dirname( __FILE__ ) ) ); ?>"/ alt="Limit Attempts Booster">
							</a>
						</div>
						<li class="" id="ux_li_dashboard">
							<a href="javascript:;">
								<i class="icon-custom-grid"></i>
								<span class="title">
									<?php echo esc_attr( $lab_dashboard_last10_logs ); ?>
								</span>
							</a>
							<ul class="sub-menu">
								<li id="ux_li_last_login">
									<a href="admin.php?page=lab_limit_attempts_booster">
										<i class="icon-custom-clock"></i>
										<span class="title">
											<?php echo esc_attr( $lab_login_logs ); ?>
										</span>
									</a>
								</li>
								<li id="ux_li_visitor_logs_dashboard">
									<a href="admin.php?page=lab_visitor_logs_dashboard">
										<i class="icon-custom-users"></i>
										<span class="title">
											<?php echo esc_attr( $lab_visitor_logs_menu ); ?>
										</span>
									</a>
								</li>
								<li id="ux_li_last_blocked_ip">
									<a href="admin.php?page=lab_last_blocked_ip_addresses">
										<i class=icon-custom-globe></i>
										<span class="title">
											<?php echo esc_attr( $lab_blocked_ip_addresses_menu ); ?>
										</span>
									</a>
								</li>
								<li id="ux_li_last_blocked_ip_range">
									<a href="admin.php?page=lab_last_blocked_ip_ranges">
										<i class="icon-custom-wrench"></i>
										<span class="title">
											<?php echo esc_attr( $lab_blocked_ip_ranges_menu ); ?>
										</span>
									</a>
								</li>
							</ul>
						</li>
						<li id="ux_li_logs">
							<a href="javascript:;">
							<i class="icon-custom-docs"></i>
							<span class="title">
							<?php echo esc_attr( $lab_logs ); ?>
							</span>
							</a>
							<ul class="sub-menu">
								<li id="ux_li_live_traffic">
									<a href="admin.php?page=lab_live_traffic">
									<i class="icon-custom-directions"></i>
									<span class="title">
										<?php echo esc_attr( $lab_live_traffic_menu ); ?>
									</span>
									</a>
								</li>
								<li id="ux_li_recent_logins">
									<a href="admin.php?page=lab_recent_logs">
									<i class="icon-custom-clock"></i>
									<span class="title">
										<?php echo esc_attr( $lab_recent_login_logs_menu ); ?>
									</span>
									</a>
								</li>
								<li id="ux_li_visitor_logs">
									<a href="admin.php?page=lab_visitor_logs">
									<i class="icon-custom-users"></i>
									<span class="title">
										<?php echo esc_attr( $lab_visitor_logs_menu ); ?>
									</span>
									</a>
								</li>
							</ul>
						</li>
						<li id="ux_li_advance_security">
							<a href="javascript:;">
							<i class="icon-custom-lock"></i>
							<span class="title">
							<?php echo esc_attr( $lab_advance_security ); ?>
							</span>
							</a>
							<ul class="sub-menu">
								<li id="ux_li_blocking_options">
									<a href="admin.php?page=lab_blocking_options">
									<i class="icon-custom-shield"></i>
									<span class="title">
										<?php echo esc_attr( $lab_blocking_options_menu ); ?>
									</span>
									</a>
								</li>
								<li id="ux_li_manage_ip_addresses">
									<a href="admin.php?page=lab_manage_ip_addresses">
									<i class="icon-custom-globe"></i>
									<span class="title">
										<?php echo esc_attr( $lab_manage_ip_addresses_menu ); ?>
									</span>
									</a>
								</li>
								<li id="ux_li_manage_ip_ranges">
									<a href="admin.php?page=lab_manage_ip_ranges">
									<i class="icon-custom-wrench"></i>
									<span class="title">
										<?php echo esc_attr( $lab_manage_ip_ranges_menu ); ?>
									</span>
									</a>
								</li>
								<li id="ux_li_country_blocks">
									<a href="admin.php?page=lab_country_blocks">
									<i class="icon-custom-target"></i>
									<span class="title">
										<?php echo esc_attr( $lab_country_blocks_menu ); ?>
									</span>
									</span><span class="badge">Pro</span>
									</a>
								</li>
							</ul>
						</li>
						<li id="ux_li_general_settings">
							<a href="javascript:;">
							<i class="icon-custom-settings"></i>
							<span class="title">
							<?php echo esc_attr( $lab_general_settings ); ?>
							</span>
							</a>
							<ul class="sub-menu">
								<li id="ux_li_alert_setup">
									<a href="admin.php?page=lab_alert_setup">
									<i class="icon-custom-bell"></i>
									<span class="title">
										<?php echo esc_attr( $lab_alert_setup_menu ); ?>
									</span>
									</span><span class="badge">Pro</span>
									</a>
								</li>
								<li id="ux_li_error_messages">
									<a href="admin.php?page=lab_error_messages">
									<i class="icon-custom-shield"></i>
									<span class="title">
										<?php echo esc_attr( $lab_error_messages_menu ); ?>
									</span>
									</span><span class="badge">Pro</span>
									</a>
								</li>
								<li id="ux_li_other_settings">
									<a href="admin.php?page=lab_other_settings">
									<i class="icon-custom-wrench"></i>
									<span class="title">
										<?php echo esc_attr( $lab_other_settings_menu ); ?>
									</span>
									</a>
								</li>
							</ul>
						</li>
						<li id="ux_li_email_templates">
							<a href="admin.php?page=lab_email_templates">
							<i class="icon-custom-link"></i>
							<span class="title">
								<?php echo esc_attr( $lab_email_templates_menu ); ?>
							</span>
							</span><span class="badge">Pro</span>
							</a>
						</li>
						<li id="ux_li_roles_capabilities">
							<a href="admin.php?page=lab_roles_and_capabilities">
							<i class="icon-custom-users"></i>
							<span class="title">
								<?php echo esc_attr( $lab_roles_and_capability ); ?>
							</span><span class="badge">Pro</span>
							</span>
							</a>
						</li>
						<li id="ux_li_cron_jobs">
							<a href="javascript:;">
							<i class="icon-custom-speedometer"></i>
							<span class="title">
								<?php echo esc_attr( $lab_cron_jobs ); ?>
							</span>
							</a>
							<ul class="sub-menu">
								<li id="ux_li_custom_cron_jobs">
									<a href="admin.php?page=lab_custom_cron_jobs">
									<i class="icon-custom-user"></i>
									<span class="title">
										<?php echo esc_attr( $lab_custom_cron_jobs_menu ); ?>
									</span>
									</span><span class="badge">Pro</span>
									</a>
								</li>
								<li id="ux_li_core_cron_jobs">
									<a href="admin.php?page=lab_core_cron_jobs">
									<i class="icon-custom-folder"></i>
									<span class="title">
										<?php echo esc_attr( $lab_core_cron_jobs_menu ); ?>
									</span>
									</a>
								</li>
							</ul>
						</li>
						<li id="ux_li_feature_requests">
							<a href="https://wordpress.org/support/plugin/limit-attempts-booster" target="_blank">
							<i class="icon-custom-call-out"></i>
							<span class="title">
								<?php echo esc_attr( $lab_feature_requests ); ?>
							</span>
							</a>
						</li>
						<li id="ux_li_system_information">
							<a href="admin.php?page=lab_system_information">
							<i class="icon-custom-screen-desktop"></i>
							<span class="title">
								<?php echo esc_attr( $lab_system_information ); ?>
							</span>
							</a>
						</li>
						<li id="ux_li_system_information">
							<a href="https://tech-banker.com/limit-attempts-booster/pricing/" target="_blank">
								<i class="icon-custom-briefcase"></i>
								<strong><span class="title" style="color: yellow !important;">
								<?php echo esc_attr( $lab_upgrade ); ?>
							</span></strong>
							</a>
						</li>
					</ul>
				</div>
			</div>
			</div>
			<div class="page-content-wrapper">
			<div class="page-content">
			<?php
	}
}
