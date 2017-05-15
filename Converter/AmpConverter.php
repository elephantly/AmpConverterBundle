<?php 

namespace Elephantly\AmpConverterBundle\Converter;

use DOMDocument;
use Elephantly\AmpConverterBundle\Converter\Media\AmpImgConverter;
use Elephantly\AmpConverterBundle\Converter\ConverterChain;

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
        
        foreach ($this->converters as $tag => $converterClass) {

            $tags = $this->getMatchingTags($document, $tag);
            $converter = new $converterClass();

            $tabsLength = $tags->length;
            
            for ($i = 0; $i < $tabsLength ; $i++) {
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

    private function getMatchingTags(DOMDocument $document, $tag)
    {
        return $document->getElementsByTagName($tag);
    }
    
    private function convertTag($tag, $converter)
    {
        $ampTag = $converter->convertToAmp($tag);
        $tag->parentNode->replaceChild($ampTag, $tag);
    }
    
}
