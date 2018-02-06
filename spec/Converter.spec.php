<?php

require __DIR__.'./../vendor/autoload.php';

use Elephantly\AmpConverterBundle\Converter\AmpConverter;
use Elephantly\AmpConverterBundle\Cleaner\AmpTagCleaner;
use Elephantly\AmpConverterBundle\spec\TestConfig;


/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
describe("Converter", function() {
    context("Regular", function() {
        beforeAll(function() {
            $this->_amp = new AmpConverter(TestConfig::$converters, TestConfig::$options, new AmpTagCleaner(TestConfig::$options));
        });
        describe("convert()", function() {
            it("converts empty as string", function() {
                expect($this->_amp->convert(''))->toBeA('string');
            });
        });
    });
});
