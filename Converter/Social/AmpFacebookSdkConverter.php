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
class AmpFacebookSdkConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    
    const FACEBOOK_OEMBED_POST = 'https://www.facebook.com/plugins/post/oembed.json/?url=';
    const FACEBOOK_OEMBED_VIDEO = 'https://www.facebook.com/plugins/video/oembed.json/?url=';

    function __construct($options = array())
    {
        $this->attributes = array('data-href', 'data-embed-as');
        $this->mandatoryAttributes = array('layout', 'data-href', 'width');
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
            case 'width':
                return $this->inputElement->getAttribute('data-width');
            case 'height':
                return $this->inputElement->getAttribute('data-height') ? $this->inputElement->getAttribute('data-height') : null;
            default:
                return null;
        }
    }
    
    public function setup()
    {
        
    }

    public function callback()
    {
        $src = $this->inputElement->getAttribute('data-href');
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
        
        if (!$this->outputElement->getAttribute('height')) {
            try {
                $oEmbedClient = new OEmbedClient();
                $OEmbed = $oEmbedClient->getOEmbed(self::FACEBOOK_OEMBED_POST.$src);
            } catch (RequestException $e) {
                $OEmbed = null;
            }
            $height = $OEmbed['height'] ? $OEmbed['height']: 366;
            if ($height) {
                $this->outputElement->setAttribute('height', $height);
            }else{
                $this->outputElement->removeAttribute('height');
            }
            
        }

    }

    public static function getIdentifier()
    {
        return 'facebook_sdk';
    }

    public function getSelector()
    {
        return 'div.fb-post';
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
