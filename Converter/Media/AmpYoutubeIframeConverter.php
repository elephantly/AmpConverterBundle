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
class AmpYoutubeIframeConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    function __construct($options = array())
    {
        $this->attributes = array('autoplay', 'data-videoid', 'data-param-*');
        $this->mandatoryAttributes = array('data-videoid');
        $this->options = $options;
    }
    
    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'data-videoid':
                $src = $this->inputElement->getAttribute('src');
                preg_match('/embed\/([\w-]*)|\?v=([\w-]*)/', $src, $matches);

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
        return 'youtube_iframe';
    }

    public function getSelector()
    {
        return 'iframe[src*="youtube.com"]';
    }

    public function getAmpTagName()
    {
        return 'amp-youtube';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>';
    }
    
}
