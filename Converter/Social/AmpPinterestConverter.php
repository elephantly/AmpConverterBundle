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
class AmpPinterestConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    function __construct($options = array())
    {
        $this->attributes = array('data-do', 'data-url', 'data-media', 'data-description', 'data-href', 'data-label', 'data-count');
        $this->mandatoryAttributes = array('data-do', 'width', 'height');
        $this->options = $options;    
    }
    
    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'width':
                return 236;
            case 'height':
                return 380;
            case 'data-do':
                return $this->inputElement->getAttribute('data-pin-do');
            default:
                return null;
        }
    }
    
    public function setup()
    {
        
    }

    public function callback()
    {
        switch ($this->outputElement->getAttribute('data-do')) {
            case 'embedPin':
                if (!$this->outputElement->getAttribute('data-url')) {
                    $this->outputElement->setAttribute('data-url', $this->inputElement->getAttribute('href'));
                }
                if (!$size = $this->inputElement->getAttribute('data-pin-width')) {
                    switch ($size) {
                        case 'medium':
                            $height = 422;
                            $width = 345;
                            break;
                        case 'large':
                            $height = 628;
                            $width = 600;
                            break;
                        default:
                            $height = 380;
                            $width = 236;
                            break;
                    }
                    $this->outputElement->setAttribute('width', $width);
                    $this->outputElement->setAttribute('height', $height);
                }
                return;
            case 'buttonFollow':
                if (!$this->outputElement->getAttribute('data-href')) {
                    $this->outputElement->setAttribute('data-href', $this->inputElement->getAttribute('href'));
                }
                if (!$this->outputElement->getAttribute('data-label')) {
                    $this->outputElement->setAttribute('data-label', $this->options['follow_label']);
                    $this->outputElement->setAttribute('data-label', 'Follow us on pinterest');
                }
                $strLen = strlen($this->outputElement->getAttribute('data-label'));
                $width = 10 * $strLen;
                $width -= $width*0.15;
                $this->outputElement->setAttribute('width', $width);
                $this->outputElement->setAttribute('height', 20);
                return;
            case 'buttonPin':
                $this->outputElement->setAttribute('data-do', 'buttonPin');

                $href =  $this->inputElement->getAttribute('href');
                $href = parse_url($href);
                parse_str($href['query'], $href);

                if (!$this->outputElement->getAttribute('data-url')) {
                    $this->outputElement->setAttribute('data-url', $href['url']);
                }

                if (!$this->outputElement->getAttribute('data-media')) {
                    $this->outputElement->setAttribute('data-media', $href['media']);
                }

                if (!$this->outputElement->getAttribute('data-description')) {
                    $this->outputElement->setAttribute('data-description', $href['description']);
                }
                
                // set multiple values
                if (!$count = $this->inputElement->getAttribute('data-pin-count')) {
                    $this->outputElement->setAttribute('data-count', $count);
                }

                if (!$isTall = $this->inputElement->getAttribute('data-pin-tall')) {
                    $this->outputElement->setAttribute('data-tall', $isTall);
                }
                
                if (!$isRound = $this->inputElement->getAttribute('data-pin-round')) {
                    $this->outputElement->setAttribute('data-round', $isRound);
                }

                $width = $isTall ? 57 : 40;
                $height = $isTall ? 28 : 20;
                
                if ($this->outputElement->getAttribute('data-count') == 'beside') {
                    $width = $isTall ? 107 : 88;
                    $height = $isTall ? 28 : 20;
                }

                if ($this->outputElement->getAttribute('data-count') == 'above') {
                    $width = $isTall ? 56 : 40;
                    $height = $isTall ? 66 : 50;
                }
                
                if ($this->outputElement->getAttribute('data-round')) {
                    $width = $isTall ? 32 : 16;
                    $height = $isTall ? 32 : 16;
                }

                $this->outputElement->setAttribute('width', $width);
                $this->outputElement->setAttribute('height', $height);
                return;
            default:
                return;
        }        
        
    }

    public static function getIdentifier()
    {
        return 'pinterest';
    }

    public function getSelector()
    {
        return 'a[href*="pinterest.com"]';
    }

    public function getAmpTagName()
    {
        return 'amp-pinterest';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-pinterest" src="https://cdn.ampproject.org/v0/amp-pinterest-0.1.js"></script>';
    }
    
}
