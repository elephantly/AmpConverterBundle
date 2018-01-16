<?php

namespace Elephantly\AmpConverterBundle\Cleaner;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpTagCleaner
{
    public function __construct()
    {
        $this->illegalAttributes = array('style', 'contenteditable', 'frameborder', 'allowfullscreen', 'onclick', 'onmouseover');
    }

    public function clean($input)
    {

        foreach ($this->illegalAttributes as $attribute) {
            $input = preg_replace("/".$attribute."=[\"'][\w\s:;%-\.]*[\"'][[:space:]]*/", '', $input);
        }

        return trim($input, " \t\n\r\0\x0B");
    }



}
