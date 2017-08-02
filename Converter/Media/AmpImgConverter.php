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

    protected $imageInfos = null;

    public function __construct($options = array())
    {
        $this->attributes = array('src', 'srcset', 'sizes', 'alt', 'attribution');
        $this->mandatoryAttributes = array('layout', 'width', 'height');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'width':
                return $this->getWidth();
            case 'height':
                return $this->getHeight();
            default:
                return null;
        }
    }

    private function getImageInfo()
    {
        $imageSizer = new FastImageSize();
        try {
            $imageSize = $imageSizer->getImageSize($this->inputElement->getAttribute('src'));
        } catch (\Exception $e) {
            $imageSize = false;
        }

        return $imageSize ? $imageSize : null;
    }

    public function setup()
    {
        if (!$this->imageInfos = $this->getImageInfo()) {
            $this->isInputValid = false;
        }
    }

    public function callback()
    {

        // checking illegal values for width and heigth
        $illegalValues = array('auto');
        $isIllegal = in_array($this->outputElement->getAttribute('width'), $illegalValues) || in_array($this->outputElement->getAttribute('height'), $illegalValues);

        if ($isIllegal) {
            $this->outputElement->setAttribute('width', $this->getWidth($this->outputElement));
            $this->outputElement->setAttribute('height', $this->getHeight($this->outputElement));
        }

        preg_match('/\d*(\w*)/', $this->outputElement->getAttribute('width'), $matchWidth);
        preg_match('/\d*(\w*)/', $this->outputElement->getAttribute('height'), $matchHeight);

        $unitsAreInconsistent = $matchWidth[1] !== $matchHeight[1];

        $isInconsistent = ($this->inputElement->hasAttribute('width') && !$this->inputElement->hasAttribute('height')) || (!$this->inputElement->hasAttribute('width') && $this->inputElement->hasAttribute('height'));

        if ($isInconsistent || $unitsAreInconsistent) {
            $this->outputElement->setAttribute('width', $this->getWidth($this->outputElement));
            $this->outputElement->setAttribute('height', $this->getHeight($this->outputElement));
        }
    }

    public static function getIdentifier()
    {
        return 'img';
    }

    public function getSelector()
    {
        return 'img';
    }

    public function getAmpTagName()
    {
        if ( (isset($this->options['amp_anim']) && $this->options['amp_anim']) || !isset($this->options['amp_anim'])) {
            if ($this->inputElement && preg_match('/.*\.gif[?]*/', $this->inputElement->getAttribute('src'))) {
                return 'amp-anim';
            }
        }

        return 'amp-img';
    }

    public function hasScriptTag()
    {
        if ((isset($this->options['amp_anim']) && $this->options['amp_anim'])) {
            return true;
        }
        return false;
    }

    public function getScriptTag()
    {
        if ($this->hasScriptTag()) {
            return '<script async custom-element="amp-anim" src="https://cdn.ampproject.org/v0/amp-anim-0.1.js"></script>';
        }
        return null;
    }

    public function getWidth()
    {
        if (!$this->imageInfos) {
            return 0;
        }
        return $this->imageInfos['width'];
    }

    public function getHeight()
    {
        if (!$this->imageInfos) {
            return 0;
        }
        return $this->imageInfos['height'];
    }

}
