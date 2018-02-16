<?php

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;
use Elephantly\AmpConverterBundle\Cleaner\AmpDimensionsCleaner;

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

        if (preg_match('/.*\.gif[?]*/', $this->inputElement->getAttribute('src'))) {
            # code...
        }
    }

    public function callback()
    {
        $isConsistent = (AmpDimensionsCleaner::isLegal($this->inputElement->getAttribute('width')) && AmpDimensionsCleaner::isLegal($this->inputElement->getAttribute('height')));

        if (!$isConsistent) {
            $this->outputElement->setAttribute('width', $this->getDefaultValue('width'));
            $this->outputElement->setAttribute('height', $this->getDefaultValue('height'));
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
