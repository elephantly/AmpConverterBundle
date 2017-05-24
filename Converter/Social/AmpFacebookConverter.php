<?php 

namespace Elephantly\AmpConverterBundle\Converter\Social;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use DOMXPath;
use Elephantly\AmpConverterBundle\Client\OEmbedClient;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpFacebookConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    function __construct($options = array())
    {
        $this->attributes = array('data-href', 'data-embed-as');
        $this->mandatoryAttributes = array('layout', 'data-href', 'height', 'width');
        $this->options = $options;
    }
    
    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'data-href':
                $src = $this->inputElement->getAttribute('src');
                $fbUrl = parse_url($src);
                parse_str($fbUrl['query'], $fbUrl);
                return $fbUrl['href'];
            case 'height':
                return $this->inputElement->getAttribute('height');
            case 'width':
                return $this->inputElement->getAttribute('width');
            default:
                return null;
        }
    }
    
    public function setup()
    {
        
    }

    public function callback()
    {
        $src = $this->outputElement->getAttribute('src');
        preg_match('/https:\/\/www.facebook\.com\/\w*\/(\w*)\/\d*/', $src, $embedType);
        switch ($embedType) {
            case 'videos':
                $embedOut = 'video';
                break;
            case 'posts':
                $embedOut = 'post';
                break;
            default:
                $embedOut = 'post';
                break;
        }
        $this->outputElement->setAttribute('data-embed-as', $embedOut);
    }

    public static function getIdentifier()
    {
        return 'facebook';
    }

    public function getSelector()
    {
        return 'iframe[src*="facebook.com"]';
    }

    public function getAmpTagName()
    {
        return 'amp-facebook';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>';
    }
    
}
