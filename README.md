# AmpConverter Bundle
[![Packagist](https://img.shields.io/packagist/v/elephantly/amp-converter-bundle.svg?style=flat-square)](https://packagist.org/packages/elephantly/amp-converter-bundle)
![PHP](https://img.shields.io/badge/PHP-%3E%3D5.3.0-brightgreen.svg?style=flat-square)
![Symfony2](https://img.shields.io/badge/Symfony2-%3E2.7-brightgreen.svg?style=flat-square)
[![Packagist](https://img.shields.io/packagist/dt/elephantly/amp-converter-bundle.svg?style=flat-square)](https://packagist.org/packages/elephantly/amp-converter-bundle)
[![Packagist](https://img.shields.io/packagist/l/elephantly/amp-converter-bundle.svg?style=flat-square)](https://packagist.org/packages/elephantly/amp-converter-bundle)
[![Travis](https://img.shields.io/travis/elephantly/AmpConverterBundle.svg?style=flat-square)](https://travis-ci.org/elephantly/AmpConverterBundle)
[![Code Climate](https://img.shields.io/codeclimate/github/elephantly/AmpConverterBundle.svg?style=flat-square)](https://codeclimate.com/github/elephantly/AmpConverterBundle)
[![Code Climate](https://img.shields.io/codeclimate/coverage/github/elephantly/AmpConverterBundle.svg?style=flat-square)](https://codeclimate.com/github/elephantly/AmpConverterBundle)

## Features

Basic features list:

 * Convert Classic Html to AmpHtml
 * Get The list of needed scripts for AmpHtml


Supported Elements:

 * amp-iframe
 * amp-audio
 * amp-brightcove
 * amp-dailymotion
 * amp-image
 * amp-video
 * amp-vimeo
 * amp-youtube
 * amp-facebook
 * amp-instagram
 * amp-pinterest
 * amp-twitter

 Tested Elements:

 - [ ] amp-iframe
 - [ ] amp-audio
 - [ ] amp-brightcove
 - [x] amp-dailymotion
 - [x] amp-image
 - [ ] amp-video
 - [ ] amp-vimeo
 - [ ] amp-youtube
 - [ ] amp-facebook
 - [ ] amp-instagram
 - [ ] amp-pinterest
 - [x] amp-twitter

## Install

Install with composer :
```shell
composer require elephantly/amp-converter-bundle
```
Then in your *AppKernel.php* file add:
```php
new Elephantly\AmpConverterBundle\ElephantlyAmpConverterBundle(),
```
Finally, just use the service to access functions:
```php
$converter  = $this->get('elephantly.amp_converter');
$ampHtml    = $converter->convert($html);
$ampScripts = $converter->getAmpScripts($html);
```
And you're done


## Pull Requests:

Pull requests are very welcome :D
Pleas do not hesitate to tell us if you wnat a feature, see any issue, or just want to discuss the future of the bundle...

## Todo

 - [ ] Complete Contributing guide
 - [ ] Test all Elements
 - [ ] Create Empty Converter to clone

### Stuff used to make this:

 * [PHP](http://php.net/) >= 5.3.0
 * [marc1706/fast-image-size](https://github.com/marc1706/fast-image-size)
 * [symfony/css-selector](https://github.com/symfony/css-selector)
 * [kriswallsmith/buzz](https://github.com/kriswallsmith/Buzz)
 * [symfony/framework-bundle](https://github.com/symfony/framework-bundle)
