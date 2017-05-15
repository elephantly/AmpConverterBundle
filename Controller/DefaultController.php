<?php

namespace Elephantly\AmpConverterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elephantly\AmpConverterBundle\Converter\AmpConverter;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $html = '<div><img src="https://upload.wikimedia.org/wikipedia/commons/e/ee/%22Birdcatcher%22_with_jockey_up.jpg"><span>coucou</span><img src="https://upload.wikimedia.org/wikipedia/commons/e/ee/%22Birdcatcher%22_with_jockey_up.jpg"></div>';
        $converter = new AmpConverter($this->get('elephantly.converters'));
        $output = $converter->convert($html);

        return $this->render('ElephantlyAmpConverterBundle:Default:index.html.twig', array('tag' => $output));
    }
}
