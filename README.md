# PHCurryDI - A dependency injection mechanism inspired by Curry

Example:

```php

$dependencies = array(
    'emailSender'=>function($to, $subject, $body) { ... },
    'hashPassword'=>funuction($password) { return md5($password); }
);

$registerUser = function($hashPassword, $emailSender, $name, $emailAddr) {};

call_user_func(
    phcurrydi($registerUser, $dependencies),
    'Jack Smith',
    'jack@smiths.com'
);

```
