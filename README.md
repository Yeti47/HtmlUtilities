# HtmlUtilities
A PHP utility library for easily and quickly generating HTML content.
This is just a little something I threw together to simplify my work with PHP and HTML and to standardize the way HTML content is produced within my PHP code.

# Usage

## Simple HTML tags
```PHP
<?php

include 'HtmlUtilities.php';

// Create a new instance of the HtmlTag class and pass the type of the tag as a string.
$htmlParagraph = new HtmlTag('p');

// Now there are a number of ways to work with this new tag.

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
$htmlCode = $htmlParagraph->Surround('I got my own personal class attribute.');

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
Technically, you can use the above HtmlTag class to generate lists in HTML. However, there is a shorter, much more convenient way to do this.

```PHP
<?php

include 'HtmlUtilities.php';

// Define the data that we want to display in an HTML list.
$listData = [ 'PHP', 'JavaScript', 'Python', 'Ruby', 'Perl' ];

// Create an HTML List. The first argument in the constructor determines whether the list is ordered or unordered.
// In this case it is unordered.
$htmlList = new HtmlList(false, $listData);

// Get the HTML code for the list.
$htmlCode = $htmlList->GenerateList();

/* $htmlCode now stores the following string:
 *
 * <ul>\n
 *     <li>PHP</li>\n
 *     <li>JavaScript</li>\n
 *     <li>Python</li>\n
 *     <li>Ruby</li>\n
 *     <li>Perl</li>\n
 * <ul>
 *
 */

// Print the HTML code.
echo $htmlCode;

// Or output the code directly using:
$htmlList->EchoList();

// For ordered lists, we just pass true as the first argument of the constructor.
$orderedList = new HtmlList(true, $listData);

// Or we can call the SetOrdered method
$htmlList.SetOrdered(true);

// Of course, we can also add attributes to our list just like we can with any other type of HTML element.
$htmlList->CreateAttribute('id', 'scriptingLanguages');

?>

```

## Tables
There's also a class for quickly generating HTML tables. Please note that currently the library only supports tables where every row has the same number of columns. 

```PHP
<?php

include 'HtmlUtilities.php';

// Create a new HTML table with 3 rows and 2 columns.
$htmlTable = new HtmlTable(3, 2);

// Set the content of the table's fields by providing the index of the column and the row as well as the actual content.
$htmlTable->SetFieldContent(0, 0, 'English');
$htmlTable->SetFieldContent(1, 0, 'PHP is my friend.');
$htmlTable->SetFieldContent(0, 1, 'German');
$htmlTable->SetFieldContent(1, 1, 'PHP ist mein Freund.');
$htmlTable->SetFieldContent(0, 2, 'Spanish');
$htmlTable->SetFieldContent(1, 2, 'PHP es mi amigo.');

// Mark the first column in each row as a table header (<th>).
for($row = 0; $row < 3; $row++)
    $htmlTable->SetHeader(0, $row);

// Print the table.
$htmlTable->EchoTable();

?>
```

In your browser, this would produce the following output:

<table>
  <tr>
    <th>English</th>
    <td>PHP is my friend.</td>
  </tr>
  <tr>
    <th>German</th>
    <td>PHP ist mein Freund.</td>
  </tr>
  <tr>
    <th>Spanish</th>
    <td>PHP es mi amigo.</td>
  </tr>
</table>

Tables can also be created by providing one or two dimensional arrays:

```PHP
<?php
include 'HtmlUtilities.php';

// Create a one dimensional array containing the data for the table to generate. We'll leave the translation
// into Greek blank, because I have no clue how to say 'hello' in Greek.
$tableData = [ "English", "Hello", "German", "Hallo", "Spanish", "Hola", "Greek" ];

// Create an instance of HtmlTable by passing the array to the static CreateFromArray method.
// Also, we need to pass the number of columns in each row. Since the number of items in our array
// is 7 and therefore not a multiple of 2, the leftover columns will be left empty.
$table = HtmlTable::CreateFromArray($tableData, 2);

// Print the table.
$table->EchoTable();

?>
```

This will result in the following output:

<table>
<tr>
<td>English</td><td>Hello</td>
</tr>
<tr>
<td>German</td><td>Hallo</td>
</tr>
<tr>
<td>Spanish</td><td>Hola</td>
</tr>
<tr>
<td>Greek</td><td></td>
</tr>
</table>


Alternatively, we can use a two dimensional array like this:

```PHP
<?php
include 'HtmlUtilities.php';

