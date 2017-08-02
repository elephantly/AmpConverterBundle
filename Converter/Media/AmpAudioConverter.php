<?php

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpAudioConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    public function __construct($options = array())
    {
        $this->attributes = array('muted', 'autoplay', 'loop');
        $this->mandatoryAttributes = array();
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            default:
                return null;
        }
    }

    public function setup()
    {

    }

    public function callback()
    {

        foreach ($this->inputElement->childNodes as $tag) {

            $tagIsAllowed = $tag->tagName === 'source' || $tag->tagName === 'track';

            $src = $tag->getAttribute("src");
            $tagIsValid = preg_match('/^https/', $src);

            if ($tagIsAllowed && $tagIsValid) {
                $this->outputElement->appendChild($tag);
            }
            if ($tag->tagName === 'div') {
                $fallback = $this->inputElement->ownerDocument->createElement('div');
                $fallback->setAttribute('fallback', '');
                $fallback->appendChild($tag);
                $this->outputElement->appendChild($fallback);
            }
        }
    }

    public static function getIdentifier()
    {
        return 'audio';
    }

    public function getSelector()
    {
        return 'audio';
    }

    public function getAmpTagName()
    {
        return 'amp-audio';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>';
    }

}
