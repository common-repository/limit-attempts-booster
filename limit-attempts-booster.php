<?php // @codingStandardsIgnoreLine.
/**
 * Plugin Name: Limit Login Attempts by Limit Attempts Booster
 * Plugin URI: https://tech-banker.com/limit-attempts-booster/
 * Description: Limit Attempts Booster is a High Quality WordPress Plugin which manages/restricts the access to your website as per your requirements.
 * Author: Tech Banker
 * Author URI: https://tech-banker.com/limit-attempts-booster/
 * Version: 3.0.14
 * License: GPLv3
 * Text Domain: limit-attempts-booster
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
/* Constant Declaration */
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_FILE' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_FILE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_DIR_PATH' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_URL_PATH' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_URL_PATH', plugins_url( __FILE__ ) );
}
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_PLUGIN_DIRNAME' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_PLUGIN_DIRNAME', plugin_basename( dirname( __FILE__ ) ) );
}
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME', strtotime( date_i18n( 'Y-m-d H:i:s' ) ) );
}
if ( ! defined( 'TECH_BANKER_URL' ) ) {
	define( 'TECH_BANKER_URL', 'https://tech-banker.com' );
}
if ( ! defined( 'TECH_BANKER_BETA_URL' ) ) {
	define( 'TECH_BANKER_BETA_URL', 'https://tech-banker.com/limit-attempts-booster' );
}
if ( ! defined( 'TECH_BANKER_SERVICES_URL' ) ) {
	define( 'TECH_BANKER_SERVICES_URL', 'https://tech-banker.com' );
}
if ( ! defined( 'TECH_BANKER_STATS_URL' ) ) {
	define( 'TECH_BANKER_STATS_URL', 'http://stats.tech-banker-services.org' );
}
if ( ! defined( 'LIMIT_ATTEMPTS_BOOSTER_VERSION_NUMBER' ) ) {
	define( 'LIMIT_ATTEMPTS_BOOSTER_VERSION_NUMBER', '3.0.14' );
}
$memory_limit_limit_attempts_booster = intval( ini_get( 'memory_limit' ) );
if ( ! extension_loaded( 'suhosin' ) && $memory_limit_limit_attempts_booster < 512 ) {
	@ini_set( 'memory_limit', '512M' );// @codingStandardsIgnoreLine.
}

@ini_set( 'max_execution_time', 6000 );// @codingStandardsIgnoreLine.
@ini_set( 'max_input_vars', 10000 );// @codingStandardsIgnoreLine.

if ( ! function_exists( 'install_script_for_limit_attempts_booster' ) ) {
	/**
	 * This function is used to create tables in database.
	 */
	function install_script_for_limit_attempts_booster() {
		global $wpdb;
		if ( is_multisite() ) {
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );// db call ok; no-cache ok.
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );// @codingStandardsIgnoreLine.
				$version = get_option( 'limit_attempts_booster_version_number' );
				if ( $version < '3.0.2' ) {
					if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-install-script-limit-attempts-booster.php' ) ) {
						include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-install-script-limit-attempts-booster.php';
					}
				}
				restore_current_blog();
			}
		} else {
			$version = get_option( 'limit_attempts_booster_version_number' );
			if ( $version < '3.0.2' ) {
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-install-script-limit-attempts-booster.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-install-script-limit-attempts-booster.php';
				}
			}
		}
	}
}
if ( ! function_exists( 'get_others_capabilities_limit_attempts_booster' ) ) {
	/**
	 * This function is used to get all the roles available in WordPress.
	 */
	function get_others_capabilities_limit_attempts_booster() {
		$user_capabilities = array();
		if ( function_exists( 'get_editable_roles' ) ) {
			foreach ( get_editable_roles() as $role_name => $role_info ) {
				foreach ( $role_info['capabilities'] as $capability => $values ) {
					if ( ! in_array( $capability, $user_capabilities, true ) ) {
						array_push( $user_capabilities, $capability );
					}
				}
			}
		} else {
			$user_capabilities = array(
				'manage_options',
				'edit_plugins',
				'edit_posts',
				'publish_posts',
				'publish_pages',
				'edit_pages',
				'read',
			);
		}
		return $user_capabilities;
	}
}

if ( ! function_exists( 'check_user_roles_for_limit_attempts_booster' ) ) {
	/**
	 * This function is used for checking roles of different users.
	 */
	function check_user_roles_for_limit_attempts_booster() {
		global $current_user;
		$user = $current_user ? new WP_User( $current_user ) : wp_get_current_user();
		return $user->roles ? $user->roles[0] : false;
	}
}

/**
 * This function is used to create link for Pro Editions.
 *
 * @param string $plugin_link .
 */
function limit_attempts_booster_action_links( $plugin_link ) {
	$plugin_link[] = '<a href="https://tech-banker.com/limit-attempts-booster/pricing/" style="color: red; font-weight: bold;" target="_blank">Go Pro!</a>';
	return $plugin_link;
}

if ( ! function_exists( 'limit_attempts_booster' ) ) {
	/**
	 * This function is used for creating parent table.
	 */
	function limit_attempts_booster() {
		global $wpdb;
		return $wpdb->prefix . 'limit_attempts_booster';
	}
}
if ( ! function_exists( 'limit_attempts_booster_ip_locations' ) ) {
	/**
	 * This function is used for creating ip locations table.
	 */
	function limit_attempts_booster_ip_locations() {
		global $wpdb;
		return $wpdb->prefix . 'limit_attempts_booster_ip_locations';
	}
}
if ( ! function_exists( 'limit_attempts_booster_meta' ) ) {
	/**
	 * This function is used for creating meta table.
	 */
	function limit_attempts_booster_meta() {
		global $wpdb;
		return $wpdb->prefix . 'limit_attempts_booster_meta';
	}
}
if ( ! function_exists( 'limit_attempts_booster_settings_link' ) ) {
	/**
	 * This function is used to add settings link.
	 *
	 * @param string $action .
	 */
	function limit_attempts_booster_settings_link( $action ) {
		global $wpdb;
		$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
		$settings_link        = '<a href = "' . admin_url( 'admin.php?page=lab_limit_attempts_booster' ) . '"> Settings </a>';
		array_unshift( $action, $settings_link );
		return $action;
	}
}
/**
 * This function is used to convert IP to long2ip.
 *
 * @param string $long .
 */
function long2ip_limit_attempts_booster( $long ) {
	// Valid range: 0.0.0.0 -> 255.255.255.255 .
	if ( $long < 0 || $long > 4294967295 ) {
		return false;
	}
	$ip = '';
	for ( $i = 3;$i >= 0;$i-- ) {
		$ip   .= (int) ( $long / pow( 256, $i ) );
		$long -= (int) ( $long / pow( 256, $i ) ) * pow( 256, $i );
		if ( $i > 0 ) {
			$ip .= '.';
		}
	}
	return $ip;
}

