<?php

namespace Galaxy\BackEndBundle\Tests\Controller\Space;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BootstrapControllerTest extends WebTestCase
{
    public function testSplitintosegments()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/splitIntoSegments');
    }

    public function testChangingsegmentsize()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/changingSegmentSize');
    }

    public function testDownloadsection()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/downloadSection');
    }

    public function testDownloadspace()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/downloadSpace');
    }

}
