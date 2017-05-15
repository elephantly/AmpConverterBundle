<?php 

namespace Elephantly\AmpConverterBundle\Converter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpTagConverter
{
    protected $attributes = array();

    protected $mandatoryAttributes = array();
    
    protected $element = null;

    public function getAmpCommonAttributes()
    {
        return array('fallback', 'heights', 'layout', 'media', 'noloading', 'on', 'placeholder', 'sizes', 'width', 'height');
    }
    
    public function convertToAmp($element)
    {
        $this->element = $element;
        
        $ampElement = $element->ownerDocument->createElement($this->getAmpTagName());
        foreach ($this->getAmpAttributes() as $attribute) {
            if ($element->hasAttribute($attribute)) {
                $ampElement->setAttribute($attribute, $element->getAttribute($attribute));
            }
        }
        foreach ($this->getMandatoryAttributes() as $mandatoryAttribute) {
            if (!$ampElement->hasAttribute($mandatoryAttribute)) {
                $ampElement->setAttribute($mandatoryAttribute, $this->getDefaultValue($mandatoryAttribute, $element));
            }
        }
        // TODO: add a general callback for fixed images
        return $ampElement;
    }

    public function getAmpAttributes()
    {
        return array_merge($this->attributes, $this->getAmpCommonAttributes());
    }

    public function getMandatoryAttributes()
    {
        return $this->mandatoryAttributes;
    }
    
}
