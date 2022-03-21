## Orbit Git Integration

[![Packagist License](https://poser.pugx.org/Jubeki/orbit-git/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/Jubeki/orbit-git/version.png)](https://packagist.org/packages/jubeki/orbit-git)
<!-- ![Tests](https://github.com/Jubeki/orbit/workflows/Tests/badge.svg) -->

## Installation

Require this package with composer.

```shell
composer require jubeki/orbit-git
```

The service provider will be automatically registered using [package discovery](https://laravel.com/docs/5.8/packages#package-discovery).

If you don't use auto-discovery you should add the service provider to the providers array in `config/app.php`.

```php
// existing providers...
Jubeki\OrbitGit\OrbitGitServiceProvider::class,
```

## Customisation

### Customising the author name and email
By default, Orbit will use the system's name and email address when making commits to your repository. If you wish to change the name, use the `ORBIT_GIT_NAME` and `ORBIT_GIT_EMAIL` environment variables.

If you would like to use a more dynamic name and email address, you can use the `OrbitGit::resolveNameUsing` and `Orbit::resolveEmailUsing` methods instead:

```php
use Jubeki\OrbitGit\Facades\OrbitGit;

public function boot()
{
    OrbitGit::resolveNameUsing(function () {
        return Auth::user()->name;
    });

    OrbitGit::resolveEmailUsing(function () {
        return Auth::user()->email;
    });
}
```

### Customizing the commit message

The default is `[AUTO] {event} {model} {primary_key}`. You can also change the commit message with the `OrbitGit::resolveMessageUsing` method.

```php
use Jubeki\OrbitGit\Facades\OrbitGit;

public function boot()
{
    OrbitGit::resolveMessageUsing(function ($event) {
        return (string) Str::of(config('orbit-git.message_template'))
                ->replace('{event}', $this->getTypeOfEvent($event))
                ->replace('{model}', class_basename($event->model))
                ->replace('{primary_key}', $event->model->getKey());
    });
}
```

You can also overwrite messages for specific events which has a higher priority than the default `OrbitGit::resolveMessageUsing` method:

```php
use Jubeki\OrbitGit\Facades\OrbitGit;

public function boot()
{
    OrbitGit::resolveCreatedMessageUsing(function ($event) {
        return '...',
    });

    OrbitGit::resolveDeletedMessageUsing(function ($event) {
        return '...',
    });

    OrbitGit::resolveForceDeletedMessageUsing(function ($event) {
        return '...',
    });

    OrbitGit::resolveUpdatedMessageUsing(function ($event) {
        return '...',
    });
}
```

### Deploy with Laravel Forge

You can add the following to the top of your deployment script to skip the deployment from commits made using Orbit on the production system.

```bash
if [[ $FORGE_DEPLOY_MESSAGE =~ ^\[AUTO\](.*)$ ]]; then
    echo "AUTOMATED COMMIT FROM THE SERVER DO NOT DEPLOY!!!"
    exit 0
fi
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](./.github/CONTRIBUTING.md) for details.

## Credits

- [Julius Kiekbusch](https://github.com/Jubeki)
- [Ryan Chandler](http://github.com/ryangjchandler) (Implemented Orbit and the original Git Integration)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
