<?php
/**
* Plugin Name: Chat2
* Plugin URI: http://chat2.com/
* Description: This plugin adds Chat2 live chat to your wordpress website.
* Version: 1.0.0
* Author: Chat2
* Author URI: http://chat2.com
* License: GPL2
*/

add_action( 'admin_init', 'chat2_settings' );

function chat2_settings() {
	register_setting( 'chat2_group', 'language' );
	register_setting( 'chat2_group', 'department' );
	register_setting( 'chat2_group', 'operator_id' );
	register_setting( 'chat2_group', 'theme' );
	register_setting( 'chat2_group', 'popupwidth' );
	register_setting( 'chat2_group', 'popupheight' );
	register_setting( 'chat2_group', 'widgetwidth' );
	register_setting( 'chat2_group', 'widgetheight' );
	register_setting( 'chat2_group', 'httpmode' );
	register_setting( 'chat2_group', 'position' );
	register_setting( 'chat2_group', 'minimize' );
	register_setting( 'chat2_group', 'posTop' );
	register_setting( 'chat2_group', 'domain' );
	register_setting( 'chat2_group', 'identifier' );
	register_setting( 'chat2_group', 'enablechat2plugin' );
	register_setting( 'chat2_group', 'loginusername' );
	register_setting( 'chat2_group', 'loginpassword' );
	register_setting( 'chat2_group', 'chaturl' );
	register_setting( 'chat2_group', 'embedcodedata' );
	wp_register_style( 'chat2_css', plugins_url('css/style.css', __FILE__) );
	wp_register_script( 'chat2_js', plugins_url('js/common.js', __FILE__) );
}

add_action('admin_menu', 'chat2_setting_menu');

function chat2_setting_menu() {
	$page = add_menu_page('Chat2 Settings', 'Chat2', 'administrator', 'chat2-settings', 'chat2_setting_page', plugin_dir_url( __FILE__ ) . 'image/32uldpi.png');
	
	add_action( 'admin_print_styles-' . $page, 'chat2_admin_styles' );
	add_action( 'admin_print_scripts-' . $page, 'chat2_admin_js' );
}

function chat2_admin_styles(){
	wp_enqueue_style( 'chat2_css' );
}

function chat2_admin_js(){
	wp_enqueue_script( 'chat2_js' );
}

function chat2_setting_page() {
	include("settingform.php");
}


add_filter( 'wp_footer' , 'chat2_footer' );
function chat2_footer() {
	$isEnabled = (get_option('enablechat2plugin') === FALSE)?"1":get_option('enablechat2plugin'); 
	if($isEnabled == "1"){
		$widget_height = esc_attr( get_option('widgetwidth', 300));
		$widget_width = esc_attr( get_option('widgetheight', 340));
		$popup_height = esc_attr( get_option('popupheight', 520));
		$popup_width = esc_attr( get_option('popupwidth', 500));
		$topPos = esc_attr( get_option('posTop', 350));

		if($topPos == "")
			$topPos = "350";
		
		$pointsUnit = esc_attr( get_option('posType', "pixels"));
		if($pointsUnit == "")
			$pointsUnit = "pixels";

		$identifier = esc_attr( get_option('identifier') );
		$identifierStr = "";
		if($identifier != ""){
			$identifierStr = "(identifier)/" . $identifier . "/";
		}


		$domains = get_site_url();
		$domainsStr = "";

		if($domains != ""){
			$domainsStr = ",domain:'" . $domains . "'";
		}

		$minmizesection = esc_attr( get_option('minimize', "br"));
		$minmizesectionStr = "";

		if($minmizesection != ""){
			$minmizesectionStr = "(ma)/" . $minmizesection . "/";
		}

		$PositionData = esc_attr( get_option('position', "bottom_right") );
		$PositionDataStr = "";

		if($PositionData != ""){
			$PositionDataStr = "(position)/" . $PositionData . "/";
		}

		$httpMode = esc_attr( get_option('httpmode', "") );

		$theme = esc_attr( get_option('theme'), 0 );
		$themeStr = "";

		if($theme != ""){
			$themeStr = "(theme)/" . $theme;
		}

		$operatorId = esc_attr( get_option('operator_id') );
		$operatorIdStr = "";

		if($operatorId != ""){
			$operatorIdStr = "(operator)/" . $operatorId . "/";
		}

		$language = esc_attr( get_option('language', "eng/") );
		$languageStr = "";
		if($language != "" && $language != "eng/"){
			$languageStr = $language;
		}

		$departmentStr = "";

		$DepartmentData = esc_attr( get_option('department') );
		$departmentStr = "";

		if($DepartmentData != ""){
			$departmentStr = "(department)/" . $DepartmentData . "/";
		}

		$LoSWebsiteUrl = get_option('chaturl');
		$LoSWebsiteUrlArray = parse_url($LoSWebsiteUrl);
		$LoSWebsiteUrl = $LoSWebsiteUrlArray["host"];
		$LoSWebsiteUrl = str_replace(".", "", $LoSWebsiteUrl) . ".chat2.com";

		if($LoSWebsiteUrl == ""){
			$LoSWebsiteUrl = get_site_url();
			$LoSWebsiteUrlArray = parse_url($LoSWebsiteUrl);
			$LoSWebsiteUrl = $LoSWebsiteUrlArray["host"];
			$LoSWebsiteUrl = str_replace(".", "", $LoSWebsiteUrl) . ".chat2.com";
		}
		echo $scriptCodeData = '<script type="text/javascript">' .
							 'var Chat2Options = {};' .
							 'Chat2Options.opt = {widget_height:' . $widget_height . ',widget_width:' . $widget_width . ',popup_height:' . $popup_height . ',popup_width:' . $popup_width . $domainsStr . '};' . 
							 '(function() {' . 
								 'var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;' .
								 'var refferer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf(\'://\')+1)) : \'\';' .
								 'var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : \'\';' .
								 'po.src = \'' . $httpMode . '//' . $LoSWebsiteUrl .  '/' . $languageStr . 'chat/getstatus/(click)/internal/' . $PositionDataStr . $minmizesectionStr . '(check_operator_messages)/true/(top)/' . $topPos . '/(units)/' . $pointsUnit . '/(leaveamessage)/true/' . $operatorIdStr . $identifierStr . $departmentStr . $themeStr . '?r=\'+refferer+\'&l=\'+location;' .
								 'var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);' .
							 '})();' .
							 '</script>';
			
	}

				 
}
?>