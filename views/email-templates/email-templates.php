<?php
/**
 * Template for email templates settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/views/email-templates
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
	} elseif ( EMAIL_TEMPLATES_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
		$limit_attempts_email_template_data = wp_create_nonce( 'limit_attempts_email_template_data' );
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
				<span>
					<?php echo esc_attr( $lab_email_templates_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-link"></i>
						<?php echo esc_attr( $lab_email_templates_menu ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_email_templates">
						<div class="form-body">
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_choose_email_template ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<select name="ux_ddl_user_success" id="ux_ddl_user_success" class="form-control" onchange="template_change_data_limit_attempts_booster();">
								<option value="template_for_user_success"><?php echo esc_attr( $lab_email_template_for_user_success ); ?></option>
								<option value="template_for_user_failure"><?php echo esc_attr( $lab_email_template_for_user_failure ); ?></option>
								<option value="template_for_ip_address_blocked"><?php echo esc_attr( $lab_email_template_for_ip_address_blocked ); ?></option>
								<option value="template_for_ip_address_unblocked"><?php echo esc_attr( $lab_email_template_for_ip_address_unblocked ); ?></option>
								<option value="template_for_ip_range_blocked"><?php echo esc_attr( $lab_email_template_for_ip_range_blocked ); ?></option>
								<option value="template_for_ip_range_unblocked"><?php echo esc_attr( $lab_email_template_for_ip_range_unblocked ); ?></option>
							</select>
							<i class="controls-description"> <?php echo esc_attr( $lab_choose_email_template_tooltip ); ?></i>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_email_template_send_to ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<input type="text" class="form-control" name="ux_txt_send_to" id="ux_txt_send_to" placeholder="<?php echo esc_attr( $lab_email_template_send_to_placeholder ); ?>">
							<i class="controls-description"><?php echo esc_attr( $lab_email_template_send_to_tooltip ); ?></i>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
									<?php echo esc_attr( $lab_email_template_cc ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
								</label>
								<input type="text" class="form-control" name="ux_txt_cc" id="ux_txt_cc" placeholder="<?php echo esc_attr( $lab_email_template_cc_placeholder ); ?>">
								<i class="controls-description"><?php echo esc_attr( $lab_email_template_cc_tooltip ); ?></i>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">
									<?php echo esc_attr( $lab_email_template_bcc ); ?> :
									<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
								</label>
								<input type="text" class="form-control" name="ux_txt_bcc" id="ux_txt_bcc" placeholder="<?php echo esc_attr( $lab_email_template_bcc_placeholder ); ?>">
								<i class="controls-description"><?php echo esc_attr( $lab_email_template_bcc_tooltip ); ?></i>
							</div>
						</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_subject ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<input type="text" class="form-control" name="ux_txt_subject" id="ux_txt_subject" placeholder="<?php echo esc_attr( $lab_email_template_subject_placeholder ); ?>">
							<i class="controls-description"><?php echo esc_attr( $lab_email_template_subject_tooltip ); ?></i>
						</div>
						<div class="form-group">
							<label class="control-label">
								<?php echo esc_attr( $lab_email_template_message ); ?> :
								<span class="required" aria-required="true">*<?php echo ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></span>
							</label>
							<?php
							$distribution = '';
							wp_editor(
								$distribution, 'ux_heading_content', array(
									'media_buttons' => false,
									'textarea_rows' => 8,
									'tabindex'      => 4,
								)
							);
							?>
							<i class="controls-description"><?php echo esc_attr( $lab_email_template_message_tooltip ); ?></i>
						</div>
						<div class="line-separator"></div>
						<div class="form-actions">
							<div class="pull-right">
								<input type="hidden" id="ux_email_template_meta_id"/>
								<input type="submit" class="btn vivid-green" name="ux_btn_email_change" id="ux_btn_email_change" value="<?php echo esc_attr( $lab_save_changes ); ?>">
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
				<span>
					<?php echo esc_attr( $lab_email_templates_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
				<div class="caption">
				<i class="icon-custom-link"></i>
						<?php echo esc_attr( $lab_email_templates_menu ); ?>
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
