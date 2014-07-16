var COMMON = {
	
	/**
	 * Confirm delete
	 * @author DungNT
	 * @since 14/12/2013
	 * @param int the_i_Id
	 * @param string the_sz_Url
	 * @param string the_sz_ActionName
	 * @param string the_sz_AlertTitle
	 * @param string the_sz_AlertMsg
	 * @return void
	 */
	v_fConfirmDelete : function(the_i_Id, the_sz_Url, the_sz_ActionName, the_sz_AlertTitle, the_sz_AlertMsg){
		
		$('#dialog').dialog({		
			title: the_sz_AlertTitle,
			autoOpen: true,
			modal: true,
			width: 350,
			position: 'center',
			buttons: [{	text: 'Yes',
			           	'class': 'btn btn-primary',
			            click: function() {
  
							$.post(the_sz_Url, { 'id': the_i_Id, 'act': the_sz_ActionName, 'format': 'json' }, function(a_Data) {
							
								if (a_Data.sz_ResultMsg){
									
									var a_AlertData = { 'msg' : a_Data.sz_ResultMsg };			
										
									GLOBAL.v_fAlertDialog(a_AlertData);
										
								} else {
										
									window.location = a_Data.sz_Url;
										
								}
								
							}, 'json');
							
								$('#dialog').dialog('close');
							}
			          },
			          {
			              text: 'No',
			              'class': 'btn btn-default',
			              click: function() {

			            	  $('#dialog').dialog('close');
			            	  
			              }
			          }],
		}).html('<span>' + the_sz_AlertMsg + '</span>');	
	},
	
	/**
	 * Filter action when search button is clicked
	 * @author DungNT
	 * @since 18/12/2013
	 * @param string the_sz_SearchBtnId
	 * @param array the_a_ElementIds
	 */
	v_fFilterAction : function(the_sz_SearchBtnId, the_a_ElementIds){
		
		var sz_RedirectUrl = $('#' + the_sz_SearchBtnId).attr('sz_Url');
		
		$.each(the_a_ElementIds, function( i_Key, sz_Field ) {
		
			var sz_Value = $('#' + sz_Field).val();
			
			if(sz_Value){
				
				sz_RedirectUrl += sz_Field + '/' + sz_Value + '/';
				
			}		
		});
		window.location = sz_RedirectUrl; 		
	},
	
	/**
	 * Reset action when reset button is clicked
	 * @author DungNT
	 * @since 24/12/2013
	 * @param string the_sz_FormId
	 */
	v_fResetAction : function(the_sz_FormId){
		
		$('#' + the_sz_FormId + ' input').val('');
		
		$('#' + the_sz_FormId + ' select')[0].selectedIndex = 0;
		
		$('#' + the_sz_FormId + ' button.btn-primary').click();
		
	},
	
	/**
	 * Get list of ids from check box list view
	 * @author DungNT
	 * @since 19/12/2013
	 * @param string the_sz_AlertSelectMsg
	 * @return array
	 */
	a_fGetCheckListIds : function(the_sz_AlertSelectMsg){
		
		var a_IdsList = [];
		
	    $.each($('.check-box-ids:checked'), function() {
	    
	    	a_IdsList.push($(this).val()); 
	    
	    });
	    
		if( $('.check-box-ids:checked').length )
		{
			return a_IdsList;
			
		} else {
			
			var a_AlertData = { 'msg' : the_sz_AlertSelectMsg };								
			
			GLOBAL.v_fAlertDialog(a_AlertData);
			
			return false;
		}
	},
		
	/**
	 * Confirm delete multi records
	 * @author DungNT
	 * @since 19/12/2013
	 * @param string the_sz_Url
	 * @param string the_sz_ActionName
	 * @param string the_sz_AlertTitle
	 * @param string the_sz_AlertMsg
	 * @param string the_sz_AlertSelectMsg
	 * @return void
	 */
	v_fConfirmMultiDelete : function(the_sz_Url, the_sz_ActionName, the_sz_AlertTitle, the_sz_AlertMsg, the_sz_AlertSelectMsg){
		
		var a_IdsList = COMMON.a_fGetCheckListIds(the_sz_AlertSelectMsg);
		
		if( !a_IdsList ) return false;
		
		$('#dialog').dialog({			
			title: the_sz_AlertTitle,
			autoOpen: true,
			modal: true,
			width: 400,
			position: 'center',
			buttons: {			
				'Yes': function() {
					
					$.post(the_sz_Url + '/multidelete/', { 'a_IdsList': a_IdsList, 'act': the_sz_ActionName, 'format': 'json' }, function(a_Data) {
						
						if (a_Data.sz_ResultMsg){
						
							var a_AlertData = { 'msg' : a_Data.sz_ResultMsg };								
							
							GLOBAL.v_fAlertDialog(a_AlertData);
						
						} else {
						
							window.location = a_Data.sz_Url;
						
						}
						
					}, 'json');
				
					$('#dialog').dialog('close');
				
				},			
				'No': function() {
				
					$('#dialog').dialog('close');			
				}			
			}	
		}).html('<span>' + the_sz_AlertMsg + '</span>');	
	},

	/**
	 * Get label text
	 * @author DungNT
	 * @since 16/04/2014
	 * @param object the_o_Element
	 */
	sz_fGetLabelText : function(the_o_Element) {
		
		return $('#' + the_o_Element.attr('id') + '-label label').text().replace(' *', '');

	},
	
	/**
	 * Validate element with check required and max, min length
	 * @author DungNT
	 * @since 16/04/2014
	 * @param string the_sz_ElementId
	 * @param int the_i_Minlength
	 * @param int the_i_Maxlength
	 * @return bool
	 */
	b_fValidateElement : function(the_sz_ElementId, the_i_Minlength, the_i_Maxlength) {
		
		var o_Element = $('#' + the_sz_ElementId);
		
		// Validate input required
		if(the_i_Minlength > 0) {
			
			var b_IsRequired = COMMON.b_fValidateRequired(o_Element);

			if(!b_IsRequired)
				return false;

		}
		// Validate input max and min length
		var b_ValidateLength = COMMON.b_fValidateLength(o_Element, the_i_Minlength, the_i_Maxlength);
		
		if(!b_ValidateLength)
			return false;
		else
			return true;
	},
	
	/**
	 * Check value is empty or not
	 * @author DungNT
	 * @since 16/04/2014
	 * @param object the_o_Element
	 * @return bool
	 */
	b_fValidateRequired : function(the_o_Element) {

		var b_IsEmpty = $.trim(the_o_Element.val()) == '' ? true : false; 
		
		var sz_WarningMsg =  COMMON.sz_fGetLabelText(the_o_Element) + ' ' + $('#requiredMsg').val();
		
		if(b_IsEmpty) {
			
			return COMMON.b_fFromWaringMsg(the_o_Element, sz_WarningMsg, false);

		} else {
			
			return COMMON.b_fFromWaringMsg(the_o_Element, sz_WarningMsg, true);
		}
	},
	
	/**
	 * Validate min length or max length
	 * @author DungNT
	 * @since 16/04/2014
	 * @param object the_o_Element
	 * @param int the_i_Minlength
	 * @param int the_i_Maxlength
	 * @return bool
	 */
	b_fValidateLength : function(the_o_Element, the_i_Minlength, the_i_Maxlength) {
		var sz_WarningMsg = '';
		// Compare maxlength
		if(the_i_Maxlength > 0 && the_o_Element.val().length > the_i_Maxlength) {
			sz_WarningMsg += COMMON.sz_fGetLabelText(the_o_Element) + ' ' + $('#maxlengthMsg').val() + ' ' + the_i_Maxlength;
		}		
		// Compare minlength
		if(the_i_Minlength > 0 && the_o_Element.val().length < the_i_Minlength) {
			sz_WarningMsg += COMMON.sz_fGetLabelText(the_o_Element) + ' ' + $('#minlengthMsg').val() + ' ' + the_i_Minlength;
		}
		
		if(sz_WarningMsg != '') {
			
			return COMMON.b_fFromWaringMsg(the_o_Element, sz_WarningMsg, false);

		} else {
			
			return COMMON.b_fFromWaringMsg(the_o_Element, sz_WarningMsg, true);
		}

	},
	
	/**
	 * Validate email address
	 * @author DungNT
	 * @since 16/04/2014
	 * @param string the_sz_ElementId
	 * @return bool
	 */
	b_fValidateEmail : function(the_sz_ElementId) {

		var o_Element = $('#' + the_sz_ElementId);
		
		var sz_WarningMsg = COMMON.sz_fGetLabelText(o_Element) + ' ' + $('#invalidMsg').val();
		
		var o_Pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		
		if( !o_Pattern.test(o_Element.val()) ) {
			
			return COMMON.b_fFromWaringMsg(o_Element, sz_WarningMsg, false);

		} else {
			
			return COMMON.b_fFromWaringMsg(o_Element, sz_WarningMsg, true);
		}
		
	},
	
	/**
	 * Validate user password
	 * @author DungNT
	 * @since 16/04/2014
	 * @param string the_sz_PwdId1
	 * @param string the_sz_PwdId2
	 * @return bool
	 */
	b_fValidatePassword : function(the_sz_PwdId1, the_sz_PwdId2) {

		var o_Pwd1 = $('#' + the_sz_PwdId1), o_Pwd2 = $('#' + the_sz_PwdId2);
		
		var sz_WarningMsg = COMMON.sz_fGetLabelText(o_Pwd1) + ' + ' + COMMON.sz_fGetLabelText(o_Pwd2) + ' ' + $('#invalidMsg').val();
		
		if( $.trim(o_Pwd1.val()) != $.trim(o_Pwd2.val()) ) {
			
			return COMMON.b_fFromWaringMsg(o_Pwd2, sz_WarningMsg, false);

		} else {
			
			return COMMON.b_fFromWaringMsg(o_Pwd2, sz_WarningMsg, true);
		}
		
	},
	
	/**
	 * Append warning message after element
	 * @author DungNT
	 * @since 16/04/2014
	 * @param object the_o_Element
	 * @param string the_sz_Msg
	 * @param bool the_b_Result
	 * @return bool
	 */
	b_fFromWaringMsg : function(the_o_Element, the_sz_Msg, the_b_Result) {

		var sz_WarningId = the_o_Element.attr('id') + '-alert-warning';
		
		if($('#' + sz_WarningId).length) {

			if(the_b_Result) {
				
				$('#' + sz_WarningId).remove();

				return true;
				
			} else {

				$('#' + sz_WarningId).text(the_sz_Msg);
				
				the_o_Element.focus();
			}
			
		} else {

			if(the_b_Result) {
				
				return true;
			
			}
			
			var sz_MsgBlock = '<div id="' + sz_WarningId + '" class="alert alert-warning col-xs-12 col-md-8">' + the_sz_Msg + '</div>'
			
			the_o_Element.parent().parent().append(sz_MsgBlock);
			
			the_o_Element.focus();
		}
		
		return false;
	},
};

