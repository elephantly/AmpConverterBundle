<?php 

require __DIR__.'./../vendor/autoload.php';

use Elephantly\AmpConverterBundle\Converter\AmpConverter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
describe("Converter", function() {
    context("Regular", function() {
        beforeAll(function() {
            $this->_amp = new AmpConverter(array('img' => 'Elephantly\AmpConverterBundle\Converter\Media\AmpImgConverter'));
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">'))->toBeA('string');
            });
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" layout="responsive" width="800" height="965"></amp-img>');
            });
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Gopouetlde33443.jpg">'))->toBeA(null);
            });
            it("converts to string", function() {
                expect($this->_amp->convert('<img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" width="125" height="96">'))->toBe('<amp-img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg" width="125" height="96" layout="fixed"></amp-img>');
            });
            // it("converts to string", function() {
            //     expect($this->_amp->convert())->toBe();
            // });
        });
    });
});