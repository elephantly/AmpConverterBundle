<?php 

namespace Elephantly\AmpConverterBundle\Converter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
interface AmpTagConverterInterface
{
    function __construct();
    public function convertToAmp($element);
    public function getTagName();
    public function getAmpTagName();
}
