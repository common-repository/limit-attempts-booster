<?php
/**
 * This file is used to update data.
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
		if ( ! function_exists( 'get_limit_attempts_booster_unserialize_data' ) ) {
			/**
			 * This Function is used to get unserailzed data.
			 *
			 * @param string $manage_data .
			 */
			function get_limit_attempts_booster_unserialize_data( $manage_data ) {
				$unserialize_complete_data = array();
				if ( count( $manage_data ) > 0 ) {
					foreach ( $manage_data as $value ) {
						$unserialize_data            = maybe_unserialize( $value->meta_value );
						$unserialize_data['meta_id'] = $value->meta_id;
						array_push( $unserialize_complete_data, $unserialize_data );
					}
				}
				return $unserialize_complete_data;
			}
		}

		if ( ! function_exists( 'get_limit_attempts_booster_details_date_serialization' ) ) {
			/**
			 * This Function is used to get date details.
			 *
			 * @param string $limit_attempts_manage .
			 * @param string $date1 .
			 * @param string $date2 .
			 */
			function get_limit_attempts_booster_details_date_serialization( $limit_attempts_manage, $date1, $date2 ) {
				$limit_attempts_details = array();
				foreach ( $limit_attempts_manage as $raw_row ) {
					$row = maybe_unserialize( $raw_row->meta_value );
					if ( $row['date_time'] >= $date1 && $row['date_time'] <= $date2 ) {
						array_push( $limit_attempts_details, $row );
					}
				}
				return $limit_attempts_details;
			}
		}
		if ( isset( $_REQUEST['param'] ) ) {// WPCS: CSRF ok, input var ok.
			$obj_dbhelper_limit_attempts_booster = new Dbhelper_Limit_Attempts_Booster();
			switch ( sanitize_text_field( wp_unslash( $_REQUEST['param'] ) ) ) { // WPCS: CSRF ok, input var ok.
				case 'wizard_limit_attempts_booster':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_check_status' ) ) {// WPCS: CSRF ok, input var ok.
						$type             = isset( $_REQUEST['type'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['type'] ) ) : '';// WPCS: CSRF ok, input var ok.
						$user_admin_email = isset( $_REQUEST['id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['id'] ) ) : '';// WPCS: CSRF ok, input var ok.
						if ( '' === $user_admin_email ) {
							$user_admin_email = get_option( 'admin_email' );
						}
						update_option( 'limit-attempts-booster-admin-email', $user_admin_email );
						update_option( 'limit-attempts-wizard-set-up', $type );
						if ( 'opt_in' === $type ) {
							$plugin_info_limit_attempts_booster = new Plugin_Info_Limit_Attempts_Booster();
							global $wp_version;
							$url           = TECH_BANKER_STATS_URL . '/wp-admin/admin-ajax.php';
							$theme_details = array();
							if ( $wp_version >= 3.4 ) {
								$active_theme                   = wp_get_theme();
								$theme_details['theme_name']    = strip_tags( $active_theme->name );
								$theme_details['theme_version'] = strip_tags( $active_theme->version );
								$theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
							}
							$plugin_stat_data                     = array();
							$plugin_stat_data['plugin_slug']      = 'limit-attempts-booster';
							$plugin_stat_data['type']             = 'standard_edition';
							$plugin_stat_data['version_number']   = LIMIT_ATTEMPTS_BOOSTER_VERSION_NUMBER;
							$plugin_stat_data['status']           = $type;
							$plugin_stat_data['event']            = 'activate';
							$plugin_stat_data['domain_url']       = site_url();
							$plugin_stat_data['wp_language']      = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
							$plugin_stat_data['email']            = $user_admin_email;
							$plugin_stat_data['wp_version']       = $wp_version;
							$plugin_stat_data['php_version']      = sanitize_text_field( phpversion() );
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
						}
					}
					break;

				case 'limit_attempts_last_login_delete_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_last_10_login_log_delete' ) ) {// WPCS: input var ok.
						$where              = array();
						$where_parent       = array();
						$log_id             = isset( $_REQUEST['log_id'] ) ? intval( $_REQUEST['log_id'] ) : 0;// WPCS: input var ok.
						$where['meta_id']   = $log_id;
						$where_parent['id'] = $log_id;
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_dashboard_visitor_delete_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_visitor_logs_delete' ) ) {// WPCS: input var ok.
						$where              = array();
						$where_parent       = array();
						$real_id            = isset( $_REQUEST['real_id'] ) ? intval( $_REQUEST['real_id'] ) : 0;// WPCS: input var ok.
						$where['meta_id']   = $real_id;
						$where_parent['id'] = $real_id;
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_last_login_delete_ip_address':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_delete_ip_address' ) ) {// WPCS: input var ok.
						$id                 = isset( $_REQUEST['id_address'] ) ? intval( $_REQUEST['id_address'] ) : 0;// WPCS: input var ok, sanitization ok.
						$where              = array();
						$where_parent       = array();
						$where['meta_id']   = $id;
						$where_parent['id'] = $id;
						$cron_name          = 'ip_address_unblocker_' . $id;
						unschedule_events_limit_attempts_booster( $cron_name );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_delete_ip_ranges_last_login':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_delete_ip_ranges' ) ) {// WPCS: input var ok.
						$where              = array();
						$where_parent       = array();
						$id_address         = isset( $_REQUEST['id_address'] ) ? intval( $_REQUEST['id_address'] ) : 0;// WPCS: input var ok, sanitization ok.
						$where['meta_id']   = $id_address;
						$where_parent['id'] = $id_address;
						$cron_name          = 'ip_range_unblocker_' . $where['meta_id'];
						unschedule_events_limit_attempts_booster( $cron_name );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_blocking_options_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_block' ) ) {// WPCS: input var ok.
						parse_str( isset( $_REQUEST['data'] ) ? base64_decode( wp_unslash( filter_input( INPUT_POST, 'data' ) ) ) : '', $blocking_options_array );// WPCS: input var ok.
						$update_blocking_options = array();
						$where                   = array();

						$update_blocking_options['auto_ip_block']                  = sanitize_text_field( $blocking_options_array['ux_ddl_auto_ip'] );
						$update_blocking_options['maximum_login_attempt_in_a_day'] = intval( $blocking_options_array['ux_txt_login'] );
						$update_blocking_options['block_for']                      = sanitize_text_field( $blocking_options_array['ux_ddl_blocked_for'] );

						$update_block_data               = array();
						$where['meta_key']               = 'blocking_options';// WPCS: slow query ok.
						$update_block_data['meta_value'] = maybe_serialize( $update_blocking_options );// WPCS: slow query ok.
						$obj_dbhelper_limit_attempts_booster->update_command( limit_attempts_booster_meta(), $update_block_data, $where );
					}
					break;

				case 'limit_attempts_other_settings_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_other_settings' ) ) {// WPCS: input var ok.
						parse_str( isset( $_REQUEST['data'] ) ? base64_decode( wp_unslash( $_REQUEST['data'] ) ) : '', $update_array );// WPCS: input var ok, sanitization ok.
						$update_limit_attempts_type = array();
						$where                      = array();
						if ( 'enable' === $update_array['ux_ddl_trackback'] ) {
							$trackback = $wpdb->query(
								$wpdb->prepare(
									'UPDATE ' . $wpdb->posts . ' SET ping_status=%s', 'open'
								)
							);// db call ok; no-cache ok.
						} else {
							$trackback = $wpdb->query(
								$wpdb->prepare(
									'UPDATE ' . $wpdb->posts . ' SET ping_status=%s', 'closed'
								)
							);// db call ok; no-cache ok.
						}
						if ( 'enable' === $update_array['ux_ddl_Comments'] ) {
							$comments = $wpdb->query(
								$wpdb->prepare(
									'UPDATE ' . $wpdb->posts . ' SET comment_status=%s', 'open'
								)
							);// db call ok; no-cache ok.
						} else {
							$comments = $wpdb->query(
								$wpdb->prepare(
									'UPDATE ' . $wpdb->posts . ' SET comment_status=%s', 'closed'
								)
							);// db call ok; no-cache ok.
						}
						$update_limit_attempts_type['live_traffic_monitoring']    = sanitize_text_field( $update_array['ux_ddl_live_traffic_monitoring'] );
						$update_limit_attempts_type['visitor_logs_monitoring']    = sanitize_text_field( $update_array['ux_ddl_visitor_logs_monitoring'] );
						$update_limit_attempts_type['uninstall_plugin']           = sanitize_text_field( $update_array['ux_ddl_plugin_uninstall'] );
						$update_limit_attempts_type['ip_address_fetching_method'] = sanitize_text_field( $update_array['ux_ddl_ip_address_fetching_method'] );

						$update_data               = array();
						$where['meta_key']         = 'other_settings';// WPCS: slow query ok.
						$update_data['meta_value'] = maybe_serialize( $update_limit_attempts_type );// WPCS: slow query ok.
						$obj_dbhelper_limit_attempts_booster->update_command( limit_attempts_booster_meta(), $update_data, $where );
					}
					break;

				case 'limit_attempts_manage_ip_address_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_manage_ip_address' ) ) {// WPCS: input var ok.
						parse_str( isset( $_REQUEST['data'] ) ? base64_decode( wp_unslash( filter_input( INPUT_POST, 'data' ) ) ) : '', $advance_security_data );// WPCS: input var ok.
						$ip = isset( $_REQUEST['lab_ip_address'] ) ? sprintf( '%u', ip2long( sanitize_text_field( wp_unslash( $_REQUEST['lab_ip_address'] ) ) ) ) : 0;// WPCS: input var ok.

						$blocked_for = sanitize_text_field( $advance_security_data['ux_ddl_ip_blocked_for'] );

						$get_ip   = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $ip ) );
						$location = '' == $get_ip->country_name && '' == $get_ip->city ? '' : '' == $get_ip->country_name ? '' : '' == $get_ip->city ? $get_ip->country_name : $get_ip->city . ', ' . $get_ip->country_name;// WPCS: loose comparison ok.

						$ip_address_count = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'block_ip_address'
							)
						);// db call ok; no-cache ok.
						if ( isset( $ip_address_count ) && count( $ip_address_count ) > 0 ) {
							foreach ( $ip_address_count as $data ) {
								$ip_address_unserialize = maybe_unserialize( $data->meta_value );
								if ( $ip === $ip_address_unserialize['ip_address'] ) {
									echo '1';
									die();
								}
							}
						}
						$ip_address_ranges_data = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'block_ip_range'
							)
						);// db call ok; no-cache ok.
						$ip_exists              = false;
						if ( isset( $ip_address_ranges_data ) && count( $ip_address_ranges_data ) > 0 ) {
							foreach ( $ip_address_ranges_data as $data ) {
								$ip_range_unserialized_data = maybe_unserialize( $data->meta_value );
								$data_range                 = explode( ',', $ip_range_unserialized_data['ip_range'] );
								if ( $ip >= $data_range[0] && $ip <= $data_range[1] ) {
									$ip_exists = true;
									break;
								}
							}
						}
						$lab_ip_address  = get_ip_address_limit_attempts_booster();
						$user_ip_address = '::1' === $lab_ip_address ? sprintf( '%u', ip2long( '127.0.0.1' ) ) : sprintf( '%u', ip2long( $lab_ip_address ) );
						if ( true === $ip_exists ) {
							echo 1;
						} elseif ( $user_ip_address === $ip ) {
							echo 2;
						} else {
							$insert_manage_ip_address              = array();
							$insert_manage_ip_address['type']      = 'block_ip_address';
							$insert_manage_ip_address['parent_id'] = '0';
							$last_id                               = $obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster(), $insert_manage_ip_address );

							$insert_manage_ip_address                = array();
							$insert_manage_ip_address['ip_address']  = $ip;
							$insert_manage_ip_address['blocked_for'] = $blocked_for;
							$insert_manage_ip_address['location']    = $location;
							$insert_manage_ip_address['comments']    = $advance_security_data['ux_txtarea_ip_comments'];
							$timestamp                               = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
							$insert_manage_ip_address['date_time']   = $timestamp;

							$insert_data               = array();
							$insert_data['meta_id']    = $last_id;
							$insert_data['meta_key']   = 'block_ip_address';// WPCS: slow query ok.
							$insert_data['meta_value'] = maybe_serialize( $insert_manage_ip_address );// WPCS: slow query ok.
							$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $insert_data );

							if ( 'permanently' !== $blocked_for ) {
								$cron_name = 'ip_address_unblocker_' . $last_id;
								schedule_limit_attempts_booster_ip_address_range( $cron_name, $blocked_for );
							}
						}
					}
					break;

				case 'limit_attempts_delete_ip_address_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_manage_ip_address_delete' ) ) {// WPCS: CSRF ok, input var ok, sanitization ok.
						$id                 = isset( $_REQUEST['id_address'] ) ? intval( $_REQUEST['id_address'] ) : 0;// WPCS: input var ok.
						$where              = array();
						$where_parent       = array();
						$where['meta_id']   = $id;
						$where_parent['id'] = $id;
						$cron_name          = 'ip_address_unblocker_' . $id;
						unschedule_events_limit_attempts_booster( $cron_name );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_delete_ip_range_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_manage_ip_ranges_delete' ) ) {// WPCS: input var ok.
						$where_meta            = array();
						$where_parent          = array();
						$id_range              = isset( $_REQUEST['id_range'] ) ? intval( $_REQUEST['id_range'] ) : 0;// WPCS: input var ok.
						$where_meta['meta_id'] = $id_range;
						$where_parent['id']    = $id_range;
						$cron_name             = 'ip_range_unblocker_' . $where_meta['meta_id'];
						unschedule_events_limit_attempts_booster( $cron_name );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where_meta );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_manage_ip_ranges_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_manage_ip_ranges' ) ) {// WPCS: CSRF ok, input var ok.
						parse_str( isset( $_REQUEST['data'] ) ? base64_decode( wp_unslash( filter_input( INPUT_POST, 'data' ) ) ) : '', $ip_range_data );// WPCS: CSRF ok, input var ok.
						$start_ip_range = isset( $_REQUEST['start_range'] ) ? sprintf( '%u', ip2long( sanitize_text_field( wp_unslash( $_REQUEST['start_range'] ) ) ) ) : 0;// WPCS: input var ok.
						$end_ip_range   = isset( $_REQUEST['end_range'] ) ? sprintf( '%u', ip2long( sanitize_text_field( wp_unslash( $_REQUEST['end_range'] ) ) ) ) : 0;// WPCS: input var ok.

						$blocked_for = sanitize_text_field( $ip_range_data['ux_ddl_range_blocked'] );
						$ip_range    = $start_ip_range . ',' . $end_ip_range;
						$get_ip      = lab_get_ip_location_limit_attempts_booster( long2ip_limit_attempts_booster( $start_ip_range ) );
						$location    = '' == $get_ip->country_name && '' == $get_ip->city ? '' : '' == $get_ip->country_name ? '' : '' == $get_ip->city ? $get_ip->country_name : $get_ip->city . ', ' . $get_ip->country_name;// WPCS: loose comparison ok.

						$ip_address_range_data = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', 'block_ip_range'
							)
						);// db call ok; no-cache ok.
						$ip_exists             = false;
						if ( isset( $ip_address_range_data ) && count( $ip_address_range_data ) > 0 ) {
							foreach ( $ip_address_range_data as $data ) {
								$ip_range_unserialized_data = maybe_unserialize( $data->meta_value );
								$data_range                 = explode( ',', $ip_range_unserialized_data['ip_range'] );
								if ( ( $start_ip_range >= $data_range[0] && $start_ip_range <= $data_range[1] ) || ( $end_ip_range >= $data_range[0] && $end_ip_range <= $data_range[1] ) ) {
									echo 1;
									$ip_exists = true;
									break;
								} elseif ( ( $start_ip_range <= $data_range[0] && $start_ip_range <= $data_range[1] ) && ( $end_ip_range >= $data_range[0] && $end_ip_range >= $data_range[1] ) ) {
									echo 1;
									$ip_exists = true;
									break;
								}
							}
						}
						$lab_ip_address  = get_ip_address_limit_attempts_booster();
						$user_ip_address = '::1' === $lab_ip_address ? sprintf( '%u', ip2long( '127.0.0.1' ) ) : sprintf( '%u', ip2long( $lab_ip_address ) );
						if ( $user_ip_address >= $start_ip_range && $user_ip_address <= $end_ip_range ) {
							echo 2;
							$ip_exists = true;
							break;
						}
						if ( false === $ip_exists ) {
							$insert_manage_ip_range              = array();
							$insert_manage_ip_range['type']      = 'block_ip_range';
							$insert_manage_ip_range['parent_id'] = '0';
							$last_id                             = $obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster(), $insert_manage_ip_range );

							$insert_manage_ip_range                = array();
							$insert_manage_ip_range['ip_range']    = $ip_range;
							$insert_manage_ip_range['blocked_for'] = $blocked_for;
							$insert_manage_ip_range['location']    = $location;
							$insert_manage_ip_range['comments']    = htmlspecialchars_decode( $ip_range_data['ux_txtarea_manage_ip_range'] );
							$timestamp                             = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
							$insert_manage_ip_range['date_time']   = $timestamp;

							$insert_data               = array();
							$insert_data['meta_id']    = $last_id;
							$insert_data['meta_key']   = 'block_ip_range';// WPCS: slow query ok.
							$insert_data['meta_value'] = maybe_serialize( $insert_manage_ip_range );// WPCS: slow query ok.
							$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $insert_data );

							if ( 'permanently' !== $blocked_for ) {
								$cron_name = 'ip_range_unblocker_' . $last_id;
								schedule_limit_attempts_booster_ip_address_range( $cron_name, $blocked_for );
							}
						}
					}
					break;

				case 'limit_attempts_delete_selected_recent_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_recent_selected_delete' ) ) {// WPCS: input var ok.
						$where              = array();
						$where_parent       = array();
						$login_id           = isset( $_REQUEST['login_id'] ) ? intval( $_REQUEST['login_id'] ) : 0;// WPCS: input var ok.
						$where['meta_id']   = $login_id;
						$where_parent['id'] = $login_id;
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_delete_selected_live_visitor_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_traffic_delete' ) ) {// WPCS: input var ok.
						$where_meta            = array();
						$where_parent          = array();
						$confirm_id            = isset( $_REQUEST['confirm_id'] ) ? intval( $_REQUEST['confirm_id'] ) : 0;// WPCS: input var ok.
						$where_meta['meta_id'] = $confirm_id;
						$where_parent['id']    = $confirm_id;
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster_meta(), $where_meta );
						$obj_dbhelper_limit_attempts_booster->delete_command( limit_attempts_booster(), $where_parent );
					}
					break;

				case 'limit_attempts_change_email_template_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_email_template_data' ) ) { // WPCS: input var ok.
						$templates      = sanitize_text_field( wp_unslash( $_REQUEST['data'] ) );// WPCS: input var ok.
						$templates_data = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s', $templates
							)
						);// db call ok; no-cache ok.

						$email_template_data = get_limit_attempts_booster_unserialize_data( $templates_data );
						echo wp_json_encode( $email_template_data );
					}
					break;

				case 'limit_attempts_delete_custom_cron_job_module':
					if ( wp_verify_nonce( isset( $_REQUEST['_wp_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wp_nonce'] ) ) : '', 'limit_attempts_delete_custom_cron_jobs' ) ) {// WPCS: input var ok.
						$cron_name = isset( $_REQUEST['scheduler'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['scheduler'] ) ) : '';// WPCS: input var ok.
						unschedule_events_limit_attempts_booster( $cron_name );
					}
					break;
			}
			die();
		}
	}
}
