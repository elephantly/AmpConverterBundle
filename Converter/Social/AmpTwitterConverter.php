<?php

namespace Elephantly\AmpConverterBundle\Converter\Social;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;
use DOMXPath;


/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpTwitterConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    protected $link = null;

    public function __construct($options = array())
    {
        $this->attributes = array('data-*', 'data-tweetid');
        $this->mandatoryAttributes = array('data-tweetid', 'layout', 'height', 'width');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'data-tweetid':
                preg_match('/https:\/\/twitter\.com\/\w*\/[status[es]*\/(\d+)/', $this->link, $ids);
                if (!isset($ids[1])) {
                    return null;
                }
                $tweetId = $ids[1];
                return $tweetId;
            case 'height':
                // hacking height and width
                // https://github.com/ampproject/amphtml/blob/master/extensions/amp-twitter/amp-twitter.md
                if (!$this->outputElement->hasAttribute('height')) {
                    if ($this->outputElement->hasAttribute('data-cards') && $this->outputElement->getAttribute('data-cards') === 'hidden') {
                        $height = '223';
                    } else {
                        $height = '694';
                    }
                }
                return $height;
            case 'width':
                // hacking height and width
                // https://github.com/ampproject/amphtml/blob/master/extensions/amp-twitter/amp-twitter.md
                return '486';
            default:
                return null;
        }
    }

    public function setup()
    {
        $xpath = new DOMXPath($this->inputElement->ownerDocument);
        $elements = $xpath->query($this->inputElement->getNodePath().'/a');
        if ($elements->length) {
            $this->link = $elements->item(0)->getAttribute('href');
        }
        $this->isInputValid = $elements->length;
    }

    public function callback()
    {
        // Testing if output is valid
        $tweetId = $this->outputElement->hasAttribute('data-tweetid');
        $isValid = $tweetId && !empty($tweetId);
        if (!$isValid) {
            $this->outputElement = null;
            return;
        }
    }

    public static function getIdentifier()
    {
        return 'twitter';
    }

    public function getSelector()
    {
        return 'blockquote.twitter-tweet';
    }

    public function getAmpTagName()
    {
        return 'amp-twitter';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>';
    }

}
