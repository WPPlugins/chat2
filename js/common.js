
jQuery(function(){
	generateCode();
	jQuery( ".blurClass" ).blur(function() {
		generateCode();
	});
	jQuery( ".changeClass" ).change(function() {
		generateCode();
	});

	jQuery( "#departmentCbo" ).change(function() {
		var strData = "";
		jQuery('#departmentCbo :selected').each(function(){
			if(strData != "")
				strData += "/";	
			strData = strData + jQuery(this).val();
		});
		jQuery("#department").val(strData);
		generateCode();
	});
});

function generateCode(){
	var widget_height = jQuery("#widgetheight").val();
	var widget_width = jQuery("#widgetwidth").val();
	var popup_height = jQuery("#popupheight").val();
	var popup_width = jQuery("#popupwidth").val();
	var topPos = jQuery("#posTop").val();

	if(topPos == "")
		topPos = "350";
	
	var pointsUnit = jQuery("#posType").val();
	if(pointsUnit == "")
		pointsUnit = "pixels";

	var identifier = jQuery("#identifier").val();
	var identifierStr = "";
	if(identifier != ""){
		var identifierStr = "(identifier)/" + identifier + "/";
	}


	var domains = jQuery("#domain").val();
	var domainsStr = "";

	if(domains != ""){
		domainsStr = ",domain:'" + domains + "'";
	}

	var minmizesection = jQuery("#minimize").val();
	var minmizesectionStr = "";

	if(minmizesection != ""){
		minmizesectionStr = "(ma)/" + minmizesection + "/";
	}

	var PositionData = jQuery("#position").val();
	var PositionDataStr = "";

	if(PositionData != ""){
		PositionDataStr = "(position)/" + PositionData + "/";
	}

	var httpMode = jQuery("#httpmode").val();

	var theme = jQuery("#theme").val();
	var themeStr = "";

	if(theme != ""){
		themeStr = "(theme)/" + theme;
	}

	var operatorId = jQuery("#operator_id").val();
	var operatorIdStr = "";

	if(operatorId != ""){
		operatorIdStr = "(operator)/" + operatorId + "/";
	}

	var language = jQuery("#language").val();
	var languageStr = "";
	if(language != "" && language != "eng/"){
		languageStr = language;
	}

	var departmentStr = "";

	var DepartmentData = jQuery("#department").val();
	var departmentStr = "";

	if(DepartmentData != ""){
		departmentStr = "(department)/" + DepartmentData + "/";
	}

	var embedUrl = jQuery("#chaturl").val();

	var location = document.createElement("a");
    location.href = embedUrl;
    
    if (location.host == "") {
      	embedUrl = jQuery("#hdnLiveChatUrl").val();
    }else{
    	embedUrl = location.hostname;
    	if(embedUrl.indexOf('www.') === 0){
		    embedUrl = embedUrl.replace('www.','');
		}
    	embedUrl = embedUrl.replace(/\./g, ''); 
    	embedUrl = embedUrl + ".chat2.com";
    }
  
	var scriptCodeData = '<script type="text/javascript">' +
						 '\r\nvar Chat2Options = {};' + 
						 '\r\nChat2Options.opt = {widget_height:' + widget_height + ',widget_width:' + widget_width + ',popup_height:' + popup_height + ',popup_width:' + popup_width + domainsStr + '};' + 
						 '\r\n(function() {' + 
							 '\r\nvar po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;' +
							 '\r\nvar refferer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf(\'://\')+1)) : \'\';' +
							 '\r\nvar location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : \'\';' +
							 '\r\npo.src = \'' + httpMode + '//' + embedUrl + '/' + languageStr + 'chat/getstatus/(click)/internal/' + PositionDataStr + minmizesectionStr + '(check_operator_messages)/true/(top)/' + topPos + '/(units)/' + pointsUnit + '/(leaveamessage)/true/' + operatorIdStr + identifierStr + departmentStr + themeStr + '?r=\'+refferer+\'&l=\'+location;' +
							 '\r\nvar s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);' +
						 '\r\n})();' +
						 '\r\n</script>';

	jQuery(".embedcode").val(scriptCodeData);
}