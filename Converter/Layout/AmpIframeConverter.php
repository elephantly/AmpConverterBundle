<?php

namespace Elephantly\AmpConverterBundle\Converter\Layout;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use DOMXPath;
use Elephantly\AmpConverterBundle\Client\OEmbedClient;
use Elephantly\AmpConverterBundle\Cleaner\AmpDimensionsCleaner;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpIframeConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    public function __construct($options = array())
    {
        $this->attributes = array('src', 'sandbox');
        $this->mandatoryAttributes = array('layout', 'src', 'height', 'width');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'width':
                return 500;
            case 'height':
                return 500;
            default:
                return null;
        }
    }

    public function setup()
    {

    }

    public function callback()
    {
        $this->outputElement->setAttribute('sandbox', 'allow-scripts allow-same-origin');

        if (!AmpDimensionsCleaner::isLegal($this->outputElement->getAttribute('width'))) {
            $this->outputElement->setAttribute('width', $this->getDefaultValue('width'));
        }
        if (!AmpDimensionsCleaner::isLegal($this->outputElement->getAttribute('height'))) {
            $this->outputElement->setAttribute('height', $this->getDefaultValue('height'));
        }

        $src = $this->outputElement->getAttribute('src');
        if (!$src) {
            $this->outputElement = null;
        }
        if (!preg_match('/^https/', $src)) {
            $srcCorrected = null;
            if (preg_match('/^http/', $src)) {
                $srcCorrected = str_replace('http', 'https', $src);
            }
            if (preg_match('/^\/\//', $src)) {
                $srcCorrected = 'https:'.$src;
            }
            $this->outputElement->setAttribute('src', $srcCorrected);
            if (!$srcCorrected) {
                $this->outputElement = null;
            }
        }
    }

    public static function getIdentifier()
    {
        return 'iframe';
    }

    public function getSelector()
    {
        return 'iframe';
    }

    public function getAmpTagName()
    {
        return 'amp-iframe';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>';
    }

}