$version = get_option( 'limit_attempts_booster_version_number' );
if ( $version >= '3.0.2' ) {
	if ( is_admin() ) {
		if ( ! function_exists( 'backend_js_css_limit_attempts_booster' ) ) {
			/**
			 * This function is used to include backend js.
			 */
			function backend_js_css_limit_attempts_booster() {
				$pages_limit_attempts_booster = array(
					'limit_attempts_wizard',
					'lab_limit_attempts_booster',
					'lab_visitor_logs_dashboard',
					'lab_last_blocked_ip_addresses',
					'lab_last_blocked_ip_ranges',
					'lab_recent_logs',
					'lab_live_traffic',
					'lab_visitor_logs',
					'lab_blocking_options',
					'lab_manage_ip_addresses',
					'lab_manage_ip_ranges',
					'lab_country_blocks',
					'lab_alert_setup',
					'lab_error_messages',
					'lab_other_settings',
					'lab_email_templates',
					'lab_roles_and_capabilities',
					'lab_custom_cron_jobs',
					'lab_core_cron_jobs',
					'lab_feature_requests',
					'lab_system_information',
				);
				if ( in_array( isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '', $pages_limit_attempts_booster, true ) ) {// WPCS: CSRF ok, input var ok.
					wp_enqueue_script( 'jquery' );
					wp_enqueue_script( 'jquery-ui-datepicker' );
					wp_enqueue_script( 'limit-attempts-booster-bootstrap.js', plugins_url( 'assets/global/plugins/custom/js/custom.js', __FILE__ ) );
					wp_enqueue_script( 'limit-attempts-booster-jquery.validate.js', plugins_url( 'assets/global/plugins/validation/jquery.validate.js', __FILE__ ) );
					wp_enqueue_script( 'limit-attempts-booster-jquery.datatables.js', plugins_url( 'assets/global/plugins/datatables/media/js/jquery.datatables.js', __FILE__ ) );
					wp_enqueue_script( 'limit-attempts-booster-jquery.fngetfilterednodes.js', plugins_url( 'assets/global/plugins/datatables/media/js/fngetfilterednodes.js', __FILE__ ) );
					wp_enqueue_script( 'limit-attempts-booster-toastr.js', plugins_url( 'assets/global/plugins/toastr/toastr.js', __FILE__ ) );
					if ( is_ssl() ) {
						wp_enqueue_script( 'limit-attempts-booster-maps_script.js', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyC4rVG7IsNk9pKUO_uOZuxQO4FmF6z03Ks' );
					} else {
						wp_enqueue_script( 'limit-attempts-booster-maps_script.js', 'http://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyC4rVG7IsNk9pKUO_uOZuxQO4FmF6z03Ks' );
					}
					wp_enqueue_style( 'limit-attempts-booster-simple-line-icons.css', plugins_url( 'assets/global/plugins/icons/icons.css', __FILE__ ) );
					wp_enqueue_style( 'limit-attempts-booster-components.css', plugins_url( 'assets/global/css/components.css', __FILE__ ) );
					wp_enqueue_style( 'limit-attempts-booster-custom.css', plugins_url( 'assets/admin/layout/css/limit-attempts-booster-custom.css', __FILE__ ) );
					if ( is_rtl() ) {
						wp_enqueue_style( 'limit-attempts-booster-bootstrap.css', plugins_url( 'assets/global/plugins/custom/css/custom-rtl.css', __FILE__ ) );
						wp_enqueue_style( 'limit-attempts-booster-layout.css', plugins_url( 'assets/admin/layout/css/layout-rtl.css', __FILE__ ) );
						wp_enqueue_style( 'limit-attempts-booster-tech-banker-custom.css', plugins_url( 'assets/admin/layout/css/tech-banker-custom-rtl.css', __FILE__ ) );
					} else {
						wp_enqueue_style( 'limit-attempts-booster-bootstrap.css', plugins_url( 'assets/global/plugins/custom/css/custom.css', __FILE__ ) );
						wp_enqueue_style( 'limit-attempts-booster-layout.css', plugins_url( 'assets/admin/layout/css/layout.css', __FILE__ ) );
						wp_enqueue_style( 'limit-attempts-booster-tech-banker-custom.css', plugins_url( 'assets/admin/layout/css/tech-banker-custom.css', __FILE__ ) );
					}
					wp_enqueue_style( 'limit-attempts-booster-default.css', plugins_url( 'assets/admin/layout/css/themes/default.css', __FILE__ ) );
					wp_enqueue_style( 'limit-attempts-booster-toastr.min.css', plugins_url( 'assets/global/plugins/toastr/toastr.css', __FILE__ ) );
					wp_enqueue_style( 'limit-attempts-booster-jquery-ui.css', plugins_url( 'assets/global/plugins/datepicker/jquery-ui.css', __FILE__ ), false, '2.0', false );
					wp_enqueue_style( 'limit-attempts-booster-datatables.foundation.css', plugins_url( 'assets/global/plugins/datatables/media/css/datatables.foundation.css', __FILE__ ) );
				}
			}
		}
		add_action( 'admin_enqueue_scripts', 'backend_js_css_limit_attempts_booster' );
	}
	if ( ! function_exists( 'get_users_capabilities_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used to get users capabilities.
		 */
		function get_users_capabilities_for_limit_attempts_booster() {
			global $wpdb;
			$capabilities              = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key = %s', 'roles_and_capabilities'
				)
			);// db call ok; no-cache ok.
			$core_roles                = array(
				'manage_options',
				'edit_plugins',
				'edit_posts',
				'publish_posts',
				'publish_pages',
				'edit_pages',
				'read',
			);
			$unserialized_capabilities = maybe_unserialize( $capabilities );
			return isset( $unserialized_capabilities['capabilities'] ) ? $unserialized_capabilities['capabilities'] : $core_roles;
		}
	}

	if ( ! function_exists( 'sidebar_menu_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used for sidebar menu.
		 */
		function sidebar_menu_for_limit_attempts_booster() {
			global $wpdb, $current_user;
			$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
				include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
			}
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/sidebar-menu.php' ) ) {
				include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/sidebar-menu.php';
			}
		}
	}
	if ( ! function_exists( 'topbar_menu_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used for topbar menu.
		 */
		function topbar_menu_for_limit_attempts_booster() {
			global $wpdb, $current_user, $wp_admin_bar;
			$role_capabilities_topbar_menu = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'roles_and_capabilities'
				)
			);// db call ok; no-cache ok.
			$roles_and_capabilities_data   = maybe_unserialize( $role_capabilities_topbar_menu );
			if ( 'enable' === $roles_and_capabilities_data['show_limit_attempts_booster_top_bar_menu'] ) {
				$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
					include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/admin-bar-menu.php' ) ) {
					include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/admin-bar-menu.php';
				}
			}
		}
	}

	if ( ! function_exists( 'helper_file_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used for helper file.
		 */
		function helper_file_for_limit_attempts_booster() {
			global $wpdb;
			$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-limit-attempts-booster.php' ) ) {
				include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/class-dbhelper-limit-attempts-booster.php';
			}
		}
	}

	if ( ! function_exists( 'ajax_register_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used for register ajax.
		 */
		function ajax_register_for_limit_attempts_booster() {
			global $wpdb;
			$user_role_permission = get_users_capabilities_for_limit_attempts_booster();
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php' ) ) {
				include LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'includes/translations.php';
			}
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/action-library.php' ) ) {
				include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/action-library.php';
			}
		}
	}

	if ( ! function_exists( 'validate_ip_limit_attempts_booster' ) ) {
		/**
		 * This function is used for validating ip address.
		 *
		 * @param string $ip .
		 */
		function validate_ip_limit_attempts_booster( $ip ) {
			if ( strtolower( $ip ) === 'unknown' ) {
				return false;
			}
			$ip = sprintf( '%u', ip2long( $ip ) );

			if ( false !== $ip && -1 !== $ip ) {
				$ip = sprintf( '%u', $ip );

				if ( $ip >= 0 && $ip <= 50331647 ) {
					return false;
				}
				if ( $ip >= 167772160 && $ip <= 184549375 ) {
					return false;
				}
				if ( $ip >= 2130706432 && $ip <= 2147483647 ) {
					return false;
				}
				if ( $ip >= 2851995648 && $ip <= 2852061183 ) {
					return false;
				}
				if ( $ip >= 2886729728 && $ip <= 2887778303 ) {
					return false;
				}
				if ( $ip >= 3221225984 && $ip <= 3221226239 ) {
					return false;
				}
				if ( $ip >= 3232235520 && $ip <= 3232301055 ) {
					return false;
				}
				if ( $ip >= 4294967040 ) {
					return false;
				}
			}
			return true;
		}
	}

	if ( ! function_exists( 'get_ip_address_limit_attempts_booster' ) ) {
		/**
		 * This function is used for getIpAddress.
		 */
		function get_ip_address_limit_attempts_booster() {
			static $ip = null;
			if ( isset( $ip ) ) {
				return $ip;
			}

			global $wpdb;
			$data                = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key=%s', 'other_settings'
				)
			);// db call ok; no-cache ok.
			$other_settings_data = maybe_unserialize( $data );

			switch ( $other_settings_data['ip_address_fetching_method'] ) {
				case 'REMOTE_ADDR':
					if ( isset( $_SERVER['REMOTE_ADDR'] ) ) { // @codingStandardsIgnoreLine.
						$remote_addr = wp_unslash( $_SERVER['REMOTE_ADDR'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $remote_addr ) && validate_ip_limit_attempts_booster( $remote_addr ) ) {
							$ip = $remote_addr;
							return $ip;
						}
					}
					break;

				case 'HTTP_X_FORWARDED_FOR':
					$http_forwarded_for = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) : ''; // @codingStandardsIgnoreLine.
					if ( isset( $http_forwarded_for ) && ! empty( $http_forwarded_for ) ) {
						if ( strpos( $http_forwarded_for, ',' ) !== false ) {
							$iplist = explode( ',', $http_forwarded_for );
							foreach ( $iplist as $ip_address ) {
								if ( validate_ip_limit_attempts_booster( $ip_address ) ) {
									$ip = $ip_address;
									return $ip;
								}
							}
						} else {
							if ( validate_ip_limit_attempts_booster( $http_forwarded_for ) ) {
								$ip = $http_forwarded_for;
								return $ip;
							}
						}
					}
					break;

				case 'HTTP_X_REAL_IP':
					if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {// @codingStandardsIgnoreLine.
						$http_real_ip = wp_unslash( $_SERVER['HTTP_X_REAL_IP'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_real_ip ) && validate_ip_limit_attempts_booster( $http_real_ip ) ) {
							$ip = $http_real_ip;
							return $ip;
						}
					}
					break;

				case 'HTTP_CF_CONNECTING_IP':
					if ( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {// @codingStandardsIgnoreLine.
						$http_connecting_ip = wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_connecting_ip ) && validate_ip_limit_attempts_booster( $http_connecting_ip ) ) {
							$ip = $http_connecting_ip;
							return $ip;
						}
					}
					break;

				default:
					if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {// @codingStandardsIgnoreLine.
						$http_client_ip = wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_client_ip ) && validate_ip_limit_attempts_booster( $http_client_ip ) ) {
							$ip = $http_client_ip;
							return $ip;
						}
					}
					$http_forward_for = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) : ''; // @codingStandardsIgnoreLine.
					if ( isset( $http_forward_for ) && ! empty( $http_forward_for ) ) {
						if ( strpos( $http_forward_for, ',' ) !== false ) {
							$iplist = explode( ',', $http_forward_for );
							foreach ( $iplist as $ip_address ) {
								if ( validate_ip_limit_attempts_booster( $ip_address ) ) {
									$ip = $ip_address;
									return $ip;
								}
							}
						} else {
							if ( validate_ip_limit_attempts_booster( $http_forward_for ) ) {
								$ip = $http_forward_for;
								return $ip;
							}
						}
					}
					if ( isset( $_SERVER['HTTP_X_FORWARDED'] ) ) {// @codingStandardsIgnoreLine.
						$http_x_forwarded = wp_unslash( $_SERVER['HTTP_X_FORWARDED'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_x_forwarded ) && validate_ip_limit_attempts_booster( $http_x_forwarded ) ) {
							$ip = $http_x_forwarded;
							return $ip;
						}
					}
					if ( isset( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] ) ) {// @codingStandardsIgnoreLine.
						$http_cluster_client_ip = wp_unslash( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_cluster_client_ip ) && validate_ip_limit_attempts_booster( $http_cluster_client_ip ) ) {
							$ip = $http_cluster_client_ip;
							return $ip;
						}
					}
					if ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {// @codingStandardsIgnoreLine.
						$http_forward = wp_unslash( $_SERVER['HTTP_FORWARDED_FOR'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_forward ) && validate_ip_limit_attempts_booster( $http_forward ) ) {
							$ip = $http_forward;
							return $ip;
						}
					}
					if ( isset( $_SERVER['HTTP_FORWARDED'] ) ) {// @codingStandardsIgnoreLine.
						$http_forwarded = wp_unslash( $_SERVER['HTTP_FORWARDED'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $http_forwarded ) && validate_ip_limit_attempts_booster( $http_forwarded ) ) {
							$ip = $http_forwarded;
							return $ip;
						}
					}
					if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {// @codingStandardsIgnoreLine.
						$remote_addr = wp_unslash( $_SERVER['REMOTE_ADDR'] ); // @codingStandardsIgnoreLine.
						if ( ! empty( $remote_addr ) && validate_ip_limit_attempts_booster( $remote_addr ) ) {
							$ip = $remote_addr;
							return $ip;
						}
					}
					break;
			}
			return '0.0.0.0';
		}
	}

	if ( ! function_exists( 'user_login_status_limit_attempts_booster' ) ) {
		/**
		 * This function is used for check the user's Login status.
		 *
		 * @param string $username .
		 * @param string $password .
		 */
		function user_login_status_limit_attempts_booster( $username, $password ) {
			global $wpdb;
			$ip         = get_ip_address_limit_attempts_booster();
			$ip_address = '::1' === $ip ? sprintf( '%u', ip2long( '0.0.0.0' ) ) : sprintf( '%u', ip2long( $ip ) );
			$location   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip_address ) );
			if ( ! limit_attempts_smart_ip_detect_crawler() ) {
				$place = '' == $location->country_name && '' == $location->city ? '' : '' == $location->country_name ? '' : '' == $location->city ? $location->country_name : $location->city . ', ' . $location->country_name;// WPCS: loose comparison ok.

				$userdata        = get_user_by( 'login', $username );
				$user_email_data = get_user_by( 'email', $username );
				if ( $userdata && wp_check_password( $password, $userdata->user_pass ) || $user_email_data && wp_check_password( $password, $user_email_data->user_pass ) ) {
					$insert_login_logs              = array();
					$insert_login_logs['type']      = 'recent_login_logs';
					$insert_login_logs['parent_id'] = '0';
					$wpdb->insert( limit_attempts_booster(), $insert_login_logs );// db call ok; no-cache ok.
					$last_id = $wpdb->insert_id;

					$insert_login_logs                    = array();
					$insert_login_logs['username']        = esc_attr( $username );
					$insert_login_logs['user_ip_address'] = doubleval( $ip_address );
					$insert_login_logs['location']        = esc_attr( $place );
					$insert_login_logs['latitude']        = doubleval( $location->latitude );
					$insert_login_logs['longitude']       = doubleval( $location->longitude );
					$insert_login_logs['resources']       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';// @codingStandardsIgnoreLine.
					$insert_login_logs['http_user_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : '';// @codingStandardsIgnoreLine.
					$insert_login_logs['date_time']       = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
					$insert_login_logs['status']          = 'Success';
					$insert_login_logs['meta_id']         = intval( $last_id );
					$recent_logs_data                     = array();
					$recent_logs_data['meta_id']          = $last_id;
					$recent_logs_data['meta_key']         = 'recent_login_data';// WPCS: slow query ok.
					$recent_logs_data['meta_value']       = maybe_serialize( $insert_login_logs );// WPCS: slow query ok.
					$wpdb->insert( limit_attempts_booster_meta(), $recent_logs_data );// db call ok; no-cache ok.
				} else {
					if ( '' == $username || '' == $password ) {// WPCS: Loose comparison ok.
						return;
					} else {
						$insert_login_logs              = array();
						$insert_login_logs['type']      = 'recent_login_logs';
						$insert_login_logs['parent_id'] = '0';
						$wpdb->insert( limit_attempts_booster(), $insert_login_logs );// db call ok; no-cache ok.
						$last_id = $wpdb->insert_id;

						$insert_login_logs                    = array();
						$insert_login_logs['username']        = esc_attr( $username );
						$insert_login_logs['user_ip_address'] = doubleval( $ip_address );
						$insert_login_logs['location']        = esc_attr( $place );
						$insert_login_logs['latitude']        = doubleval( $location->latitude );
						$insert_login_logs['longitude']       = doubleval( $location->longitude );
						$insert_login_logs['resources']       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';// @codingStandardsIgnoreLine.
						$insert_login_logs['http_user_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : '';// @codingStandardsIgnoreLine.
						$insert_login_logs['date_time']       = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
						$insert_login_logs['status']          = 'Failure';
						$insert_login_logs['meta_id']         = intval( $last_id );

						$recent_logs_data               = array();
						$recent_logs_data['meta_id']    = $last_id;
						$recent_logs_data['meta_key']   = 'recent_login_data';// WPCS: slow query ok.
						$recent_logs_data['meta_value'] = maybe_serialize( $insert_login_logs );// WPCS: slow query ok.
						$wpdb->insert( limit_attempts_booster_meta(), $recent_logs_data );// db call ok; no-cache ok.

						$auto_ip_block = $wpdb->get_var(
							$wpdb->prepare(
								'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'blocking_options'
							)
						);// db call ok; no-cache ok.

						$blocking_options_data = maybe_unserialize( $auto_ip_block );
						if ( 'enable' === $blocking_options_data['auto_ip_block'] ) {
							add_filter( 'login_errors', 'login_error_messages_limit_attempts_booster', 10, 1 );
							$get_ip   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip_address ) );
							$location = '' == $get_ip->country_name && '' == $get_ip->city ? '' : '' == $get_ip->country_name ? '' : '' == $get_ip->city ? $get_ip->country_name : $get_ip->city . ', ' . $get_ip->country_name;// WPCS: loose comparison ok.
							$date     = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;

							$meta_data_array = $blocking_options_data;

							$get_all_user_data = $wpdb->get_results(
								$wpdb->prepare(
									'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'recent_login_data'
								)
							);// db call ok; no-cache ok.

							$blocked_for_time = $meta_data_array['block_for'];

							switch ( $blocked_for_time ) {
								case '1Hour':
									$this_time = 60 * 60;
									break;

								case '12Hour':
									$this_time = 12 * 60 * 60;
									break;

								case '24hours':
									$this_time = 24 * 60 * 60;
									break;

								case '48hours':
									$this_time = 2 * 24 * 60 * 60;
									break;

								case 'week':
									$this_time = 7 * 24 * 60 * 60;
									break;

								case 'month':
									$this_time = 30 * 24 * 60 * 60;
									break;

								case 'permanently':
									$this_time = 'permanently';
									break;
							}

							$user_data = COUNT( get_limit_attempts_booster_details_login_count_check( $get_all_user_data, $date, $this_time, $ip_address ) );
							if ( ! defined( 'LAB_COUNT_LOGIN_STATUS' ) ) {
								define( 'LAB_COUNT_LOGIN_STATUS', $user_data );
							}
							if ( $user_data >= $meta_data_array['maximum_login_attempt_in_a_day'] ) {
								$ip_address_block              = array();
								$ip_address_block['type']      = 'block_ip_address';
								$ip_address_block['parent_id'] = 0;
								$wpdb->insert( limit_attempts_booster(), $ip_address_block );// db call ok; no-cache ok.
								$last_id = $wpdb->insert_id;

								$ip_address_block_meta                = array();
								$ip_address_block_meta['ip_address']  = doubleval( $ip_address );
								$ip_address_block_meta['blocked_for'] = esc_attr( $blocked_for_time );
								$ip_address_block_meta['location']    = esc_attr( $location );
								$ip_address_block_meta['comments']    = 'IP ADDRESS AUTOMATIC BLOCKED!';

								$timestamp                          = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
								$ip_address_block_meta['date_time'] = intval( $timestamp );

								$insert_data = array();

								$insert_data['meta_id']    = $last_id;
								$insert_data['meta_key']   = 'block_ip_address';// WPCS: slow query ok.
								$insert_data['meta_value'] = maybe_serialize( $ip_address_block_meta );// WPCS: slow query ok.
								$wpdb->insert( limit_attempts_booster_meta(), $insert_data );// db call ok; no-cache ok.

								if ( 'permanently' !== $blocked_for_time ) {
									$cron_name = 'ip_address_unblocker_' . $last_id;
									schedule_limit_attempts_booster_ip_address_range( $cron_name, $blocked_for_time );
								}
								$error_message_data = $wpdb->get_var(
									$wpdb->prepare(
										'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'error_message'
									)
								);// db call ok; no-cache ok.

								$meta_data_array = maybe_unserialize( $error_message_data );

								$replace_ipaddress = $meta_data_array['for_blocked_ip_address_error'];
								$replace_address   = str_replace( '[ip_address]', long2ip_limit_attempts_booster( $ip_address ), $replace_ipaddress );
								wp_die( $replace_address );// WPCS: XSS ok.
							}
						}
					}
				}
			}
		}
	}

	if ( ! function_exists( 'login_error_messages_limit_attempts_booster' ) ) {
		/**
		 * This Function is used for login error messages.
		 *
		 * @param string $default_error_message .
		 */
		function login_error_messages_limit_attempts_booster( $default_error_message ) {
			global $wpdb;
			$max_login_attempts          = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key = %s', 'blocking_options'
				)
			);// db call ok; no-cache ok.
			$max_login_attempts_data     = maybe_unserialize( $max_login_attempts );
			$error_message_attempts      = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key = %s', 'error_message'
				)
			);// db call ok; no-cache ok.
			$error_message_attempts_data = maybe_unserialize( $error_message_attempts );
			$login_attempts              = $max_login_attempts_data['maximum_login_attempt_in_a_day'] - LAB_COUNT_LOGIN_STATUS;
			$replace_attempts            = str_replace( '[login_attempts]', $login_attempts, $error_message_attempts_data['for_maximum_login_attempts'] );
			$display_error_message       = $default_error_message . ' ' . $replace_attempts;
			return $display_error_message;
		}
	}

	if ( ! function_exists( 'schedule_limit_attempts_booster_ip_address_range' ) ) {
		/**
		 * This function is used for creating a scheduler of ip address.
		 *
		 * @param string $cron_name .
		 * @param string $time_interval .
		 */
		function schedule_limit_attempts_booster_ip_address_range( $cron_name, $time_interval ) {
			if ( ! wp_next_scheduled( $cron_name ) ) {
				switch ( $time_interval ) {
					case '1Hour':
						$this_time = 60 * 60;
						break;

					case '12Hour':
						$this_time = 12 * 60 * 60;
						break;

					case '24hours':
						$this_time = 24 * 60 * 60;
						break;

					case '48hours':
						$this_time = 2 * 24 * 60 * 60;
						break;

					case 'week':
						$this_time = 7 * 24 * 60 * 60;
						break;

					case 'month':
						$this_time = 30 * 24 * 60 * 60;
						break;
				}
				wp_schedule_event( time() + $this_time, $time_interval, $cron_name );
			}
		}
	}

	$scheduler         = _get_cron_array();
	$current_scheduler = array();

	foreach ( $scheduler as $value => $key ) {
		$arr_key = array_keys( $key );
		foreach ( $arr_key as $value ) {
			array_push( $current_scheduler, $value );
		}
	}

	if ( isset( $current_scheduler[0] ) ) {
		if ( ! defined( 'SCHEDULER_NAME' ) ) {
			define( 'SCHEDULER_NAME', $current_scheduler[0] );
		}

		if ( strstr( $current_scheduler[0], 'ip_address_unblocker_' ) ) {
			add_action( $current_scheduler[0], 'unblock_script_limit_attempts_booster' );
		} elseif ( strstr( $current_scheduler[0], 'ip_range_unblocker_' ) ) {
			add_action( $current_scheduler[0], 'unblock_script_limit_attempts_booster' );
		}
	}

	if ( ! function_exists( 'unblock_script_limit_attempts_booster' ) ) {
		/**
		 * This function is used for including the unblock-script file.
		 */
		function unblock_script_limit_attempts_booster() {
			if ( file_exists( LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/unblock-script.php' ) ) {
				$nonce_unblock_script = wp_create_nonce( 'unblock_script' );
				global $wpdb;
				include_once LIMIT_ATTEMPTS_BOOSTER_DIR_PATH . 'lib/unblock-script.php';
			}
		}
	}

	if ( ! function_exists( 'block_ip_address_limit_attempts_booster' ) ) {
		/**
		 * This function  is used for blocking ip address and ip ranges.
		 *
		 * @param string $meta_data_array .
		 * @param string $meta_values_ip_blocks_lab .
		 * @param string $ip_address .
		 * @param string $location .
		 */
		function block_ip_address_limit_attempts_booster( $meta_data_array, $meta_values_ip_blocks_lab, $ip_address, $location ) {
			$flag     = 0;
			$count_ip = 0;
			for ( $key = 0; $key < count( $meta_values_ip_blocks_lab ); $key++ ) {// @codingStandardsIgnoreLine
				if ( 'block_ip_range' === $meta_values_ip_blocks_lab[ $key ]->meta_key ) {
					$block_ip_range   = maybe_unserialize( $meta_values_ip_blocks_lab[ $key ]->meta_value );
					$ip_range_address = explode( ',', $block_ip_range['ip_range'] );
					if ( $ip_address >= $ip_range_address[0] && $ip_address <= $ip_range_address[1] ) {
						$flag = 1;
						break;
					}
				} elseif ( 'block_ip_address' === $meta_values_ip_blocks_lab[ $key ]->meta_key ) {
					$block_ip_address = maybe_unserialize( $meta_values_ip_blocks_lab[ $key ]->meta_value );
					if ( $ip_address === $block_ip_address['ip_address'] ) {
						$count_ip = 1;
						break;
					}
				}
			}
			if ( 1 === $count_ip || 1 === $flag ) {
				if ( 1 === $count_ip ) {
					$replace_ipaddress = $meta_data_array['for_blocked_ip_address_error'];
					$replace_address   = str_replace( '[ip_address]', long2ip_limit_attempts_booster( $ip_address ), $replace_ipaddress );
					wp_die( $replace_address );// WPCS: XSS ok.
				} else {
					$replace_iprange = $meta_data_array['for_blocked_ip_range_error'];
					$replace_range   = str_replace( '[ip_range]', long2ip_limit_attempts_booster( $ip_range_address[0] ) . '-' . long2ip_limit_attempts_booster( $ip_range_address[1] ), $replace_iprange );
					wp_die( $replace_range );// WPCS: XSS ok.
				}
			}
		}
	}
	if ( ! function_exists( 'limit_attempts_smart_ip_detect_crawler' ) ) {
		/**
		 * This function  is used detect IP.
		 */
		function limit_attempts_smart_ip_detect_crawler() {
			$user_agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );// @codingStandardsIgnoreLine.
			// A list of some common words used only for bots and crawlers.
			$bot_identifiers = array(
				'bot',
				'slurp',
				'crawler',
				'spider',
				'curl',
				'facebook',
				'fetch',
				'scoutjet',
				'bingbot',
				'AhrefsBot',
				'spbot',
				'robot',
			);
			// See if one of the identifiers is in the UA string.
			foreach ( $bot_identifiers as $identifier ) {
				if ( strpos( $user_agent, $identifier ) !== false ) {
					return true;
				}
			}
			return false;
		}
	}

	if ( ! function_exists( 'visitor_logs_insertion_limit_attempts_booster' ) ) {
		/**
		 * This Function is used for insert the live traffic data in database.
		 *
		 * @param string $meta_data_array .
		 * @param string $ip_address .
		 * @param string $location .
		 */
		function visitor_logs_insertion_limit_attempts_booster( $meta_data_array, $ip_address, $location ) {
			if ( ( ! is_admin() ) && ( ! defined( 'DOING_CRON' ) ) ) {
				if ( ! limit_attempts_smart_ip_detect_crawler() ) {
					global $wpdb, $current_user;
					$ip         = get_ip_address_limit_attempts_booster();
					$ip_address = '::1' === $ip ? sprintf( '%u', ip2long( '0.0.0.0' ) ) : sprintf( '%u', ip2long( $ip ) );
					$location   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip_address ) );
					$place      = '' == $location->country_name && '' == $location->city ? '' : '' == $location->country_name ? '' : '' == $location->city ? $location->country_name : $location->city . ', ' . $location->country_name;// WPCS: loose comparison ok.
					$username   = $current_user->user_login;

					$insert_live_traffic              = array();
					$insert_live_traffic['type']      = 'visitor_log';
					$insert_live_traffic['parent_id'] = 0;
					$wpdb->insert( limit_attempts_booster(), $insert_live_traffic );// db call ok; no-cache ok.
					$last_id = $wpdb->insert_id;

					$insert_live_traffic                    = array();
					$insert_live_traffic['username']        = esc_attr( $username );
					$insert_live_traffic['user_ip_address'] = doubleval( $ip_address );

					$insert_live_traffic['location']        = esc_attr( $place );
					$insert_live_traffic['latitude']        = doubleval( $location->latitude );
					$insert_live_traffic['longitude']       = doubleval( $location->longitude );
					$insert_live_traffic['resources']       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';// @codingStandardsIgnoreLine.
					$insert_live_traffic['http_user_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) : '';// @codingStandardsIgnoreLine.
					$insert_live_traffic['date_time']       = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
					$insert_live_traffic['meta_id']         = intval( $last_id );
					$insert_live_traffic_data               = array();
					$insert_live_traffic_data['meta_id']    = $last_id;
					$insert_live_traffic_data['meta_key']   = 'visitor_log_data';// WPCS: slow query ok.
					$insert_live_traffic_data['meta_value'] = maybe_serialize( $insert_live_traffic );// WPCS: slow query ok.
					$wpdb->insert( limit_attempts_booster_meta(), $insert_live_traffic_data );// db call ok; no-cache ok.
				}
			}
		}
	}

	if ( ! function_exists( 'lab_get_ip_location_limit_attempts_booster' ) ) {
		/**
		 * This function is used to get ip location.
		 *
		 * @param string $ip_address .
		 */
		function lab_get_ip_location_limit_attempts_booster( $ip_address ) {
			global $wpdb;
			$core_data              = '{"ip":"0.0.0.0","country_code":"","country_name":"","region_code":"","region_name":"","city":"","latitude":0,"longitude":0}';
			$ip_location_meta_value = $wpdb->get_row(
				$wpdb->prepare(
					'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_ip_locations WHERE ip=%s', $ip_address
				)
			);// WPCS: db call ok, no-cache ok.
			if ( '' != $ip_location_meta_value ) { // WPCS: loose comparison ok.
				return $ip_location_meta_value;
			} else {
				$api_call = TECH_BANKER_SERVICES_URL . '/api-server/getipaddress.php?ip_address=' . $ip_address;
				if ( function_exists( 'curl_init' ) ) {
					$ch = curl_init();// @codingStandardsIgnoreLine.
					curl_setopt( $ch, CURLOPT_URL, $api_call );// @codingStandardsIgnoreLine.
					curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Accept: application/json' ) );// @codingStandardsIgnoreLine.
					curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );// @codingStandardsIgnoreLine.
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );// @codingStandardsIgnoreLine.
					curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );// @codingStandardsIgnoreLine.
					$json_data = curl_exec( $ch );// @codingStandardsIgnoreLine.
				} else {
					$json_data = @file_get_contents( $api_call );// @codingStandardsIgnoreLine.
				}
				$ip_location_array = false === json_decode( $json_data ) ? json_decode( $core_data ) : json_decode( $json_data );
				if ( '' != $ip_location_array ) { // WPCS: loose comparison ok.
					$ip_location_array_data                 = array();
					$ip_location_array_data['ip']           = $ip_location_array->ip;
					$ip_location_array_data['country_code'] = $ip_location_array->country_code;
					$ip_location_array_data['country_name'] = $ip_location_array->country_name;
					$ip_location_array_data['region_code']  = $ip_location_array->region_code;
					$ip_location_array_data['region_name']  = $ip_location_array->region_name;
					$ip_location_array_data['city']         = $ip_location_array->city;
					$ip_location_array_data['latitude']     = $ip_location_array->latitude;
					$ip_location_array_data['longitude']    = $ip_location_array->longitude;

					$wpdb->insert( limit_attempts_booster_ip_locations(), $ip_location_array_data ); // WPCS: db call ok.
				}
				return false === json_decode( $json_data ) ? json_decode( $core_data ) : json_decode( $json_data );
			}
		}
	}

	if ( ! function_exists( 'get_limit_attempts_booster_details_login_count_check' ) ) {
		/**
		 * This function is used to get login counts.
		 *
		 * @param string $data .
		 * @param string $date .
		 * @param string $time_interval .
		 * @param string $ip_address .
		 */
		function get_limit_attempts_booster_details_login_count_check( $data, $date, $time_interval, $ip_address ) {
			$limit_attempts_details = array();
			foreach ( $data as $raw_row ) {
				$row = maybe_unserialize( $raw_row->meta_value );
				if ( $row['user_ip_address'] == $ip_address ) { // WPCS: loose comparison ok.
					if ( 'permanently' !== $time_interval ) {
						if ( 'Failure' == $row['status'] && $row['date_time'] + $time_interval >= $date ) {// WPCS: loose comparison ok.
							array_push( $limit_attempts_details, $row );
						}
					} else {
						if ( 'Failure' == $row['status'] ) {// WPCS: loose comparison ok.
							array_push( $limit_attempts_details, $row );
						}
					}
				}
			}
			return $limit_attempts_details;
		}
	}

	if ( ! function_exists( 'cron_scheduler_for_intervals_limit_attempts_booster' ) ) {
		/**
		 * This function is used to cron scheduler for intervals.
		 *
		 * @param string $schedules .
		 */
		function cron_scheduler_for_intervals_limit_attempts_booster( $schedules ) {
			$schedules['1Hour']   = array(
				'interval' => 60 * 60,
				'display'  => 'Every 1 Hour',
			);
			$schedules['2Hour']   = array(
				'interval' => 60 * 60 * 2,
				'display'  => 'Every 2 Hours',
			);
			$schedules['3Hour']   = array(
				'interval' => 60 * 60 * 3,
				'display'  => 'Every 3 Hours',
			);
			$schedules['4Hour']   = array(
				'interval' => 60 * 60 * 4,
				'display'  => 'Every 4 Hours',
			);
			$schedules['5Hour']   = array(
				'interval' => 60 * 60 * 5,
				'display'  => 'Every 5 Hours',
			);
			$schedules['6Hour']   = array(
				'interval' => 60 * 60 * 6,
				'display'  => 'Every 6 Hours',
			);
			$schedules['7Hour']   = array(
				'interval' => 60 * 60 * 7,
				'display'  => 'Every 7 Hours',
			);
			$schedules['8Hour']   = array(
				'interval' => 60 * 60 * 8,
				'display'  => 'Every 8 Hours',
			);
			$schedules['9Hour']   = array(
				'interval' => 60 * 60 * 9,
				'display'  => 'Every 9 Hours',
			);
			$schedules['10Hour']  = array(
				'interval' => 60 * 60 * 10,
				'display'  => 'Every 10 Hours',
			);
			$schedules['11Hour']  = array(
				'interval' => 60 * 60 * 11,
				'display'  => 'Every 11 Hours',
			);
			$schedules['12Hour']  = array(
				'interval' => 60 * 60 * 12,
				'display'  => 'Every 12 Hours',
			);
			$schedules['13Hour']  = array(
				'interval' => 60 * 60 * 13,
				'display'  => 'Every 13 Hours',
			);
			$schedules['14Hour']  = array(
				'interval' => 60 * 60 * 14,
				'display'  => 'Every 14 Hours',
			);
			$schedules['15Hour']  = array(
				'interval' => 60 * 60 * 15,
				'display'  => 'Every 15 Hours',
			);
			$schedules['16Hour']  = array(
				'interval' => 60 * 60 * 16,
				'display'  => 'Every 16 Hours',
			);
			$schedules['17Hour']  = array(
				'interval' => 60 * 60 * 17,
				'display'  => 'Every 17 Hours',
			);
			$schedules['18Hour']  = array(
				'interval' => 60 * 60 * 18,
				'display'  => 'Every 18 Hours',
			);
			$schedules['19Hour']  = array(
				'interval' => 60 * 60 * 19,
				'display'  => 'Every 19 Hours',
			);
			$schedules['20Hour']  = array(
				'interval' => 60 * 60 * 20,
				'display'  => 'Every 20 Hours',
			);
			$schedules['21Hour']  = array(
				'interval' => 60 * 60 * 21,
				'display'  => 'Every 21 Hours',
			);
			$schedules['22Hour']  = array(
				'interval' => 60 * 60 * 22,
				'display'  => 'Every 22 Hours',
			);
			$schedules['23Hour']  = array(
				'interval' => 60 * 60 * 23,
				'display'  => 'Every 23 Hours',
			);
			$schedules['Daily']   = array(
				'interval' => 60 * 60 * 24,
				'display'  => 'Daily',
			);
			$schedules['24hours'] = array(
				'interval' => 60 * 60 * 24,
				'display'  => 'Every 24 Hours',
			);
			$schedules['48hours'] = array(
				'interval' => 60 * 60 * 48,
				'display'  => 'Every 48 Hours',
			);
			$schedules['week']    = array(
				'interval' => 60 * 60 * 24 * 7,
				'display'  => 'Every 1 Week',
			);
			$schedules['month']   = array(
				'interval' => 60 * 60 * 24 * 30,
				'display'  => 'Every 1 Month',
			);
			return $schedules;
		}
	}

	if ( ! function_exists( 'unschedule_events_limit_attempts_booster' ) ) {
		/**
		 * This function is used to unscheduling the events.
		 *
		 * @param string $cron_name .
		 */
		function unschedule_events_limit_attempts_booster( $cron_name ) {
			if ( wp_next_scheduled( $cron_name ) ) {
				$db_cron = wp_next_scheduled( $cron_name );
				wp_unschedule_event( $db_cron, $cron_name );
			}
		}
	}

	if ( ! function_exists( 'plugin_load_textdomain_limit_attempts_booster' ) ) {
		/**
		 * This function is used to load languages.
		 */
		function plugin_load_textdomain_limit_attempts_booster() {
			if ( function_exists( 'load_plugin_textdomain' ) ) {
				load_plugin_textdomain( 'limit-attempts-booster', false, LIMIT_ATTEMPTS_BOOSTER_PLUGIN_DIRNAME . '/languages' );
			}
		}
	}

	if ( ! function_exists( 'plugin_auto_update_limit_attempts_booster' ) ) {
		/**
		 * This function is used to Update plugin Edition.
		 */
		function plugin_auto_update_limit_attempts_booster() {
			if ( ! wp_next_scheduled( 'automatic_updates_limit_attempts_booster' ) ) {
				wp_schedule_event( LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME, 'daily', 'automatic_updates_limit_attempts_booster' );
			}
			add_action( 'automatic_updates_limit_attempts_booster', 'limit_attempts_booster_plugin_autoupdate' );
		}
	}

	if ( ! function_exists( 'limit_attempts_booster_plugin_autoupdate' ) ) {
		/**
		 * This function is used to autoupdate plugin.
		 */
		function limit_attempts_booster_plugin_autoupdate() {
			try {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/misc.php';
				define( 'FS_METHOD', 'direct' );
				require_once ABSPATH . 'wp-includes/update.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				wp_update_plugins();
				ob_start();
				$plugin_upgrader = new Plugin_Upgrader();
				$plugin_upgrader->upgrade( LIMIT_ATTEMPTS_BOOSTER_FILE );
				$output = @ob_get_contents();// @codingStandardsIgnoreLine.
				@ob_end_clean();// @codingStandardsIgnoreLine.
			} catch ( Exception $e ) {// @codingStandardsIgnoreLine.

			}
		}
	}

	if ( ! function_exists( 'admin_functions_limit_attempts_booster' ) ) {
		/**
		 * This function is used for calling add_action .
		 */
		function admin_functions_limit_attempts_booster() {
			install_script_for_limit_attempts_booster();
			helper_file_for_limit_attempts_booster();
			authenticate_limit_attempts_booster();
		}
	}

	if ( ! function_exists( 'authenticate_limit_attempts_booster' ) ) {
		/**
		 * This function is used for blocking the user .
		 */
		function authenticate_limit_attempts_booster() {
			global $wpdb;
			$meta_values = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT meta_key,meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key IN(%s,%s)',
					'error_message',
					'other_settings'
				)
			);// db call ok; no-cache ok.

			$meta_values_ip_blocks_lab = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT meta_key,meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key IN(%s,%s)',
					'block_ip_address',
					'block_ip_range'
				)
			);// db call ok; no-cache ok.
			$meta_data_array           = array();
			foreach ( $meta_values as $row ) {
				$meta_data_array[ $row->meta_key ] = maybe_unserialize( $row->meta_value );// WPCS: slow query ok.
			}

			$error_message_array = $meta_data_array['error_message'];

			$ip_address = '::1' === get_ip_address_limit_attempts_booster() ? sprintf( '%u', ip2long( '0.0.0.0' ) ) : sprintf( '%u', ip2long( get_ip_address_limit_attempts_booster() ) );
			$location   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip_address ) );
			block_ip_address_limit_attempts_booster( $error_message_array, $meta_values_ip_blocks_lab, $ip_address, $location );
		}
	}

	if ( ! function_exists( 'user_functions_limit_attempts_booster' ) ) {
		/**
		 * This function is used for calling add_action for frontend .
		 */
		function user_functions_limit_attempts_booster() {
			global $wpdb;
			plugin_load_textdomain_limit_attempts_booster();
			$meta_values = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT meta_key,meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta
					WHERE meta_key IN(%s,%s)',
					'error_message',
					'other_settings'
				)
			);// db call ok; no-cache ok.

			$meta_data_array = array();
			foreach ( $meta_values as $row ) {
				$meta_data_array[ $row->meta_key ] = maybe_unserialize( $row->meta_value );// WPCS: slow query ok.
			}

			$other_settings_array = $meta_data_array['other_settings'];

			$ip_address = '::1' === get_ip_address_limit_attempts_booster() ? sprintf( '%u', ip2long( '0.0.0.0' ) ) : sprintf( '%u', ip2long( get_ip_address_limit_attempts_booster() ) );
			$location   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip_address ) );
			if ( array_key_exists( 'automatic_plugin_updates', $other_settings_array ) ) {
				if ( 'enable' === $other_settings_array['automatic_plugin_updates'] ) {
					plugin_auto_update_limit_attempts_booster();
				} else {
					wp_clear_scheduled_hook( 'automatic_updates_limit_attempts_booster' );
				}
			}
			if ( array_key_exists( 'visitor_logs_monitoring', $other_settings_array ) && array_key_exists( 'live_traffic_monitoring', $other_settings_array ) ) {
				if ( 'enable' === $other_settings_array['visitor_logs_monitoring'] || 'enable' === $other_settings_array['live_traffic_monitoring'] ) {
					visitor_logs_insertion_limit_attempts_booster( $meta_data_array, $ip_address, $location );
				}
			}
		}
	}

	if ( ! function_exists( 'deactivation_function_for_limit_attempts_booster' ) ) {
		/**
		 * This function is used for executing the code on deactivation.
		 */
		function deactivation_function_for_limit_attempts_booster() {
			delete_option( 'limit-attempts-wizard-set-up' );
		}
	}

	/* Hooks */

	/**
	 * This hook is used for calling all the Backend Functions.
	 */
	add_action( 'admin_init', 'admin_functions_limit_attempts_booster' );

	/**
	 * This hook is used for calling all the Backend Functions.
	 */
	add_action( 'init', 'user_functions_limit_attempts_booster' );

	/**
	 * This hook is used for calling the function to register ajax.
	 */
	add_action( 'wp_ajax_limit_attempts_booster_action', 'ajax_register_for_limit_attempts_booster' );

	/**
	 * This hook is uesd for calling the function of sidebar menu.
	 */
	add_action( 'admin_menu', 'sidebar_menu_for_limit_attempts_booster' );

	/**
	 * This hook is used for calling the function of sidebar menuin multisite case.
	 */
	add_action( 'network_admin_menu', 'sidebar_menu_for_limit_attempts_booster' );

	/**
	 * This hook is used for calling the function of topbar menu.
	 */
	add_action( 'admin_bar_menu', 'topbar_menu_for_limit_attempts_booster', 100 );

	/**
	 * This hook is used for calling function of check user login status.
	 */
	add_action( 'wp_authenticate', 'user_login_status_limit_attempts_booster', 10, 2 );

	/**
	 * This hook is used for calling function oon authentication.
	 */
	add_action( 'wp_authenticate', 'authenticate_limit_attempts_booster', 10, 2 );

	/**
	 * This hook is used for calling the function of cron schedulers jobs for WordPress data and database.
	 */
	add_filter( 'cron_schedules', 'cron_scheduler_for_intervals_limit_attempts_booster' );

	/**
	 * This hook is used for calling the function of settings link.
	 */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'limit_attempts_booster_settings_link', 10, 2 );

}
/**
 * This hook is used for calling the function of install script.
 */
