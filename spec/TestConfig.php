<?php

namespace Elephantly\AmpConverterBundle\spec;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class TestConfig
{
    public static $options = array(
        'img' => array('amp_anim' => true),
        'illegal' => array('script', 'div#fb-root'),
        'pinterest' => array('follow_label' => 'Follow us'),
        'remove_incorrect_tags' => true
    );

    public static $converters = array();

}
