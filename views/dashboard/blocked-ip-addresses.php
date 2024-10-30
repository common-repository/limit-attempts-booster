<?php
/**
 * Template for block ip addresses settings.
 *
 * @author  tech-banker
 * @package limit-attempts-booster/views/dashboard
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
		$delete_ip_address = wp_create_nonce( 'limit_attempts_delete_ip_address' );
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
					<?php echo esc_attr( $lab_blocked_ip_addresses_menu ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-globe"></i>
						<?php echo esc_attr( $lab_blocked_ip_addresses_menu ); ?>
					</div>
					<p class="premium-editions-limit-attempts-booster">
						<?php echo esc_attr( $lab_upgrade_know_about ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>" target="_blank" class="premium-editions-documentation"> <?php echo esc_attr( $lab_full_features ); ?></a> <?php echo esc_attr( $lab_chek_our ); ?> <a href="<?php echo esc_attr( TECH_BANKER_BETA_URL ); ?>/backend-demos" target="_blank" class="premium-editions-documentation"><?php echo esc_attr( $lab_online_demos ); ?></a>
					</p>
				</div>
				<div class="portlet-body form">
					<form id="ux_frm_view_blocked_ip_addresses">
						<div class="form-body">
						<div class="table-top-margin">
							<select name="ux_ddl_last_manage_ip_addesses" id="ux_ddl_last_manage_ip_addesses" class="custom-bulk-width">
								<option value=""><?php echo esc_attr( $lab_bulk_action ); ?></option>
								<option value="delete" style="color:red;"> <?php echo esc_attr( $lab_delete ) . ' ( ' . esc_attr( $lab_upgrade ) . ' )'; ?></option>
							</select>
							<input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo esc_attr( $lab_apply ); ?>" onclick="premium_edition_notification_limit_attempts_booster();">
						</div>
						<table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_manage_ip_addresses">
							<thead>
								<tr>
									<th style="text-align: center; width: 5%;" class="chk-action">
									<input type="checkbox" name="ux_chk_all_manage_ip_address" id="ux_chk_all_manage_ip_address">
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
								<th style="width:20%;">
									<label class="control-label">
										<?php echo esc_attr( $lab_blocked_date_time ); ?>
									</label>
								</th>
								<th style="width:20%;">
									<label class="control-label">
										<?php echo esc_attr( $lab_release_date_time ); ?>
									</label>
								</th>
								<th>
									<label class="control-label">
										<?php echo esc_attr( $lab_comments ); ?>
									</label>
								</th>
								<th style="width: 7%" class="chk-action">
									<label class="control-label">
										<?php echo esc_attr( $lab_action ); ?>
									</label>
								</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ( $manage_ip_address as $row ) {
									?>
									<tr>
									<td style="text-align: center; width: 5%;">
										<input type="checkbox" onclick="check_all_limit_attempts_booster('#ux_chk_all_manage_ip_address');" name="ux_chk_manage_ip_address_<?php echo esc_attr( $row['meta_id'] ); ?>" id="ux_chk_details_<?php echo esc_attr( $row['meta_id'] ); ?>" value="<?php echo esc_attr( $row['meta_id'] ); ?>">
									</td>
									<td>
										<label>
											<?php echo esc_attr( long2ip_limit_attempts_booster( $row['ip_address'] ) ); ?>
										</label>
									</td>
									<td>
										<label>
											<?php echo '' !== $row['location'] ? esc_attr( $row['location'] ) : esc_attr( $lab_na ); ?>
										</label>
									</td>
									<td style="width:20%;">
										<label>
											<?php echo esc_attr( date_i18n( 'd M Y h:i A', $row['date_time'] ) ); ?>
										</label>
									</td>
									<td>
										<label>
											<?php
											$blocking_time = $row['blocked_for'];
											switch ( $blocking_time ) {
												case '1Hour':
													$release_date = $row['date_time'] + ( 60 * 60 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case '12Hour':
													$release_date = $row['date_time'] + ( 60 * 60 * 12 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case '24hours':
													$release_date = $row['date_time'] + ( 60 * 60 * 24 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case '48hours':
													$release_date = $row['date_time'] + ( 60 * 60 * 48 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case 'week':
													$release_date = $row['date_time'] + ( 60 * 60 * 24 * 7 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case 'month':
													$release_date = $row['date_time'] + ( 60 * 60 * 30 * 24 );
													echo esc_attr( date_i18n( 'd M Y h:i A', $release_date ) );
													break;

												case 'permanently':
													echo esc_attr( $lab_never );
													break;
											}
											?>
										</label>
										</td>
										<td>
											<label>
											<?php echo esc_attr( trim( htmlspecialchars( htmlspecialchars_decode( $row['comments'] ) ) ) ); ?>
										</label>
										</td>
										<td class="custom-alternative" style="width: 10%;">
											<a href="javascript:void(0);" class="btn limit-attempts-booster-buttons" onclick="delete_ip_address_last_logins(<?php echo intval( $row['meta_id'] ); ?>)"><?php echo esc_attr( $lab_delete ); ?></a>
											</a>
										</td>
									</tr>
									<?php
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
				<a href="admin.php?page=lab_limit_attempts_booster">
					<?php echo esc_attr( $lab_dashboard ); ?>
				</a>
				<span>></span>
			</li>
			<li>
				<span>
					<?php echo esc_attr( $lab_blocked_ip_addresses_menu ); ?>
				</span>
			</li>
		</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
			<div class="portlet box vivid-green">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-custom-globe"></i>
						<?php echo esc_attr( $lab_blocked_ip_addresses_menu ); ?>
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
