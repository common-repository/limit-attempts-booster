<?php
/**
 * This file is used to create tables insert defalut data.
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
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	} else {
		if ( ! class_exists( 'Dbhelper_Install_Script_Limit_Attempts_Booster' ) ) {
			/**
			 * Class Name: Dbhelper_Install_Script_Limit_Attempts_Booster
			 * Parameters: No
			 * Description: This Class is used for Insert Update and Delete operations.
			 * Created On: 23-09-2015 1:10
			 * Created By: Tech Banker Team
			 */
			class Dbhelper_Install_Script_Limit_Attempts_Booster {
				/**
				 * This Function is used for Insert data in database.
				 *
				 * @param string $table_name .
				 * @param string $data .
				 */
				public function insert_command( $table_name, $data ) {
					global $wpdb;
					$wpdb->insert( $table_name, $data );// db call ok; no-cache ok.
					return $wpdb->insert_id;
				}
				/**
				 * This function is used for Update data.
				 *
				 * @param string $table_name .
				 * @param string $data .
				 * @param string $where .
				 */
				public function update_command( $table_name, $data, $where ) {
					global $wpdb;
					$wpdb->update( $table_name, $data, $where );// db call ok; no-cache ok.
				}
				/**
				 * This function is used for delete data.
				 *
				 * @param string $table_name .
				 * @param string $where .
				 */
				public function delete_command( $table_name, $where ) {
					global $wpdb;
					$wpdb->delete( $table_name, $where );// db call ok; no-cache ok.
				}
			}
		}

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$limit_attempts_booster_version_number = get_option( 'limit_attempts_booster_version_number' );
		$obj_dbhelper_limit_attempts_booster   = new Dbhelper_Install_Script_Limit_Attempts_Booster();

		if ( ! function_exists( 'limit_attempts_booster_table' ) ) {
			/**
			 * This function is used for creating "limit_attempts_booster" table in database.
			 */
			function limit_attempts_booster_table() {
				global $wpdb;
				$collate = $wpdb->get_charset_collate();
				$sql     = 'CREATE TABLE IF NOT EXISTS ' . limit_attempts_booster() . '
				(
					`id` int(10) NOT NULL AUTO_INCREMENT,
					`type` longtext NOT NULL,
					`parent_id` int(10) DEFAULT NULL,
					 PRIMARY KEY (`id`)
				)' . $collate;
				dbDelta( $sql );

				$data = 'INSERT INTO ' . limit_attempts_booster() . " (`type`, `parent_id`) VALUES
				('roles_and_capabilities', 0),
				('collation_type', 0),
				('advance_security', 0),
				('email_templates', 0),
				('general_settings', 0)";

				dbDelta( $data );

				$parent_table = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'limit_attempts_booster' );// db call ok; no-cache ok.

				$obj_dbhelper_limit_attempts_booster = new Dbhelper_Install_Script_Limit_Attempts_Booster();
				if ( isset( $parent_table ) && count( $parent_table ) > 0 ) {
					foreach ( $parent_table as $parent ) {
						switch ( $parent->type ) {
							case 'advance_security':
								$insert_parent_value                     = array();
								$insert_parent_value['blocking_options'] = $parent->id;
								$insert_parent_value['country_blocks']   = $parent->id;
								foreach ( $insert_parent_value as $keys => $value ) {
									$insert_advance_security_data              = array();
									$insert_advance_security_data['type']      = $keys;
									$insert_advance_security_data['parent_id'] = $value;
									$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster(), $insert_advance_security_data );
								}
								break;

							case 'general_settings':
								$insert_into_parent                   = array();
								$insert_into_parent['alert_setup']    = $parent->id;
								$insert_into_parent['error_message']  = $parent->id;
								$insert_into_parent['other_settings'] = $parent->id;
								foreach ( $insert_into_parent as $keys => $value ) {
									$insert_parent_value              = array();
									$insert_parent_value['type']      = $keys;
									$insert_parent_value['parent_id'] = $value;
									$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster(), $insert_parent_value );
								}
								break;
						}
					}
				}
			}
		}

		if ( ! function_exists( 'limit_attempts_booster_meta_table' ) ) {
			/**
			 * This function is used for creating "limit_attempts_booster_meta" table in database.
			 */
			function limit_attempts_booster_meta_table() {
				global $wpdb;
				$collate = $wpdb->get_charset_collate();
				$sql     = 'CREATE TABLE IF NOT EXISTS ' . limit_attempts_booster_meta() . '
				(
					`id` int(10) NOT NULL AUTO_INCREMENT,
					`meta_id` int(10) NOT NULL,
					`meta_key` varchar(200) NOT NULL,
					`meta_value` longtext,
					PRIMARY KEY(`id`)
				)' . $collate;
				dbDelta( $sql );

				$admin_email = get_option( 'admin_email' );
				$admin_name  = get_option( 'blogname' );

				$parent_table_data = $wpdb->get_results( 'SELECT id,type FROM ' . $wpdb->prefix . 'limit_attempts_booster' );// db call ok; no-cache ok.

				$obj_dbhelper_limit_attempts_booster = new Dbhelper_Install_Script_Limit_Attempts_Booster();
				if ( isset( $parent_table_data ) && count( $parent_table_data ) > 0 ) {
					foreach ( $parent_table_data as $row ) {
						switch ( $row->type ) {
							case 'roles_and_capabilities':
								$roles_and_capabilities_data['roles_and_capabilities']                   = '1,1,1,0,0,0';
								$roles_and_capabilities_data['show_limit_attempts_booster_top_bar_menu'] = 'enable';
								$roles_and_capabilities_data['administrator_privileges']                 = '1,1,1,1,1,1,1,1,1,1';
								$roles_and_capabilities_data['author_privileges']                        = '0,1,1,0,0,1,0,1,0,0';
								$roles_and_capabilities_data['editor_privileges']                        = '0,1,1,0,0,1,0,1,1,0';
								$roles_and_capabilities_data['contributor_privileges']                   = '0,0,1,0,0,1,0,0,0,0';
								$roles_and_capabilities_data['subscriber_privileges']                    = '0,0,0,0,0,0,0,0,0,0';
								$roles_and_capabilities_data['others_full_control_capability']           = '0';
								$roles_and_capabilities_data['other_privileges']                         = '0,0,0,0,0,0,0,0,0,0';

								$user_capabilities        = get_others_capabilities_limit_attempts_booster();
								$other_roles_array        = array();
								$other_roles_access_array = array(
									'manage_options',
									'edit_plugins',
									'edit_posts',
									'publish_posts',
									'publish_pages',
									'edit_pages',
									'read',
								);
								foreach ( $other_roles_access_array as $role ) {
									if ( in_array( $role, $user_capabilities, true ) ) {
										array_push( $other_roles_array, $role );
									}
								}
								$roles_and_capabilities_data['capabilities'] = $other_roles_array;

								$roles_and_capabilities_data_serialize               = array();
								$roles_and_capabilities_data_serialize['meta_id']    = $row->id;
								$roles_and_capabilities_data_serialize['meta_key']   = 'roles_and_capabilities';// WPCS: slow query ok.
								$roles_and_capabilities_data_serialize['meta_value'] = maybe_serialize( $roles_and_capabilities_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $roles_and_capabilities_data_serialize );

								break;

							case 'country_blocks':
								$country_blocks_data                        = array();
								$country_blocks_data['country_blocks_data'] = '';

								$country_blocks_data_serialize               = array();
								$country_blocks_data_serialize['meta_id']    = $row->id;
								$country_blocks_data_serialize['meta_key']   = 'country_blocks';// WPCS: slow query ok.
								$country_blocks_data_serialize['meta_value'] = maybe_serialize( $country_blocks_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $country_blocks_data_serialize );
								break;

							case 'blocking_options':
								$blocking_option_data['auto_ip_block']                  = 'enable';
								$blocking_option_data['maximum_login_attempt_in_a_day'] = '5';
								$blocking_option_data['block_for']                      = '1Hour';

								$blocking_option_data_serialize               = array();
								$blocking_option_data_serialize['meta_id']    = $row->id;
								$blocking_option_data_serialize['meta_key']   = 'blocking_options';// WPCS: slow query ok.
								$blocking_option_data_serialize['meta_value'] = maybe_serialize( $blocking_option_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $blocking_option_data_serialize );
								break;

							case 'alert_setup':
								$alert_setup_data['email_when_a_user_fails_login']         = 'disable';
								$alert_setup_data['email_when_a_user_success_login']       = 'disable';
								$alert_setup_data['email_when_an_ip_address_is_blocked']   = 'disable';
								$alert_setup_data['email_when_an_ip_address_is_unblocked'] = 'disable';
								$alert_setup_data['email_when_an_ip_range_is_blocked']     = 'disable';
								$alert_setup_data['email_when_an_ip_range_is_unblocked']   = 'disable';

								$alert_setup_data_serialize               = array();
								$alert_setup_data_serialize['meta_id']    = $row->id;
								$alert_setup_data_serialize['meta_key']   = 'alert_setup';// WPCS: slow query ok.
								$alert_setup_data_serialize['meta_value'] = maybe_serialize( $alert_setup_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $alert_setup_data_serialize );
								break;

							case 'error_message':
								$error_message_data['for_maximum_login_attempts']   = '<p>Your Maximum <strong>[login_attempts]</strong> Login Attempts has been Left.</p>';
								$error_message_data['for_blocked_ip_address_error'] = "<p>Your IP Address <strong>[ip_address]</strong> has been blocked by the Administrator for security purposes.</p>\r\n<p>Please contact the website Administrator for more details.</p>";
								$error_message_data['for_blocked_country_error']    = '<p>Unfortunately, your country location <strong>[country_location]</strong> has been blocked by the Administrator for security purposes.</p><p>Please contact the website Administrator for more details.</p>';
								$error_message_data['for_blocked_ip_range_error']   = "<p>Your IP Range <strong>[ip_range]</strong> has been blocked by the Administrator for security purposes.</p>\r\n<p>Please contact the website Administrator for more details.</p>";

								$error_message_data_serialize               = array();
								$error_message_data_serialize['meta_id']    = $row->id;
								$error_message_data_serialize['meta_key']   = 'error_message';// WPCS: slow query ok.
								$error_message_data_serialize['meta_value'] = maybe_serialize( $error_message_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $error_message_data_serialize );

								break;

							case 'other_settings':
								$other_settings_data['live_traffic_monitoring']    = 'disable';
								$other_settings_data['visitor_logs_monitoring']    = 'disable';
								$other_settings_data['uninstall_plugin']           = 'disable';
								$other_settings_data['ip_address_fetching_method'] = '';

								$other_settings_data_serialize               = array();
								$other_settings_data_serialize['meta_id']    = $row->id;
								$other_settings_data_serialize['meta_key']   = 'other_settings';// WPCS: slow query ok.
								$other_settings_data_serialize['meta_value'] = maybe_serialize( $other_settings_data );// WPCS: slow query ok.
								$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $other_settings_data_serialize );
								break;

							case 'email_templates':
								$email_templates_data                                      = array();
								$email_templates_data['template_for_user_success']         = '<p>Hi,</p><p>A login attempt has been successfully made to your website [site_url] by user <strong>[username]</strong> at [date_time] from IP Address <strong>[ip_address]</strong>.</p><p><u>Here is the detailed footprint at the Request :-</u></p><p><strong>Username:</strong> [username]</p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>Website:</strong> [site_url]</p><p><strong>IP Address:</strong> [ip_address]</p><p><strong>Resource:</strong> [resource]</p><p>Thanks and Regards,</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';
								$email_templates_data['template_for_user_failure']         = '<p>Hi,</p><p>An unsuccessful attempt to login at your website [site_url] was being made by user <strong>[username]</strong> at [date_time] from IP Address <strong>[ip_address]</strong>.</p><p><u>Here is the detailed footprint at the Request</u> :-</p><p><strong>Username:</strong> [username]</p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>website:</strong> [site_url]<p><strong>IP Address:</strong> [ip_address]</p><strong>Resource:</strong>[resource]</p><p>Thanks & Regards</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';
								$email_templates_data['template_for_ip_address_blocked']   = '<p>Hi,</p><p>An IP Address <strong>[ip_address]</strong> has been Blocked <strong>[blocked_for]</strong> to your website [site_url]. <p><u>Here is the detailed footprint at the Request :-</u></p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>Website:</strong> [site_url]</p><p><strong>IP Address:</strong> [ip_address]</p><p><strong>Resource:</strong> [resource]</p><p>Thanks and Regards,</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';
								$email_templates_data['template_for_ip_address_unblocked'] = '<p>Hi,</p><p>An IP Address <strong>[ip_address]</strong> has been Unblocked from your website [site_url].</p><p><u>Here is the detailed footprint at the Request :-</u></p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>Website:</strong> [site_url]</p><p><strong>IP Address:</strong> [ip_address]</p><p>Thanks and Regards,</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';
								$email_templates_data['template_for_ip_range_blocked']     = '<p>Hi,</p><p>An IP Range from <strong>[start_ip_range]</strong> to <strong>[end_ip_range]</strong> has been Blocked <strong>[blocked_for]</strong> to your website [site_url]. <p><u>Here is the detailed footprint at the Request :-</u></p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>Website:</strong> [site_url]</p><p><strong>IP Range:</strong> [ip_range]</p><p><strong>Resource:</strong> [resource]</p><p>Thanks and Regards,</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';
								$email_templates_data['template_for_ip_range_unblocked']   = '<p>Hi,</p><p>An IP Range from <strong>[start_ip_range]</strong> to <strong>[end_ip_range]</strong> has been Unblocked from your website [site_url].</p><p><u>Here is the detailed footprint at the Request :-</u></p><p><strong>Date/Time:</strong> [date_time]</p><p><strong>Website:</strong> [site_url]</p><p><strong>IP Range:</strong> [ip_range]</p><p>Thanks and Regards,</p><p><strong>Technical Support Team</strong></p><p>[site_url]</p>';

								$email_templates_message = array( 'Login Success Notification - Limit Attempts Booster', 'Login Failure Notification - Limit Attempts Booster', 'IP Address Blocked Notification - Limit Attempts Booster', 'IP Address Unblocked Notification - Limit Attempts Booster', 'IP Range Blocked Notification - Limit Attempts Booster', 'IP Range Unblocked Notification - Limit Attempts Booster' );
								$count                   = 0;

								foreach ( $email_templates_data as $keys => $value ) {
									$email_templates_data_array                  = array();
									$email_templates_data_array['email_send_to'] = $admin_email;
									$email_templates_data_array['email_cc']      = '';
									$email_templates_data_array['email_bcc']     = '';
									$email_templates_data_array['email_subject'] = $email_templates_message[ $count ];
									$email_templates_data_array['email_message'] = $value;
									$count++;

									$email_templates_data_serialize               = array();
									$email_templates_data_serialize['meta_id']    = $row->id;
									$email_templates_data_serialize['meta_key']   = $keys;// WPCS: slow query ok.
									$email_templates_data_serialize['meta_value'] = maybe_serialize( $email_templates_data_array );// WPCS: slow query ok.
									$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster_meta(), $email_templates_data_serialize );
								}
								break;
						}
					}
				}
			}
		}

		if ( ! function_exists( 'limit_attempts_booster_locations_table' ) ) {
			/**
			 * This Function is used to create ip locations table.
			 */
			function limit_attempts_booster_locations_table() {
				global $wpdb;
				$collate = $wpdb->get_charset_collate();
				$sql     = 'CREATE TABLE IF NOT EXISTS ' . limit_attempts_booster_ip_locations() . '
				(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`ip` varchar(100) NOT NULL,
					`country_code` varchar(5),
					`country_name` varchar(100),
					`region_code` varchar(5),
					`region_name` varchar(100),
					`city` varchar(100),
					`latitude` varchar(100),
					`longitude` varchar(100),
					PRIMARY KEY (`id`)
				) ENGINE = MyISAM ' . $collate;
				dbDelta( $sql );
			}
		}
		$obj_dbhelper_limit_attempts_booster = new Dbhelper_Install_Script_Limit_Attempts_Booster();
		switch ( $limit_attempts_booster_version_number ) {
			case '':
				$lab_admin_notices_array                    = array();
				$lab_start_date                             = date( 'm/d/Y' );
				$lab_start_date                             = strtotime( $lab_start_date );
				$lab_start_date                             = strtotime( '+7 day', $lab_start_date );
				$lab_start_date                             = date( 'm/d/Y', $lab_start_date );
				$lab_admin_notices_array['two_week_review'] = array( 'start' => $lab_start_date, 'int' => 7, 'dismissed' => 0 ); // @codingStandardsIgnoreLine.
				update_option( 'lab_admin_notice', $lab_admin_notices_array );
				limit_attempts_booster_table();
				limit_attempts_booster_meta_table();
				limit_attempts_booster_locations_table();
				break;

			default:
				global $wpdb;
				if ( $wpdb->query( "SHOW TABLES LIKE '" . $wpdb->prefix . 'limit_attempts_booster_ip_locations' . "'" ) === 0 ) {
					limit_attempts_booster_locations_table();// db call ok; no-cache ok.
				}
				if ( $limit_attempts_booster_version_number < '2.0.3' ) {
					$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster' );// @codingStandardsIgnoreLine.
					$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'limit_attempts_booster_meta' );// @codingStandardsIgnoreLine.
				}
				if ( $wpdb->query( "SHOW TABLES LIKE '" . $wpdb->prefix . 'limit_attempts_booster' . "'" ) === 0 ) {
					limit_attempts_booster_table();// db call ok; no-cache ok.
				}
				if ( $wpdb->query( "SHOW TABLES LIKE '" . $wpdb->prefix . 'limit_attempts_booster_meta' . "'" ) === 0 ) {
					limit_attempts_booster_meta_table();// db call ok; no-cache ok.
				} else {
					$other_settings_serialized_data = $wpdb->get_var(
						$wpdb->prepare( 'SELECT meta_value FROM ' . $wpdb->prefix . 'limit_attempts_booster_meta WHERE meta_key=%s', 'other_settings'
						)
					);// db call ok; no-cache ok.
					$other_settings_data            = maybe_unserialize( $other_settings_serialized_data );
					if ( ! array_key_exists( 'automatic_plugin_updates', $other_settings_data ) ) {
						$other_settings_data['automatic_plugin_updates'] = 'disable';
					}
					$update_other_settings_data               = array();
					$where                                    = array();
					$where['meta_key']                        = 'other_settings';// WPCS: slow query ok.
					$update_other_settings_data['meta_value'] = maybe_serialize( $other_settings_data );// WPCS: slow query ok.
					$obj_dbhelper_limit_attempts_booster->update_command( limit_attempts_booster_meta(), $update_other_settings_data, $where );
				}
				$get_collate_status_data = $wpdb->query(
					$wpdb->prepare(
						'SELECT type FROM ' . $wpdb->prefix . 'limit_attempts_booster WHERE type=%s', 'collation_type'
					)
				);// db call ok; no-cache ok.
				$charset_collate         = '';
				if ( ! empty( $wpdb->charset ) ) {
					$charset_collate .= 'CONVERT TO CHARACTER SET ' . $wpdb->charset;
				}
				if ( ! empty( $wpdb->collate ) ) {
					$charset_collate .= ' COLLATE ' . $wpdb->collate;
				}
				if ( 0 === $get_collate_status_data ) {
					if ( ! empty( $charset_collate ) ) {
						$change_collate_main_table = $wpdb->query(
							'ALTER TABLE ' . $wpdb->prefix . 'limit_attempts_booster ' . $charset_collate // @codingStandardsIgnoreLine.
						);// WPCS: db call ok, no-cache ok.
						$change_collate_meta_table = $wpdb->query(
							'ALTER TABLE ' . $wpdb->prefix . 'limit_attempts_booster_meta ' . $charset_collate // @codingStandardsIgnoreLine.
						);// WPCS: db call ok, no-cache ok.

						$collation_data_array              = array();
						$collation_data_array['type']      = 'collation_type';
						$collation_data_array['parent_id'] = '0';
						$obj_dbhelper_limit_attempts_booster->insert_command( limit_attempts_booster(), $collation_data_array );
					}
				}
				break;
		}
		update_option( 'limit_attempts_booster_version_number', '3.0.2' );
	}
}
