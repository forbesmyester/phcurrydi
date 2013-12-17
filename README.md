# PHCurryDI - A dependency injection mechanism inspired by Curry

Example:

```php

<?php

require_once 'phcurrydi.php';

$dependencies = array(
    'emailSender'=>function($to, $subject, $body) {
    	// Would actually send a real email if a real implementation
    	echo "= Email =================\n";
    	echo "To: $to \nSubject: $subject \n\n$body\n";
    	echo "=========================\n\n";
    },
    'hashPassword'=>function($password) {
    	// Salt should be changed!
    	return crypt($password, 'better salt required');
    },
    'storeInDatabase'=>function($name, $emailAddr, $md5Password) {
    	// Would really write to database... using better techniques if it was
    	// a real implementation.
    	echo "= Database Insertion ====\n";
    	echo sprintf(
    		"INSERT INTO USERS " .
    			"(name, email, md5_password) VALUES " .
    			"(%s, %s, %s);\n",
    		"'" . mysql_escape_string($name) . "'",
    		"'" . mysql_escape_string($emailAddr) . "'",
    		"'" . mysql_escape_string($md5Password) . "'"
		);
    	echo "=========================\n\n";
		// Would be an Id if a real implementation
		return time();
    }
);                                          

$registerUser = function($hashPassword, $emailSender, $storeInDatabase, $name, $emailAddr, $plainPassword) {
	$id = $storeInDatabase($name, $emailAddr, $hashPassword($plainPassword));
	$emailSender(
		$emailAddr,
		"PHPCurryDI Account Pending Activation",
		"Hi $name,\n\nThank you for signing up to PHPCurryDI.\n\n" .
			"To complete your registration please click on the link below.\n\n".
			"[Activate Account](http://https://github.com/forbesmyester/phcurrydi)"
	);
	return $id;
};

call_user_func(
    phcurrydi($registerUser, $dependencies),
    'Jack Smith',
    'jack@smiths.com',
    'password is password'
);

```