register_activation_hook( __FILE__, 'install_script_for_limit_attempts_booster' );

/**
 * This hook is used for calling the function of install script.
 */
add_action( 'admin_init', 'install_script_for_limit_attempts_booster' );

/**
 * This hook is used for create link for premium Edition.
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'limit_attempts_booster_action_links' );

/**
 * This hook is used to sets the deactivation hook for a plugin.
 */
register_deactivation_hook( __FILE__, 'deactivation_function_for_limit_attempts_booster' );

if ( ! function_exists( 'plugin_activate_limit_attempts_booster' ) ) {
	/**
	 * This function is used to add option.
	 */
	function plugin_activate_limit_attempts_booster() {
		add_option( 'limit_attempts_booster_do_activation_redirect', true );
	}
}

if ( ! function_exists( 'limit_attempts_booster_redirect' ) ) {
	/**
	 * This function is used to redirect page.
	 */
	function limit_attempts_booster_redirect() {
		if ( get_option( 'limit_attempts_booster_do_activation_redirect', false ) ) {
			delete_option( 'limit_attempts_booster_do_activation_redirect' );
			wp_safe_redirect( admin_url( 'admin.php?page=lab_limit_attempts_booster' ) );
			exit;
		}
	}
}

/**
 * This hook is used for calling the function plugin_activate_limit_attempts_booster.
 */
