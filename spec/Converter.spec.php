<?php 

require __DIR__.'./../vendor/autoload.php';

use Elephantly\AmpConverterBundle\Converter\AmpConverter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
describe("Converter", function() {
    context("Regular", function() {
        beforeAll(function() {
            $this->_amp = new AmpConverter();
        });
        describe("convert()", function() {
            it("converts empty as string", function() {
                expect($this->_amp->convert(''))->toBeA('string');
            });
        });
    });
});