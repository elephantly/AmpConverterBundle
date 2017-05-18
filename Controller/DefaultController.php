<?php

namespace Elephantly\AmpConverterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elephantly\AmpConverterBundle\Converter\AmpConverter;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $twitter = '<blockquote data-cards="hidden" class="twitter-tweet" data-lang="en"><p lang="en" dir="ltr">Lorraine and I had an amazing time at the <a
href="https://twitter.com/hashtag/Oscars?src=hash">#Oscars</a>! Congrats to all of the nominees on a job
well-done! <a href="https://t.co/xyrO7kQBzH">pic.twitter.com/xyrO7kQBzH</a></p>&mdash; Andy Serkis (@andyserkis) <a
href="https://twitter.com/andyserkis/status/704420904437043200">February 29, 2016</a></blockquote><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
        $instagram = '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="7" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:62.4537037037037% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/BSO2S3iDdkz/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">Ladies, (and gents) I&#39;m starting a YouTube channel pretty damn soon &amp; am super excited to get the ball rolling! 😁 I would love your suggestions... what kind of stuff would you like to see on my channel? Swimsuit 👙 @tea_you</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">Une publication partagée par Karen Villarreal (@karen_vi) le <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2017-03-29T18:25:09+00:00">29 Mars 2017 à 11h25 PDT</time></p></div></blockquote><script async defer src="//platform.instagram.com/en_US/embeds.js"></script>';
        $converter = $this->get('elephantly.amp_converter');
        $output = $converter->convert($instagram);

        return $this->render('ElephantlyAmpConverterBundle:Default:index.html.twig', array('tag' => $output));
    }
}
