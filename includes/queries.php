<?php
/**
 * This file is used to queries.
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
		$lab_map_data = array();
		if ( ! function_exists( 'get_limit_attempts_booster_details' ) ) {
			/**
			 * This function is used to get details.
			 *
			 * @param string $manage_data .
			 */
			function get_limit_attempts_booster_details( $manage_data ) {
				$limit_attempts_id      = array();
				$limit_attempts_details = array();
				if ( isset( $manage_data ) && count( $manage_data ) > 0 ) {
					foreach ( $manage_data as $row ) {
						array_push( $limit_attempts_id, $row->meta_id );
					}
					$limit_attempts_id = array_unique( $limit_attempts_id, SORT_REGULAR );

					foreach ( $limit_attempts_id as $id ) {
						$limit_attempts = get_limit_attempts_booster_data( $id, $manage_data );
						array_push( $limit_attempts_details, $limit_attempts );
					}
				}
				return array_unique( $limit_attempts_details, SORT_REGULAR );
			}
		}

		if ( ! function_exists( 'get_limit_attempts_booster_data' ) ) {
			/**
			 * This function is used to get data.
			 *
			 * @param string $id .
			 * @param string $limit_attempts_details .
			 */
			function get_limit_attempts_booster_data( $id, $limit_attempts_details ) {
				$get_single_detail = array();
				if ( isset( $limit_attempts_details ) && count( $limit_attempts_details ) > 0 ) {
					foreach ( $limit_attempts_details as $row ) {
						if ( $row->meta_id === $id ) {
							$get_single_detail[ $row->meta_key ] = $row->meta_value;// WPCS: slow query ok.
							$get_single_detail['meta_id']        = $row->meta_id;
						}
					}
				}
				return $get_single_detail;
			}
		}
		if ( ! function_exists( 'get_limit_attempts_booster_details_date' ) ) {
			/**
			 * This function is used to get date details.
			 *
			 * @param string $manage_data .
			 * @param string $date1 .
			 * @param string $date2 .
			 */
			function get_limit_attempts_booster_details_date( $manage_data, $date1, $date2 ) {
				$array_details = array();
				if ( isset( $manage_data ) && count( $manage_data ) > 0 ) {
					foreach ( $manage_data as $raw_row ) {
						$unserialize_data            = maybe_unserialize( $raw_row->meta_value );
						$unserialize_data['id']      = $raw_row->id;
						$unserialize_data['meta_id'] = $raw_row->meta_id;
						if ( $unserialize_data['date_time'] >= $date1 && $unserialize_data['date_time'] <= $date2 ) {
							array_push( $array_details, $unserialize_data );
						}
					}
				}
				return $array_details;
			}
		}
		if ( ! function_exists( 'display_cron_arguments_limit_attempts_booster' ) ) {
			/**
			 * This function is used to display crons arguments.
			 *
			 * @param string $key .
			 * @param string $value .
			 * @param string $depth .
			 */
			function display_cron_arguments_limit_attempts_booster( $key, $value, $depth = 0 ) {
				if ( is_string( $value ) ) {
					echo str_repeat( '&nbsp;', ( $depth * 2 ) ) . wp_strip_all_tags( $key ) . ' => ' . esc_html( $value ) . '<br />';// WPCS: XSS ok.
				} elseif ( is_array( $value ) ) {
					if ( count( $value ) > 0 ) {
						echo str_repeat( '&nbsp;', ( $depth * 2 ) ) . wp_strip_all_tags( $key ) . '=> array(<br />';// WPCS: XSS ok.
						$depth++;
						foreach ( $value as $k => $v ) {
							display_cron_arguments_limit_attempts_booster( $k, $v, $depth );
						}
						echo str_repeat( '&nbsp;', ( ( $depth - 1 ) * 2 ) ) . ')';// WPCS: XSS ok.
					}
				}
			}
		}

		if ( ! function_exists( 'get_crons_limit_attempts_booster' ) ) {
			/**
			 * This function is used to get crons.
			 *
			 * @param string $get_schedulers .
			 */
			function get_crons_limit_attempts_booster( $get_schedulers ) {
				$core_events = array();
				foreach ( $get_schedulers as $value => $key ) {
					$arr_key = array_keys( $key );
					foreach ( $arr_key as $value ) {
						array_push( $core_events, $value );
					}
				}

				$core_cron_hooks = array(
					'wp_scheduled_delete',
					'upgrader_scheduled_cleanup',
					'importer_scheduled_cleanup',
					'publish_future_post',
					'akismet_schedule_cron_recheck',
					'akismet_scheduled_delete',
					'do_pings',
					'wp_version_check',
					'wp_update_plugins',
					'wp_update_themes',
					'wp_maybe_auto_update',
					'wp_scheduled_auto_draft_delete',
					'clean_up_booster_license_validator',
					'limit_attempts_booster_license_validator',
					'automatic_updates_limit_attempts_booster',
					'clean_up_optimizer_license_validator',
					'check_plugin_updates-clean-up-booster-personal-edition',
					'check_plugin_updates-clean-up-booster-business-edition',
					'check_plugin_updates-clean-up-booster-developer-edition',
					'check_plugin_updates-limit-attempts-booster-business-edition',
					'check_plugin_updates-limit-attempts-booster-personal-edition',
					'check_plugin_updates-limit-attempts-booster-developer-edition',
					'check_plugin_updates-captcha-booster-business-edition',
					'check_plugin_updates-backup-bank-business-edition',
					'check_plugin_updates-backup-bank-developer-edition',
					'check_plugin_updates-backup-bank-personal-edition',
					'backup_bank_license_validator',
					'check_plugin_updates-captcha-booster-personal-edition',
					'check_plugin_updates-captcha-booster-developer-edition',
					'check_plugin_updates-clean-up-optimizer-business-edition',
					'check_plugin_updates-clean-up-optimizer-personal-edition',
					'check_plugin_updates-clean-up-optimizer-developer-edition',
					'captcha_booster_license_scheduler',
					'mail_booster_license_validator_scheduler',
					'mail_bank_license_validator_scheduler',
					'captcha_bank_license_validator_scheduler',
				);
				foreach ( $core_events as $value ) {
					if ( strstr( $value, 'ip_address_unblocker_' ) ) {
						array_push( $core_cron_hooks, $value );
					} elseif ( strstr( $value, 'ip_range_unblocker_' ) ) {
						array_push( $core_cron_hooks, $value );
					}
				}
				return $core_cron_hooks;
			}
		}

		if ( ! function_exists( 'get_limit_attempts_booster_meta_data' ) ) {
			/**
			 * This function is used to get meta data.
			 *
			 * @param string $meta_key .
			 */
			function get_limit_attempts_booster_meta_data( $meta_key ) {
				global $wpdb;
				$data = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key=%s', $meta_key
					)
				);// db call ok; no-cache ok.
				return maybe_unserialize( $data );
			}
		}
		if ( isset( $_GET['page'] ) ) {
			$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );// WPCS: CSRF ok,WPCS: input var ok.
		}
		$check_limit_attempts_wizard = get_option( 'limit-attempts-wizard-set-up' );
		$licensing_url               = false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : $page;
		if ( isset( $_REQUEST['page'] ) ) { // WPCS: CSRF ok, input var ok.
			switch ( $licensing_url ) {
				case 'lab_limit_attempts_booster':
					$end_date   = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date = $end_date - 604380;

					$last_limit   = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 10', 'recent_login_data'
						)
					);// WPCS: db call ok, no-cache ok.
					$lab_map_data = get_limit_attempts_booster_details_date( $last_limit, $start_date, $end_date );
					break;

				case 'lab_visitor_logs_dashboard':
					$visitor_logs_data = get_limit_attempts_booster_meta_data( 'other_settings' );
					if ( 'enable' === $visitor_logs_data['visitor_logs_monitoring'] ) {
						$end_date            = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
						$start_date          = $end_date - 172640;
						$live_traffic_module = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 10', 'visitor_log_data'
							)
						);// WPCS: db call ok, no-cache ok.
						$lab_map_data        = get_limit_attempts_booster_details_date( $live_traffic_module, $start_date, $end_date );
					}
					break;

				case 'lab_last_blocked_ip_addresses':
					$end_date   = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date = $end_date - 2678340;
					$manage_ip  = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 10', 'block_ip_address'
						)
					);// WPCS: db call ok, no-cache ok.

					$manage_ip_address = get_limit_attempts_booster_details_date( $manage_ip, $start_date, $end_date );
					break;

				case 'lab_last_blocked_ip_ranges':
					$end_date         = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date       = $end_date - 2678340;
					$manage_range     = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 10', 'block_ip_range'
						)
					);// WPCS: db call ok, no-cache ok.
					$manage_ip_ranges = get_limit_attempts_booster_details_date( $manage_range, $start_date, $end_date );
					break;

				case 'lab_live_traffic':
					$visitor_logs_data = get_limit_attempts_booster_meta_data( 'other_settings' );
					if ( 'enable' === $visitor_logs_data['live_traffic_monitoring'] ) {
						$end_date          = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
						$start_date        = $end_date - 60;
						$live_traffic_data = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC', 'visitor_log_data'
							)
						);// WPCS: db call ok, no-cache ok.
						$lab_map_data      = get_limit_attempts_booster_details_date( $live_traffic_data, $start_date, $end_date );
					}
					break;

				case 'lab_recent_logs':
					$end_date   = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date = $end_date - 604380;

					$login_logs   = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC', 'recent_login_data'
						)
					);// WPCS: db call ok, no-cache ok.
					$lab_map_data = get_limit_attempts_booster_details_date( $login_logs, $start_date, $end_date );
					break;

				case 'lab_visitor_logs':
					$visitor_logs_data = get_limit_attempts_booster_meta_data( 'other_settings' );
					if ( 'enable' === $visitor_logs_data['visitor_logs_monitoring'] ) {
						$end_date          = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
						$start_date        = $end_date - 172640;
						$live_traffic_data = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC', 'visitor_log_data'
							)
						);// WPCS: db call ok, no-cache ok.
						$lab_map_data      = get_limit_attempts_booster_details_date( $live_traffic_data, $start_date, $end_date );
					}

					break;

				case 'lab_alert_setup':
					$meta_data_array = get_limit_attempts_booster_meta_data( 'alert_setup' );
					break;

				case 'lab_error_messages':
					$meta_data_array = get_limit_attempts_booster_meta_data( 'error_message' );
					break;

				case 'lab_other_settings':
					$meta_data_array = get_limit_attempts_booster_meta_data( 'other_settings' );

					$trackbacks_status = $wpdb->get_var(
						$wpdb->prepare(
							'SELECT count(ping_status) FROM ' . $wpdb->posts .
							' WHERE ping_status=%s', 'open'
						)
					);// WPCS: db call ok, no-cache ok.

					$comments_status = $wpdb->get_var(
						$wpdb->prepare(
							'SELECT count(comment_status) FROM ' . $wpdb->posts .
							' WHERE comment_status=%s', 'open'
						)
					);// WPCS: db call ok, no-cache ok.
					break;

				case 'lab_blocking_options':
					$blocking_option_array = get_limit_attempts_booster_meta_data( 'blocking_options' );

					break;

				case 'lab_manage_ip_addresses':
					$end_date   = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date = $end_date - 2678340;
					$manage_ip  = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC', 'block_ip_address'
						)
					);// WPCS: db call ok, no-cache ok.

					$manage_ip_address = get_limit_attempts_booster_details_date( $manage_ip, $start_date, $end_date );
					break;

				case 'lab_manage_ip_ranges':
					$end_date        = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME + 86340;
					$start_date      = $end_date - 2678340;
					$manage_range    = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ORDER BY meta_id DESC', 'block_ip_range'
						)
					);// WPCS: db call ok, no-cache ok.
					$manage_ip_range = get_limit_attempts_booster_details_date( $manage_range, $start_date, $end_date );
					break;

				case 'lab_country_blocks':
					$country_data_array = get_limit_attempts_booster_meta_data( 'country_blocks' );
					break;

				case 'lab_roles_and_capabilities':
					$details_roles_capabilities = get_limit_attempts_booster_meta_data( 'roles_and_capabilities' );
					$other_roles_access_array   = array(
						'manage_options',
						'edit_plugins',
						'edit_posts',
						'publish_posts',
						'publish_pages',
						'edit_pages',
						'read',
					);
					$other_roles_array          = isset( $details_roles_capabilities['capabilities'] ) && '' !== $details_roles_capabilities['capabilities'] ? $details_roles_capabilities['capabilities'] : $other_roles_access_array;
					break;

				case 'lab_core_cron_jobs':
					$get_schedulers   = _get_cron_array();
					$schedule_details = wp_get_schedules();
					$core_cron_hooks  = get_crons_limit_attempts_booster( $get_schedulers );
					break;

				case 'lab_custom_cron_jobs':
					$schedulers       = _get_cron_array();
					$schedule_details = wp_get_schedules();
					$core_cron_hooks  = get_crons_limit_attempts_booster( $schedulers );
					break;
			}
		}
	}
}
