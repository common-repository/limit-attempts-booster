<?php
/**
 * This file containe javascript.
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
		?>
		</div>
		</div>
		</div>
		<script type="text/javascript">
			jQuery("li > a").parents("li").each(function ()
			{
				if (jQuery(this).parent("ul.page-sidebar-menu-tech-banker").size() === 1)
				{
					jQuery(this).find("> a").append("<span class=\"selected\"></span>");
				}
			});
			if (typeof (load_sidebar_content_limit_attempts_booster) !== "function")
			{
				function load_sidebar_content_limit_attempts_booster()
				{
					var menus_height = jQuery(".page-sidebar-menu-tech-banker").height();
					var content_height = jQuery(".page-content").height() + 30;
					if (parseInt(menus_height) > parseInt(content_height))
					{
						jQuery(".page-content").attr("style", "min-height:" + menus_height + "px")
					} else
					{
						jQuery(".page-sidebar-menu-tech-banker").attr("style", "min-height:" + content_height + "px")
					}
				}
			}
			jQuery(".page-sidebar-tech-banker").on("click", "li > a", function (e)
			{
				var hasSubMenu = jQuery(this).next().hasClass("sub-menu");
				var parent = jQuery(this).parent().parent();
				var sidebar_menu = jQuery(".page-sidebar-menu-tech-banker");
				var sub = jQuery(this).next();
				var slideSpeed = parseInt(sidebar_menu.data("slide-speed"));
				parent.children("li.open").children(".sub-menu:not(.always-open)").slideUp(slideSpeed);
				parent.children("li.open").removeClass("open");
				var sidebar_close = parent.children("li.open").removeClass("open");
				if (sidebar_close)
				{
					setInterval(load_sidebar_content_limit_attempts_booster, 100);
				}
				if (sub.is(":visible"))
				{
					jQuery(this).parent().removeClass("open");
					sub.slideUp(slideSpeed);
				} else if (hasSubMenu)
				{
					jQuery(this).parent().addClass("open");
					sub.slideDown(slideSpeed);
				}
			});
			var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
			setTimeout(function ()
			{
				clearInterval(sidebar_load_interval);
			}, 5000);
			if (typeof (overlay_loading_limit_attempts_booster) !== "function")
			{
				function overlay_loading_limit_attempts_booster(control_id)
				{
					var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
					jQuery("body").append(overlay_opacity);
					var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
					jQuery("body").append(overlay);
					if (control_id !== undefined)
					{
						var message = control_id;
						var success = <?php echo wp_json_encode( $lab_success ); ?>;
						var issuccessmessage = jQuery("#toast-container").exists();
						if (issuccessmessage !== true)
						{
							var shortCutFunction = jQuery("#manage_messages input:checked").val();
							toastr[shortCutFunction](message, success);
						}
					}
				}
			}
			function premium_edition_notification_limit_attempts_booster()
			{
				var premium_edition = <?php echo wp_json_encode( $lab_message_premium_edition ); ?>;
				var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
				toastr[shortCutFunction](premium_edition);
			}
			if (typeof (remove_overlay_limit_attempts_booster) !== "function")
			{
				function remove_overlay_limit_attempts_booster()
				{
					jQuery(".loader_opacity").remove();
					jQuery(".opacity_overlay").remove();
				}
			}
			if (typeof (check_value_limit_attempts_booster) !== "function")
			{
				function check_value_limit_attempts_booster(id)
				{
					jQuery(id).val() === "" ? jQuery(id).val(0) : jQuery(id).val();
				}
			}
			if (typeof (prevent_paste_limit_attempts_booster) !== "function")
			{
				function prevent_paste_limit_attempts_booster(control_id)
				{
					jQuery("#" + control_id).live("paste", function (e)
					{
						e.preventDefault();
					});
				}
			}
			if (typeof (enter_only_numbers) !== "function")
			{
				function enter_only_numbers(control_id)
				{
					jQuery("#" + control_id).on("paste keypress", function (e)
					{
						var $this = jQuery("#" + control_id);
						setTimeout(function ()
						{
							$this.val($this.val().replace(/[^0-9]/g, ""));
						}, 5);
					});
				}
			}
			if (typeof (remove_unwanted_spaces) !== "function")
			{
				function remove_unwanted_spaces(id)
				{
					var api_key = jQuery("#" + id).val();
					api_key = api_key.replace(/[ ]/g, "");
					jQuery("#" + id).val("");
					jQuery("#" + id).val(jQuery.trim(api_key));
				}
			}
			if (typeof (limit_attempts_booster_valid_ip_address) !== "function")
			{
				function limit_attempts_booster_valid_ip_address(event)
				{
					if (event.which === 8 || event.keyCode === 37 || event.keyCode === 39 || event.keyCode === 46 || event.keyCode === 9 || event.keyCode === 110)
					{
						return true;
					} else if (event.which !== 46 && (event.which < 48 || event.which > 57))
					{
						event.preventDefault();
					}
				}
			}
			if (typeof (prevent_data_limit_attempts_booster) !== "function")
			{
				function prevent_data_limit_attempts_booster(event)
				{
					event.preventDefault();
				}
			}
			if (typeof (sort_function_limit_attempts_booster) !== "function")
			{
				function sort_function_limit_attempts_booster(control_id)
				{
					var options = jQuery("#" + control_id + "option");
					var arr = options.map(function (_, o)
					{
						return{
							t: jQuery(o).text(),
							v: o.value
						};
					}).get();
					arr.sort(function (o1, o2)
					{
						return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
					});
					options.each(function (i, o)
					{
						o.value = arr[i].v;
						jQuery(o).text(arr[i].t);
					});
				}
			}
			if (typeof (base64_encode) !== "function")
			{
				function base64_encode(data)
				{
					var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
					var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
							ac = 0,
							enc = "",
							tmp_arr = [];
					if (!data)
					{
						return data;
					}
					do
					{
						o1 = data.charCodeAt(i++);
						o2 = data.charCodeAt(i++);
						o3 = data.charCodeAt(i++);
						bits = o1 << 16 | o2 << 8 | o3;
						h1 = bits >> 18 & 0x3f;
						h2 = bits >> 12 & 0x3f;
						h3 = bits >> 6 & 0x3f;
						h4 = bits & 0x3f;
						tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
					} while (i < data.length);
					enc = tmp_arr.join('');
					var r = data.length % 3;
					return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
				}
			}
			if (typeof (get_datatable_limit_attempts_booster) !== "function")
			{
				function get_datatable_limit_attempts_booster(id, order)
				{
					var oTable = jQuery(id).dataTable
					({
						"pagingType": "full_numbers",
						"language": {
							"emptyTable": "No data available in table",
							"info": "Showing _START_ to _END_ of _TOTAL_ entries",
							"infoEmpty": "No entries found", "infoFiltered": "(filtered1 from _MAX_ total entries)",
							"lengthMenu": "Show _MENU_ entries",
							"search": "Search:",
							"zeroRecords": "No matching records found"}, "order": [[order, 'asc']], "bSort": true,
						"pageLength": 10,
						"aoColumnDefs": [{"bSortable": false, "aTargets": [0]}]
					});
					return oTable;
				}
			}
			if (typeof (lab_bulk_block_div_show_hide) !== "function")
			{
				function lab_bulk_block_div_show_hide(id, dropdown_id)
				{
					if (jQuery(id).val() === "block")
					{
						jQuery(dropdown_id).css("display", "inline-block");
					} else
					{
						jQuery(dropdown_id).css("display", "none");
					}
				}
			}
			if (typeof (check_all_limit_attempts_booster) !== "function")
			{
				function check_all_limit_attempts_booster(id)
				{
					if ((jQuery("tbody input:checked").length) === jQuery("tbody input[type=checkbox]").length)
					{
						jQuery(id).attr("checked", "checked");
					} else
					{
						jQuery(id).removeAttr("checked");
					}
				}
			}
			if (typeof (ip2long) !== "function")
			{
				function ip2long(IP)
				{
					var i = 0;
					IP = IP.match(
							/^([1-9]\d*|0[0-7]*|0x[\da-f]+)(?:\.([1-9]\d*|0[0-7]*|0x[\da-f]+))?(?:\.([1-9]\d*|0[0-7]*|0x[\da-f]+))?(?:\.([1-9]\d*|0[0-7]*|0x[\da-f]+))?$/i
							);
					if (!IP)
					{
						return false;
					}
					IP[0] = 0;
					for (i = 1; i < 5; i += 1)
					{
						IP[0] += !!((IP[i] || "")
								.length);
						IP[i] = parseInt(IP[i]) || 0;
					}
					IP.push(256, 256, 256, 256);
					IP[4 + IP[0]] *= Math.pow(256, 4 - IP[0]);
					if (IP[1] >= IP[5] || IP[2] >= IP[6] || IP[3] >= IP[7] || IP[4] >= IP[8])
					{
						return false;
					}
					return IP[1] * (IP[0] === 1 || 16777216) + IP[2] * (IP[0] <= 2 || 65536) + IP[3] * (IP[0] <= 3 || 256) + IP[4] * 1;
				}
			}
			if (typeof (lab_initialize) !== "function")
			{
				function lab_initialize()
				{
					var mapOptions =
					{
						center: new google.maps.LatLng(51.83790, -17.35093),
						zoom: 2,
						streetViewControl: false,
						draggableCursor: "default",
						draggingCursor: "grab"
					};
					var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
					<?php
					if ( isset( $lab_map_data ) && count( $lab_map_data ) > 0 ) {
						foreach ( $lab_map_data as $row ) {
							?>
							var infowindow = new google.maps.InfoWindow();
							var marker = new google.maps.Marker
							({
								draggable: false,
								position: new google.maps.LatLng(<?php echo wp_json_encode( $row['latitude'] ); ?>, <?php echo wp_json_encode( $row['longitude'] ); ?>),
								cursor: "pointer",
								icon: "<?php echo esc_attr( plugins_url( 'assets/global/img/map-marker.png', dirname( __FILE__ ) ) ); ?>"
							});
							marker.content = "<b>" +<?php echo wp_json_encode( $lab_ip_address ); ?> + ": </b>" + <?php echo wp_json_encode( long2ip_limit_attempts_booster( $row['user_ip_address'] ) ); ?> +
									"<br><b>" +<?php echo wp_json_encode( $lab_location ); ?> + ": </b>" + <?php echo '' !== $row['location'] ? wp_json_encode( $row['location'] ) : wp_json_encode( $lab_na ); ?> +
									"<br><b>" +<?php echo wp_json_encode( $lab_latitude ); ?> + ": </b>" +<?php echo '' !== $row['latitude'] ? wp_json_encode( $row['latitude'] ) : wp_json_encode( $lab_na ); ?> +
									"<br><b>" +<?php echo wp_json_encode( $lab_longitude ); ?> + ": </b>" +<?php echo '' !== $row['longitude'] ? wp_json_encode( $row['longitude'] ) : wp_json_encode( $lab_na ); ?> +
									"<br><b>" +<?php echo wp_json_encode( $lab_http_user_agent ); ?> + ": </b>" + <?php echo wp_json_encode( $row['http_user_agent'] ); ?>;
							google.maps.event.addListener(marker, "click", function ()
							{
								infowindow.setContent(this.content);
								infowindow.open(this.getMap(), this);
							});
							marker.setMap(map);
							<?php
						}
					}
				?>
				}
			}
			jQuery(document).ready(function ()
			{
				jQuery("#ux_txt_start_date").datepicker
				({
					dateFormat: "mm/dd/yy",
					numberOfMonths: 1, changeMonth: true,
					changeYear: true,
					yearRange: "1970:2039",
					onSelect: function (selected)
					{
						jQuery("#ux_txt_end_date").datepicker("option", "minDate", selected);
					}
				});
				jQuery("#ux_txt_end_date").datepicker
				({
					numberOfMonths: 1,
					dateFormat: "mm/dd/yy",
					changeMonth: true,
					changeYear: true,
					yearRange: "1970:2039",
					onSelect: function (selected)
					{
						jQuery("#ux_txt_start_date").datepicker("option", "maxDate", selected);
					}
				});
				load_sidebar_content_limit_attempts_booster();
			});
		<?php
		$check_limit_attempts_wizard = get_option( 'limit-attempts-wizard-set-up' );
		if ( isset( $_GET['page'] ) ) {
			$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );// WPCS: CSRF ok,WPCS: input var ok.
		}
		$licensing_url = false === $check_limit_attempts_wizard ? 'limit_attempts_wizard' : $page;
		if ( isset( $_REQUEST['page'] ) ) {// WPCS: CSRF ok,WPCS: input var ok.
			switch ( $licensing_url ) {
				case 'limit_attempts_wizard':
					?>
						if (typeof (show_hide_details_limit_attempts) !== "function")
						{
							function show_hide_details_limit_attempts()
							{
								if (jQuery("#ux_div_wizard_set_up").hasClass("wizard-set-up"))
								{
									jQuery("#ux_div_wizard_set_up").css("display", "none");
									jQuery("#ux_div_wizard_set_up").removeClass("wizard-set-up");
								} else
								{
									jQuery("#ux_div_wizard_set_up").css("display", "block");
									jQuery("#ux_div_wizard_set_up").addClass("wizard-set-up");
								}
							}
						}
						if (typeof (plugin_stats_limit_attempts) !== "function")
						{
							function plugin_stats_limit_attempts(type)
							{
								var email_pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
								if( ( jQuery("#ux_txt_email_address_notifications").val() ===  "" || false == email_pattern.test(jQuery("#ux_txt_email_address_notifications").val()) ) && type !== "skip")
								{
									if( jQuery("#ux_txt_email_address_notifications").val() ===  "" || false == email_pattern.test(jQuery("#ux_txt_email_address_notifications").val()) )
									{
										jQuery("#ux_txt_validation_gdpr_limit_attempt_booster").css({"display":'','color':'red'});
										jQuery("#ux_txt_email_address_notifications").css("border-color","red");
									} else {
										jQuery("#ux_txt_validation_gdpr_limit_attempt_booster").css( 'display','none' );
										jQuery("#ux_txt_email_address_notifications").css("border-color","#ddd");
									}
								}	else {
									jQuery("#ux_txt_validation_gdpr_limit_attempt_booster").css( 'display','none' );
									jQuery("#ux_txt_email_address_notifications").css("border-color","#ddd");
									overlay_loading_limit_attempts_booster();
									jQuery.post(ajaxurl,
									{
										id: jQuery("#ux_txt_email_address_notifications").val(),
										type: type,
										param: "wizard_limit_attempts_booster",
										action: "limit_attempts_booster_action",
										_wp_nonce: "<?php echo esc_attr( $limit_attempts_check_status ); ?>"
									},
									function (data)
									{
										remove_overlay_limit_attempts_booster();
										window.location.href = "admin.php?page=lab_limit_attempts_booster";
									});
								}
							}
						}
					<?php
					break;
				case 'lab_limit_attempts_booster':
					?>
						jQuery("#ux_li_dashboard").addClass("active");
						jQuery("#ux_li_last_login").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( DASHBOARD_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
						?>
							jQuery(document).ready(function ()
							{
								lab_initialize();
							});
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_last_login_logs", 0);
							jQuery("#ux_chk_all_user").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_data_logs) !== "function")
							{
								function delete_data_logs(meta_id)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											log_id: meta_id,
											param: "limit_attempts_last_login_delete_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo isset( $lab_last_10_login_logs_delete ) ? esc_attr( $lab_last_10_login_logs_delete ) : ''; ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_limit_attempts_booster";
											}, 3000);
										});
									}
								}
							}
						<?php
					}
					break;
				case 'lab_visitor_logs_dashboard':
					?>
						jQuery("#ux_li_dashboard").addClass("active");
						jQuery("#ux_li_visitor_logs_dashboard").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( DASHBOARD_LIMIT_ATTEMPTS_BOOSTER === '1' ) {
						?>
							jQuery(document).ready(function ()
							{
								lab_initialize();
							});
						<?php
						if ( 'enable' === $visitor_logs_data['visitor_logs_monitoring'] ) {
							?>
								var oTable = get_datatable_limit_attempts_booster("#ux_tbl_visitor_logs", 0);
								jQuery("#ux_chk_all_user").click(function ()
								{
									jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
								});
								if (typeof (selected_delete_visitor_logs_dashboard) !== "function")
								{
									function selected_delete_visitor_logs_dashboard(meta_id)
									{
										var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
										if (confirm_delete === true)
										{
											jQuery.post(ajaxurl,
											{
												real_id: meta_id,
												param: "limit_attempts_dashboard_visitor_delete_module",
												action: "limit_attempts_booster_action", _wp_nonce: "<?php echo esc_attr( $lab_visitor_logs_delete ); ?>"
											},
											function (data)
											{
												overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
												setTimeout(function ()
												{
													remove_overlay_limit_attempts_booster();
													window.location.href = "admin.php?page=lab_visitor_logs_dashboard";
												}, 3000);
											});
										}
									}
								}
							<?php
						}
					}
					break;
				case 'lab_last_blocked_ip_addresses':
					?>
						jQuery("#ux_li_dashboard").addClass("active");
						jQuery("#ux_li_last_blocked_ip").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function () {
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === DASHBOARD_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_manage_ip_addresses", 0);
							jQuery("#ux_chk_all_manage_ip_address").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_ip_address_last_logins) !== "function")
							{
								function delete_ip_address_last_logins(meta_id)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											id_address: meta_id,
											param: "limit_attempts_last_login_delete_ip_address",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $delete_ip_address ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_last_blocked_ip_addresses";
											}, 3000);
										});
									}
								}
							}
						<?php
					}
					break;
				case 'lab_last_blocked_ip_ranges':
					?>
						jQuery("#ux_li_dashboard").addClass("active");
						jQuery("#ux_li_last_blocked_ip_range").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === DASHBOARD_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_manage_ip_ranges", 0);
							jQuery("#ux_chk_all_manage_ip_ranges").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_ip_ranges_last_logins) !== "function")
							{
								function delete_ip_ranges_last_logins(meta_id)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											id_address: meta_id,
											param: "limit_attempts_delete_ip_ranges_last_login",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $delete_ip_ranges ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_last_blocked_ip_ranges";
											}, 3000);
										});
									}
								}
							}
						<?php
					}
					break;
				case 'lab_recent_logs':
					?>
						jQuery("#ux_li_logs").addClass("active");
						jQuery("#ux_li_recent_logins").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === LOGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								lab_initialize();
							});
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_recent_logs", 0);
							jQuery("#ux_chk_all_logins").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_selected_log_limit_attempts_booster) !== "function")
							{
								function delete_selected_log_limit_attempts_booster(id)
								{
									var confirmDelete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirmDelete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											login_id: id,
											param: "limit_attempts_delete_selected_recent_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $limit_attempts_recent_selected_delete ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_recent_logs";
											}, 3000);
										});
									}
								}
							}
							jQuery("#ux_frm_recent_login").validate
							({
								rules:
								{
									ux_txt_start_date:
									{
										required: true
									},
									ux_txt_end_date:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_live_traffic':
					?>
						jQuery("#ux_li_logs").addClass("active");
						jQuery("#ux_li_live_traffic").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === LOGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								lab_initialize();
							});
							i = 30;
							if (typeof (counter_live_traffic) !== "function")
							{
								function counter_live_traffic()
								{
									jQuery(".timer").html(i);
									if (i === 0)
									{
										window.location.href = "admin.php?page=lab_live_traffic";
									}
									i--;
								}
							}
							setInterval(counter_live_traffic, 1000);
						<?php
						if ( 'enable' === $visitor_logs_data['live_traffic_monitoring'] ) {
							?>
								var oTable = get_datatable_limit_attempts_booster("#ux_tbl_live_traffic", 0);
								jQuery("#ux_chk_all_live_traffic").click(function ()
								{
									jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
								});
								if (typeof (live_selected_delete_limit_attempts_booster) !== "function")
								{
									function live_selected_delete_limit_attempts_booster(meta_id)
									{
										var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
										if (confirm_delete === true)
										{
											overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
											jQuery.post(ajaxurl,
											{
												confirm_id: meta_id,
												param: "limit_attempts_delete_selected_live_visitor_module", action: "limit_attempts_booster_action",
												_wp_nonce: "<?php echo esc_attr( $limit_attempts_traffic_delete ); ?>"
											},
											function (data)
											{
												setTimeout(function ()
												{
													remove_overlay_limit_attempts_booster();
													window.location.href = "admin.php?page=lab_live_traffic";
												}, 3000);
											});
										}
									}
								}
							<?php
						}
					}
					break;
				case 'lab_visitor_logs':
					?>
						jQuery("#ux_li_logs").addClass("active");
						jQuery("#ux_li_visitor_logs").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === LOGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								lab_initialize();
							});
						<?php
						if ( 'enable' === $visitor_logs_data['visitor_logs_monitoring'] ) {
							?>
								var oTable = get_datatable_limit_attempts_booster("#ux_tbl_visitor_logs", 0);
								jQuery("#ux_chk_all_visitor_logs").click(function ()
								{
									jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
								});
								if (typeof (visitor_log_delete_limit_attempts_booster) !== "function")
								{
									function visitor_log_delete_limit_attempts_booster(meta_id)
									{
										var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
										if (confirm_delete === true)
										{
											overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
											jQuery.post(ajaxurl,
											{
												confirm_id: meta_id,
												param: "limit_attempts_delete_selected_live_visitor_module",
												action: "limit_attempts_booster_action",
												_wp_nonce: "<?php echo esc_attr( $limit_attempts_traffic_delete ); ?>"
											},
											function (data)
											{
												setTimeout(function ()
												{
													remove_overlay_limit_attempts_booster();
													window.location.href = "admin.php?page=lab_visitor_logs";
												}, 3000);
											});
										}
									}
								}
								jQuery("#ux_frm_visitor_logs").validate
								({
									rules:
									{
										ux_txt_start_date:
										{
											required: true
										},
										ux_txt_end_date:
										{
											required: true
										}
											},
									errorPlacement: function ()
									{
									},
									highlight: function (element)
									{
										jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
									},
									success: function (label, element)
									{
										var icon = jQuery(element).parent(".input-icon").children("i");
										jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
										icon.removeClass("fa-warning").addClass("fa-check");
									},
									submitHandler: function (form)
									{
										premium_edition_notification_limit_attempts_booster();
									}
								});
							<?php
						}
					}
					break;
				case 'lab_alert_setup':
					?>
						jQuery("#ux_li_general_settings").addClass("active");
						jQuery("#ux_li_alert_setup").addClass("active");
					<?php
					if ( '1' === GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								jQuery("#ux_ddl_fail").val("<?php echo isset( $meta_data_array['email_when_a_user_fails_login'] ) ? esc_attr( $meta_data_array['email_when_a_user_fails_login'] ) : ''; ?>");
								jQuery("#ux_ddl_success").val("<?php echo isset( $meta_data_array['email_when_a_user_success_login'] ) ? esc_attr( $meta_data_array['email_when_a_user_success_login'] ) : ''; ?>");
								jQuery("#ux_ddl_IP_address_blocked").val("<?php echo isset( $meta_data_array['email_when_an_ip_address_is_blocked'] ) ? esc_attr( $meta_data_array['email_when_an_ip_address_is_blocked'] ) : ''; ?>");
								jQuery("#ux_ddl_IP_address_unblocked").val("<?php echo isset( $meta_data_array['email_when_an_ip_address_is_unblocked'] ) ? esc_attr( $meta_data_array['email_when_an_ip_address_is_unblocked'] ) : ''; ?>");
								jQuery("#ux_ddl_IP_range_blocked").val("<?php echo isset( $meta_data_array['email_when_an_ip_range_is_blocked'] ) ? esc_attr( $meta_data_array['email_when_an_ip_range_is_blocked'] ) : ''; ?>");
								jQuery("#ux_ddl_IP_range_unblocked").val("<?php echo isset( $meta_data_array['email_when_an_ip_range_is_unblocked'] ) ? esc_attr( $meta_data_array['email_when_an_ip_range_is_unblocked'] ) : ''; ?>");
							});
							jQuery("#ux_frm_alert_setup").validate
							({
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_error_messages':
					?>
						jQuery("#ux_li_general_settings").addClass("active");
						jQuery("#ux_li_error_messages").addClass("active");
					<?php
					if ( '1' === GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery("#ux_frm_error_messages").validate
							({
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_other_settings':
					?>
						jQuery("#ux_li_general_settings").addClass("active");
						jQuery("#ux_li_other_settings").addClass("active");
					<?php
					if ( '1' === GENERAL_SETTINGS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								jQuery("#ux_ddl_trackback").val("<?php echo $trackbacks_status > 0 ? 'enable' : 'disable'; ?>");
								jQuery("#ux_ddl_Comments").val("<?php echo $comments_status > 0 ? 'enable' : 'disable'; ?>");
								jQuery("#ux_ddl_plugin_updates").val("<?php echo isset( $meta_data_array['automatic_plugin_updates'] ) ? esc_attr( $meta_data_array['automatic_plugin_updates'] ) : 'disable'; ?>");
								jQuery("#ux_ddl_live_traffic_monitoring").val("<?php echo isset( $meta_data_array['live_traffic_monitoring'] ) ? esc_attr( $meta_data_array['live_traffic_monitoring'] ) : ''; ?>");
								jQuery("#ux_ddl_visitor_logs_monitoring").val("<?php echo isset( $meta_data_array['visitor_logs_monitoring'] ) ? esc_attr( $meta_data_array['visitor_logs_monitoring'] ) : ''; ?>");
								jQuery("#ux_ddl_plugin_uninstall").val("<?php echo isset( $meta_data_array['uninstall_plugin'] ) ? esc_attr( $meta_data_array['uninstall_plugin'] ) : ''; ?>");
								jQuery("#ux_ddl_ip_address_fetching_method").val("<?php echo isset( $meta_data_array['ip_address_fetching_method'] ) ? esc_attr( $meta_data_array['ip_address_fetching_method'] ) : ''; ?>");
							});
							jQuery("#ux_frm_other_settings").validate
									({
										submitHandler: function (form)
										{
											overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_saved_message ); ?>);
											jQuery.post(ajaxurl,
											{
												data: base64_encode(jQuery("#ux_frm_other_settings").serialize()),
												param: "limit_attempts_other_settings_module",
												action: "limit_attempts_booster_action",
												_wp_nonce: "<?php echo esc_attr( $limit_attempts_other_settings ); ?>"
											},
											function (data)
											{
												setTimeout(function ()
												{
													remove_overlay_limit_attempts_booster();
													window.location.href = "admin.php?page=lab_other_settings";
												}, 3000);
											});
										}
									});
						<?php
					}
					break;
				case 'lab_blocking_options':
					?>
						jQuery("#ux_li_advance_security").addClass("active");
						jQuery("#ux_li_blocking_options").addClass("active");
					<?php
					if ( '1' === ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							if (typeof (change_mailer_type_limit_attempts_booster) !== "function")
							{
								function change_mailer_type_limit_attempts_booster()
								{
									var change = jQuery("#ux_ddl_auto_ip").val();
									switch (change)
									{
										case "enable":
											jQuery("#ux_div_auto_ip").css("display", "block");
											break;
										case "disable":
											jQuery("#ux_div_auto_ip").css("display", "none");
											break;
									}
								}
							}
							jQuery(document).ready(function ()
							{
								jQuery("#ux_ddl_auto_ip").val("<?php echo isset( $blocking_option_array['auto_ip_block'] ) ? esc_attr( $blocking_option_array['auto_ip_block'] ) : ''; ?>");
								jQuery("#ux_ddl_blocked_for").val("<?php echo isset( $blocking_option_array['block_for'] ) ? esc_attr( $blocking_option_array['block_for'] ) : ''; ?>");
								change_mailer_type_limit_attempts_booster();
							});
							jQuery("#ux_frm_blocking_options").validate
							({
								rules:
								{
									ux_txt_login:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_saved_message ); ?>);
									jQuery.post(ajaxurl,
									{
										data: base64_encode(jQuery("#ux_frm_blocking_options").serialize()),
										param: "limit_attempts_blocking_options_module",
										action: "limit_attempts_booster_action",
										_wp_nonce: "<?php echo esc_attr( $limit_attempts_block ); ?>"
									},
									function (data)
									{
										setTimeout(function ()
										{
											remove_overlay_limit_attempts_booster();
											window.location.href = "admin.php?page=lab_blocking_options";
										}, 3000);
									});
								}
							});
						<?php
					}
					break;
				case 'lab_manage_ip_addresses':
					?>
						jQuery("#ux_li_advance_security").addClass("active");
						jQuery("#ux_li_manage_ip_addresses").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_manage_ip_addresses", 0);
							jQuery("#ux_chk_all_manage_ip_address").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_ip_address_limit_attempts_booster) !== "function")
							{
								function delete_ip_address_limit_attempts_booster(meta_id)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											id_address: meta_id,
											param: "limit_attempts_delete_ip_address_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $limit_attempts_manage_ip_address_delete ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_manage_ip_addresses";
											}, 3000);
										});
									}
								}
							}
							jQuery("#ux_frm_view_blocked_ip_addresses").validate
							({
								rules:
								{
									ux_txt_start_date:
									{
										required: true
									},
									ux_txt_end_date:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
							if (typeof (value_blank_ip_addresses_limit_attempts_booster) !== "function")
							{
								function value_blank_ip_addresses_limit_attempts_booster()
								{
									jQuery("#ux_txt_ip_address").val("");
									jQuery("#ux_txtarea_ip_comments").val("");
								}
							}
							if (typeof (check_valid_ip_address_limit_attempts_booster) !== "function")
							{
								function check_valid_ip_address_limit_attempts_booster()
								{
									var single_ip = jQuery("#ux_txt_ip_address").val();
									var flag;
									if (single_ip !== "")
									{
										if (!single_ip.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/))
										{
											var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
											toastr[shortCutFunction](<?php echo wp_json_encode( $lab_valid_ip_address ); ?>,<?php echo wp_json_encode( $lab_error_message_notification ); ?>);
											return flag = false;
										}
										return flag = true;
									}
								}
							}
							jQuery("#ux_frm_manage_ip_addresses_form").validate
							({
								rules:
								{
									ux_txt_ip_address:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								}, success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									var ip_address = check_valid_ip_address_limit_attempts_booster();
									var lab_ip_address = jQuery("#ux_txt_ip_address").val();
									if (ip_address === true)
									{
										jQuery.post(ajaxurl,
										{
											lab_ip_address: lab_ip_address,
											data: base64_encode(jQuery("#ux_frm_manage_ip_addresses_form").serialize()),
											param: "limit_attempts_manage_ip_address_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $limit_attempts_manage_ip_address ); ?>"
										},
										function (data) {
											if (parseInt(data) === 1)
											{
												var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
												toastr[shortCutFunction](<?php echo wp_json_encode( $lab_ip_address_already_blocked ); ?>,<?php echo wp_json_encode( $lab_notification ); ?>);
											}
											else if (parseInt(data) === 2)
											{
												var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
												toastr[shortCutFunction](<?php echo wp_json_encode( $lab_block_own_ip_address ); ?>,<?php echo wp_json_encode( $lab_notification ); ?>);
											}
											else
											{
												overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_blocked_message ); ?>);
												setTimeout(function ()
												{
													remove_overlay_limit_attempts_booster();
													window.location.href = "admin.php?page=lab_manage_ip_addresses";
												}, 3000);
											}
										});
									}
								}
							});
						<?php
					}
					break;
				case 'lab_manage_ip_ranges':
					?>
						jQuery("#ux_li_advance_security").addClass("active");
						jQuery("#ux_li_manage_ip_ranges").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_manage_ip_range", 0);
							jQuery("#ux_chk_all_manage_ip_range").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_ip_range_limit_attempts_booster) !== "function")
							{
								function delete_ip_range_limit_attempts_booster(meta_id)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											id_range: meta_id,
											param: "limit_attempts_delete_ip_range_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $limit_attempts_manage_ip_ranges_delete ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_manage_ip_ranges";
											}, 3000);
										});
									}
								}
							}
							jQuery("#ux_view_manage_ip_ranges").validate
							({
								rules:
								{
									ux_txt_start_date:
									{
										required: true
									},
									ux_txt_end_date:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
							if (typeof (value_blank_limit_attempts_booster) !== "function")
							{
								function value_blank_limit_attempts_booster()
								{
									jQuery("#ux_txt_start_ip_range").val("");
									jQuery("#ux_txt_end_ip_range").val("");
									jQuery("#ux_txtarea_manage_ip_range").val("");
								}
							}
							if (typeof (check_valid_ip_ranges_limit_attempts_booster) !== "function")
							{
								function check_valid_ip_ranges_limit_attempts_booster(control_id) {
									var ip_value = jQuery(control_id).val();
									var flag;
									if (ip_value !== "")
									{
										if (!jQuery(control_id).val().match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/))
										{
											var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
											switch (jQuery(control_id).attr("id"))
											{
												case "ux_txt_start_ip_range" :
													toastr[shortCutFunction](<?php echo wp_json_encode( $lab_valid_ip_range ); ?>,<?php echo wp_json_encode( $lab_error_message_notification ); ?>);
													break;
												case "ux_txt_end_ip_range" :
													toastr[shortCutFunction](<?php echo wp_json_encode( $lab_valid_ip_range ); ?>,<?php echo wp_json_encode( $lab_error_message_notification ); ?>);
													break;
											}
											return flag = false;
										}
										return flag = true;
									}
								}
							}
							jQuery("#ux_frm_manage_ip_ranges").validate
							({
								rules:
								{
									ux_txt_start_ip_range:
									{
										required: true
									},
									ux_txt_end_ip_range:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function (form)
								{
									var control_start_range = jQuery("#ux_txt_start_ip_range");
									var control_end_range = jQuery("#ux_txt_end_ip_range");
									if (check_valid_ip_ranges_limit_attempts_booster(control_start_range) && check_valid_ip_ranges_limit_attempts_booster(control_end_range))
									{
										if (ip2long(control_start_range.val()) < ip2long(control_end_range.val()))
										{
											var start_range = jQuery("#ux_txt_start_ip_range").val();
											var end_range = jQuery("#ux_txt_end_ip_range").val();
											jQuery.post(ajaxurl,
													{
														start_range: start_range,
														end_range: end_range,
														data: base64_encode(jQuery("#ux_frm_manage_ip_ranges").serialize()),
														param: "limit_attempts_manage_ip_ranges_module",
														action: "limit_attempts_booster_action",
														_wp_nonce: "<?php echo esc_attr( $limit_attempts_manage_ip_ranges ); ?>"
													},
													function (data)
													{
														if (parseInt(data) === 1)
														{
															var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
															toastr[shortCutFunction](<?php echo wp_json_encode( $lab_ip_address_already_blocked ); ?>,<?php echo wp_json_encode( $lab_notification ); ?>);
														}
														else if (parseInt(data) === 2)
														{
															var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
															toastr[shortCutFunction](<?php echo wp_json_encode( $lab_block_own_ip_address ); ?>,<?php echo wp_json_encode( $lab_notification ); ?>);
														}
														else
														{
															overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_blocked_message ); ?>);
															setTimeout(function ()
															{
																remove_overlay_limit_attempts_booster();
																window.location.href = "admin.php?page=lab_manage_ip_ranges";
															}, 3000);
														}
													});
										} else
										{
											var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
											toastr[shortCutFunction](<?php echo wp_json_encode( $lab_valid_ip_range ); ?>,<?php echo wp_json_encode( $lab_error_message_notification ); ?>);
										}
									} else
									{
										var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
										toastr[shortCutFunction](<?php echo wp_json_encode( $lab_valid_ip_address ); ?>,<?php echo wp_json_encode( $lab_error_message_notification ); ?>);
									}
								}
							});
						<?php
					}
					break;
				case 'lab_country_blocks':
					?>
						jQuery("#ux_li_advance_security").addClass("active");
						jQuery("#ux_li_country_blocks").addClass("active");
					<?php
					if ( '1' === ADVANCE_SECURITY_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery(document).ready(function ()
							{
								var available_countries = ["AF", "AX", "AL", "DZ", "AS", "AD", "AO", "AI", "AQ", "AG", "AR", "AM", "AW", "AU", "AT", "AZ", "BS", "BH", "BD", "BB", "BY", "BE", "BZ", "BJ", "BM", "BT", "BO", "BQ", "BA", "BW", "BV", "BR", "IO", "BN", "BG", "BF", "BI", "KH", "CM", "CA", "CV", "KY", "CF", "TD", "CL", "CN", "CX", "CC", "CO", "KM", "CG", "CD", "CK", "CR", "CI", "HR", "CU", "CW", "CY", "CZ", "DK", "DJ", "DM", "DO", "EC", "EG", "SV", "GQ", "ER", "EE", "ET", "FK", "FO", "FJ", "FI", "FR", "GF", "PF", "TF", "GA", "GM", "GE", "DE", "GH", "GI", "GR", "GL", "GD", "GP", "GU", "GT", "GG", "GN", "GW", "GY", "HT", "HM", "VA", "HN", "HK", "HU", "IS", "IN", "ID", "IR", "IQ", "IE", "IM", "IL", "IT", "JM", "JP", "JE", "JO", "KZ", "KE", "KI", "KP", "KR", "KW", "KG", "LA", "LV", "LB", "LS", "LR", "LY", "LI", "LT", "LU", "MO", "MK", "MG", "MW", "MY", "MV", "ML", "MT", "MH", "MQ", "MR", "MU", "YT", "MX", "FM", "MD", "MC", "MN", "ME", "MS", "MA", "MZ", "MM", "NA", "NR", "NP", "NL", "NC", "NZ", "NI", "NE", "NG", "NU", "NF", "MP", "NO", "OM", "PK", "PW", "PS", "PA", "PG", "PY", "PE", "PH", "PN", "PL", "PT", "PR", "QA", "RE", "RO", "RU", "RW", "BL", "SH", "KN", "LC", "MF", "PM", "VC", "WS", "SM", "ST", "SA", "SN", "RS", "SC", "SL", "SG", "SX", "SK", "SI", "SB", "SO", "ZA", "GS", "SS", "ES", "LK", "SD", "SR", "SJ", "SZ", "SE", "CH", "SY", "TW", "TJ", "TZ", "TH", "TL", "TG", "TK", "TO", "TT", "TN", "TR", "TM", "TC", "TV", "UG", "UA", "AE", "GB", "US", "UM", "UY", "UZ", "VU", "VE", "VN", "VG", "VI", "WF", "EH", "YE", "ZM", "ZW"];
								var all_available_countries = [];
								var selected_countries = "<?php echo isset( $country_data_array['country_blocks_data'] ) ? esc_attr( $country_data_array['country_blocks_data'] ) : ''; ?>";
								var strings = selected_countries.split(",");
								all_available_countries = available_countries.filter(function (val)
								{
									return selected_countries.indexOf(val) === -1;
								});
								var option = "";
								var option1 = "";
								if (all_available_countries.length > 0)
								{
									for (var flag = 0; flag < all_available_countries.length; flag++)
									{
										if (all_available_countries[flag] !== "")
										{
											option += '<option value="' + all_available_countries[flag] + '"> ' + jQuery("#ux_ddl_available_country_duplicate option[value=" + all_available_countries[flag] + "]").text() + '</option>';
										}
									}
									jQuery("#ux_ddl_available_country").append(option);
									sort_function_limit_attempts_booster("ux_ddl_selected_country");
								}
								var sel_coun = selected_countries.split(",");
								if (sel_coun.length > 0)
								{
									for (var flag = 0; flag < sel_coun.length; flag++)
									{
										if (sel_coun[flag] !== "")
										{
											option1 += '<option value="' + sel_coun[flag] + '"> ' + jQuery("#ux_ddl_available_country_duplicate option[value=" + sel_coun[flag] + "]").text() + '</option>';
										}
									}
									jQuery("#ux_ddl_selected_country").append(option1);
									sort_function_limit_attempts_booster("ux_ddl_available_country");
								}
							});
							if (typeof (add_country_limit_attempts_booster) !== "function")
							{
								function add_country_limit_attempts_booster()
								{
									var selected_countries = [];
									jQuery.each(jQuery("#ux_ddl_available_country option:selected"), function ()
									{
										selected_countries.push(jQuery(this));
										jQuery(this).remove();
									});
									var value = "";
									for (var flag = 0; flag < selected_countries.length; flag++)
									{
										value += '<option value="' + jQuery(selected_countries[flag]).val() + '">' + jQuery(selected_countries[flag]).text() + '</option>';
									}
									jQuery("#ux_ddl_selected_country").append(value);
									sort_function_limit_attempts_booster("ux_ddl_selected_country");
								}
							}
							if (typeof (remove_country_limit_attempts_booster) !== "function")
							{
								function remove_country_limit_attempts_booster()
								{
									var selected_countries = [];
									jQuery.each(jQuery("#ux_ddl_selected_country option:selected"), function ()
									{
										selected_countries.push(jQuery(this));
										jQuery(this).remove();
									});
									var value = "";
									for (var flag = 0; flag < selected_countries.length; flag++) {
										value += '<option value="' + jQuery(selected_countries[flag]).val() + '">' + jQuery(selected_countries[flag]).text() + '</option>';
									}
									jQuery("#ux_ddl_available_country").append(value);
									sort_function_limit_attempts_booster("ux_ddl_available_country");
								}
							}
							jQuery("#ux_frm_country_blocks").validate
							({
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_email_templates':
					?>
						jQuery("#ux_li_email_templates").addClass("active");
					<?php
					if ( '1' === EMAIL_TEMPLATES_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							if (typeof (template_change_data_limit_attempts_booster) !== "function")
							{
								function template_change_data_limit_attempts_booster()
								{
									var email_type = jQuery("#ux_ddl_user_success").val();
									jQuery.post(ajaxurl,
									{
										data: email_type,
										param: "limit_attempts_change_email_template_module",
										action: "limit_attempts_booster_action",
										_wp_nonce: "<?php echo esc_attr( $limit_attempts_email_template_data ); ?>"
									},
									function (data)
									{
										jQuery("#ux_email_template_meta_id").val(jQuery.parseJSON(data)[0]["meta_id"]);
										jQuery("#ux_txt_send_to").val(jQuery.parseJSON(data)[0]["email_send_to"]);
										jQuery("#ux_txt_cc").val(jQuery.parseJSON(data)[0]["email_cc"]);
										jQuery("#ux_txt_bcc").val(jQuery.parseJSON(data)[0]["email_bcc"]);
										jQuery("#ux_txt_subject").val(jQuery.parseJSON(data)[0]["email_subject"]);
										if (window.CKEDITOR)
										{
											CKEDITOR.instances["ux_heading_content"].setData(jQuery.parseJSON(data)[0]["email_message"]);
										} else if (jQuery("#wp-ux_heading_content-wrap").hasClass("tmce-active"))
										{
											tinyMCE.get("ux_heading_content").setContent(jQuery.parseJSON(data)[0]["email_message"]);
										} else
										{
											jQuery("#ux_heading_content").val(jQuery.parseJSON(data)[0]["email_message"]);
										}
									});
								}
							}
							jQuery(document).ready(function ()
							{
								if (window.CKEDITOR)
								{
									CKEDITOR.replace("ux_heading_content");
								}
								template_change_data_limit_attempts_booster();
							});
							jQuery("#ux_frm_email_templates").validate
							({
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_custom_cron_jobs':
					?>
						jQuery("#ux_li_cron_jobs").addClass("active");
						jQuery("#ux_li_custom_cron_jobs").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === CRON_JOBS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_data_table_custom_cron", 4);
							jQuery("#ux_chk_select_all_scheduler").click(function ()
							{
								jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
							});
							if (typeof (delete_custom_cron_job_limit_attempts_booster) !== "function")
							{
								function delete_custom_cron_job_limit_attempts_booster(scheduler)
								{
									var confirm_delete = confirm(<?php echo wp_json_encode( $lab_confirm_message ); ?>);
									if (confirm_delete === true)
									{
										overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_delete_message ); ?>);
										jQuery.post(ajaxurl,
										{
											scheduler: scheduler,
											param: "limit_attempts_delete_custom_cron_job_module",
											action: "limit_attempts_booster_action",
											_wp_nonce: "<?php echo esc_attr( $limit_attempts_delete_custom_cron_jobs ); ?>"
										},
										function (data)
										{
											setTimeout(function ()
											{
												remove_overlay_limit_attempts_booster();
												window.location.href = "admin.php?page=lab_custom_cron_jobs";
											}, 3000);
										});
									}
								}
							}
						<?php
					}
					break;
				case 'lab_core_cron_jobs':
					?>
						jQuery("#ux_li_cron_jobs").addClass("active");
						jQuery("#ux_li_core_cron_jobs").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === CRON_JOBS_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							var oTable = get_datatable_limit_attempts_booster("#ux_tbl_data_table_core_cron", 3);
						<?php
					}
					break;
				case 'lab_roles_and_capabilities':
					?>
						jQuery("#ux_li_roles_capabilities").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === ROLES_AND_CAPABILITIES_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							if (typeof (show_roles_capabilities_limit_attempts_booster) !== "function")
							{
								function show_roles_capabilities_limit_attempts_booster(id, div_id)
								{
									if (jQuery(id).prop("checked"))
									{
										jQuery("#" + div_id).css("display", "block");
									} else
									{
										jQuery("#" + div_id).css("display", "none");
									}
								}
							}
							if (typeof (full_control_function_limit_attempts_booster) !== "function")
							{
								function full_control_function_limit_attempts_booster(id, div_id)
								{
									var checkbox_id = jQuery(id).prop("checked");
									jQuery("#" + div_id + " input[type=checkbox]").each(function ()
									{
										if (checkbox_id)
										{
											jQuery(this).attr("checked", "checked");
											if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
											{
												jQuery(this).attr("disabled", "disabled");
											}
										} else
										{
											if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
											{
												jQuery(this).removeAttr("disabled");
												jQuery("#ux_chk_other_capabilities_manage_options").attr("disabled", "disabled");
												jQuery("#ux_chk_other_capabilities_read").attr("disabled", "disabled");
											}
										}
									});
								}
							}
							jQuery(document).ready(function ()
							{
								jQuery("#ux_ddl_limit_attempts_booster_menu").val("<?php echo isset( $details_roles_capabilities['show_limit_attempts_booster_top_bar_menu'] ) ? esc_attr( $details_roles_capabilities['show_limit_attempts_booster_top_bar_menu'] ) : 'enable'; ?>");
								show_roles_capabilities_limit_attempts_booster("#ux_chk_author", "ux_div_author_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_author", "ux_div_author_roles");
								show_roles_capabilities_limit_attempts_booster("#ux_chk_editor", "ux_div_editor_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_editor", "ux_div_editor_roles");
								show_roles_capabilities_limit_attempts_booster("#ux_chk_contributor", "ux_div_contributor_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_contributor", "ux_div_contributor_roles");
								show_roles_capabilities_limit_attempts_booster("#ux_chk_subscriber", "ux_div_subscriber_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_subscriber", "ux_div_subscriber_roles");
								show_roles_capabilities_limit_attempts_booster("#ux_chk_other", "ux_div_other_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_other", "ux_div_other_roles");
								full_control_function_limit_attempts_booster("#ux_chk_full_control_other_roles", "ux_div_other_roles_capabilities");
							});
							var roles = [];
							jQuery("#ux_frm_roles_and_capabilities").validate
							({
								submitHandler: function (form)
								{
									premium_edition_notification_limit_attempts_booster();
								}
							});
						<?php
					}
					break;
				case 'lab_feature_requests':
					?>
						jQuery("#ux_li_feature_requests").addClass("active");
						var features_array = [];
						var url = "<?php echo esc_attr( TECH_BANKER_URL ) . '/feedbacks.php'; ?>";
						var domain_url = "<?php echo esc_attr( site_url() ); ?>";
						jQuery("#ux_frm_feature_requests").validate
						({ rules:
							{
								ux_txt_your_name:
								{
									required: true
								},
								ux_txt_email_address:
								{
									required: true,
									email: true
								},
								ux_txtarea_feature_request:
								{
									required: true
								}
							},
							errorPlacement: function ()
							{
							},
							highlight: function (element)
							{
								jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
							},
							success: function (label, element)
							{
								var icon = jQuery(element).parent(".input-icon").children("i");
								jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
								icon.removeClass("fa-warning").addClass("fa-check");
							},
							submitHandler: function (form)
							{
								features_array.push(jQuery("#ux_txt_your_name").val(), jQuery("#ux_txt_email_address").val(), domain_url, jQuery("#ux_txtarea_feature_request").val());
								overlay_loading_limit_attempts_booster(<?php echo wp_json_encode( $lab_feature_request ); ?>);
								jQuery.post(url,
								{
									data: JSON.stringify(features_array),
									param: "lab_feature_requests"
								},
								function ()
								{
									setTimeout(function ()
									{
										remove_overlay_limit_attempts_booster();
										window.location.href = "admin.php?page=lab_feature_requests";
									}, 3000);
								});
							}
						});
					<?php
					break;
				case 'lab_system_information':
					?>
						jQuery("#ux_li_system_information").addClass("active");
						var sidebar_load_interval = setInterval(load_sidebar_content_limit_attempts_booster, 1000);
						setTimeout(function ()
						{
							clearInterval(sidebar_load_interval);
						}, 5000);
					<?php
					if ( '1' === SYSTEM_INFORMATION_LIMIT_ATTEMPTS_BOOSTER ) {
						?>
							jQuery.getSystemReport = function (strDefault, stringCount, string, location)
							{
								var o = strDefault.toString();
								if (!string)
								{
									string = "0";
								}
								while (o.length < stringCount)
								{
									if (location === "undefined")
									{
										o = string + o;
									} else
									{
										o = o + string;
									}
								}
								return o;
							};
							jQuery(".system-report").click(function ()
							{
								var report = "";
								jQuery(".custom-form-body").each(function ()
								{
									jQuery("h3.form-section", jQuery(this)).each(function ()
									{
										report = report + "\n### " + jQuery.trim(jQuery(this).text()) + " ###\n\n";
									});
									jQuery("tbody > tr", jQuery(this)).each(function ()
									{
										var the_name = jQuery.getSystemReport(jQuery.trim(jQuery(this).find("strong").text()), 25, " ");
										var the_value = jQuery.trim(jQuery(this).find("span").text());
										var value_array = the_value.split(", ");
										if (value_array.length > 1)
										{
											var temp_line = "";
											jQuery.each(value_array, function (key, line)
											{
												var tab = (key === 0) ? 0 : 25;
												temp_line = temp_line + jQuery.getSystemReport("", tab, " ", "f") + line + "\n";
											});
											the_value = temp_line;
										}
										report = report + "" + the_name + the_value + "\n";
									});
								});
								try
								{
									jQuery("#ux_system_information").slideDown();
									jQuery("#ux_system_information textarea").val(report).focus().select();
									return false;
								} catch (e)
								{
								}
								return false;
							});
							jQuery("#ux_btn_system_information").click(function ()
							{
								if (jQuery("#ux_btn_system_information").text() === "Close System Information!")
								{
									jQuery("#ux_system_information").slideUp();
									jQuery("#ux_btn_system_information").html("Get System Information!");
								} else
								{
									jQuery("#ux_btn_system_information").html("Close System Information!");
									jQuery("#ux_btn_system_information").removeClass("system-information");
									jQuery("#ux_btn_system_information").addClass("close-information");
								}
							});
						<?php
					}
					break;
			}
		}
		?>
		</script>
		<?php
	}
}
