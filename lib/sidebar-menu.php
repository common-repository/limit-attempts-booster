<?php
/**
 * This file is used to create sidebar menu.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/lib
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
		$flag              = 0;
		$role_capabilities = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE  meta_key = %s', 'roles_and_capabilities'
			)
		);// db call ok; no-cache ok.

		$roles_and_capabilities = maybe_unserialize( $role_capabilities );
		$capabilities           = explode( ',', $roles_and_capabilities['roles_and_capabilities'] );
		if ( is_super_admin() ) {
			$cub_role = 'administrator';
		} else {
			$cub_role = check_user_roles_for_limit_attempts_booster();
		}
		switch ( $cub_role ) {
			case 'administrator':
				$privileges = 'administrator_privileges';
				$flag       = $capabilities[0];
				break;

			case 'author':
				$privileges = 'author_privileges';
				$flag       = $capabilities[1];
				break;

			case 'editor':
				$privileges = 'editor_privileges';
				$flag       = $capabilities[2];
				break;

			case 'contributor':
				$privileges = 'contributor_privileges';
				$flag       = $capabilities[3];
				break;

			case 'subscriber':
				$privileges = 'subscriber_privileges';
				$flag       = $capabilities[4];
				break;

			default:
				$privileges = 'other_privileges';
				$flag       = $capabilities[5];
				break;
		}

		$privileges_value = '';
		if ( isset( $roles_and_capabilities ) && count( $roles_and_capabilities ) > 0 ) {
			foreach ( $roles_and_capabilities as $key => $value ) {
				if ( $privileges === $key ) {
					$privileges_value = $value;
					break;
				}
			}
		}

		$full_control = explode( ',', $privileges_value );
		if ( ! defined( 'FULL_CONTROL' ) ) {
			define( 'FULL_CONTROL', "$full_control[0]" );
		}
		if ( ! defined( 'DASHBOARD_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'DASHBOARD_LIMIT_ATTEMPTS_BOOSTER', "$full_control[1]" );
		}
		if ( ! defined( 'LOGS_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'LOGS_LIMIT_ATTEMPTS_BOOSTER', "$full_control[2]" );
		}
		if ( ! defined( 'ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER', "$full_control[3]" );
		}
		if ( ! defined( 'GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER', "$full_control[4]" );
		}
		if ( ! defined( 'EMAIL_TEMPLATES_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'EMAIL_TEMPLATES_LIMIT_ATTEMPTS_BOOSTER', "$full_control[5]" );
		}
		if ( ! defined( 'ROLES_AND_CAPABILITIES_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'ROLES_AND_CAPABILITIES_LIMIT_ATTEMPTS_BOOSTER', "$full_control[6]" );
		}
		if ( ! defined( 'CRON_JOBS_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'CRON_JOBS_LIMIT_ATTEMPTS_BOOSTER', "$full_control[7]" );
		}
		if ( ! defined( 'SYSTEM_INFORMATION_LIMIT_ATTEMPTS_BOOSTER' ) ) {
			define( 'SYSTEM_INFORMATION_LIMIT_ATTEMPTS_BOOSTER', "$full_control[8]" );
		}
		$check_limit_attempts_wizard = get_option( 'limit-attempts-wizard-set-up' );
		if ( '1' === $flag ) {
			if ( $check_limit_attempts_wizard ) {
				add_menu_page( $lab_limit_attempts, $lab_limit_attempts, 'read', 'lab_limit_attempts_booster', '', plugins_url( 'assets/global/img/icons.png', dirname( __FILE__ ) ) );
			} else {
				add_menu_page( $lab_limit_attempts, $lab_limit_attempts, 'read', 'limit_attempts_wizard', '', plugins_url( 'assets/global/img/icons.png', dirname( __FILE__ ) ) );
				add_submenu_page( $lab_limit_attempts, $lab_limit_attempts, '', 'read', 'limit_attempts_wizard', 'limit_attempts_wizard' );
			}
			add_submenu_page( 'lab_limit_attempts_booster', $lab_recent_login_logs_menu, $lab_dashboard, 'read', 'lab_limit_attempts_booster', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_limit_attempts_booster' );
			add_submenu_page( $lab_dashboard, $lab_visitor_logs_menu, '', 'read', 'lab_visitor_logs_dashboard', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_visitor_logs_dashboard' );
			add_submenu_page( $lab_dashboard, $lab_blocked_ip_addresses_menu, '', 'read', 'lab_last_blocked_ip_addresses', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_last_blocked_ip_addresses' );
			add_submenu_page( $lab_dashboard, $lab_blocked_ip_ranges_menu, '', 'read', 'lab_last_blocked_ip_ranges', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_last_blocked_ip_ranges' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_recent_login_logs_menu, $lab_logs, 'read', 'lab_recent_logs', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_recent_logs' );
			add_submenu_page( $lab_logs, $lab_live_traffic_menu, '', 'read', 'lab_live_traffic', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_live_traffic' );
			add_submenu_page( $lab_logs, $lab_visitor_logs_menu, '', 'read', 'lab_visitor_logs', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_visitor_logs' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_blocking_options_menu, $lab_advance_security, 'read', 'lab_blocking_options', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_blocking_options' );
			add_submenu_page( $lab_advance_security, $lab_manage_ip_addresses_menu, '', 'read', 'lab_manage_ip_addresses', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_manage_ip_addresses' );
			add_submenu_page( $lab_advance_security, $lab_manage_ip_ranges_menu, '', 'read', 'lab_manage_ip_ranges', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_manage_ip_ranges' );
			add_submenu_page( $lab_advance_security, $lab_country_blocks_menu, '', 'read', 'lab_country_blocks', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_country_blocks' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_alert_setup_menu, $lab_general_settings, 'read', 'lab_alert_setup', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_alert_setup' );
			add_submenu_page( $lab_general_settings, $lab_error_messages_menu, '', 'read', 'lab_error_messages', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_error_messages' );
			add_submenu_page( $lab_general_settings, $lab_other_settings_menu, '', 'read', 'lab_other_settings', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_other_settings' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_email_templates_menu, $lab_email_templates_menu, 'read', 'lab_email_templates', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_email_templates' );
			add_submenu_page( 'lab_limit_attempts_booster', $lab_roles_and_capability, $lab_roles_and_capability, 'read', 'lab_roles_and_capabilities', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_roles_and_capabilities' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_custom_cron_jobs_menu, $lab_cron_jobs, 'read', 'lab_custom_cron_jobs', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_custom_cron_jobs' );
			add_submenu_page( $lab_cron_jobs, $lab_core_cron_jobs_menu, '', 'read', 'lab_core_cron_jobs', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_core_cron_jobs' );

			add_submenu_page( 'lab_limit_attempts_booster', $lab_feature_requests, $lab_feature_requests, 'read', 'https://wordpress.org/support/plugin/limit-attempts-booster' );
			add_submenu_page( 'lab_limit_attempts_booster', $lab_system_information, $lab_system_information, 'read', 'lab_system_information', false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : 'lab_system_information' );
			add_submenu_page( 'lab_limit_attempts_booster', $lab_upgrade, $lab_upgrade, 'read', 'https://tech-banker.com/limit-attempts-booster/pricing/' );
		}



		if ( ! function_exists( 'limit_attempts_wizard' ) ) {
			/**
			 * Function Name: limit_attempts_wizard
			 * Parameters: No
			 * Description: This function is used for creating limit_attempts_wizard menu.
			 * Created On: 12-04-2017 16:46
			 * Created By: Tech Banker Team
			 */
			function limit_attempts_wizard() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/wizard/wizard.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/wizard/wizard.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_limit_attempts_booster' ) ) {
			/**
			 * Function Name: lab_limit_attempts_booster
			 * Parameters: No
			 * Description: This function is used to create limit attempts booster menu.
			 * Created On: 2015-08-04 3:24
			 * Created By: Tech Banker Team
			 */
			function lab_limit_attempts_booster() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/login-log.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/login-log.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_live_traffic_dashboard' ) ) {

			/**
			 * Function Name: lab_live_traffic_dashboard
			 * Parameters: No
			 * Description: This function is used to create live traffic dashboard menu.
			 * Created On: 2015-08-04 3:24
			 * Created By: Tech Banker Team
			 */
			function lab_live_traffic_dashboard() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/live-traffic.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/live-traffic.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_visitor_logs_dashboard' ) ) {
			/**
			 * Function Name: lab_visitor_logs_dashboard
			 * Parameters: No
			 * Description: This function is used to create Visitor Logs dashboard menu.
			 * Created On: 2015-08-04 3:24
			 * Created By: Tech Banker Team
			 */
			function lab_visitor_logs_dashboard() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/visitor-logs.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/visitor-logs.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_last_blocked_ip_addresses' ) ) {
			/**
			 * Function Name: lab_last_blocked_ip_addresses
			 * Parameters: No
			 * Description: This function is used to create last Blocked IP addresses menu.
			 * Created On: 2015-08-04 3:24
			 * Created By: Tech Banker Team
			 */
			function lab_last_blocked_ip_addresses() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/blocked-ip-addresses.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/blocked-ip-addresses.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_last_blocked_ip_ranges' ) ) {
			/**
			 * Function Name: lab_last_blocked_ip_ranges
			 * Parameters: No
			 * Description: This function is used to create last Blocked IP ranges menu.
			 * Created On: 2015-08-04 3:24
			 * Created By: Tech Banker Team
			 */
			function lab_last_blocked_ip_ranges() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/blocked-ip-ranges.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/dashboard/blocked-ip-ranges.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_recent_logs' ) ) {
			/**
			 * Function Name: lab_recent_logs
			 * Parameters: No
			 * Description: This function is used to create recent login logs menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_recent_logs() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/recent-login-logs.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/recent-login-logs.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_live_traffic' ) ) {
			/**
			 * Function Name: lab_live_traffic
			 * Parameters: No
			 * Description: This function is used to create live traffic menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_live_traffic() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/live-traffic.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/live-traffic.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_visitor_logs' ) ) {
			/**
			 * Function Name: lab_visitor_logs
			 * Parameters: No
			 * Description: This function is used to create Visitor Logs menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_visitor_logs() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/visitor-logs.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/logs/visitor-logs.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_alert_setup' ) ) {
			/**
			 * Function Name: lab_alert_setup
			 * Parameters: No
			 * Description: This function is used to create alert setup menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_alert_setup() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/alert-setup.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/alert-setup.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_error_messages' ) ) {
			/**
			 * Function Name: lab_error_messages
			 * Parameters: No
			 * Description: This function is used to create error messages menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_error_messages() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/error-messages.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/error-messages.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_other_settings' ) ) {
			/**
			 * Function Name: lab_other_settings
			 * Parameters: No
			 * Description: This function is used to create other settings menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_other_settings() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/other-settings.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/general-settings/other-settings.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_blocking_options' ) ) {
			/**
			 * Function Name: lab_blocking_options
			 * Parameters: No
			 * Description: This function is used to create blocking options menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_blocking_options() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/blocking-options.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/blocking-options.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_manage_ip_addresses' ) ) {
			/**
			 * Function Name: lab_manage_ip_addresses
			 * Parameters: No
			 * Description: This function is used to create manage IP addresses menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_manage_ip_addresses() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/manage-ip-addresses.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/manage-ip-addresses.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_manage_ip_ranges' ) ) {
			/**
			 * Function Name: lab_manage_ip_ranges
			 * Parameters: No
			 * Description: This function is used to create manage IP ranges menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_manage_ip_ranges() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/manage-ip-ranges.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/manage-ip-ranges.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_country_blocks' ) ) {
			/**
			 * Function Name: lab_country_blocks
			 * Parameters: No
			 * Description: This function is used to create country block menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_country_blocks() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/country-blocks.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/advance-security/country-blocks.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_email_templates' ) ) {
			/**
			 * Function Name: lab_email_templates
			 * Parameters: No
			 * Description: This function is used to create email templates menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_email_templates() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/email-templates/email-templates.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/email-templates/email-templates.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_roles_and_capabilities' ) ) {
			/**
			 * Function Name: lab_roles_and_capabilities
			 * Parameters: No
			 * Description: This function is used to create roles and capabilities menu.
			 * Created On: 24-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_roles_and_capabilities() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/roles-and-capabilities/roles-and-capabilities.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/roles-and-capabilities/roles-and-capabilities.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'lab_custom_cron_jobs' ) ) {
			/**
			 * Function Name: lab_custom_cron_jobs
			 * Parameters: No
			 * Description: This function is used to create custom cron jobs menu.
			 * Created On: 24-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_custom_cron_jobs() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/cron-jobs/custom-cron-jobs.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/cron-jobs/custom-cron-jobs.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'lab_core_cron_jobs' ) ) {
			/**
			 * Function Name: lab_core_cron_jobs
			 * Parameters: No
			 * Description: This function is used to create core cron jobs menu.
			 * Created On: 24-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_core_cron_jobs() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/cron-jobs/core-cron-jobs.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/cron-jobs/core-cron-jobs.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'lab_system_information' ) ) {
			/**
			 * Function Name: lab_system_information
			 * Parameters: No
			 * Description: This function is used to create system information menu.
			 * Created On: 23-09-2015 1:00
			 * Created By: Tech Banker Team
			 */
			function lab_system_information() {
				global $wpdb;
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/sidebar.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/system-information/system-information.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'views/system-information/system-information.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/footer.php';
				}
			}
		}
	}
}
