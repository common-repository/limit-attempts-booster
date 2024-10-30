<?php
/**
 * Template for Error message settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/views/general-settings
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
if ( ! is_user_logged_in() ) {
	return;
} else {
	$access_granted = false;
	foreach ( $user_role_permission as $permission ) {
		if ( current_user_can( $permission ) ) {
			$access_granted = true;
			break;
		}
	}
	if ( ! $access_granted ) {
		return;
	} elseif ( GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
		?>
		<div class="page-bar">
			<ul class="page-breadcrumb">
			<li>
				<i class="icon-custom-home"></i>
				<a href="admin.php?page=lab_limit_attempts_booster">
					<?php echo esc_attr( $limit_attempts_booster ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<a href="admin.php?page=lab_alert_setup">
					<?php echo esc_attr( $lab_general_settings ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_error_messages_menu ); ?>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-shield"></i>
						<?php echo esc_attr( $lab_error_messages_menu ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_error_messages">
						<div class="form-body">
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_error_messages_for_login_attempts_failure ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<textarea class="form-control" name="ux_txt_login_attempts" id="ux_txt_login_attempts"  placeholder="<?php echo esc_attr( $lab_error_messages_for_login_attempts_failure_placeholder ); ?>"><?php echo isset( $meta_data_array['for_maximum_login_attempts'] ) ? esc_attr( trim( htmlspecialchars( htmlspecialchars_decode( $meta_data_array['for_maximum_login_attempts'] ) ) ) ) : ''; ?></textarea>
							<i class="controls-description"><?php echo esc_attr( $lab_error_messages_for_login_attempts_failure_tooltip ); ?></i>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_error_messages_for_blocked_country ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<textarea class="form-control" name="ux_txt_blocked_country" id="ux_txt_blocked_country"  placeholder="<?php echo esc_attr( $lab_error_messages_for_blocked_country_placeholder ); ?>"><?php echo isset( $meta_data_array['for_blocked_country_error'] ) ? esc_attr( trim( htmlspecialchars( htmlspecialchars_decode( $meta_data_array['for_blocked_country_error'] ) ) ) ) : ''; ?></textarea>
							<i class="controls-description"><?php echo esc_attr( $lab_error_messages_for_blocked_country_tooltip ); ?></i>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_error_messages_for_ip_address ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<textarea class="form-control" name="ux_txt_ip_address" id="ux_txt_ip_address"  placeholder="<?php echo esc_attr( $lab_error_messages_for_ip_address_placeholder ); ?>"><?php echo isset( $meta_data_array['for_blocked_ip_address_error'] ) ? esc_attr( trim( htmlspecialchars( htmlspecialchars_decode( $meta_data_array['for_blocked_ip_address_error'] ) ) ) ) : ''; ?></textarea>
							<i class="controls-description"><?php echo esc_attr( $lab_error_messages_for_ip_address_tooltip ); ?></i>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_error_messages_for_ip_range ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<textarea class="form-control" name="ux_txt_ip_range" id="ux_txt_ip_range"  placeholder="<?php echo esc_attr( $lab_error_messages_for_ip_range_placeholder ); ?>"><?php echo isset( $meta_data_array['for_blocked_ip_range_error'] ) ? esc_attr( trim( htmlspecialchars( htmlspecialchars_decode( $meta_data_array['for_blocked_ip_range_error'] ) ) ) ) : ''; ?></textarea>
							<i class="controls-description"><?php echo esc_attr( $lab_error_messages_for_ip_range_tooltip ); ?></i>
						</div>
						<div class="line-separator"></div>
						<div class="form-actions">
							<div class="pull-right">
								<input type="submit" class="btn vivid-green" name="ux_btn_save_changes" id="ux_btn_save_changes" value="<?php echo esc_attr( $lab_save_changes ); ?>">
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
		<?php
	} else {
		?>
		<div class="page-bar">
			<ul class="page-breadcrumb">
			<li>
				<i class="icon-custom-home"></i>
				<a href="admin.php?page=lab_limit_attempts_booster">
					<?php echo esc_attr( $limit_attempts_booster ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<a href="admin.php?page=lab_alert_setup">
					<?php echo esc_attr( $lab_general_settings ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_error_messages_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-shield"></i>
						<?php echo esc_attr( $lab_error_messages_menu ); ?>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						<strong><?php echo esc_attr( $lab_user_access_message ); ?></strong>
					</div>
				</div>
			</div>
		</div>
	</div>
		<?php
	}
}
