<?php 

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use DOMNode;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpImgConverter implements AmpTagConverterInterface
{
    public function convertToAmp($element)
    {
        $ampElement = $element->ownerDocument->createElement($this->getAmpTagName());
        $ampElement->setAttribute('src', $element->getAttribute('src'));
        return $ampElement;
    }
    
    public function getTagName()
    {
        return 'img';
    }

    public function getAmpTagName()
    {
        return 'amp-img';
    }

    
}
