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
 * Wrapper for the \DOMElement class.
 */
class Element extends \DOMElement implements XPathAware
{
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
        return $this->appendChild(new self($name, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function query($xpath, \DOMNode $context = null)
    {
        return $this->ownerDocument->xpath()->query($xpath, $context ?: $this);
    }

    public function queryOne($xpath, \DOMNode $context = null)
    {
        return $this->ownerDocument->xpath()->queryOne($xpath, $context ?: $this);
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($expression, \DOMNode $context = null)
    {
        return $this->ownerDocument->xpath()->evaluate($expression, $context ?: $this);
    }
}
