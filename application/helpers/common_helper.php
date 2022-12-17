<?php 
 function token_get(){
    $tokenData = array();
    $tokenData['id'] = mt_rand(10000,99999); //TODO: Replace with data for token
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    return $output['token'];
}
function get_session_name($user_type='')
    {
		switch ($user_type) {
		    case "superadmin":
		       	return "eg_tech_superadmin_logged_in";
		        break;
		    default:
		        return "eg_tech_superadmin_logged_in";
		}
    }

	function check_validation($name_1 ='',$content_1='',$name='',$content='')
	{
		$result = array();
		if (!empty($name[0]) && !empty($rangefrom[0])) {
				foreach ($name as $name_key => $name_row) {
					$custom_key = $name_key+1;
					if (empty($name_row)) {
						$result[$name_1.'_'.$custom_key]='Required';
					}
					// is_numeric($name_row)
			
					if (empty($content[$name_key])) {
						$result[$content_1.'_'.$custom_key]='Required';
					}
					
				}
		} else {
				if (empty($name[0])) {
					$result[$name_1.'_1']='Required';
				}
				if (empty($content[0])) {
					$result[$content_1.'_1']='Required';
				}
				
		}
		return $result;
	}

