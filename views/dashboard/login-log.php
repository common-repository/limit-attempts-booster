<?php
/**
 * Template for login logs settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/dashboard
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
	} elseif ( DASHBOARD_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
		$lab_last_10_login_logs_delete = wp_create_nonce( 'limit_last_10_login_log_delete' );
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
					<a href="admin.php?page=lab_limit_attempts_booster">
						<?php echo esc_attr( $lab_dashboard ); ?>
					</a>
					<span>></span>
				</li>
				<li>
					<span>
						<?php echo esc_attr( $lab_login_logs ); ?>
					</span>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-clock"></i>
						<?php echo esc_attr( $lab_recent_login_logs_on_world_map ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_recent_login_logs">
						<div class="form-body">
						<div id="map_canvas" class="custom-map"></div>
					</div>
					</form>
				</div>
			</div>
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-clock"></i>
						<?php echo esc_attr( $lab_login_logs ); ?>
					</div>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_last_10_login">
						<div class="form-body">
						<div class="form-actions">
							<div class="table-top-margin">
								<select name="ux_ddl_last_login_logs" id="ux_ddl_last_login_logs" class="custom-bulk-width" onchange="lab_bulk_block_div_show_hide('#ux_ddl_last_login_logs', '#ux_ddl_login_log_ip_blocked_for')">
									<option value=""><?php echo esc_attr( $lab_bulk_action ); ?></option>
									<option value="delete" style="color:red;"> <?php echo esc_attr( $lab_delete ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
									<option value="block" style="color:red;"> <?php echo esc_attr( $lab_bulk_block ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
								</select>
								<select name="ux_ddl_login_log_ip_blocked_for" id="ux_ddl_login_log_ip_blocked_for" class="custom-bulk-width" style="display:none !important;">
									<option value="1Hour"><?php echo esc_attr( $lab_one_hour ); ?></option>
									<option value="12Hour"><?php echo esc_attr( $lab_twelve_hours ); ?></option>
									<option value="24hours"><?php echo esc_attr( $lab_twenty_four_hours ); ?></option>
									<option value="48hours"><?php echo esc_attr( $lab_forty_eight_hours ); ?></option>
									<option value="week"><?php echo esc_attr( $lab_one_week ); ?></option>
									<option value="month"><?php echo esc_attr( $lab_one_month ); ?></option>
									<option value="permanently"><?php echo esc_attr( $lab_permanently ); ?></option>
								</select>
								<input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" onclick="premium_edition_notification_limit_attempts_booster();" value="<?php echo esc_attr( $lab_apply ); ?>">
							</div>
							<table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_last_login_logs">
								<thead>
									<tr>
									<th style="text-align:center;width: 5%;" class="chk-action">
										<input type="checkbox" class="custom-chkbox-operation" name="ux_chk_all_user" id="ux_chk_all_user">
									</th>
									<th>
										<label class="control-label">
											<?php echo esc_attr( $lab_user_name ); ?>
										</label>
									</th>
									<th>
										<label class="control-label">
											<?php echo esc_attr( $lab_ip_address ); ?>
										</label>
									</th>
									<th>
										<label class="control-label">
											<?php echo esc_attr( $lab_location ); ?>
										</label>
									</th>
									<th>
										<label class="control-label">
											<?php echo esc_attr( $lab_date_time ); ?>
										</label>
									</th>
									<th>
										<label class="control-label">
											<?php echo esc_attr( $lab_status ); ?>
										</label>
									</th>
									<th style="text-align:center;" class="chk-action">
										<label class="control-label">
											<?php echo esc_attr( $lab_action ); ?>
										</label>
									</th>
								</tr>
								</thead>
								<tbody id="dynamic_table_filter">
									<?php
									foreach ( $lab_map_data as $row ) {
										?>
										<tr>
										<td style="text-align:center;">
											<label>
												<input  type="checkbox" onclick="check_all_limit_attempts_booster('#ux_chk_all_user');" name="ux_chk_last_login_<?php echo esc_attr( $row['meta_id'] ); ?>" id="ux_chk_last_login_<?php echo esc_attr( $row['meta_id'] ); ?>" value="<?php echo esc_attr( $row['meta_id'] ); ?>">
											</label>
										</td>
										<td>
											<label>
												<?php echo '' !== $row['username'] ? esc_attr( $row['username'] ) : esc_attr( $lab_na ); ?>
											</label>
										</td>
										<td>
											<label>
												<?php echo esc_attr( long2ip_limit_attempts_booster( $row['user_ip_address'] ) ); ?>
											</label>
										</td>
										<td>
											<label>
												<?php echo '' !== $row['location'] ? esc_attr( $row['location'] ) : esc_attr( $lab_na ); ?>
											</label>
										</td>
										<td>
											<label>
												<?php echo esc_attr( date_i18n( 'd M Y h:i A', $row['date_time'] ) ); ?>
											</label>
										</td>
										<td>
											<div style="background-color:<?php echo 'Success' === $row['status'] ? '#00934A' : '#D11919'; ?>; text-align:center; color:#FFFFFF;">
												<?php echo esc_attr( $row['status'] ); ?>
											</div>
										</td>
										<td class="custom-alternative"  style="width: 10%;">
											<a href="javascript:void(0);" class="btn limit-attempts-booster-buttons" onclick="delete_data_logs(<?php echo intval( $row['meta_id'] ); ?>)"><?php echo esc_attr( $lab_delete ); ?></a>
											<a onclick="premium_edition_notification_limit_attempts_booster();" class="btn limit-attempts-booster-buttons"><?php echo esc_attr( $lab_block_ip_address ); ?></a>
										</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
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
				<a href="admin.php?page=lab_limit_attempts_booster">
					<?php echo esc_attr( $lab_dashboard ); ?>
					</a>
					<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_login_logs ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-clock"></i>
						<?php echo esc_attr( $lab_login_logs ); ?>
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