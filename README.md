DOM
===

This library provides a wrapper for the PHP DOM library which makes your life
easier.

It wraps the `\DOMDocument`, `\DOMElement` and `\DOMXpath` classes.`

Example:

```php
$dom = new Document();
$element = $dom->createRoot('example');
$element->appendChild('boo', 'hello');
$element->appendChild('baz', 'world');

echo $dom->saveXml();
// <?xml version="1.0"?>
// <example>
//   <boo>hello</boo>
//   <baz>world</baz>
// </example>

$element->appendChild('number', 5);
$element->appendChild('number', 10);

echo $element->evaluate('sum(./number)'); // 15

$nodeList = $element->query('./number');

echo $nodeList->length; // 2
```

Document
--------

The `PhpBench\Dom\Document` class wraps the `\DOMDocument` class and replaces the
`\DOMElement` class with the `PhpBench\Dom\Element` class.

It implements the `XPathAware` interface.

- `createRoot($name, $value = null)`: Create and return a new root node with `$name` and optional
  `$value`.
- `query($query, $context = null)`: Execute a given XPath query on the
  document.
- `queryOne($query, $context = null)`: Execute a given XPath query on the
  document and return the first element or `NULL`.
- `evaluate($query, $context = null)`: Evaluate the given XPath expression.

Element
-------

- `appendElement($name $value)`: Create and return an element with name
  `$name` and value `$value`.
- `query`, `queryOne` and `evalauate`: As with Document but will use the context of this element by
  default.
