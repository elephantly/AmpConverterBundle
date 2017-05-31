<?php 

namespace Elephantly\AmpConverterBundle\Converter\Media;

use Elephantly\AmpConverterBundle\Converter\AmpTagConverterInterface;
use Elephantly\AmpConverterBundle\Converter\AmpTagConverter;
use DOMNode;
use FastImageSize\FastImageSize;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpBrightcoveVideoConverter extends AmpTagConverter implements AmpTagConverterInterface
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
        if (!$this->outputElement->getAttribute('data-account')) {
            $this->outputElement = null;
        }
        if (!$this->outputElement->getAttribute('data-player')) {
            $this->outputElement = null;
        }
        if (!$this->outputElement->getAttribute('data-embed')) {
            $this->outputElement = null;
        }
        if (!$this->outputElement->getAttribute('data-video-id')) {
            $this->outputElement = null;
        }
    }

    public static function getIdentifier()
    {
        return 'brightcove_video';
    }

    public function getSelector()
    {
        return 'video.video-js[data-player]';
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
