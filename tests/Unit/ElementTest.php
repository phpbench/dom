<?php

/*
 * This file is part of the PhpBench DOM  package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpBench\Dom\Tests\Unit;

use PhpBench\Dom\Document;

class ElementTest extends \PHPUnit_Framework_TestCase
{
    private $element;
    private $document;

    public function setUp()
    {
        $this->document = new Document();
        $this->element = $this->document->createRoot('test');
    }

    /**
     * It should create and append a child element.
     */
    public function testAppendElement()
    {
        $element = $this->element->appendElement('hello');
        $result = $this->document->evaluate('count(//hello)');
        $this->assertInstanceOf('PhpBench\Dom\Element', $element);
        $this->assertEquals(1, $result);
    }

    /**
     * It should exeucte an XPath query.
     */
    public function testQuery()
    {
        $boo = $this->element->appendElement('boo');
        $nodeList = $this->element->query('.//*');
        $this->assertInstanceOf('DOMNodeList', $nodeList);
        $this->assertEquals(1, $nodeList->length);
        $nodeList = $boo->query('.//*');
        $this->assertEquals(0, $nodeList->length);
    }

    /**
     * It should evaluate an XPath expression.
     */
    public function testEvaluate()
    {
        $boo = $this->element->appendElement('boo');
        $count = $this->element->evaluate('count(.//*)');
        $this->assertEquals(1, $count);
        $count = $boo->evaluate('count(.//*)');
        $this->assertEquals(0, $count);
    }

    /**
     * It should query for one element.
     */
    public function testQueryOne()
    {
        $boo = $this->element->appendElement('boo');
        $node = $this->element->queryOne('./boo');
        $this->assertSame($boo, $node);
    }

    /**
     * It should return null if one element is queried for an it none exist.
     */
    public function testQueryOneNone()
    {
        $node = $this->element->queryOne('./boo');
        $this->assertNull($node);
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
EOT;

        return $xml;
    }
}
