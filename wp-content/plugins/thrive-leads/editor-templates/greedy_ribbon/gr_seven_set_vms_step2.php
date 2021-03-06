<?php
$config = tve_leads_errors_config();
/* always include all elements inside a thrv-leads-slide-in element */
?>
<div class="thrv-greedy-ribbon tve_no_drag tve_no_icons tve_element_hover thrv_wrapper tve_gr_seven_set tve_black" style="background-image: url('<?php echo TVE_LEADS_URL . 'editor-templates/_form_css/images/gr_seven_set_bg.jpg' ?>');background-size: cover; background-position: center center;">
	<div class="tve-greedy-ribbon-content tve_editor_main_content">
		<div class="thrv_wrapper thrv_contentbox_shortcode" data-tve-style="5">
			<div class="tve_cb tve_cb5 tve_white">
				<div class="tve_cb_cnt">
					<div class="thrv_wrapper thrv_content_container_shortcode">
						<div class="tve_clear"></div>
						<div class="tve_center tve_content_inner" style="width: 910px;min-width:50px; min-height: 2em;">
							<h2 class="tve_p_center rft" style="color: #666666; font-size: 65px;margin-top: 60px;margin-bottom: 0;">
								<font color="#0065bb">Sign up below</font> to get access
								to the <font color="#0065bb">FREE Download</font>
							</h2>
						</div>
						<div class="tve_clear"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="thrv_wrapper thrv_content_container_shortcode">
			<div class="tve_clear"></div>
			<div class="tve_center tve_content_inner" style="width: 910px;min-width:50px; min-height: 2em;margin-top: 120px;">
				<div class="thrv_wrapper thrv_contentbox_shortcode" data-tve-style="6">
					<div class="tve_cb tve_cb6 tve_white">
						<div class="tve_cb_cnt">
							<div class="thrv_wrapper thrv_content_container_shortcode">
								<div class="tve_clear"></div>
								<div class="tve_center tve_content_inner" style="width: 450px;min-width:50px; min-height: 2em;margin-top: 80px;margin-bottom: 80px;">
									<div
										class="thrv_wrapper thrv_lead_generation tve_clearfix thrv_lead_generation_vertical tve_orange tve_3"
										data-inputs-count="3" data-tve-style="1" style="margin-top: 0; margin-bottom: 20px;">
										<div class="thrv_lead_generation_code" style="display: none;"></div>
										<input type="hidden" class="tve-lg-err-msg"
										       value="<?php echo htmlspecialchars( json_encode( $config ) ) ?>"/>

										<div class="thrv_lead_generation_container tve_clearfix">
											<div class="tve_lead_generated_inputs_container tve_clearfix">
												<div class="tve_lead_fields_overlay"></div>
												<div class=" tve_lg_input_container tve_lg_3 tve_lg_input">
													<input type="text" data-placeholder="" value="" name="name"
													       placeholder="Your name"/>
												</div>
												<div class=" tve_lg_input_container tve_lg_3 tve_lg_input">
													<input type="text" data-placeholder="" value="" name="email"
													       placeholder="Your Email Address"/>
												</div>
												<div class="tve_lg_input_container tve_submit_container tve tve_lg_3 tve_lg_submit">
													<button type="Submit">I Want to Have More Free Time</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tve_clear"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tve_clear"></div>
		</div>
		<div class="thrv_wrapper thrv_icon aligncenter gr-close-button tve_no_drag">
            <span data-tve-icon="gr-seven-set-close"
                  class="tve_sc_icon gr-seven-set-close tve_white tve_evt_manager_listen tve_et_click"
                  style="font-size: 90px;" data-tcb-events="|close_form|"></span>
		</div>
	</div>
</div>