// PASSWORD INPUT

$(document).ready(function () {
	$("#password").val("************");
	$("#password").click(function () {
    	$(this).val('');
    });
});

// END -----------------------------------


// 2 - START LOGIN PAGE SHOW HIDE BETWEEN LOGIN AND FORGOT PASSWORD BOXES--------------------------------------

$(document).ready(function () {
	$("#forgot-pwd").click(function () {
	$("#loginbox").hide();
	$("#forgotbox").show();
	return false;
	});

});

$(document).ready(function () {
	$("#back-login").click(function () {
	$("#loginbox").show();
	$("#forgotbox").hide();
	return false;
	});
});

// END ----------------------------- 2



// 3 - MESSAGE BOX FADING SCRIPTS ---------------------------------------------------------------------

$(document).ready(function() {
	$(".close-yellow").click(function () {
		$("#message-yellow").fadeOut("slow");
	});
	$(".close-red").click(function () {
		$("#message-red").fadeOut("slow");
	});
	$(".close-blue").click(function () {
		$("#message-blue").fadeOut("slow");
	});
	$(".close-green").click(function () {
		$("#message-green").fadeOut("slow");
	});
});

// END ----------------------------- 3

// 6 - DYNAMIC YEAR STAMP FOR FOOTER -----------------------------------------------------------------------

 $('#spanYear').html(new Date().getFullYear()); 
 
// END -----------------------------  6 
  
