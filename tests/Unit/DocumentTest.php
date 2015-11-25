<?php

namespace PhpBench\Dom\Tests\Unit;

use PhpBench\Dom\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Document
     */
    private $document;

    public function setUp()
    {
        $this->document = new Document(1.0);
    }

    /**
     * It should perform an XPath query
     */
    public function testQuery()
    {
        $this->document->loadXml($this->getXml());
        $nodeList = $this->document->query('//record');
        $this->assertInstanceOf('DOMNodeList', $nodeList);
        $this->assertEquals(2, $nodeList->length);
    }

    /**
     * It should evaluate an XPath expression
     */
    public function testEvaluate()
    {
        $this->document->loadXml($this->getXml());
        $result = $this->document->evaluate('count(//record)');
        $this->assertEquals(2, $result);
    }

    /**
     * It should create a root element
     */
    public function testCreateRoot()
    {
        $this->document->createRoot('hello');
        $this->assertContains('<hello/>', $this->document->saveXml());
    }

    private function getXml()
    {
        $xml = <<<EOT
<?xml version="1.0"?>
<document>
    <record id="1">
        <title>Hello</title>
    </record>
    <record id="2">
        <title>World</title>
    </record>
</document>
EOT
        ;

        return $xml;
    }
}
