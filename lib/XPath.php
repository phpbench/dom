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
 * Wrapper for the \DOMXPath class.
 */
class XPath extends \DOMXPath
{
    /**
     * {@inheritdoc}
     */
    public function evaluate($expr, \DOMNode $contextEl = null, $registerNodeNs = null)
    {
        $result = $this->execute('evaluate', 'expression', $expr, $contextEl, $registerNodeNs);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function query($expr, \DOMNode $contextEl = null, $registerNodeNs = null)
    {
        return $this->execute('query', 'query', $expr, $contextEl, $registerNodeNs);
    }

    /**
     * Query for one node.
     */
    public function queryOne($expr, \DOMNode $contextEl = null, $registerNodeNs = null)
    {
        $nodeList = $this->query($expr, $contextEl, $registerNodeNs);

        if (0 === $nodeList->length) {
            return;
        }

        return $nodeList->item(0);
    }

    /**
     * Execute the given xpath method and cactch any errors.
     */
    private function execute($method, $context, $query, \DOMNode $contextEl = null, $registerNodeNs)
    {
        libxml_use_internal_errors(true);

        $value = @parent::$method($query, $contextEl, $registerNodeNs);

        $xmlErrors = libxml_get_errors();
        if ($xmlErrors) {
            $errors = [];
            foreach ($xmlErrors as $xmlError) {
                $errors[] = sprintf('[%s] %s', $xmlError->code, $xmlError->message);
            }
            libxml_clear_errors();

            throw new Exception\InvalidQueryException(sprintf(
                'Errors encountered when evaluating XPath %s "%s": %s%s',
                $context, $query, PHP_EOL, implode(PHP_EOL, $errors)
            ));
        }

        libxml_use_internal_errors(false);

        return $value;
    }
}
