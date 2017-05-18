<?php 

namespace Elephantly\AmpConverterBundle\Converter;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;

class ConverterChain
{
    private $converters;

    public function __construct()
    {
        $this->converters = array();
    }

    public function addConverter(AmpTagConverterInterface $converter)
    {
        $this->converters[$converter->getSelector()] = $converter;
    }
    
    public function getConverters()
    {
        return $this->converters;
    }
}