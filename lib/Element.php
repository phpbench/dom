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

use DOMNode;
use DOMNodeList;

/**
 * Wrapper for the \DOMElement class.
 */
class Element extends \DOMElement implements XPathAware
{
    /**
     * Create and append a text-node with the given name and optionally given value.
     *
     * @param string $name
     * @param string $value
     *
     * @return Element
     */
    public function appendTextNode($name, $value = null)
    {
        $element = $this->appendChild(new self($name, $this->owner()->createTextNode($value)));
        assert($element instanceof Element);

        return $element;
    }
    
    /**
     * Create and append an element with the given name and optionally given value.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return Element
     */
    public function appendElement($name, $value = null)
    {
        $element = $this->appendChild(new self($name, $value));
        assert($element instanceof Element);

        return $element;
    }

    /**
     * @return DOMNodeList<DOMNode>
     */
    public function query($xpath, DOMNode $context = null): DOMNodeList
    {
        return $this->owner()->xpath()->query($xpath, $context ?: $this);
    }

    public function queryOne($xpath, DOMNode $context = null)
    {
        return $this->owner()->xpath()->queryOne($xpath, $context ?: $this);
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($expression, DOMNode $context = null)
    {
        return $this->owner()->xpath()->evaluate($expression, $context ?: $this);
    }

    /**
     * Dump the current node
     */
    public function dump(): string
    {
        $document = new Document();
        $document->appendChild($document->importNode($this, true));

        return $document->dump();
    }

    private function owner(): Document
    {
        $owner = $this->ownerDocument;
        assert($owner instanceof Document);

        return $owner;
    }
}
