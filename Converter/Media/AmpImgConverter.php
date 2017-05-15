<?php 

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpImgConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    function __construct()
    {
        $this->attributes = array('src', 'srcset', 'sizes', 'alt', 'attribution');
        $this->mandatoryAttributes = array('layout', 'width', 'height');
    }
    
    protected function getDefaultValue($attribute, $element)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'width':
                return $this->getImageInfo($element)['width'];
            case 'height':
                return $this->getImageInfo($element)['height'];
            default:
                return null;
        }
    }
    
    private function getImageInfo($element)
    {   
        // TODO: try and catch error if image not existing
        $imageSizer = new FastImageSize();
        $imageSize = $imageSizer->getImageSize($element->getAttribute('src'));
        return $imageSize;
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
