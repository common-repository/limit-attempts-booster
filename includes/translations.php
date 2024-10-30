<?php
/**
 * This file is contain variables.
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
		// Premium Edition.
		$lab_message_premium_edition = __( 'This feature is available only in Premium Editions! <br> Kindly Purchase to unlock it!', 'limit-attempts-booster' );

		$lab_upgrade_know_about = __( 'Know about', 'limit-attempts-booster' );
		$lab_full_features      = __( 'Full Features', 'limit-attempts-booster' );
		$lab_chek_our           = __( 'or check our', 'limit-attempts-booster' );
		$lab_online_demos       = __( 'Online Demos', 'limit-attempts-booster' );
		$lab_support_forum      = __( 'Ask For Help', 'limit-attempts-booster' );
		// Footer.
		$lab_upgrade                    = __( 'Premium Edition', 'limit-attempts-booster' );
		$lab_success                    = __( 'Success!', 'limit-attempts-booster' );
		$lab_saved_message              = __( 'Saved Successfully!', 'limit-attempts-booster' );
		$lab_blocked_message            = __( 'Blocked Successfully!', 'limit-attempts-booster' );
		$lab_delete_message             = __( 'Data Deleted!', 'limit-attempts-booster' );
		$lab_countries_unblocks         = __( 'Unblocked Successfully!', 'limit-attempts-booster' );
		$lab_ip_address                 = __( 'IP Address', 'limit-attempts-booster' );
		$lab_location                   = __( 'Location', 'limit-attempts-booster' );
		$lab_latitude                   = __( 'Latitude', 'limit-attempts-booster' );
		$lab_longitude                  = __( 'Longitude', 'limit-attempts-booster' );
		$lab_http_user_agent            = __( 'HTTP User Agent', 'limit-attempts-booster' );
		$lab_na                         = 'N/A';
		$lab_confirm_message            = __( 'Are you sure?', 'limit-attempts-booster' );
		$lab_choose_action              = __( 'Choose an Action!', 'limit-attempts-booster' );
		$lab_choose_record              = __( 'Please choose at least 1 record to delete!', 'limit-attempts-booster' );
		$lab_valid_ip_address           = __( 'Please provide valid IP Address', 'limit-attempts-booster' );
		$lab_valid_ip_range             = __( 'Please provide valid IP Range', 'limit-attempts-booster' );
		$lab_error_message_notification = __( 'Error Message', 'limit-attempts-booster' );
		$lab_test_email                 = __( 'Test email was sent successfully!', 'limit-attempts-booster' );
		$lab_ip_address_already_blocked = __( 'Already blocked!', 'limit-attempts-booster' );
		$lab_notification               = __( 'Notification!', 'limit-attempts-booster' );
		$lab_choose_block_record        = __( 'Please choose at least 1 record to block IP Address!', 'limit-attempts-booster' );
		$lab_bulk_block                 = __( 'Block', 'limit-attempts-booster' );
		$lab_block_own_ip_address       = __( 'You cannot block your own IP Address!', 'limit-attempts-booster' );

		// Common Variables.
		$limit_attempts_booster        = 'Limit Attempts Booster';
		$lab_limit_attempts            = 'Limit Attempts';
		$lab_bulk_action               = __( 'Bulk Action', 'limit-attempts-booster' );
		$lab_delete                    = __( 'Delete', 'limit-attempts-booster' );
		$lab_apply                     = __( 'Apply', 'limit-attempts-booster' );
		$lab_user_name                 = __( 'User Name', 'limit-attempts-booster' );
		$lab_date_time                 = __( 'Date & Time', 'limit-attempts-booster' );
		$lab_status                    = __( 'Status', 'limit-attempts-booster' );
		$lab_details                   = __( 'Details', 'limit-attempts-booster' );
		$lab_resources                 = __( 'Resources', 'limit-attempts-booster' );
		$lab_block_ip_address          = __( 'Block IP Address', 'limit-attempts-booster' );
		$lab_blocked_date_time         = __( 'Blocked Date & Time', 'limit-attempts-booster' );
		$lab_release_date_time         = __( 'Release Date & Time', 'limit-attempts-booster' );
		$lab_action                    = __( 'Action', 'limit-attempts-booster' );
		$lab_ip_ranges                 = __( 'IP Ranges', 'limit-attempts-booster' );
		$lab_live_traffic_on_world_map = __( 'Live Traffic On World Map', 'limit-attempts-booster' );
		$lab_visitor_logs_on_world_map = __( 'Visitor Logs On World Map', 'limit-attempts-booster' );
		$lab_start_date_heading        = __( 'Start Date', 'limit-attempts-booster' );
		$lab_start_date_placeholder    = __( 'Please choose Start Date', 'limit-attempts-booster' );
		$lab_end_date_heading          = __( 'End Date', 'limit-attempts-booster' );
		$lab_end_date_placeholder      = __( 'Please choose End Date', 'limit-attempts-booster' );
		$lab_submit                    = __( 'Submit', 'limit-attempts-booster' );
		$lab_save_changes              = __( 'Save Changes', 'limit-attempts-booster' );
		$lab_enable                    = __( 'Enable', 'limit-attempts-booster' );
		$lab_disable                   = __( 'Disable', 'limit-attempts-booster' );
		$lab_comments                  = __( 'Comments', 'limit-attempts-booster' );
		$lab_user_access_message       = __( "You don't have Sufficient Access to this Page. Kindly contact the Administrator for more Privileges", 'limit-attempts-booster' );
		$lab_comments_placeholder      = __( 'Please provide Comments', 'limit-attempts-booster' );
		$lab_clear                     = __( 'Clear', 'limit-attempts-booster' );
		$lab_blocked_for               = __( 'Blocked For', 'limit-attempts-booster' );
		$lab_one_hour                  = __( '1 Hour', 'limit-attempts-booster' );
		$lab_twelve_hours              = __( '12 Hours', 'limit-attempts-booster' );
		$lab_twenty_four_hours         = __( '24 Hours', 'limit-attempts-booster' );
		$lab_forty_eight_hours         = __( '48 Hours', 'limit-attempts-booster' );
		$lab_one_week                  = __( '1 Week', 'limit-attempts-booster' );
		$lab_one_month                 = __( '1 Month', 'limit-attempts-booster' );
		$lab_permanently               = __( 'Permanently', 'limit-attempts-booster' );
		$lab_subject                   = __( 'Subject', 'limit-attempts-booster' );
		$lab_never                     = __( 'Never', 'limit-attempts-booster' );

		// Admin Bar Menu.
		$lab_dashboard            = __( 'Dashboard', 'limit-attempts-booster' );
		$lab_logs                 = __( 'Logs', 'limit-attempts-booster' );
		$lab_advance_security     = __( 'Advance Security', 'limit-attempts-booster' );
		$lab_general_settings     = __( 'General Settings', 'limit-attempts-booster' );
		$lab_email_templates_menu = __( 'Email Templates', 'limit-attempts-booster' );
		$lab_roles_and_capability = __( 'Roles & Capabilities', 'limit-attempts-booster' );
		$lab_cron_jobs            = __( 'Cron Jobs', 'limit-attempts-booster' );
		$lab_feature_requests     = __( 'Ask For Help', 'limit-attempts-booster' );
		$lab_system_information   = __( 'System Information', 'limit-attempts-booster' );

		// Sidebar Menu.
		$lab_live_traffic_menu         = __( 'Live Traffic', 'limit-attempts-booster' );
		$lab_visitor_logs_menu         = __( 'Visitor Logs', 'limit-attempts-booster' );
		$lab_blocked_ip_addresses_menu = __( 'Blocked IP Addresses', 'limit-attempts-booster' );
		$lab_blocked_ip_ranges_menu    = __( 'Blocked IP Ranges', 'limit-attempts-booster' );
		$lab_recent_login_logs_menu    = __( 'Login Logs', 'limit-attempts-booster' );
		$lab_blocking_options_menu     = __( 'Blocking Options', 'limit-attempts-booster' );
		$lab_manage_ip_addresses_menu  = __( 'Manage IP Addresses', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_menu     = __( 'Manage IP Ranges', 'limit-attempts-booster' );
		$lab_country_blocks_menu       = __( 'Country Blocks', 'limit-attempts-booster' );
		$lab_alert_setup_menu          = __( 'Alert Setup', 'limit-attempts-booster' );
		$lab_error_messages_menu       = __( 'Error Messages', 'limit-attempts-booster' );
		$lab_other_settings_menu       = __( 'Other Settings', 'limit-attempts-booster' );
		$lab_custom_cron_jobs_menu     = __( 'Custom Cron Jobs', 'limit-attempts-booster' );
		$lab_core_cron_jobs_menu       = __( 'Core Cron Jobs', 'limit-attempts-booster' );

		// Sidebar.
		$lab_dashboard_last10_logs = __( 'Dashboard (Last 10 Logs)', 'limit-attempts-booster' );
		$lab_login_logs            = __( 'Login Logs', 'limit-attempts-booster' );

		// Error Messages.
		$lab_error_messages_for_login_attempts_failure             = __( 'Maximum Login Attempts', 'limit-attempts-booster' );
		$lab_error_messages_for_login_attempts_failure_tooltip     = __( 'Error Message to be displayed when a User exceeds Maximum Number of Login Attempts', 'limit-attempts-booster' );
		$lab_error_messages_for_login_attempts_failure_placeholder = __( 'Please provide your Login Attempts Error Message', 'limit-attempts-booster' );
		$lab_error_messages_for_blocked_country                    = __( 'Blocked Country', 'limit-attempts-booster' );
		$lab_error_messages_for_blocked_country_tooltip            = __( 'Error Message to be displayed when a Country is Blocked', 'limit-attempts-booster' );
		$lab_error_messages_for_blocked_country_placeholder        = __( 'Please provide your Blocked Country Error Message', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_address                         = __( 'Blocked IP Address', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_address_tooltip                 = __( 'Error Message to be displayed when an IP Address is Blocked', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_address_placeholder             = __( 'Please provide your Blocked IP Address Error Message', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_range                           = __( 'Blocked IP Range', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_range_tooltip                   = __( 'Error Message to be displayed when an IP Range is Blocked', 'limit-attempts-booster' );
		$lab_error_messages_for_ip_range_placeholder               = __( 'Please provide your Blocked IP Range Error Message', 'limit-attempts-booster' );

		// Other Settings.
		$lab_other_settings_trackbacks                         = __( 'Trackbacks', 'limit-attempts-booster' );
		$lab_other_settings_trackbacks_tooltip                 = __( 'Do you want to enable trackbacks to your site?', 'limit-attempts-booster' );
		$lab_other_settings_comments_tooltip                   = __( 'Do you want to allow people to comment on your posts?', 'limit-attempts-booster' );
		$lab_other_settings_live_traffic_monitoring_title      = __( 'Live Traffic Monitoring', 'limit-attempts-booster' );
		$lab_other_settings_live_traffic_monitoring_tooltip    = __( 'Do you want Live Monitoring of currently visiting users on your website?', 'limit-attempts-booster' );
		$lab_other_settings_visitor_logs_monitoring_title      = __( 'Visitor Logs Monitoring', 'limit-attempts-booster' );
		$lab_other_settings_visitor_logs_monitoring_tooltip    = __( 'Do you want to Monitor the details of currently visiting users on your website?', 'limit-attempts-booster' );
		$lab_other_settings_uninstall_plugin                   = __( 'Remove Database at Uninstall', 'limit-attempts-booster' );
		$lab_other_settings_remove_tables_at_uninstall_tooltip = __( 'Do you want to remove Database at Uninstall of the Plugin?', 'limit-attempts-booster' );
		$lab_other_settings_error_reporting                    = __( 'Error Reporting', 'limit-attempts-booster' );
		$lab_other_settings_error_reporting_tooltip            = __( 'If you would like to Report your Errors in Error Logs Menu, then you would need to Choose Enable from dropdown or vice-versa', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_method         = __( 'How does Limit Attempts Booster get IPs', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_tooltips                = __( 'Options available for retrieving IP Address', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_option1        = __( 'Let Limit Attempts Booster use the most secure method to get visitor IP address. Prevents spoofing and works with most sites.', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_option2        = __( "Use PHP's built in REMOTE_ADDR and don't use anything else. Very secure if this is compatible with your site.", 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_option3        = __( 'Use the X-Forwarded-For HTTP header. Only use if you have a front-end proxy or spoofing may result.', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_option4        = __( 'Use the X-Real-IP HTTP header. Only use if you have a front-end proxy or spoofing may result.', 'limit-attempts-booster' );
		$lab_other_settings_ip_address_fetching_option5        = __( "Use the Cloudflare 'CF-Connecting-IP' HTTP header to get a visitor IP. Only use if you're using Cloudflare.", 'limit-attempts-booster' );

		// Alert Setup.
		$lab_alert_setup_email_when_a_user_fails         = __( 'Email when a User Fails Login', 'limit-attempts-booster' );
		$lab_alert_setup_email_when_a_user_success       = __( 'Email when a User Success Login', 'limit-attempts-booster' );
		$lab_alert_setup_email_when_ip_address_blocked   = __( 'Email when an IP Address is Blocked', 'limit-attempts-booster' );
		$lab_alert_setup_email_when_ip_address_unblocked = __( 'Email when an IP Address is Unblocked', 'limit-attempts-booster' );
		$lab_alert_setup_email_when_ip_range_blocked     = __( 'Email when an IP Range is Blocked', 'limit-attempts-booster' );
		$lab_alert_setup_email_when_ip_range_unblocked   = __( 'Email when an IP Range is Unblocked', 'limit-attempts-booster' );

		// Logs.
		$lab_recent_login_logs_on_world_map       = __( 'Login Logs On World Map', 'limit-attempts-booster' );
		$lab_visitor_logs_live_traffic_monitoring = __( 'Monitoring is Turned Off. Go to General Settings > Other Settings Menu to enable it', 'limit-attempts-booster' );
		$lab_visitor_logs_next_refresh_in         = __( 'Next Refresh in', 'limit-attempts-booster' );
		$lab_visitor_logs_seconds                 = __( 'Seconds', 'limit-attempts-booster' );

		// Blocking Options.
		$lab_blocking_options_auto_ip_block              = __( 'Auto IP Block', 'limit-attempts-booster' );
		$lab_blocking_options_auto_ip_block_tooltip      = __( 'Choose whether to block IP Address automatically when User exceeds Maximum Number of Login Attempts', 'limit-attempts-booster' );
		$lab_blocking_options_login_attempts             = __( 'Maximum Login Attempts in a Day', 'limit-attempts-booster' );
		$lab_blocking_options_login_attempts_tooltip     = __( 'Maximum Number of Login Attempts to be allowed in a Day', 'limit-attempts-booster' );
		$lab_blocking_options_login_attempts_placeholder = __( 'Please provide Maximum Login Attempts in a Day', 'limit-attempts-booster' );

		// Manage IP Address.
		$lab_manage_ip_addresses_tooltip      = __( 'Valid IP Address to be Blocked', 'limit-attempts-booster' );
		$lab_manage_ip_addresses_view_blocked = __( 'View Blocked IP Addresses', 'limit-attempts-booster' );

		// Manage IP Range.
		$lab_manage_ip_ranges_start                = __( 'Start IP Range', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_start_tooltip        = __( 'Valid IP Range to be Blocked', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_start_placeholder    = __( 'Please provide valid Start IP Range', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_end                  = __( 'End IP Range', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_end_placeholder      = __( 'Please provide valid End IP Range', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_blocked_for_tootltip = __( 'Maximum Time Duration', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_comments_tooltip     = __( 'Reason for Blocking', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_block                = __( 'Block IP Range', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_view_blocked         = __( 'View Blocked IP Ranges', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_start_date_tooltip   = __( 'Start Date for Retrieving Data', 'limit-attempts-booster' );
		$lab_manage_ip_ranges_end_date_tooltip     = __( 'End Date for Retrieving Data', 'limit-attempts-booster' );

		// Country Blocks.
		$lab_country_blocks_available_countries         = __( 'Available Countries', 'limit-attempts-booster' );
		$lab_country_blocks_available_countries_tooltip = __( 'List of Available Countries', 'limit-attempts-booster' );
		$lab_country_blocks_add                         = __( 'Add >>', 'limit-attempts-booster' );
		$lab_country_blocks_remove                      = __( '<< Remove', 'limit-attempts-booster' );
		$lab_blocked_countries                          = __( 'Blocked Countries', 'limit-attempts-booster' );
		$lab_blocked_countries_tooltip                  = __( 'List of Blocked Countries', 'limit-attempts-booster' );

		// Email Templates.
		$lab_choose_email_template                   = __( 'Choose Email Template', 'limit-attempts-booster' );
		$lab_choose_email_template_tooltip           = __( 'Available Email Templates', 'limit-attempts-booster' );
		$lab_email_template_for_user_success         = __( 'Template For User Successful Login', 'limit-attempts-booster' );
		$lab_email_template_for_user_failure         = __( 'Template For User Failure Login', 'limit-attempts-booster' );
		$lab_email_template_for_ip_address_blocked   = __( 'Template For IP Address Blocked', 'limit-attempts-booster' );
		$lab_email_template_for_ip_address_unblocked = __( 'Template For IP Address Unblocked', 'limit-attempts-booster' );
		$lab_email_template_for_ip_range_blocked     = __( 'Template For IP Range Blocked', 'limit-attempts-booster' );
		$lab_email_template_for_ip_range_unblocked   = __( 'Template For IP Range Unblocked', 'limit-attempts-booster' );
		$lab_email_template_send_to                  = __( 'Send To', 'limit-attempts-booster' );
		$lab_email_template_send_to_tooltip          = __( 'A valid Email Address account to which you would like to send Emails', 'limit-attempts-booster' );
		$lab_email_template_send_to_placeholder      = __( 'Please provide valid Email Address', 'limit-attempts-booster' );
		$lab_email_template_cc                       = 'CC';
		$lab_email_template_cc_tooltip               = __( 'A valid Email Address account used in the "CC" field. Use "," to separate multiple email addresses', 'limit-attempts-booster' );
		$lab_email_template_cc_placeholder           = __( 'Please provide CC Email', 'limit-attempts-booster' );
		$lab_email_template_bcc                      = 'BCC';
		$lab_email_template_bcc_tooltip              = __( 'A valid Email Address account used in the "BCC" field. Use "," to separate multiple email addresses', 'limit-attempts-booster' );
		$lab_email_template_bcc_placeholder          = __( 'Please provide BCC Email', 'limit-attempts-booster' );
		$lab_email_template_subject_tooltip          = __( 'Subject Line of your Email', 'limit-attempts-booster' );
		$lab_email_template_subject_placeholder      = __( 'Please provide Subject', 'limit-attempts-booster' );
		$lab_email_template_message                  = __( 'Message', 'limit-attempts-booster' );
		$lab_email_template_message_tooltip          = __( 'The content of your Email', 'limit-attempts-booster' );

		// Roles and Capabilities.
		$lab_roles_capabilities_show_menu                        = __( 'Show Limit Attempts Booster Menu', 'limit-attempts-booster' );
		$lab_roles_capabilities_show_menu_tooltip                = __( 'Choose who would be able to see Limit Attempts Booster Menu?', 'limit-attempts-booster' );
		$lab_roles_capabilities_administrator                    = __( 'Administrator', 'limit-attempts-booster' );
		$lab_roles_capabilities_author                           = __( 'Author', 'limit-attempts-booster' );
		$lab_roles_capabilities_editor                           = __( 'Editor', 'limit-attempts-booster' );
		$lab_roles_capabilities_contributor                      = __( 'Contributor', 'limit-attempts-booster' );
		$lab_roles_capabilities_subscriber                       = __( 'Subscriber', 'limit-attempts-booster' );
		$lab_roles_capabilities_topbar_menu                      = __( 'Show Limit Attempts Booster Top Bar Menu', 'limit-attempts-booster' );
		$lab_roles_capabilities_topbar_menu_tooltip              = __( 'Do you want to show Limit Attempts menu in Top Bar?', 'limit-attempts-booster' );
		$lab_roles_capabilities_administrator_role               = __( 'An Administrator Role can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_administrator_role_tooltip       = __( 'Choose pages for users having Administrator Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_full_control                     = __( 'Full Control', 'limit-attempts-booster' );
		$lab_roles_capabilities_author_role                      = __( 'An Author Role can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_author_role_tooltip              = __( 'Choose pages for users having Author Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_editor_role                      = __( 'An Editor Role can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_editor_role_tooltip              = __( 'Choose pages for users having Editor Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_contributor_role                 = __( 'A Contributor Role can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_contributor_role_tooltip         = __( 'Choose pages for users having Contributor Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_subscriber_role                  = __( 'A Subscriber Role can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_subscriber_role_tooltip          = __( 'Choose pages for users having Subscriber Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_others                           = __( 'Others', 'limit-attempts-booster' );
		$lab_roles_capabilities_other_role                       = __( 'Other Roles can do the following ', 'limit-attempts-booster' );
		$lab_roles_capabilities_other_role_tooltip               = __( 'Choose pages for users having Others Role Access', 'limit-attempts-booster' );
		$lab_roles_capabilities_other_roles_capabilities         = __( 'In this field, you would need to choose appropriate capabilities for security purposes', 'limit-attempts-booster' );
		$lab_roles_capabilities_other_roles_capabilities_tooltip = __( 'Only users with these capabilities can access Limit Attempts Booster', 'limit-attempts-booster' );

		// Core Cron Jobs.
		$lab_cron_jobs_name_of_hook   = __( 'Name of the Hook', 'limit-attempts-booster' );
		$lab_cron_jobs_interval_hook  = __( 'Interval Hook', 'limit-attempts-booster' );
		$lab_cron_jobs_args           = __( 'Args', 'limit-attempts-booster' );
		$lab_cron_jobs_next_execution = __( 'Next Execution', 'limit-attempts-booster' );
	}
}
