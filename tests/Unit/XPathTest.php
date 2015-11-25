<?php

namespace PhpBench\Dom\Tests\Unit;

use PhpBench\Dom\Document;

class XPathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * It should throw an exception if the xpath query is invalid
     *
     * @expectedException PhpBench\Dom\Exception\InvalidQueryException
     * @expectedExceptionMessage function noexistfunc not found
     */
    public function testQueryException()
    {
        $this->getDocument()->query('//article[noexistfunc() = "as"]');
    }

    /**
     * It should throw an exception if the xpath expression is invalid
     *
     * @expectedException PhpBench\Dom\Exception\InvalidQueryException
     * @expectedExceptionMessage function noexistfunc not found
     */
    public function testEvaluateException()
    {
        $this->getDocument()->evaluate('//article[noexistfunc() = "as"]');
    }

    private function getDocument()
    {
        $xml = <<<EOT
<?xml version="1.0"?>
<document>
    <article id="1">
        <title>Morning</title>
    </article>
    <article id="2">
        <title>Afternoon</title>
    </article>
</document>
EOT
        ;

        $document = new Document();
        $document->loadXml($xml);

        return $document;
    }
}
