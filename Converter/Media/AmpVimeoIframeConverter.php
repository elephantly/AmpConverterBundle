<?php

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use DOMXPath;
use Elephantly\AmpConverterBundle\Client\OEmbedClient;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpVimeoIframeConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    public function __construct($options = array())
    {
        $this->attributes = array('data-videoid');
        $this->mandatoryAttributes = array('data-videoid');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'data-videoid':
                $src = $this->inputElement->getAttribute('src');
                preg_match('/video\/([\w-]*)/', $src, $matches);

                if (isset($matches[1])) {
                    return $matches[1];
                }
                return null;
            default:
                return null;
        }
    }

    public function setup()
    {

    }

    public function callback()
    {

    }

    public static function getIdentifier()
    {
        return 'vimeo_iframe';
    }

    public function getSelector()
    {
        return 'iframe[src*="player.vimeo.com"]';
    }

    public function getAmpTagName()
    {
        return 'amp-vimeo';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>';
    }

}
