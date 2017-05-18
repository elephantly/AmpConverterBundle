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
class AmpInstagramConverter extends AmpTagConverter implements AmpTagConverterInterface
{
    protected $link = null;

    protected $oembed = null;
    const INSTAGRAM_OEMBED = 'http://api.instagram.com/oembed/?url=';

    function __construct($options = array())
    {
        $this->attributes = array('data-captioned', 'data-shortcode');
        $this->mandatoryAttributes = array('layout', 'data-shortcode', 'height', 'width');
        $this->options = $options;    
    }
    
    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'layout':
                return 'responsive';
            case 'data-shortcode':
                preg_match('/https:\/\/www\.instagram\.com\/p\/(\w+)\//', $this->link, $ids);
                if (!isset($ids[1])) {
                    return null;
                }
                $shortcode = $ids[1];
                return $shortcode;
            case 'width':
                return $this->oembed['width'];
            case 'height':
                return $this->oembed['height'] ? $this->oembed['height'] : 400;
            default:
                return null;
        }
    }
    
    public function setup()
    {
        $xpath = new DOMXPath($this->inputElement->ownerDocument);
        $elements = $xpath->query($this->inputElement->getNodePath().'/div/p/a');
        $this->link = $elements->item(0)->getAttribute('href');
        try {
            $oEmbedClient = new OEmbedClient();
            $this->oembed = $oEmbedClient->getOEmbed(self::INSTAGRAM_OEMBED.$this->link);
        } catch (RequestException $e) {
            $this->oembed = null;
        }
        
    }

    public function callback()
    {
        
    }

    public static function getIdentifier()
    {
        return 'instagram';
    }

    public function getSelector()
    {
        return 'blockquote.instagram-media';
    }

    public function getAmpTagName()
    {
        return 'amp-instagram';
    }
    
    public function inputIsValid()
    {
        if ($this->oembed) {
            return true;
        }
        return false;
    }

    public function hasScriptTag()
    {
        return true;
    }
    
}
