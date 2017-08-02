<?php

require __DIR__.'./../vendor/autoload.php';

use Elephantly\AmpConverterBundle\Converter\AmpConverter;
use Elephantly\AmpConverterBundle\spec\TestConfig;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
describe("Converter", function() {
    context("Regular", function() {
        beforeAll(function() {
            $this->_amp = new AmpConverter(array('iframe[src*="dailymotion.com"]' => 'Elephantly\AmpConverterBundle\Converter\Media\AmpDailymotionIframeConverter'), TestConfig::$options);
            $this->_tag = '<iframe frameborder="0" width="480" height="270"
src="//www.dailymotion.com/embed/video/xwr14q?autoplay=1&mute=1&syndication=123456"
allowfullscreen></iframe>';
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert($this->_tag))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tag))->toBe('<amp-dailymotion width="480" height="270" data-videoid="xwr14q" autoplay="1" data-mute="1" data-param-syndication="123456"></amp-dailymotion>');
            });
        });
    });
});
