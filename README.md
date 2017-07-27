# HtmlUtilities
A PHP utility library for easily and quickly generating HTML content.
This is just a little something I threw together to simplify my work with PHP and HTML and to unify the way HTML content is produced within my PHP code.

# Usage

## Simple HTML tags
```PHP
<?php

include 'HtmlUtilities.php';

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

$htmlParagraph->EchoSurround('This is an HTML paragraph. Yay!'); // prints the HTML code for the paragraph

?>
```

## Attributes
Of course, HTML is not really fun and hardly of any use without attributes.

```PHP
<?php

include 'HtmlUtilities.php';

// Create a new HTML paragraph;
$htmlParagraph = new HtmlTag('p');

// Add a 'class' attribute with the value 'my-paragraph'.
$htmlParagraph->CreateAttribute('class', 'my-paragraph');

// Returns "<p class=\"my-paragraph\">I got my own personal class attribute.</p>";
$htmlCode = $htmlParagraph->EchoSurround('I got my own personal class attribute.');

// Print an HTML paragraph with the class 'my-paragraph'.
echo $htmlCode;

// Assign an additional 'style' attribute with the value 'color:blue' to the paragraph tag.
$htmlParagraph->CreateAttribute('style', 'color:blue');

// Print a paragraph with class 'my-paragraph' and BLUE font color.
$htmlParagraph->EchoSurround('I am as blue as Edgar Allan Poe.');

// We can update the element's attributes like this:
// Since we already printed the blue paragraph on the screen, we can safely update it's style attribute and just reuse
// the same HTMLTag instance.
$htmlParagraph->UpdateAttribute('style', 'color:red');

// Print a paragraph with class 'my-paragraph' and RED font color.
$htmlParagraph->EchoSurround('I am as red as love and anger combined.');

?>
```

## Lists
Technically, you can use the above HthmlTag class to generate lists in HTML. However, there is a shorter, much more convenient way to do this.

```PHP

<?php

inlcude 'HtmlUtilities.php';

// Define the data that we want to display in an HTML list.
$listData = [ 'PHP', 'JavaScript', 'Python', 'Ruby', 'Perl' ];

// Create an HTML List. The first argument in the constructor determines whether the list is ordered or unordered.
// In this case it is unordered.
$htmlList = new HtmlList(false, $listData);

// Get the HTML code for the list.
$htmlCode = $htmlList->GenerateList();

/* $htmlCode now stores the following string:
 *
 * <ul>
 *     <li>PHP</li>
 *     <li>JavaScript</li>
 *     <li>Python</li>
 *     <li>Ruby</li>
 *     <li>Perl</li>
 * <ul>
 *
 */

// Print the HTML code.
echo $htmlCode;

// Or output the code directly using:
$htmlList->EchoList();

// For ordered lists, we just pass true as the first argument of the constructor.
$orderedList = new HtmlList(true, $listData);

// Or we can call the SetOrdered method (
$htmlList.SetOrdered(true);


?>

```
