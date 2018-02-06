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
            $this->_tag = '<iframe width="560" height="315" src="https://www.youtube.com/watch?v=N1w-hDiJ4dM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            $this->_tagBis = '<iframe width="560" height="315" src="https://www.youtube.com/embed/N1w-hDiJ4dM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert($this->_tag))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tag))->toBe('<amp-youtube width="560" height="315" data-videoid="N1w-hDiJ4dM"></amp-youtube>');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tagBis))->toBe('<amp-youtube width="560" height="315" data-videoid="N1w-hDiJ4dM"></amp-youtube>');
            });
        });
    });
});
