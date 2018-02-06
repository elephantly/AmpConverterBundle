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
        describe("Removes incorrect tags", function() {
            it("removes onclick", function() {
                expect($this->_amp->convert('<a href="https://www.amazon.fr" onclick="window.open(this.href); return false;">Amazon</a>'))
                    ->toBe('<a href="https://www.amazon.fr" >Amazon</a>');
            });
            it("Removes shape attribute", function() {
                expect($this->_amp->convert('<a href="http://www.example.fr/" shape="rect"></a>'))
                    ->toBe('<a href="http://www.example.fr/"></a>');
            });
            it("Removes type from p", function() {
                expect($this->_amp->convert('<p type="question">Lorem ipsum</p>'))
                    ->toBe('<p>Lorem ipsum</p>');
            });
        });
    });
});
