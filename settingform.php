<?php
	$languageArray = array("eng", "lit", "hrv", "esp", "por", "nld", "ara", "ger", "pol", "rus", "ita", "fre", "chn", "cse", "nor", "tur", "vnm", "idn", "sve", "per", "ell", "dnk", "rou", "bgr", "tha", "geo", "fin", "alb");
	
	$LoSDepartment = array("0" => "Any", "1" => "Support");
	$LosTheme = array("" => "Default", "1" => "energyhub theme", "2" => "greyspace", "3" => "chat002");
	$LoSHttpMode = array("" => "Based on site (default)", "http:" => "http:", "https:" => "https:");
	$LoSPosition = array("original" => "Native placement - it will be shown where the html is embedded", "bottom_right" => "Bottom right corner of the screen", "bottom_left" => "Bottom left corner of the screen", "middle_right" => "Middle right side of the screen", "middle_left" => "Middle left side of the screen", "api" => "Invisible, only JS API will be included");

	$LoSminiMize = array("" => "Keep where it was", "br" => "Minimize to bottom of the screen");

	$LoSPoSType = array("pixels" => "Pixels", "percents" => "Percents");
	$LoSWebsiteUrl = get_site_url();
	$LoSWebsiteUrlArray = parse_url($LoSWebsiteUrl);
	$LoSWebsiteUrl = $LoSWebsiteUrlArray["host"];
	$LoSWebsiteUrl = str_replace(".", "", $LoSWebsiteUrl) . ".chat2.com";

	$isEnabled = (get_option('enablechat2plugin') === FALSE)?"1":get_option('enablechat2plugin'); 
	
?>
<script>
	function validateChat2(){
		if(jQuery("#chaturl").val() == ""){
			alert("Please enter Chat Url.");
			jQuery("#chaturl").focus();
			return false;
		}
		return true;
	}

	function toggleDiv(){
		jQuery("#advanceoptionId").toggle("slow");
		jQuery("#advanceoptionCodeId").toggle("slow");
		jQuery("#advanceOptionLabel").toggleClass("trundown");
		
	}
