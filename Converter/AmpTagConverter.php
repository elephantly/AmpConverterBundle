<?php 

namespace Elephantly\AmpConverterBundle\Converter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpTagConverter
{
    protected $attributes = array();

    protected $mandatoryAttributes = array();
    
    protected $inputElement = null;

    protected $outputElement = null;

    protected $isInputValid = true;

    protected $options = array();

    public function getAmpCommonAttributes()
    {
        return array('fallback', 'heights', 'layout', 'media', 'noloading', 'on', 'placeholder', 'sizes', 'width', 'height', 'class');
    }
    
    private function canBeConverted($attribute)
    {
        $regex = '/';
        foreach($this->getAmpAttributes() as $ampAttribute) {
            $ampAttribute = preg_replace('/\*/', '\w+', $ampAttribute);
            $regex .= '^'.$ampAttribute.'$|';
        }
        $regex = rtrim($regex,"| ");
        $regex .= '/';

        return preg_match($regex, $attribute);
    }

    public function convertToAmp($element)
    {
        $this->inputElement = $element;
        
        $this->setup();
        
        if (!$this->isInputValid) {
            return null;
        }

        $this->outputElement = $this->inputElement->ownerDocument->createElement($this->getAmpTagName());
        foreach ($this->inputElement->attributes as $attrName => $attrNode) {
            if ($this->canBeConverted($attrName)) {
                 $this->outputElement->setAttribute($attrName, $attrNode->value);
            }
        }

        foreach ($this->getMandatoryAttributes() as $mandatoryAttribute) {
            if (!$this->outputElement->hasAttribute($mandatoryAttribute)) {
                $this->outputElement->setAttribute($mandatoryAttribute, $this->getDefaultValue($mandatoryAttribute, $this->inputElement));
            }
        }

        $this->callback();
        
        $this->inputElement = null;

        return $this->outputElement;
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
