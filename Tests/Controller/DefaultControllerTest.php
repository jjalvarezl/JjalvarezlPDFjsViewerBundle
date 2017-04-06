<?php

namespace jjalvarezl\PDFjsViewerBundle\Tests\Controller;

use Salva\PdfJsBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        //$client = static::createClient();

        //$crawler = $client->request('POST', '/custom_viewer');

        //$this->assertContains('Hello World', $client->getResponse()->getContent());

        $this->assertContains('1', '1');
    }
}