// Define the two dimensional array containing the data for each row.
$tableData2D = [ ["English", "Hello"], ["German", "Hallo"], ["Spanish", "Hola"], ["Greek"] ];

// Pass the array to the static CreateFromArray2D method.
$table2D = HtmlTable::CreateFromArray2D($tableData2D);

// Print the table.
$table2D->EchoTable();

?>
```

This will leave us with the same result as the previous example.

### The ITableRow interface

Another way to automatically generate HTML table code is to have a class implement the ITableRow interface and then pass an array of instances of that class to the HtmlTable::CreateFromTableRows method. The ITableRow interface provides the method GetTableRowData which determines how the class instance is displayed in a table.

Let's take a look at an example. Say we have a class called Person.

```PHP
<?php

class Person implements ITableRow {

    private $_firstname;
    private $_lastname;
    private $_street;
    private $_city;
    private $_state;
    private $_postcode;
    
    public function __construct($firstname, $lastname, $street, $city, $state, $postcode) {
    
        $this->_firstname = $firstname;
        $this->_lastname = $lastname;
        $this->_street = $street;
        $this->_city = $city;
        $this->_state = $state;
        $this->_postcode = $postcode;
       
    
    }
    
    public function GetAddress() {
    
        return "$this->_street - $this->_city $this->_state - $this->_postcode";
    
    }

    public function GetTableRowData() {
        
        return [
        
            $this->_firstname,
            $this->_lastname,
            $this->GetAddress()
        
        ];
        
    }

}

?>
```

As you can see, the GetTableRowData method simply returns an array that represents the content of each field in a table's row.
With this class given, we can do something like this:

```PHP
<?php
include 'HtmlUtilities.php';

// Create a few instances of Person
$john = new Person('John', 'Doe', '356 Some Street', 'Awesometown', 'AZ', '33617');
$finn = new Person('Finn', 'Mertens', '47 Treehouse Ave.', 'Candy Kingdom', 'CK', '47823');
$laura = new Person('Laura', 'Kinney', '23 Mutant Boulevard', 'Seattle', 'WA', '98109');

// Put the instances into an array for convenience
$people = [ $john, $finn, $laura ];

// Pass the array to the method to generate the table.
$table = HtmlTable::CreateFromTableRows($people);

// Print the table.
$table->EchoTable();

?>
```

This would give us the following output:

<table>
<tr>
<td>John</td><td>Doe</td><td>356 Some Street - Awesometown AZ - 33617</td>
</tr>
<tr>
<td>Finn</td><td>Mertens</td><td>47 Treehouse Ave. - Candy Kingdom CK - 47823</td>
</tr>
<tr>
<td>Laura</td><td>Kinney</td><td>23 Mutant Boulevard - Seattle WA - 98109</td>
</tr>
</table>


If we also want to display an additional row with headers, we can pass an optional second argument.

```PHP
<?php
include 'HtmlUtilities.php';

// Create a few instances of Person
$john = new Person('John', 'Doe', '356 Some Street', 'Awesometown', 'AZ', '33617');
$finn = new Person('Finn', 'Mertens', '47 Treehouse Ave.', 'Candy Kingdom', 'CK', '47823');
$laura = new Person('Laura', 'Kinney', '23 Mutant Boulevard', 'Seattle', 'WA', '98109');

// Put the instances into an array for convenience
$people = [ $john, $finn, $laura ];

// Define an array with headers to use.
$headers = [ 'Firstname', 'Lastname', 'Address' ];

// Pass the people array as well as the headers array to the method.
$table = HtmlTable::CreateFromTableRows($people, $headers);

// Print the table.
$table->EchoTable();

?>
```

This would result in the same output, except now our table has an additional header row.

<table>
<tr>
<th>Firstname</th><th>Lastname</th><th>Address</th>
</tr>
<tr>
<td>John</td><td>Doe</td><td>356 Some Street - Awesometown AZ - 33617</td>
</tr>
<tr>
<td>Finn</td><td>Mertens</td><td>47 Treehouse Ave. - Candy Kingdom CK - 47823</td>
</tr>
<tr>
<td>Laura</td><td>Kinney</td><td>23 Mutant Boulevard - Seattle WA - 98109</td>
</tr>
</table>


And again, you can add attributes to the table using the same ol' CreateAttribute method.

## Shorthand methods

### Print a &lt;br&gt; tag:
HtmlTag::EchoBR();

### Print $n &lt;br&gt; tags:
HtmlTag::EchoBR($n);

# License
The project is available under the MIT License.

Author: Alexander Herrfurth
