<?php
/**
 * Template for live traffic settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/views/logs
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
	} elseif ( LOGS_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
		$limit_attempts_traffic_delete                = wp_create_nonce( 'limit_attempts_traffic_delete' );
		$limit_attempts_traffic_start_end_date_module = wp_create_nonce( 'limit_attempts_traffic_start_end_date_module' );
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
					<a href="admin.php?page=lab_live_traffic">
						<?php echo esc_attr( $lab_logs ); ?>
					</a>
					<span>></span>
				</li>
				<li>
					<span>
						<?php echo esc_attr( $lab_live_traffic_menu ); ?>
					</span>
				</li>
			</ul>
		</div>
		<div class="portlet box vivid-green">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-custom-directions"></i>
					<?php echo esc_attr( $lab_live_traffic_on_world_map ); ?>
				</div>
				<p class="premium-editions-limit-attempts-booster">
					<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
				</p>
				<div class="caption pull-right" style="font-size:12px">
					<strong><?php echo esc_attr( $lab_visitor_logs_next_refresh_in ); ?>
						<span class="timer"></span> <?php echo esc_attr( $lab_visitor_logs_seconds ); ?> </strong>
				</div>
			</div>
			<div class="portlet-body form">
				<form id="ux_frm_live_traffic">
					<div class="form-body">
						<div id="map_canvas" class="custom-map"></div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box vivid-green">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-custom-directions"></i>
							<?php echo esc_attr( $lab_live_traffic_menu ); ?>
						</div>
						<div class="caption pull-right" style="font-size:12px">
							<strong><?php echo esc_attr( $lab_visitor_logs_next_refresh_in ); ?>
								<span class="timer"></span> <?php echo esc_attr( $lab_visitor_logs_seconds ); ?> </strong>
							</div>
					</div>
					<div class="portlet-body form">
						<form id="ux_frm_live_traffic_logs">
							<div class="form-body">
								<?php
								if ( 'enable' === $visitor_logs_data['live_traffic_monitoring'] ) {
									?>
									<div class="form-actions">
										<div class="table-top-margin">
											<select name="ux_ddl_live_traffic" id="ux_ddl_live_traffic" class="custom-bulk-width" onchange="lab_bulk_block_div_show_hide('#ux_ddl_live_traffic', '#ux_ddl_live_traffic_blocked_for');">
												<option value=""><?php echo esc_attr( $lab_bulk_action ); ?></option>
												<option value="delete" style="color:red;"> <?php echo esc_attr( $lab_delete ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
												<option value="block" style="color:red;"> <?php echo esc_attr( $lab_bulk_block ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
											</select>
											<select name="ux_ddl_live_traffic_blocked_for" id="ux_ddl_live_traffic_blocked_for" style="display:none" class="custom-bulk-width">
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
										<table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_live_traffic">
											<thead>
												<tr>
													<th style="text-align:center;width: 5% !important;" class="chk-action">
														<input type="checkbox" name="ux_chk_all_live_traffic" id="ux_chk_all_live_traffic" >
													</th>
													<th style="width: 15%;">
														<label class="control-label" >
															<?php echo esc_attr( $lab_user_name ); ?>
														</label>
													</th>
													<th style="width: 15%;">
														<label class="control-label">
															<?php echo esc_attr( $lab_ip_address ); ?>
														</label>
													</th>
													<th style="width: 15%;">
														<label class="control-label">
															<?php echo esc_attr( $lab_location ); ?>
														</label>
													</th>
													<th style="width: 25%;">
														<label class="control-label">
															<?php echo esc_attr( $lab_details ); ?>
														</label>
													</th>
													<th style="width: 15%;">
														<label class="control-label">
															<?php echo esc_attr( $lab_date_time ); ?>
														</label>
													</th>
													<th style="text-align:center;width: 10%;" class="chk-action">
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
														<td style="text-align: center;">
															<input type="checkbox" name="ux_chk_live_traffic_<?php echo esc_attr( $row['meta_id'] ); ?>" id="ux_chk_live_traffic_<?php echo esc_attr( $row['meta_id'] ); ?>" value="<?php echo esc_attr( $row['meta_id'] ); ?>" onclick="check_all_limit_attempts_booster('#ux_chk_all_live_traffic');">
														</td>
														<td style="width: 15%;">
															<label>
																<?php echo '' !== $row['username'] ? esc_attr( $row['username'] ) : esc_attr( $lab_na ); ?>
															</label>
														</td>
														<td style="width: 15%;">
															<label>
																<?php echo esc_attr( long2ip_limit_attempts_booster( $row['user_ip_address'] ) ); ?>
															</label>
														</td>
														<td style="width: 15%;">
															<label>
																<?php echo '' !== $row['location'] ? esc_attr( $row['location'] ) : esc_attr( $lab_na ); ?>
															</label>
														</td>
														<td style="width: 25%;">
															<label>
																<?php echo esc_attr( $lab_resources ); ?>: <?php echo esc_attr( $row['resources'] ); ?><br/>
																<?php echo esc_attr( $lab_http_user_agent ); ?>: <?php echo esc_attr( $row['http_user_agent'] ); ?>
															</label>
														</td>
														<td style="width: 15%;">
															<label>
																<?php echo esc_attr( date_i18n( 'd M Y h:i A', $row['date_time'] ) ); ?>
															</label>
														</td>
														<td class="custom-alternative"  style="width: 10%;">
															<a href="javascript:void(0);" class="btn limit-attempts-booster-buttons" onclick="live_selected_delete_limit_attempts_booster(<?php echo intval( $row['meta_id'] ); ?>)"><?php echo esc_attr( $lab_delete ); ?></a>
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
									<?php
								} else {
									?>
									<strong>
										<?php echo esc_attr( $lab_visitor_logs_live_traffic_monitoring ); ?>
									</strong>
									<?php
								}
								?>
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
					<a href="admin.php?page=lab_live_traffic">
						<?php echo esc_attr( $lab_logs ); ?>
					</a>
					<span>></span>
				</li>
				<li>
					<span>
						<?php echo esc_attr( $lab_live_traffic_menu ); ?>
					</span>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box vivid-green">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-custom-directions"></i>
							<?php echo esc_attr( $lab_live_traffic_menu ); ?>
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
