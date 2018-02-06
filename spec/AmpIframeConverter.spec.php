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
            $this->_tag = '<iframe title="exemple 1 avec iframe" src="https://mdn-samples.mozilla.org/snippets/html/iframe-simple-contents.html" width="100%" height="300"><p>Your browser does not support iframes.</p></iframe>';
            $this->_tagBis = '<iframe title="exemple 1 avec iframe" src="https://mdn-samples.mozilla.org/snippets/html/iframe-simple-contents.html" width="" height="300"><p>Your browser does not support iframes.</p></iframe>';
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert($this->_tag))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tag))->toBe('<amp-iframe src="https://mdn-samples.mozilla.org/snippets/html/iframe-simple-contents.html" width="500" height="300" layout="responsive" sandbox="allow-scripts allow-same-origin"></amp-iframe>');
            });
            it("delete empty attributes", function() {
                expect($this->_amp->convert($this->_tagBis))->toBe('<amp-iframe src="https://mdn-samples.mozilla.org/snippets/html/iframe-simple-contents.html" width="500" height="300" layout="responsive" sandbox="allow-scripts allow-same-origin"></amp-iframe>');
            });
        });
    });
});
