<?php 

namespace Elephantly\AmpConverterBundle\Converter;

use DOMDocument;
use DOMXPath;
use Elephantly\AmpConverterBundle\Converter\Media\AmpImgConverter;
use Elephantly\AmpConverterBundle\Converter\ConverterChain;
use Symfony\Component\CssSelector\CssSelectorConverter;


/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpConverter
{    
    protected $input;

    protected $output;
    
    protected $options;

    protected $converters;

    function __construct($converters = array(), $options = array())
    {
        $this->options = $options;
        $this->converters = $converters;
        if ($converters instanceof ConverterChain) {
            $this->converters = $converters->getConverters();
        }
    }
    
    public function convert($input)
    {
        if (!$input) {
            return '';
        }
        $document = $this->getDom($input);  
        
        foreach ($this->converters as $selector => $converterClass) {

            $tags = $this->getMatchingTags($document, $selector);
            $identifier = $converterClass::getIdentifier();
            $tagOptions = isset($this->options[$identifier]) ? $this->options[$identifier]:array();
            $converter = new $converterClass($tagOptions);

            $tagsLength = $tags->length;
            
            for ($i = 0; $i < $tagsLength ; $i++) {
                $this->convertTag($tags->item(0), $converter);
            }
            
        }
        
        $output = $document->saveHTML();
        return trim($output);

    }

    private function getDom($input)
    {
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($input, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $document->encoding = 'UTF-8';
        libxml_clear_errors();
        
        return $document;
    }

    private function getMatchingTags(DOMDocument $document, $selector)
    {
        $selectorConverter = new CssSelectorConverter();

        $xpathSelector = $selectorConverter->toXPath($selector);
        $xpath = new DOMXPath($document);

        $elements = $xpath->query($xpathSelector);
        return $elements;
    }
    
    private function convertTag($tag, $converter)
    {
        // Delete the script tag associated
        if ($converter->hasScriptTag()) {
            if ($tag->nextSibling) {
                $tag->parentNode->removeChild($tag->nextSibling);
            }elseif ($tag->parentNode instanceof DOMDocument) {
                //special case where the script and the element are sibling of DomDocument
                $scriptTag = $tag->parentNode->getElementsByTagName('script')->item(0);
                $scriptTag->parentNode->removeChild($scriptTag);
            }
        }
        $ampTag = $converter->convertToAmp($tag);
        if ($ampTag) {
            $tag->parentNode->replaceChild($ampTag, $tag);
        }else {
            $tag->parentNode->removeChild($tag);
        }
    }
    
}
