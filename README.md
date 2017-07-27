# HtmlUtilities
A PHP utility library for easily and quickly generating HTML content.
This is just a little something I threw together to simplify my work with PHP and HTML and to unify the way HTML content is produced within my PHP code.

# Usage

## Simple HTML tags

```PHP
<?php

// Create a new instance of the HtmlTag class and pass the type of the tag as a string.
$htmlParagraph = new HtmlTag('p');

// Now there are a number ways to work with this new tag.

// Get the HTML code for an opening tag.
$openTag = $htmlParagraph->GetFullTagOpen(); // returns '<p>'

// Get the HTML code for a closing tag.
$closeTag = $htmlParagraph->GetFullTagClose(); // returns '</p>'

// Use the tag to output HTML code.
echo "$openTag This is an HTML paragraph. Yay! $closeTag";

// This can be simplified using the Surround method.

// Generate a string containing HTML code.
$htmlCode = $htmlParagraph->Surround('This is an HTML paragraph. Yay!'); // returns '<p>This is an HTML paragraph. Yay!</p>'

// Print the paragraph.
echo $htmlCode;

// If you want to output the code directly, this can be simplified even further using:

$htmlParagraph->EchoSurround('This is an HTML paragraph. Yay!'); // prints the html code for the paragraph

?>
```
