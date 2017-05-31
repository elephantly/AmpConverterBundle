<?php 

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpBrightcoveIframeConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    function __construct($options = array())
    {
        $this->attributes = array('data-account', 'data-player', 'data-player-id', 'data-embed', 'data-video-id', 'data-playlist-id', 'data-param-*');
        $this->mandatoryAttributes = array('data-account', 'data-player', 'data-embed', 'data-video-id', 'layout', 'width', 'height');
        $this->options = $options;
    }
    
    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'width':
                return 480;
            case 'height':
                return 270;
            default:
                return null;
        }
    }
    
    public function setup()
    {

    }

    public function callback()
    {
        $src = $this->inputElement->getAttribute('src');
        $brightcoveUrl = parse_url($src);
        $brightcovePath = explode('/', $brightcoveUrl['path']);

        if (!isset($brightcovePath[1])) {
            $this->outputElement = null;
            return;
        }
        if (!isset($brightcovePath[2])) {
            $this->outputElement = null;
            return;
        }

        parse_str($brightcoveUrl['query'], $brightcoveUrl);

        if (!$this->outputElement->getAttribute('data-account')) {
            $this->outputElement->setAttribute('data-account', $brightcovePath[1]);
        }
            
        $brightcovePath = explode('_', $brightcovePath[2]);

        if (!$this->outputElement->getAttribute('data-player')) {
            $this->outputElement->setAttribute('data-player', $brightcovePath[0]);
        }
        if (!$this->outputElement->getAttribute('data-embed')) {
            $this->outputElement->setAttribute('data-embed', $brightcovePath[1]);
        }
        if (!$this->outputElement->getAttribute('data-video-id')) {
            $this->outputElement->setAttribute('data-video-id', $brightcoveUrl['videoId']);
        }
    }

    public static function getIdentifier()
    {
        return 'brightcove_iframe';
    }

    public function getSelector()
    {
        return 'iframe[src*="players.brightcove.net"]';
    }

    public function getAmpTagName()
    {
        return 'amp-brightcove';
    }
    
    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-brightcove" src="https://cdn.ampproject.org/v0/amp-brightcove-0.1.js"></script>';
    }
    
}
