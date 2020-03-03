![Engraving](https://raw.githubusercontent.com/engraving/skeleton/master/public/favicon.png)

# Engraving Skeleton Project

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Skeleton Project with the Engraving Framework.

## Disclaimer

Should you use this package? Probably not. This package is purely educational, and there are more mature alternatives out there.

## Some interesting sources of inspiration

- [Shrink Your Framework](https://speakerdeck.com/belanur/liebling-ich-habe-das-framework-geschrumpft-at-code-dot-talks-2015)
- [No Framework Tutorial](https://github.com/PatrickLouys/no-framework-tutorial)

## Create new Project

Via Composer

``` bash
$ docker run -v $PWD/your-project-name:/app --rm -it composer:latest create-project engraving/skeleton . dev-master
```

## Install dependencies

Via Composer

``` bash
$ docker run -v $PWD:/app --rm -it composer:latest composer install
```

## Run

To run the project, just use `docker-compose`.

``` bash
$ docker-compose up
```

## Profiling

You can either use spx or blackfire for profiling your application.

### SPX

The `php` container ships with the [spx extension](https://github.com/NoiseByNorthwest/php-spx) preinstalled.

You can use spx by opening `http://localhost:8080/_spx?SPX_KEY=dev` in your browser and tick `Enabled`.

### Xdebug

The `xdebug` extension in preinstalled. To use breakpoints you may have to configure a path mapping in your ide to the directory `/app/`.

### Blackfire

To use blackfire, you have to add an extra blackfire container to the `docker-compose.yml`.

``` yaml
  blackfire:
    image: blackfire/blackfire
    environment:
      BLACKFIRE_SERVER_ID: ${BLACKFIRE_SERVER_ID}
      BLACKFIRE_SERVER_TOKEN: ${BLACKFIRE_SERVER_TOKEN}
```

Also you have to remove the spx part from the dockerfile and replace it with the following instructions.

``` dockerfile
# Install Blackfire
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
 && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
 && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
 && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so
ADD ./docker/php-blackfire.ini $PHP_INI_DIR/conf.d/blackfire.ini
```

Just set the environment variables `BLACKFIRE_CLIENT_ID`, `BLACKFIRE_CLIENT_TOKEN`, `BLACKFIRE_SERVER_ID` and `BLACKFIRE_SERVER_TOKEN`.

``` bash
$ export BLACKFIRE_CLIENT_ID="YOUR_CLIENT_ID"
$ export BLACKFIRE_CLIENT_TOKEN="YOUR_CLIENT_TOKEN"
$ export BLACKFIRE_SERVER_ID="YOUR_SERVER_ID"
$ export BLACKFIRE_SERVER_TOKEN="YOUR_SERVER_TOKEN"
```

## Changelog

Please see the [changelog](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email `maikhilker89@gmail.com` instead of using the issue tracker.

## License

The MIT License (MIT). Please see the [license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/engraving/skeleton.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/engraving/skeleton/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/engraving/skeleton.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/engraving/skeleton.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/engraving/skeleton.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/engraving/skeleton
[link-travis]: https://travis-ci.org/engraving/skeleton
[link-scrutinizer]: https://scrutinizer-ci.com/g/engraving/skeleton/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/engraving/skeleton
[link-downloads]: https://packagist.org/packages/engraving/skeleton
