<?php
/***********************************************
DAVE PHP API
https://github.com/evantahler/PHP-DAVE-API
Evan Tahler | 2011

I am an example function to view a user.
If "this" user is viewing (indicated by propper password hash along with another key, all data is shown), otherwise, just basic info is returned
***********************************************/
if ($ERROR == 100)
{	
	list($msg, $ReturnedUsers) = _VIEW("users",array(
		"UserID" => $PARAMS['UserID'],
		"ScreenName" => $PARAMS['ScreenName'],
		"EMail" => $PARAMS['EMail'],
	));
	if ($msg == false)
	{
		$ERROR = $ReturnedUsers;
	}
	elseif(count($ReturnedUsers) == 1)
	{
		if(!empty($PARAMS["PasswordHash"]) || !empty($PARAMS["Password"]))
		{
			$OUTPUT["User"]['InformationType'] = "Private";
			$AuthResp = AuthenticateUser();
			if ($AuthResp[0] !== true)
			{
				$ERROR = $AuthResp[1];
			}
			else
			{
				foreach( $ReturnedUsers[0] as $key => $val)
				{
					$OUTPUT["User"][$key] = $val;
				}
			}
		}
		else // Public Data Request
		{
			$OUTPUT["User"]['InformationType'] = "Public";
			$OUTPUT["User"]['ScreenName'] = $ReturnedUsers[0]['ScreenName'];
			$OUTPUT["User"]['Joined'] = $ReturnedUsers[0]['Joined'];
		}
	}
	else
	{
		$ERROR = "User cannot be found";
	}
}


?>