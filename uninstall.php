<?php
/**
 * This file is used to create drop tables at the uninstallation of plugin.
 *
 * @author  tech-banker
 * @package limit-attempts-booster
 * @version 2.1.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
} else {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	} else {
		global $wpdb;
		if ( is_multisite() ) {
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );// db call ok; no-cache ok.
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );// @codingStandardsIgnoreLine.
				$limit_attempts_booster_version_number = get_option( 'limit_attempts_booster_version_number' );
				if ( false !== $limit_attempts_booster_version_number ) {
					global $wp_version, $wpdb;
					$other_settings_data              = $wpdb->get_var(
						$wpdb->prepare(
							'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ', 'other_settings'
						)
					);// db call ok; no-cache ok.
					$other_settings_unserialized_data = maybe_unserialize( $other_settings_data );

					if ( 'enable' === esc_attr( $other_settings_unserialized_data['uninstall_plugin'] ) ) {
						$block_unblock_ip_range_and_address_scheduled = $wpdb->get_results(
							$wpdb->prepare(
								'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster WHERE type IN(%s, %s) ', 'block_ip_address', 'block_ip_range'
							)
						);// db call ok; no-cache ok.

						// Unschedule Schedulers.
						if ( count( $block_unblock_ip_range_and_address_scheduled ) > 0 ) {
							foreach ( $block_unblock_ip_range_and_address_scheduled as $value ) {
								if ( 'block_ip_address' === $value->type ) {
									if ( wp_next_scheduled( 'ip_address_unblocker_' . $value->id ) ) {
										wp_clear_scheduled_hook( 'ip_address_unblocker_' . $value->id );
									}
								} elseif ( 'block_ip_range' === $value->type ) {
									if ( wp_next_scheduled( 'ip_range_unblocker_' . $value->id ) ) {
										wp_clear_scheduled_hook( 'ip_range_unblocker_' . $value->id );
									}
								}
							}
						}
						$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster' );// @codingStandardsIgnoreLine.
						$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster_meta' );// @codingStandardsIgnoreLine.
						$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster_ip_locations' );// @codingStandardsIgnoreLine.

						delete_option( 'limit_attempts_booster_version_number' );
						delete_option( 'lab_admin_notice' );
						delete_option( 'limit-attempts-wizard-set-up' );
					}
				}
				restore_current_blog();
			}
		} else {
			$limit_attempts_booster_version_number = get_option( 'limit_attempts_booster_version_number' );
			if ( false !== $limit_attempts_booster_version_number ) {
				global $wp_version, $wpdb;
				$other_settings_data              = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key = %s ', 'other_settings'
					)
				);// db call ok; no-cache ok.
				$other_settings_unserialized_data = maybe_unserialize( $other_settings_data );

				if ( 'enable' === esc_attr( $other_settings_unserialized_data['uninstall_plugin'] ) ) {
					$block_unblock_ip_range_and_address_scheduled = $wpdb->get_results(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster WHERE type IN(%s, %s) ', 'block_ip_address', 'block_ip_range'
						)
					);// db call ok; no-cache ok.

					// Unschedule Schedulers.
					if ( count( $block_unblock_ip_range_and_address_scheduled ) > 0 ) {
						foreach ( $block_unblock_ip_range_and_address_scheduled as $value ) {
							if ( 'block_ip_address' === $value->type ) {
								if ( wp_next_scheduled( 'ip_address_unblocker_' . $value->id ) ) {
									wp_clear_scheduled_hook( 'ip_address_unblocker_' . $value->id );
								}
							} elseif ( 'block_ip_range' === $value->type ) {
								if ( wp_next_scheduled( 'ip_range_unblocker_' . $value->id ) ) {
									wp_clear_scheduled_hook( 'ip_range_unblocker_' . $value->id );
								}
							}
						}
					}
					$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster' );// @codingStandardsIgnoreLine.
					$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster_meta' );// @codingStandardsIgnoreLine.
					$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster_ip_locations' );// @codingStandardsIgnoreLine.

					delete_option( 'limit_attempts_booster_version_number' );
					delete_option( 'lab_admin_notice' );
				}
			}
		}
	}
}
