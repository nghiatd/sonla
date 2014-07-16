var USER = {
		/**
		 * Check user name is existed or not
		 * 
		 * @author DungNT
		 * @since 14/12/2013
		 * @param string
		 *            the_sz_UserName
		 */
		v_fCheckUserName : function(the_sz_UserName){
			if(the_sz_UserName == ''){
				if($('#userNameErr').html()){
					$('#userNameErr').remove();
				}
				return false;
			}
			$.post('/admin/user/checkusername', { 'user_name': the_sz_UserName, 'format': 'json' }, function(data) {
				if (data.sz_ResultMsg){
					COMMON.b_fFromWaringMsg($('#name'), data.sz_ResultMsg, false);
				} else {
					COMMON.b_fFromWaringMsg($('#name'), '', true);
				}
			}, 'json');
		},
				
};

$(document).ready(function () {
	
	$('#submitLogin').click(function(){
		var hasError = false;
		var message = '';
			
		if ( $('#loginname').val() == '' && $('#loginpassword').val() == '' ) {
			message = $('#user-pass-required').val();
			hasError = true;
		} else if ( $('#loginname').val() == '' ) {
			message = $('#user-required').val();
			hasError = true;
		} else if ( $('#loginpassword').val() == '' ) {
			message = $('#pass-required').val();
			hasError = true;
		}
		if ( hasError ) {
			var options = {};
			$('#loginbox').effect('shake',options,50);
				
			$('#login-error').html('<div id=\'warning-message\' class=\'alert alert-warning\'>' + message + '</div>');
			return false;
		}

		// Merge the challenge string with the password
		var challenge = sha256( $('#challenge-text').val() + sha256($('#loginpassword').val()) );

		// Put the value inside the challenge field
		$('#loginchallenge').val(challenge);

		// Clean the pass field
		$('#loginpassword').val('');
	});
	
	$('#submitUser').click(function(){
		// Validate user name
		var b_ValidateName = COMMON.b_fValidateElement('name', 5, 150);
		
		if(!b_ValidateName)
			return false;
		
		// Validate user email
		var b_ValidateEmail = COMMON.b_fValidateElement('email', 1, 100);
		if(!b_ValidateEmail)
			return false;
		
		// Validate user email format
		var b_ValidateEmailFormat = COMMON.b_fValidateEmail('email');
		if(!b_ValidateEmailFormat)
			return false;
		
		// Validate user password
		var b_ValidatePassword = COMMON.b_fValidateElement('password', 6, 0);
		if(!b_ValidatePassword)
			return false;
		
		// Validate user password 2
		var b_ValidatePassword2 = COMMON.b_fValidateElement('password2', 6, 0);
		if(!b_ValidatePassword2)
			return false;
		
		// Matching password
		var b_MatchPassword = COMMON.b_fValidatePassword('password', 'password2');
		if(!b_MatchPassword)
			return false;
		
		return true;
	});
});