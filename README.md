## Installation
Add l4-confirm-action to you composer.json file:
```
"require": {
	"agelxnash/l4-confirm-action": "dev-master"
}
```
Now, run a composer update on the command line from the root of your project:
```
composer update
```

### Registering the Package
Add the L4ConfirmAction Service Provider to your config in ```app/config/app.php```:
```php
'providers' => array(
	'AgelxNash\L4ConfirmAction\ConfirmServiceProvider'
),
```
If you use a [Package Installer](https://github.com/rtablada/package-installer), you can run ```php artisan package:install agelxnash/l4-confirm-action```

### Publish the config
Run this on the command line from the root of your project: ```php artisan config:publish agelxnash/l4-confirm-action``` This will publish L4ConfirmAction's config to ```app/config/packages/agelxnash/l4-confim-action/```

You may also want to change the ``'classname'`` value if you want change action logic.

### Migration
Now migrate the database tables for L4ConfirmAction. Run these on the command line from the root of your project: ```php artisan migrate --package="agelxnash/l4-confirm-action"```

_You must be have **InnoDB table users with unsigned id field**_

## Usage
Sending confirmation email action to replace:
```php
$userObj = Auth::user();
$newMail = 'test@example.com';

$newHash = ConfirmUserAction::createHash($userObj->id, 'newMail', $newMail);
\Mail::send('emails.newMail', array(
	'hash' => $newHash
    'userObj' => $userObj->id
), function($message) use ($obj, $newMail){
	$message->from(Config::get('mail.from.address'))
		->to($newMail)
        ->subject('Confirmation email change');
});

\Mail::send('emails.oldMail', array(
	'hash' => CChop\Helpers\User::confirum($userObj->id, 'oldMail', $userObj->email),
    'userObj' => $userObj,
    'newMail' => $newMail
), function($message) use ($userObj){
	$message->from(Config::get('mail.from.address'))
		->to($userObj->email)
        ->subject('Notice of the request for a change of your email');
    }
);
```
**emails.newMail** blade
```php
Change e-mail: {{ URL::route('confirum', compact('hash')) }}
```

**emails.oldMail** blade
```php
Cancels the request to change email: {{ URL::route('confirum', compact('hash')) }}
To confirm the change, open a link from a letter sent by mail: {{ $newMail }}
```

