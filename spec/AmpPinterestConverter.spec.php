<?php

require __DIR__.'./../vendor/autoload.php';

use Elephantly\AmpConverterBundle\Converter\AmpConverter;
use Elephantly\AmpConverterBundle\spec\TestConfig;
use Elephantly\AmpConverterBundle\Cleaner\AmpTagCleaner;


/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
describe("Converter", function() {
    context("Regular", function() {
        beforeAll(function() {
            $this->_amp = new AmpConverter(TestConfig::$converters, TestConfig::$options, new AmpTagCleaner(TestConfig::$options));
            $this->_tag = '<a data-pin-do="embedPin" href="https://www.pinterest.com/pin/345018021446184758/"></a>';
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert($this->_tag))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tag))->toBe('<amp-pinterest data-do="embedPin" width="236" height="380" data-url="https://www.pinterest.com/pin/345018021446184758/"></amp-pinterest>');
            });
        });
    });
});
