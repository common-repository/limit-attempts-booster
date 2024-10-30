<?php
/**
 * Template for alert setup settings.
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
					<?php echo esc_attr( $lab_alert_setup_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-bell"></i>
						<?php echo esc_attr( $lab_alert_setup_menu ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_alert_setup">
						<div class="form-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_a_user_fails ); ?> :
									<span class="required" aria-required="true">* <?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
								</label>
								<select name="ux_ddl_fail" id="ux_ddl_fail" class="form-control">
									<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_a_user_success ); ?> :
									<span class="required" aria-required="true">* <?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span></span>
								</label>
								<select name="ux_ddl_success" id="ux_ddl_success" class="form-control">
									<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_ip_address_blocked ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span></span>
								</label>
								<select name="ux_ddl_IP_address_blocked" id="ux_ddl_IP_address_blocked" class="form-control">
									<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_ip_address_unblocked ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span></span>
								</label>
								<select name="ux_ddl_IP_address_unblocked" id="ux_ddl_IP_address_unblocked" class="form-control">
									<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_ip_range_blocked ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span></span>
								</label>
								<select name="ux_ddl_IP_range_blocked" id="ux_ddl_IP_range_blocked" class="form-control">
									<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_alert_setup_email_when_ip_range_unblocked ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span></span>
								</label>
								<select name="ux_ddl_IP_range_unblocked" id="ux_ddl_IP_range_unblocked" class="form-control">
									<<option value="enable"><?php echo esc_attr( $lab_enable ); ?></option>
									<option value="disable"><?php echo esc_attr( $lab_disable ); ?></option>
								</select>
								</div>
							</div>
						</div>
						<div class="line-separator"></div>
						<div class="form-actions">
							<div class="pull-right">
								<input type="submit" class="btn vivid-green" name="ux_btn_save_changes" id="ux_btn_save_changes" value="<?php echo esc_attr( $lab_save_changes ); ?>">
							</div>
						</div>
					</div>
					</form>
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
					<?php echo esc_attr( $lab_alert_setup_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-bell"></i>
						<?php echo esc_attr( $lab_alert_setup_menu ); ?>
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
