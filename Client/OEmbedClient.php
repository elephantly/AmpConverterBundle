<?php

namespace Elephantly\AmpConverterBundle\Client;

use Buzz\Browser as BuzzBrowser;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Buzz\Client\FileGetContents;
use Buzz\Client\Curl;

/**
* primary @author purplebabar(lalung.alexandre@gmail.com)
*/
class OEmbedClient extends BuzzBrowser
{

    /**
    * Return the OEmbed content of a url
    * @return array
    */
    public function getOEmbed($url)
    {
        $this->setClient(new Curl());
        $response = $this->get($url);

        $content = $response->getContent();
        $oEmbed = json_decode($content, true);

        return $oEmbed;
    }
}