register_activation_hook( __FILE__, 'plugin_activate_limit_attempts_booster' );

/**
 * This hook is used for calling the function limit_attempts_booster_redirect.
 */
add_action( 'admin_init', 'limit_attempts_booster_redirect' );

/**
 * This function is used to create the object of admin notices.
 */
function limit_attempts_booster_admin_notice_class() {
	global $wpdb;
	/**
	 * This class is used to add admin notices.
	 */
	class Limit_Attempts_Booster_Admin_Notices {
		/**
		 * The $promo_link of this plugin.
		 *
		 * @access   protected
		 * @var      string    $promo_link  .
		 */
		protected $promo_link = '';
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      string    $config  .
		 */
		public $config;
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      integer    $notice_spam .
		 */
		public $notice_spam = 0;
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      integer    $notice_spam_max .
		 */
		public $notice_spam_max = 2;
		/**
		 * Public Constructor.
		 *
		 * @param array $config .
		 */
		public function __construct( $config = array() ) {
			// Runs the admin notice ignore function incase a dismiss button has been clicked.
			add_action( 'admin_init', array( $this, 'lab_admin_notice_ignore' ) );
			// Runs the admin notice temp ignore function incase a temp dismiss link has been clicked.
			add_action( 'admin_init', array( $this, 'lab_admin_notice_temp_ignore' ) );
			add_action( 'admin_notices', array( $this, 'lab_display_admin_notices' ) );
		}
		/**
		 * Checks to ensure notices aren't disabled and the user has the correct permissions.
		 */
		public function lab_admin_notices() {
			$settings = get_option( 'lab_admin_notice' );
			if ( ! isset( $settings['disable_admin_notices'] ) || ( isset( $settings['disable_admin_notices'] ) && 0 === $settings['disable_admin_notices'] ) ) {
				if ( current_user_can( 'manage_options' ) ) {
					return true;
				}
			}
			return false;
		}
		/**
		 * Primary notice function that can be called from an outside function sending necessary variables.
		 *
		 * @param string $admin_notices .
		 */
		public function change_admin_notice_limit_attempts_booster( $admin_notices ) {
			// Check options.
			if ( ! $this->lab_admin_notices() ) {
				return false;
			}
			foreach ( $admin_notices as $slug => $admin_notice ) {
				// Call for spam protection.
				if ( $this->lab_anti_notice_spam() ) {
					return false;
				}

				// Check for proper page to display on.
				if ( isset( $admin_notices[ $slug ]['pages'] ) && is_array( $admin_notices[ $slug ]['pages'] ) ) {
					if ( ! $this->lab_admin_notice_pages( $admin_notices[ $slug ]['pages'] ) ) {
						return false;
					}
				}

				// Check for required fields.
				if ( ! $this->lab_required_fields( $admin_notices[ $slug ] ) ) {

					// Get the current date then set start date to either passed value or current date value and add interval.
					$current_date = current_time( 'm/d/Y' );
					$start        = ( isset( $admin_notices[ $slug ]['start'] ) ? $admin_notices[ $slug ]['start'] : $current_date );
					$start        = date( 'm/d/Y' );
					$date_array   = explode( '/', $start );
					$interval     = ( isset( $admin_notices[ $slug ]['int'] ) ? $admin_notices[ $slug ]['int'] : 0 );
					$date         = strtotime( '+' . $interval . ' days', strtotime( $start ) );
					$start        = date( 'm/d/Y', $date );

					// This is the main notices storage option.
					$admin_notices_option = get_option( 'lab_admin_notice', array() );
					// Check if the message is already stored and if so just grab the key otherwise store the message and its associated date information.
					if ( ! array_key_exists( $slug, $admin_notices_option ) ) {
						$admin_notices_option[ $slug ]['start'] = date( 'm/d/Y' );
						$admin_notices_option[ $slug ]['int']   = $interval;
						update_option( 'lab_admin_notice', $admin_notices_option );
					}

					// Sanity check to ensure we have accurate information.
					// New date information will not overwrite old date information.
					$admin_display_check    = ( isset( $admin_notices_option[ $slug ]['dismissed'] ) ? $admin_notices_option[ $slug ]['dismissed'] : 0 );
					$admin_display_start    = ( isset( $admin_notices_option[ $slug ]['start'] ) ? $admin_notices_option[ $slug ]['start'] : $start );
					$admin_display_interval = ( isset( $admin_notices_option[ $slug ]['int'] ) ? $admin_notices_option[ $slug ]['int'] : $interval );
					$admin_display_msg      = ( isset( $admin_notices[ $slug ]['msg'] ) ? $admin_notices[ $slug ]['msg'] : '' );
					$admin_display_title    = ( isset( $admin_notices[ $slug ]['title'] ) ? $admin_notices[ $slug ]['title'] : '' );
					$admin_display_link     = ( isset( $admin_notices[ $slug ]['link'] ) ? $admin_notices[ $slug ]['link'] : '' );
					$output_css             = false;

					// Ensure the notice hasn't been hidden and that the current date is after the start date.
					if ( 0 === $admin_display_check && strtotime( $admin_display_start ) <= strtotime( $current_date ) ) {

						// Get remaining query string.
						$query_str = ( isset( $admin_notices[ $slug ]['later_link'] ) ? $admin_notices[ $slug ]['later_link'] : esc_url( add_query_arg( 'lab_admin_notice_ignore', $slug ) ) );
						if ( strpos( $slug, 'promo' ) === false ) {
							// Admin notice display output.
							echo '<div class="update-nag lab-admin-notice" style="width:95%!important;">
															 <div></div>
																<strong><p>' . $admin_display_title . '</p></strong>
																<strong><p style="font-size:14px !important">' . $admin_display_msg . '</p></strong>
																<strong><ul>' . $admin_display_link . '</ul></strong>
															</div>';// WPCS: XSS ok.
						} else {
							echo '<div class="admin-notice-promo">';
							echo $admin_display_msg;// WPCS: XSS ok.
							echo '<ul class="notice-body-promo blue">
																		' . $admin_display_link . '
																	</ul>';// WPCS: XSS ok.
							echo '</div>';
						}
						$this->notice_spam += 1;
						$output_css         = true;
					}
				}
			}
		}
		/**
		 * Spam protection check
		 */
		public function lab_anti_notice_spam() {
			if ( $this->notice_spam >= $this->notice_spam_max ) {
				return true;
			}
			return false;
		}
		/**
		 * Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked.
		 */
		public function lab_admin_notice_ignore() {
			// If user clicks to ignore the notice, update the option to not show it again.
			if ( isset( $_GET['lab_admin_notice_ignore'] ) ) {// WPCS: CSRF ok, input var ok.
				$admin_notices_option = get_option( 'lab_admin_notice', array() );
				$admin_notices_option[ $_GET['lab_admin_notice_ignore'] ]['dismissed'] = 1;// WPCS: CSRF ok, input var ok, sanitization ok.
				update_option( 'lab_admin_notice', $admin_notices_option );
				$query_str = remove_query_arg( 'lab_admin_notice_ignore' );
				wp_safe_redirect( $query_str );
				exit;
			}
		}
		/**
		 * Temp Ignore function that gets ran at admin init to ensure any messages that were temp dismissed get their start date changed.
		 */
		public function lab_admin_notice_temp_ignore() {
			// If user clicks to temp ignore the notice, update the option to change the start date - default interval of 14 days.
			if ( isset( $_GET['lab_admin_notice_temp_ignore'] ) ) {// WPCS: CSRF ok, input var ok.
				$admin_notices_option = get_option( 'lab_admin_notice', array() );
				$current_date         = current_time( 'm/d/Y' );
				$date_array           = explode( '/', $current_date );
				$interval             = ( isset( $_GET['int'] ) ? $_GET['int'] : 7 );// WPCS: input var ok, CSRF ok, sanitization ok.
				$date                 = strtotime( '+' . $interval . ' days', strtotime( $current_date ) );
				$new_start            = date( 'm/d/Y', $date );

				$admin_notices_option[ $_GET['lab_admin_notice_temp_ignore'] ]['start']     = $new_start;// WPCS: CSRF ok, input var ok, sanitization ok.
				$admin_notices_option[ $_GET['lab_admin_notice_temp_ignore'] ]['dismissed'] = 0;// WPCS: CSRF ok, input var ok, sanitization ok.
				update_option( 'lab_admin_notice', $admin_notices_option );
				$query_str = remove_query_arg( array( 'lab_admin_notice_temp_ignore', 'int' ) );
				wp_safe_redirect( $query_str );
				exit;
			}
		}
		/**
		 * Display admin notice on pages.
		 *
		 * @param array $pages .
		 */
		public function lab_admin_notice_pages( $pages ) {
			foreach ( $pages as $key => $page ) {
				if ( is_array( $page ) ) {
					if ( isset( $_GET['page'] ) && $_GET['page'] === $page[0] && isset( $_GET['tab'] ) && $_GET['tab'] === $page[1] ) {// WPCS: CSRF ok, input var ok.
						return true;
					}
				} else {
					if ( 'all' === $page ) {
						return true;
					}
					if ( get_current_screen()->id === $page ) {
						return true;
					}
					if ( isset( $_GET['page'] ) && $_GET['page'] === $page ) {// WPCS: CSRF ok, input var ok.
						return true;
					}
				}
				return false;
			}
		}
		/**
		 * Required fields check.
		 *
		 * @param array $fields .
		 */
		public function lab_required_fields( $fields ) {
			if ( ! isset( $fields['msg'] ) || ( isset( $fields['msg'] ) && empty( $fields['msg'] ) ) ) {
				return true;
			}
			if ( ! isset( $fields['title'] ) || ( isset( $fields['title'] ) && empty( $fields['title'] ) ) ) {
				return true;
			}
			return false;
		}
		/**
		 * Display Content in admin notice.
		 */
		public function lab_display_admin_notices() {
			$two_week_review_ignore     = add_query_arg( array( 'lab_admin_notice_ignore' => 'two_week_review' ) );
			$two_week_review_temp       = add_query_arg(
				array(
					'lab_admin_notice_temp_ignore' => 'two_week_review',
					'int'                          => 7,
				)
			);
			$notices['two_week_review'] = array(
				'title'      => __( 'Leave A Limit Attempts Booster Review?', 'limit-attempts-booster' ),
				'msg'        => __( 'We love and care about you. Limit Attempts Booster Team is putting our maximum efforts to provide you the best functionalities.<br> We would really appreciate if you could spend a couple of seconds to give a Nice Review to the plugin for motivating us!', 'limit-attempts-booster' ),
				'link'       => '<span class="dashicons dashicons-external limit-attempts-booster-admin-notice"></span><span class="limit-attempts-booster-admin-notice"><a href="https://wordpress.org/support/plugin/limit-attempts-booster/reviews/?filter=5" target="_blank" class="limit-attempts-booster-admin-notice-link">' . __( 'Sure! I\'d love to!', 'limit-attempts-booster' ) . '</a></span>
												<span class="dashicons dashicons-smiley limit-attempts-booster-admin-notice"></span><span class="limit-attempts-booster-admin-notice"><a href="' . $two_week_review_ignore . '" class="limit-attempts-booster-admin-notice-link"> ' . __( 'I\'ve already left a review', 'limit-attempts-booster' ) . '</a></span>
												<span class="dashicons dashicons-calendar-alt limit-attempts-booster-admin-notice"></span><span class="limit-attempts-booster-admin-notice"><a href="' . $two_week_review_temp . '" class="limit-attempts-booster-admin-notice-link">' . __( 'Maybe Later', 'limit-attempts-booster' ) . '</a></span>',
				'later_link' => $two_week_review_temp,
				'int'        => 7,
			);
			$this->change_admin_notice_limit_attempts_booster( $notices );
		}
	}
	$plugin_info_limit_attempts_booster = new Limit_Attempts_Booster_Admin_Notices();
}

