<?php
	session_start();

	// Example of logging into user account using email and
	// password for incorporating into another web application

	// utilizing WebMail Lite API
	include_once __DIR__.'/../libraries/afterlogic/api.php';

	if (class_exists('CApi') && CApi::IsValid())
	{
		// data for logging into account
		$sEmail = $_SESSION['email'];
		$sPassword = $_SESSION['password'];

		try
		{
			// Getting required API class
			$oApiIntegratorManager = CApi::Manager('integrator');

			// attempting to obtain object for account we're trying to log into
			$oAccount = $oApiIntegratorManager->LoginToAccount($sEmail, $sPassword);
			if ($oAccount)
			{
				// populating session data from the account
				$oApiIntegratorManager->SetAccountAsLoggedIn($oAccount);

				// redirecting to WebMail Lite main page
				CApi::Location('../');
			}
			else
			{
				// login error
				echo $oApiIntegratorManager->GetLastErrorMessage();
			}
		}
		catch (Exception $oException)
		{
			// login error
			echo $oException->getMessage();
		}
	}
	else
	{
		echo 'AfterLogic API isn\'t available kk';
	}