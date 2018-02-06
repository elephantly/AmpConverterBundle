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
class AmpDailymotionIframeConverter extends AmpTagConverter implements AmpTagConverterInterface
{

    public function __construct($options = array())
    {
        $this->attributes = array('autoplay', 'data-mute', 'data-videoid', 'data-endscreen-enable', 'data-sharing-enable', 'data-start', 'data-ui-logo', 'data-info', 'data-param-*');
        $this->mandatoryAttributes = array('data-videoid');
        $this->options = $options;
    }

    public function getDefaultValue($attribute)
    {
        switch ($attribute) {
            case 'data-videoid':
                $src = $this->inputElement->getAttribute('src');
                preg_match('/video\/([\w-]*[^_?#&]+)/', $src, $matches);

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

        $src = $this->inputElement->getAttribute('src');
        $dmUrl = parse_url($src);
        parse_str(html_entity_decode($dmUrl['query']), $dmUrl);

        foreach ($dmUrl as $key => $value) {
            $prefix = 'data-param-';
            if (in_array('data-'.$key, $this->attributes)) {
                $prefix = 'data-';
            }elseif (in_array($key, $this->attributes)){
                $prefix = '';
            }

            $this->outputElement->setAttribute($prefix.$key, $value);
        }

        if ($this->outputElement->hasAttribute('data-info') && !is_bool($dataInfo = $this->outputElement->getAttribute('data-info'))) {
            $this->outputElement->setAttribute('data-info', $dataInfo ? 'true' : 'false');
        }
        if ($this->outputElement->hasAttribute('data-ui-logo') && !is_bool($dataUiLogo = $this->outputElement->getAttribute('data-ui-logo'))) {
            $this->outputElement->setAttribute('data-ui-logo', $dataUiLogo ? 'true' : 'false');
        }

    }

    public static function getIdentifier()
    {
        return 'dailymotion_iframe';
    }

    public function getSelector()
    {
        return 'iframe[src*="dailymotion.com"]';
    }

    public function getAmpTagName()
    {
        return 'amp-dailymotion';
    }

    public function hasScriptTag()
    {
        return true;
    }

    public function getScriptTag()
    {
        return '<script async custom-element="amp-dailymotion" src="https://cdn.ampproject.org/v0/amp-dailymotion-0.1.js"></script>';
    }

}
