<?php 

namespace Elephantly\AmpConverterBundle\Converter;

use DOMDocument;
use Elephantly\AmpConverterBundle\Converter\Media\AmpImgConverter;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpConverter
{    
    protected $input;

    protected $output;
    
    protected $options;

    function __construct($input, $options = array())
    {
        $this->input = $input;
    }

    public function convert()
    {

        $document = $this->getDom();
        
        // TODO: automate work here
        $img = $document->getElementsByTagName("img")->item(0);
        $imgConverter = new AmpImgConverter();
        $ampImage = $imgConverter->convertToAmp($img);
        $img->parentNode->replaceChild($ampImage, $img);

        return $document;

    }

    public function getDom()
    {
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($this->input);
        // $document->encoding = 'UTF-8';
        libxml_clear_errors();
        
        return $document;
    }
    
}
