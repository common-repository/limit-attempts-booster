<?php
/**
 * This file is used to display adminbar menu.
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
				$flag = $capabilities[0];
				break;

			case 'author':
				$flag = $capabilities[1];
				break;

			case 'editor':
				$flag = $capabilities[2];
				break;

			case 'contributor':
				$flag = $capabilities[3];
				break;

			case 'subscriber':
				$flag = $capabilities[4];
				break;

			default:
				$flag = $capabilities[5];
				break;
		}

		if ( '1' === $flag ) {
			$wp_admin_bar->add_menu(
				array(
					'id'    => 'limit_attempts_booster',
					'title' => '<img style="width:16px; height:16px; vertical-align:middle; margin-right:3px; display:inline-block;" src=' . plugins_url( 'assets/global/img/icons.png', dirname( __FILE__ ) ) . '> ' . $lab_limit_attempts,
					'href'  => admin_url( 'admin.php?page=lab_limit_attempts_booster' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'dashboard_limit_attempts',
					'title'  => $lab_dashboard,
					'href'   => admin_url( 'admin.php?page=lab_limit_attempts_booster' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'logs_limit_attempts',
					'title'  => $lab_logs,
					'href'   => admin_url( 'admin.php?page=lab_recent_logs' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'advance_security_limit_attempts',
					'title'  => $lab_advance_security,
					'href'   => admin_url( 'admin.php?page=lab_blocking_options' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'general_settings_limit_attempts',
					'title'  => $lab_general_settings,
					'href'   => admin_url( 'admin.php?page=lab_alert_setup' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'email_templates_limit_attempts',
					'title'  => $lab_email_templates_menu,
					'href'   => admin_url( 'admin.php?page=lab_email_templates' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'roles_and_capabilities_limit_attempts',
					'title'  => $lab_roles_and_capability,
					'href'   => admin_url( 'admin.php?page=lab_roles_and_capabilities' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'cron_jobs_limit_attempts',
					'title'  => $lab_cron_jobs,
					'href'   => admin_url( 'admin.php?page=lab_custom_cron_jobs' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'feature_requests_limit_attempts',
					'title'  => $lab_feature_requests,
					'href'   => 'https://wordpress.org/support/plugin/limit-attempts-booster',
					'meta'   => array( 'target' => '_blank' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'system_information_limit_attempts',
					'title'  => $lab_system_information,
					'href'   => admin_url( 'admin.php?page=lab_system_information' ),
				)
			);

			$wp_admin_bar->add_menu(
				array(
					'parent' => 'limit_attempts_booster',
					'id'     => 'system_information_limit_attempts',
					'title'  => $lab_upgrade,
					'href'   => 'https://tech-banker.com/limit-attempts-booster/pricing/',
					'meta'   => array( 'target' => '_blank' ),
				)
			);
		}
	}
}
