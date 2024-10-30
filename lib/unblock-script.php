<?php
/**
 * This file is used to unblock ip address.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/lib
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
	if ( wp_verify_nonce( $nonce_unblock_script, 'unblock_script' ) ) {
		if ( strstr( SCHEDULER_NAME, 'ip_address_unblocker_' ) ) {
			$meta_id = explode( 'ip_address_unblocker_', SCHEDULER_NAME );
		} else {
			$meta_id = explode( 'ip_range_unblocker_', SCHEDULER_NAME );
		}
		$where              = array();
		$where_parent       = array();
		$where['meta_id']   = $meta_id[1];
		$where_parent['id'] = $meta_id[1];

		$type = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT type FROM ' . $wpdb->prefix . 'limit_attempts_booster WHERE id = %d', $meta_id[1]
			)
		); // WPCS: db call ok, no-cache ok.

		if ( '' !== $type ) {
			$manage_ip = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_id=%d AND meta_key=%s', $meta_id[1], $type
				)
			);// WPCS: db call ok, no-cache ok.

			$ip_address_data_array = maybe_unserialize( $manage_ip );
			$wpdb->delete( limit_attempts_booster(), $where_parent );// WPCS: db call ok, no-cache ok.
			$wpdb->delete( limit_attempts_booster_meta(), $where );// WPCS: db call ok, no-cache ok.
		}
		unschedule_events_limit_attempts_booster( SCHEDULER_NAME );
	}
}
