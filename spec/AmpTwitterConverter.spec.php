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
            $this->_tag = '<blockquote data-cards="hidden" class="twitter-tweet" data-lang="en"><p lang="en" dir="ltr">Lorraine and I had an amazing time at the <a
    href="https://twitter.com/hashtag/Oscars?src=hash">#Oscars</a>! Congrats to all of the nominees on a job
well-done! <a href="https://t.co/xyrO7kQBzH">pic.twitter.com/xyrO7kQBzH</a></p>&mdash; Andy Serkis (@andyserkis) <a
    href="https://twitter.com/andyserkis/status/704420904437043200">February 29, 2016</a></blockquote><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
        });
        describe("convert()", function() {
            it("converts to string", function() {
                expect($this->_amp->convert($this->_tag))->toBeA('string');
            });
            it("converts to valid amp", function() {
                expect($this->_amp->convert($this->_tag))->toBe('<amp-twitter data-cards="hidden" class="twitter-tweet" data-lang="en" data-tweetid="704420904437043200" layout="responsive" height="223" width="486"></amp-twitter>');
            });
        });
    });
});
