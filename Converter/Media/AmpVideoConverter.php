<?php

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpVideoConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    public function __construct($options = array())
    {
        $this->attributes = array('src', 'poster', 'autoplay', 'controls', 'loop');
        $this->mandatoryAttributes = array('layout', 'width', 'height');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'width':
                return $this->inputElement->getAttribute('width');
            case 'height':
                return $this->inputElement->getAttribute('height');
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
        return 'video';
    }

    public function getSelector()
    {
        return 'video';
    }

    public function getAmpTagName()
    {
        return 'amp-video';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>';
    }

}
