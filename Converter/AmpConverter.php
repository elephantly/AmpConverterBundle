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
        
        // delete illegal if illegals are specified
        if (isset($this->options['illegal'])) {
            foreach ($this->options['illegal'] as $selector) {
                // if body exists, select all illegal elements inside of it
                $bodyExists = $this->getMatchingTags($document, 'body');
                if ($bodyExists->length) {
                    $selector = 'body '.$selector;
                }

                $tags = $this->getMatchingTags($document, $selector);
                            
                foreach ($tags as $tag) {
                    $this->deleteTag($tag);
                }

            }
        }
        
        // convert Tags
        foreach ($this->converters as $selector => $converterClass) {

            $tags = $this->getMatchingTags($document, $selector);

            $converter = $this->getConverter($converterClass);
                        
            foreach ($tags as $tag) {
                $this->convertTag($tag, $converter);
            }

        }
        
        // Workaround 2 Working for 53
        // https://stackoverflow.com/questions/5706086/php-domdocument-output-without-xml-version-1-0-encoding-utf-8
        $output = $document->saveXML($document->documentElement->firstChild->firstChild);
        return trim($output);

    }

    public function getAmpScripts($input)
    {
        $scripts = array();

        if (!$input) {
            return '';
        }
        
        $document = $this->getDom($input);
        
        foreach ($this->converters as $selector => $converterClass) {
            
            $tags = $this->getMatchingTags($document, $selector);
            $converter = $this->getConverter($converterClass);

            if ($tags->length && $converter->hasScriptTag()) {
                $scripts[] = $converter->getScriptTag();
            }
    
        }
        
        return implode('', $scripts);
    }

    private function getDom($input)
    {
        $document = new DOMDocument();
        $document->encoding = 'UTF-8';
        libxml_use_internal_errors(true);
        // not working in 53
        // see https://stackoverflow.com/questions/4879946/how-to-savehtml-of-domdocument-without-html-wrapper
        // $document->loadHTML($input, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // WORKAROUND 1 not working either
        // $fragment = $document->createDocumentFragment();
        // $fragment->appendXML($input);
        // 
        // $document->appendChild($fragment);

        $document->loadHTML($input);
        
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

    private function getConverter($converterClass)
    {
        $identifier = $converterClass::getIdentifier();
        $tagOptions = isset($this->options[$identifier]) ? $this->options[$identifier]:array();
        $converter = new $converterClass($tagOptions);
        return $converter;
    }
    
    private function convertTag($tag, $converter)
    {
        $ampTag = $converter->convertToAmp($tag);

        $parent = $tag->parentNode;
        
        if ($ampTag) {
            $parent->replaceChild($ampTag, $tag);
        }

    }

    private function deleteTag($tag)
    {
        $parent = $tag->parentNode;
        $parent->removeChild($tag);
    }
    
}
