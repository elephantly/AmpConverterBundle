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
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">'))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="800" height="965"></amp-img>');
            });
            it("converts to null if src is null", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Gopouetlde33443.jpg">'))->toBeA('string');
            });
            it("converts to valid amp sized", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" width="125" height="96">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" width="125" height="96" layout="responsive"></amp-img>');
            });
            it("converts to valid amp sized", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="500">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="800" height="965"></amp-img>');
            });
            it("converts to valid amp sized", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="625" height="auto">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="800" height="965"></amp-img>');
            });
            it("converts to valid amp sized", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="625rem" height="480">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="800" height="965"></amp-img>');
            });
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Cardi-puppy-head.gif">'))->toBe('<amp-anim src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Cardi-puppy-head.gif" layout="responsive" width="45" height="45"></amp-anim>');
            });
            it("removes attributes if empty", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Cardi-puppy-head.gif" height="">'))->toBe('<amp-anim src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Cardi-puppy-head.gif" height="45" layout="responsive" width="45"></amp-anim>');
            });
        });
    });
});
