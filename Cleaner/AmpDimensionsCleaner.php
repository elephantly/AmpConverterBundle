<?php

namespace Elephantly\AmpConverterBundle\Cleaner;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class AmpDimensionsCleaner
{

    public static function isLegal($dimension)
    {
        if(preg_match('/auto|%|em/', $dimension)) {
            return false;
        }

        $dimension = intval($dimension);
        if (empty($dimension)) {
            return false;
        }

        return true;
    }

}
