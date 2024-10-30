<?php
/**
 * This file is used to create class for insert update and delete sql commands.
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
		if ( ! class_exists( 'Dbhelper_Limit_Attempts_Booster' ) ) {
			/**
			 * Class Name: Dbhelper_Limit_Attempts_Booster
			 * Parameters: No
			 * Description: This Class is used for Insert Update and Delete operations.
			 * Created On: 23-09-2015 1:10
			 * Created By: Tech Banker Team
			 */
			class Dbhelper_Limit_Attempts_Booster {
				/**
				 * This Function is used for Insert data in database.
				 *
				 * @param string $table_name .
				 * @param string $data .
				 */
				public function insert_command( $table_name, $data ) {
					global $wpdb;
					$wpdb->insert( $table_name, $data ); // db call ok; no-cache ok.
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
		if ( ! class_exists( 'Plugin_Info_Limit_Attempts_Booster' ) ) {
			/**
			 * Class Name: Plugin_Info_Limit_Attempts_Booster
			 * Parameters: No
			 * Description: This Class is used to get the the information about plugins.
			 * Created On: 18-04-2017 17:06
			 * Created By: Tech Banker Team
			 */
			class Plugin_Info_Limit_Attempts_Booster { // @codingStandardsIgnoreLine.
				/**
				 * Function Name: get_plugin_info_limit_attempts_booster
				 * Parameters: No
				 * Decription: This function is used to return the information about plugins.
				 * Created On: 18-04-2017 17:06
				 * Created By: Tech Banker Team
				 */
				public function get_plugin_info_limit_attempts_booster() {
					$active_plugins = (array) get_option( 'active_plugins', array() );
					if ( is_multisite() ) {
						$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
					}
					$plugins = array();
					if ( count( $active_plugins ) > 0 ) {
						$get_plugins = array();
						foreach ( $active_plugins as $plugin ) {
							$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );// @codingStandardsIgnoreLine.

							$get_plugins['plugin_name']    = strip_tags( $plugin_data['Name'] );
							$get_plugins['plugin_author']  = strip_tags( $plugin_data['Author'] );
							$get_plugins['plugin_version'] = strip_tags( $plugin_data['Version'] );
							array_push( $plugins, $get_plugins );
						}
						return $plugins;
					}
				}
			}
		}
	}
}
