<?php

/*
 * This file is part of the PhpBench DOM  package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpBench\Dom;

/**
 * Wrapper for the \DOMDocument class.
 */
class Document extends \DOMDocument implements XPathAware
{
    /**
     * @var XPath
     */
    private $xpath;

    /**
     * @param string $version
     * @param mixed  $encoding
     */
    public function __construct($version = '1.0', $encoding = null)
    {
        parent::__construct($version, $encoding);
        $this->registerNodeClass('DOMElement', 'PhpBench\Dom\Element');
    }

    /**
     * Create and return a root DOM element.
     *
     * @param string $name
     *
     * @return Element
     */
    public function createRoot($name)
    {
        return $this->appendChild(new Element($name));
    }

    /**
     * Return the XPath object bound to this document.
     *
     * @return XPath
     */
    public function xpath()
    {
        if ($this->xpath) {
            return $this->xpath;
        }

        $this->xpath = new XPath($this);

        return $this->xpath;
    }

    /**
     * {@inheritdoc}
     */
    public function query($query, \DOMNode $context = null)
    {
        return $this->xpath()->query($query, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function queryOne($query, \DOMNode $context = null)
    {
        return $this->xpath()->queryOne($query, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($expression, \DOMNode $context = null)
    {
        return $this->xpath()->evaluate($expression, $context);
    }

    /**
     * Return a formatted string representation of the document.
     *
     * @return string
     */
    public function dump()
    {
        $this->formatOutput = true;
        $result = $this->saveXml();
        $this->formatOutput = false;

        return $result;
    }

    public function duplicate()
    {
        $dom = new self();
        $firstChild = $dom->importNode($this->firstChild, true);

        $dom->appendChild($firstChild);

        return $dom;
    }
}
