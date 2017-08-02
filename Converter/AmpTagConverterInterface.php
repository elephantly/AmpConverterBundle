<?php

namespace Elephantly\AmpConverterBundle\Converter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
interface AmpTagConverterInterface
{
    public function __construct($options = array());
    public function convertToAmp($element);
    public static function getIdentifier();
    public function hasScriptTag();
    public function getScriptTag();
    public function getSelector();
    public function getAmpTagName();
    public function getDefaultValue($attribute);
    public function callback();
    public function setup();
}