</script>
<div class="wrap">
	
	
	<form method="post" action="options.php" onSubmit="return validateChat2();">
		<div class="chat2_heading">
			<div class="chat2_heading_label">Chat2</div>
			<div class="chat2_toggle">
				<label class="css-switch">
				  <input type="checkbox" class="css-switch-check" name="enablechat2plugin" id="enablechat2plugin" value="1" <?php echo ($isEnabled == "1")?"checked='checked'": ""; ?> />
			      
			      <span class="css-switch-label"></span>
			      <span class="css-switch-handle"></span>
				</label>
			</div>
		</div>	
		<div style="clear:both;"></div>
		<?php settings_fields( 'chat2_group' ); ?>
		<?php do_settings_sections( 'chat2_group' ); ?>
		<input type="hidden" name="hdnLiveChatUrl" id="hdnLiveChatUrlId" value="<?php echo $LoSWebsiteUrl;?>"  >
		<table width="100%">
			
			<tr>
				<td colspan="3">
					<b class="label">Login Username <a href="http://www.chat2.com/" target="_blank"> (register for an account here)</a>

					<input type="text" class="fullwidth" name="loginusername" id="loginusername" value="<?php echo esc_attr( get_option('loginusername') ); ?>" />
				</td>
			</tr>

			<tr>
				<td colspan="3">
					<b class="label">Login Password</b><br />
					<input type="text" class="fullwidth" name="loginpassword" id="loginpassword" value="<?php echo esc_attr( get_option('loginpassword') ); ?>" />
				</td>
			</tr>

			<tr>
				<td colspan="3">
					<b class="label">URL</b><br />
					<input type="text" class="fullwidth changeClass" name="chaturl" id="chaturl" value="<?php echo esc_attr( get_option('chaturl1', get_site_url())); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<br />
					<b class="label" id="advanceOptionLabel" onclick="toggleDiv();">Advanced Options</b><br />
				</td>
			</tr>
			<tr valign="top" id="advanceoptionId" style="display:none;">
				<td class="formleft">
					<table width="100%">
						
						<tr>
							<td class="col1Field">
								<b class="label">Choose a language</b><br />
								<select name="language" id="language" class="fullwidth changeClass">
									<?php
										foreach($languageArray as $kry => $val){
											$LoSTmp = $val. "/";
											$LoSStrSelected = "";
											if($LoSTmp == esc_attr( get_option('language', "eng/") ))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $val;?>/" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>
								</select>
							</td> 
						</tr>
						
						<tr>
							<td class="col1Field">
								<b class="label">Department</b><br />
								<select name="departmentCbo" id="departmentCbo" multiple="multiple" class="fullwidth">
									<?php
										$LosSelectedDepartment = esc_attr( get_option('department') );
										$LosSelectedDepartmentArray = array();
										if($LosSelectedDepartment != "")
											$LosSelectedDepartmentArray = explode("/", $LosSelectedDepartment);	
										foreach($LoSDepartment as $key => $val){
											
											$LoSStrSelected = "";
											if(in_array($key, $LosSelectedDepartmentArray))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $key;?>" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>	
								</select>
								<input type="hidden" name="department" id="department" value="<?php echo esc_attr( get_option('department') );?>" />
							</td>
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Operator ID</b><br />
								<input type="text" class="fullwidth blurClass" name="operator_id" id="operator_id" value="<?php echo esc_attr( get_option('operator_id') ); ?>" />
							</td>
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Theme</b><br />
								<input type="text" class="fullwidth blurClass" name="theme" id="theme" value="<?php echo esc_attr( get_option('theme') ); ?>" />
							</td>
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Popup Window Size</b><br />
								<input type="text" class="width_45 blurClass" name="popupwidth" id="popupwidth" value="<?php echo esc_attr( get_option('popupwidth', 500) ); ?>" />
								X
								<input type="text" class="width_45 blurClass" name="popupheight" id="popupheight" value="<?php echo esc_attr( get_option('popupheight', 520) ); ?>" />
							</td>
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Widget Size</b><br />
								<input type="text" class="width_45 blurClass" name="widgetwidth" id="widgetwidth" value="<?php echo esc_attr( get_option('widgetwidth', 300) ); ?>" />
								X
								<input type="text" class="width_45 blurClass" name="widgetheight" id="widgetheight" value="<?php echo esc_attr( get_option('widgetheight', 340) ); ?>" />
							</td>
						</tr>
					</table>
				</td>
				<td class="formmiddle">&nbsp;</td>
				<td class="formright">
					<table width="100%">
						
						<tr>
							<td class="col1Field">
								<b class="label">Choose prefered http mode</b><br />
								<select name="httpmode" id="httpmode" class="fullwidth changeClass">
									<?php
										foreach($LoSHttpMode as $key => $val){
											
											$LoSStrSelected = "";
											if($key == esc_attr( get_option('httpmode', "") ))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $key;?>" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>	
								</select>
							</td> 
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Position</b><br />
								<select name="position" id="position" class="fullwidth changeClass">
									<?php
										foreach($LoSPosition as $key => $val){
											
											$LoSStrSelected = "";
											if($key == esc_attr( get_option('position', "bottom_right") ))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $key;?>" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>	
								</select>
							</td> 
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Minimize action, applies only if status widget is at the bottom</b><br />
								<select name="minimize" id="minimize" class="fullwidth changeClass">
									<?php
										foreach($LoSminiMize as $key => $val){
											
											$LoSStrSelected = "";
											if($key == esc_attr( get_option('minimize', "br") ))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $key;?>" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>	
								</select>
							</td> 
						</tr>

						<tr>
							<td class="col1Field">
								<b class="label">Position from the top, only used if the Middle left or the Middle right side is chosen</b><br />

								<input type="text" class="width70 blurClass" name="posTop" id="posTop" value="<?php echo esc_attr( get_option('posTop', 350) ); ?>" />

								<select name="posType" id="posType" class="width25 changeClass">
									<?php
										foreach($LoSPoSType as $key => $val){
											
											$LoSStrSelected = "";
											if($key == esc_attr( get_option('posType', "pixels") ))
												$LoSStrSelected = "selected = 'selected'";
									?>
											<option value="<?php echo $key;?>" <?php echo $LoSStrSelected; ?> ><?php echo $val;?></option>	
									<?php
										}
									?>	
								</select>
							</td> 
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">For what domain you are generating embed code?</b><br />
								<input type="text" disabled class="fullwidth blurClass" name="domain" id="domain" value="<?php echo get_site_url(); ?>" />
							</td>
						</tr>
						<tr>
							<td class="col1Field">
								<b class="label">Identifier, this can be used as filter for pro active chat invitations and is use full having different messages for different domains. Only string without spaces or special characters.</b><br />
								<input type="text" class="fullwidth blurClass" name="identifier" id="identifier" value="<?php echo esc_attr( get_option('identifier') ); ?>" />
							</td>
						</tr>
					</table>			
				</td>
			</tr>
			<tr style="display:none;" id="advanceoptionCodeId">
				<td colspan="3">
					<b class="label">Result</b><br />
					<textarea disabled class="embedcode" name="embedcodedata"><?php echo esc_attr( get_option('embedcodedata') ); ?></textarea>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>