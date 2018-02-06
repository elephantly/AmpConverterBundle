<?php

namespace Elephantly\AmpConverterBundle\Cleaner;

use Symfony\Component\CssSelector\CssSelectorConverter;
use DOMDocument;
use DOMXPath;


/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpTagCleaner
{
    public function __construct($config = array())
    {
        $this->illegalAttributes = array_merge($config['illegal_attributes'],
                                                array('style',
                                                'contenteditable',
                                                'onclick',
                                                'onmouseover'));

        $this->illegalTagAttributes = array_merge_recursive($config['illegal_tag_attributes'], array());

        $this->illegalTags = array_merge($config['illegal_tags'], array('script', 'div#fb-root'));
    }

    public function cleanillegalAttributes($input)
    {

        foreach ($this->illegalAttributes as $attribute) {
            $input = preg_replace("/".$attribute."=[\"'][\w\s:;!?#-\.]*[\"'][[:space:]]*/", '', $input);
        }

        return trim($input, " \t\n\r\0\x0B");
    }

    public function cleanillegalTags(DOMDocument $input) {
        foreach ($this->illegalTags as $selector) {
            // if body exists, select all illegal elements inside of it
            $bodyExists = $this->getMatchingTags($input, 'body');
            if ($bodyExists->length) {
                $selector = 'body '.$selector;
            }

            $tags = $this->getMatchingTags($input, $selector);
            foreach ($tags as $tag) {
                $this->deleteTag($tag);
            }
        }

        return $input;
    }

    public function cleanIllegalTagAttributes(DOMDocument $input) {
        foreach ($this->illegalTagAttributes as $tag => $tagAttributes) {
            foreach ($tagAttributes as $tagAttribute) {
                $selector = $tag.'['.$tagAttribute.']';
                $matchingTags = $this->getMatchingTags($input, $selector);
                foreach ($matchingTags as $wrongTag) {
                    $wrongTag->removeAttribute($tagAttribute);
                    if (strpos($tagAttribute,'=')) {
                        $wrongTag->removeAttribute(explode('=', $tagAttribute)[0]);
                    }
                }
            }
        }

        return $input;
    }

    private function getMatchingTags(DOMDocument $document, $selector)
    {
        $selectorConverter = new CssSelectorConverter();

        $xpathSelector = $selectorConverter->toXPath($selector);

        $xpath = new DOMXPath($document);

        $elements = $xpath->query($xpathSelector);
        return $elements;
    }
    private function deleteTag($tag)
    {
        $parent = $tag->parentNode;
        $parent->removeChild($tag);
    }


}
