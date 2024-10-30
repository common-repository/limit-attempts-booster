<?php
/**
 * Template for custom cron jobs settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/cron-jobs
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
	} elseif ( CRON_JOBS_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
		$limit_attempts_delete_custom_cron_jobs = wp_create_nonce( 'limit_attempts_delete_custom_cron_jobs' );
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
				<a href="admin.php?page=lab_custom_cron_jobs">
					<?php echo esc_attr( $lab_cron_jobs ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_custom_cron_jobs_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-user"></i>
						<?php echo esc_attr( $lab_custom_cron_jobs_menu ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_custom_cron_jobs">
						<div class="form-body">
						<div class="table-margin-top">
							<select name="ux_ddl_custom_cron_jobs" id="ux_ddl_custom_cron_jobs" class="custom-bulk-width">
								<option value=""><?php echo esc_attr( $lab_bulk_action ); ?></option>
								<option value="delete" style="color:red;"> <?php echo esc_attr( $lab_delete ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
							</select>
							<input type="button" id="ux_btn_apply" name="ux_btn_apply" class="btn vivid-green" value="<?php echo esc_attr( $lab_apply ); ?>" onclick="premium_edition_notification_limit_attempts_booster();">
						</div>
						<table class="table table-striped table-bordered table-hover" id="ux_tbl_data_table_custom_cron">
							<thead>
								<tr>
									<th class="chk-action">
									<input type="checkbox" id="ux_chk_select_all_scheduler" name="ux_chk_select_all_scheduler" style="margin:1px 0px 0px 1px" />
								</th>
								<th scope="col" style="width:25%;">
									<?php echo esc_attr( $lab_cron_jobs_name_of_hook ); ?>
								</th>
								<th scope="col" style="width:25%;">
									<?php echo esc_attr( $lab_cron_jobs_interval_hook ); ?>
								</th>
								<th scope="col" style="width:25%;">
									<?php echo esc_attr( $lab_cron_jobs_args ); ?>
								</th>
								<th scope="col" style="width:25%;">
									<?php echo esc_attr( $lab_cron_jobs_next_execution ); ?>
								</th>
							</tr>
						</thead>
						<tbody class="all_wp_chks">
							<?php
							$flag = 0;
							foreach ( $schedulers as $time => $time_cron_array ) {
								foreach ( $time_cron_array as $hook => $data ) {
									if ( ! in_array( $hook, $core_cron_hooks, true ) ) {
										$times_class = LIMIT_ATTEMPTS_BOOSTER_LOCAL_TIME;
										?>
										<tr>
										<td>
											<input type="checkbox" id="ux_chk_schedulers_<?php echo esc_attr( $flag ); ?>" name="ux_chk_schedulers_<?php echo esc_attr( $flag ); ?>" value=<?php echo esc_attr( $hook ); ?> onclick="check_all_limit_attempts_booster('#ux_chk_select_all_scheduler')" />
										</td>
										<td class="custom-alternative" style="text-align:left;">
											<?php echo esc_attr( wp_strip_all_tags( $hook ) ); ?><br/>
											<a href="#data-table-custom-cron" onclick="delete_custom_cron_job_limit_attempts_booster('<?php echo esc_attr( $hook ); ?>');"><?php echo esc_attr( $lab_delete ); ?></a>
										</td>
										<?php
										foreach ( $data as $hash => $info ) {
											?>
											<td>
											<?php
											if ( empty( $info['interval'] ) ) {
												echo 'Single Event';
											} else {
												if ( array_key_exists( $info['schedule'], $schedule_details ) ) {
													echo esc_attr( $schedule_details[ $info['schedule'] ]['display'] );
												} else {
													echo esc_attr( $info['schedule'] );
												}
											}
												?>
											</td>
											<td>
												<?php
												if ( is_array( $info['args'] ) && ! empty( $info['args'] ) ) {
													foreach ( $info['args'] as $key => $value ) {
														display_cron_arguments_limit_attempts_booster( $key, $value );
													}
												} elseif ( '' !== is_string( $info['args'] ) && $info['args'] ) {
													echo esc_html( $info['args'] );
												} else {
													echo 'No Args';
												}
												?>
											</td>
											<td <?php echo esc_attr( $times_class ); ?>>
												<label style="display:none;"><?php echo esc_attr( $time ); ?></label>
												<?php
												$current_offset = get_option( 'gmt_offset' ) * 60 * 60;
												echo esc_attr( date_i18n( 'd M, Y g:i A e', $time + $current_offset ) ) . '<br /> <b>In About ' . esc_attr( human_time_diff( $time ) ) . '</b>'
												?>
											</td>
											<?php
										}
										?>
									</tr>
										<?php
									}
										$flag++;
								}
							}
							?>
							</tbody>
						</table>
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
				<a href="admin.php?page=lab_custom_cron_jobs">
					<?php echo esc_attr( $lab_cron_jobs ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_custom_cron_jobs_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-user"></i>
						<?php echo esc_attr( $lab_custom_cron_jobs_menu ); ?>
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