add_action( 'init', 'limit_attempts_booster_admin_notice_class' );
/**
 * Add Pop on deactivation.
 */
function add_popup_on_deactivation_limit_attempts_booster() {
	global $wpdb;
	/**
	 * Display deactivation form.
	 */
	class Limit_Attempts_Booster_Deactivation_Form {// @codingStandardsIgnoreLine.
		/**
		 * Public Constructor.
		 */
		function __construct() {
			add_action( 'wp_ajax_post_user_feedback_limit_attempts_booster', array( $this, 'post_user_feedback_limit_attempts_booster' ) );
			global $pagenow;
			if ( 'plugins.php' === $pagenow ) {
					add_action( 'admin_enqueue_scripts', array( $this, 'feedback_form_js_limit_attempts_booster' ) );
					add_action( 'admin_head', array( $this, 'add_form_layout_limit_attempts_booster' ) );
					add_action( 'admin_footer', array( $this, 'add_deactivation_dialog_form_limit_attempts_booster' ) );
			}
		}
		/**
		 * Add css and js files.
		 */
		function feedback_form_js_limit_attempts_booster() {
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_register_script( 'limit-attempts-booster-feedback', plugins_url( 'assets/global/plugins/deactivation/deactivate-popup.js', __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' ), false, true );
			wp_localize_script( 'limit-attempts-booster-feedback', 'post_feedback', array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_script( 'limit-attempts-booster-feedback' );
		}
		/**
		 * Post user Fedback.
		 */
		function post_user_feedback_limit_attempts_booster() {
			$limit_attempts_booster_deactivation_reason = isset( $_POST['reason'] ) ? wp_unslash( $_POST['reason'] ) : ''; // WPCS: CSRF ok, input var ok, sanitization ok.
			$type                                       = get_option( 'limit-attempts-wizard-set-up' );
			$user_admin_email                           = get_option( 'limit-attempts-booster-admin-email' );
			$plugin_info_limit_attempts_booster         = new Plugin_Info_Limit_Attempts_Booster();
			global $wp_version, $wpdb;
			$url           = TECH_BANKER_STATS_URL . '/wp-admin/admin-ajax.php';
			$theme_details = array();
			if ( $wp_version >= 3.4 ) {
				$active_theme                   = wp_get_theme();
				$theme_details['theme_name']    = strip_tags( $active_theme->name );
				$theme_details['theme_version'] = strip_tags( $active_theme->version );
				$theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
			}
			$plugin_stat_data                   = array();
			$plugin_stat_data['plugin_slug']    = 'limit-attempts-booster';
			$plugin_stat_data['reason']         = $limit_attempts_booster_deactivation_reason;
			$plugin_stat_data['type']           = 'standard_edition';
			$plugin_stat_data['version_number'] = LIMIT_ATTEMPTS_BOOSTER_VERSION_NUMBER;
			$plugin_stat_data['status']         = $type;
			$plugin_stat_data['event']          = 'de-activate';
			$plugin_stat_data['domain_url']     = site_url();
			$plugin_stat_data['wp_language']    = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();

			$plugin_stat_data['email']            = false !== $user_admin_email ? $user_admin_email : get_option( 'admin_email' );
			$plugin_stat_data['wp_version']       = $wp_version;
			$plugin_stat_data['php_version']      = esc_html( phpversion() );
			$plugin_stat_data['mysql_version']    = $wpdb->db_version();
			$plugin_stat_data['max_input_vars']   = ini_get( 'max_input_vars' );
			$plugin_stat_data['operating_system'] = PHP_OS . '  (' . PHP_INT_SIZE * 8 . ') BIT';
			$plugin_stat_data['php_memory_limit'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
			$plugin_stat_data['extensions']       = get_loaded_extensions();
			$plugin_stat_data['plugins']          = $plugin_info_limit_attempts_booster->get_plugin_info_limit_attempts_booster();
			$plugin_stat_data['themes']           = $theme_details;

			$response = wp_safe_remote_post(
				$url, array(
					'method'      => 'POST',
					'timeout'     => 45,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking'    => true,
					'headers'     => array(),
					'body'        => array(
						'data'    => maybe_serialize( $plugin_stat_data ),
						'site_id' => false !== get_option( 'lab_tech_banker_site_id' ) ? get_option( 'lab_tech_banker_site_id' ) : '',
						'action'  => 'plugin_analysis_data',
					),
				)
			);

			if ( ! is_wp_error( $response ) ) {
				false !== $response['body'] ? update_option( 'lab_tech_banker_site_id', $response['body'] ) : '';
			}
				die( 'success' );
		}
		/**
		 * Add form layout of deactivation form.
		 */
		function add_form_layout_limit_attempts_booster() {
			?>
			<style type="text/css">
					.limit-attempts-booster-feedback-form .ui-dialog-buttonset {
						float: none !important;
					}
					#limit-attempts-booster-feedback-dialog-continue,#limit-attempts-booster-feedback-dialog-skip {
						float: right;
					}
					#limit-attempts-booster-feedback-cancel{
						float: left;
					}
					#limit-attempts-booster-feedback-content p {
						font-size: 1.1em;
					}
					.limit-attempts-booster-feedback-form .ui-icon {
						display: none;
					}
					#limit-attempts-booster-feedback-dialog-continue.limit-attempts-booster-ajax-progress .ui-icon {
						text-indent: inherit;
						display: inline-block !important;
						vertical-align: middle;
						animation: rotate 2s infinite linear;
					}
					#limit-attempts-booster-feedback-dialog-continue.limit-attempts-booster-ajax-progress .ui-button-text {
						vertical-align: middle;
					}
					@keyframes rotate {
						0%    { transform: rotate(0deg); }
						100%  { transform: rotate(360deg); }
					}
			</style>
			<?php
		}
		/**
		 * Add deactivation dialog form.
		 */
		function add_deactivation_dialog_form_limit_attempts_booster() {
			?>
			<div id="limit-attempts-booster-feedback-content" style="display: none;">
			<p style="margin-top:-5px"><?php echo esc_attr( _e( 'We feel guilty when anyone stop using Limit Attempts Booster', 'limit-attempts-booster' ) ); ?></p>
						<p><?php echo esc_attr( _e( 'If Limit Attempts Booster isn\'t working for you, others also may not', 'limit-attempts-booster' ) ); ?></p>
						<p><?php echo esc_attr( _e( 'We would love to hear your feedback about what went wrong', 'limit-attempts-booster' ) ); ?></p>
						<p><?php echo esc_attr( _e( 'We would like to help you in fixing the issue', 'limit-attempts-booster' ) ); ?></p>
						<p><?php echo esc_attr( _e( 'If you click Continue, some data would be sent to our servers for Compatiblity Testing Purposes.', 'limit-attempts-booster' ) ); ?></p>
						<p><?php echo esc_attr( _e( 'If you Skip, no data would be shared with our servers.', 'limit-attempts-booster' ) ); ?></p>
			<form>
				<?php wp_nonce_field(); ?>
				<ul id="limit-attempts-booster-deactivate-reasons">
					<li class="limit-attempts-booster-reason limit-attempts-booster-custom-input">
						<label>
							<span><input value="0" type="radio" name="reason"/></span>
							<span><?php echo esc_attr( _e( 'The Plugin didn\'t work', 'limit-attempts-booster' ) ); ?></span>
						</label>
					</li>
					<li class="limit-attempts-booster-reason limit-attempts-booster-custom-input">
						<label>
							<span><input value="1" type="radio" name="reason" /></span>
							<span><?php echo esc_attr( _e( 'I found a better Plugin', 'limit-attempts-booster' ) ); ?></span>
						</label>
					</li>
					<li class="limit-attempts-booster-reason">
						<label>
							<span><input value="2" type="radio" name="reason" checked/></span>
							<span><?php echo esc_attr( _e( 'It\'s a temporary deactivation. I\'m just debugging an issue', 'limit-attempts-booster' ) ); ?></span>
						</label>
					</li>
					<li class="limit-attempts-booster-reason limit-attempts-booster-custom-input">
						<label>
							<span><input value="3" type="radio" name="reason" /></span>
							<span><a href="https://wordpress.org/support/plugin/limit-attempts-booster" target="_blank"><?php echo esc_attr( _e( 'Open a Support Ticket for me', 'limit-attempts-booster' ) ); ?></a> </span>
						</label>
					</li>
				</ul>
			</form>
		</div>
		<?php
		}
	}
	$plugin_deactivation_details = new Limit_Attempts_Booster_Deactivation_Form();
}
add_action( 'plugins_loaded', 'add_popup_on_deactivation_limit_attempts_booster' );
/**
 * Insert deactivation link.
 *
 * @param array $links .
 */
function insert_deactivate_link_id_limit_attempts_booster( $links ) {
	if ( ! is_multisite() ) {
		$links['deactivate'] = str_replace( '<a', '<a id="limit-attempts-booster-plugin-disable-link"', $links['deactivate'] );
	}
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'insert_deactivate_link_id_limit_attempts_booster', 10, 2 );
