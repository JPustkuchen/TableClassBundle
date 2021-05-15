**Symfony (5) Bundle to represent a HTML Table as Object structure of typical elements like Header, Rows, Cells and the possibility to set Attributes (& classes especially) on all elements in PHP Code.**

Helpful especially in combination with [DataTables](https://datatables.net/), but completely flexible and not bound to that context. To use in combination with DataTables, set the required classes and require [DataTables](https://datatables.net/) yourself. NOT included in this bundle!
If you'd like to use AJAXified DataTables with Symfony, have a look at: https://github.com/omines/datatables-bundle
I didn't need that complexity and missed some flexibility instead, which lead me to this project.

# Example (in Symfony Controller)
```php

use JPustkuchen\TableClassBundle\Elements\TableRow;
use JPustkuchen\TableClassBundle\TableFactory;

class TsfAgDefaultController extends AbstractController
{
  public function indexAction(Request $request, TableFactory $tableFactory): Response
  {
        $results = [/* Your database query results or custom array as keyed array with row keys as value keys */
          ['col1' => 'Row 1 Cell 1 Value', 'col2' => 'Row 1 Cell 2 Value'],
          ['col1' => 'Row 2 Cell 1 Value', 'col2' => 'Row 2 Cell 2 Value'],
          // ...
        ];
        
        // TableFactory via dependency injection
        $tableMain = $tableFactory->createTable()
          // Set DataTable classes (optional - just as example)
          ->addClassesFromArray(['ui', 'selectable', 'celled', 'striped', 'stackable', 'table'])
          ->setHeaderFromArray([
            'col1' => 'Col 1 Header Label',
            'col2' => 'Col 2 Header Label',
            'tableActions' => 'Actions Example Row',
          ])->addRowsFromArray($results);
          // Alternatively you could also add rows and cols manually by ->addRow() or ->addColumn().

        // Iterate rows for actions on the data:
        $tableMain->iterateRows(function (TableRow $row, $index) {
          // Add classes based on cell values:
          $cellRow1 = $row->getCellbyKey('row1');
          $cellRow1Value = $cellRow1->getValue();
          if ($y) {
            // Add class 'warning' to row if condition is met
            $row->addClass('warning');
          }
          if ($z) {
            // Add class 'error' to cell if condition is met
            $cellRow1->addClass('error');
          }
          return $row;
        });

        // The contained table.html.twig expects the table array structure in the key 'tabledata':
        return $this->render('table.html.twig', [
          'tabledata' => $tableMain->toArray(),
        ]);
    }
}
```

# Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require jpustkuchen/tableclass-bundle
```

## Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require jpustkuchen/tableclass-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    <vendor>\<bundle-name>\<bundle-long-name>::class => ['all' => true],
];
```

### Step 2: Use where you need it, for example in a Controller to create and render a table

**See example above!**

*Important: The built-in ->render() function doesn't work yet, if someone knows what's missing in the bundle to make Symfony Twig render the template, please help. Currently the bundles template / view directory isn't considered by Twig as it seems?!*

**Until that you'll have to copy the table.html.twig template from the bundle into your templates directory and use that to render the table by Twig include!**

The contained **table.html.twig** file is highly customizable by using blocks extensively.

### OPTIONAL: Use with DataTables.net

Simply require datatables.net, for example by:
~~~
npm install datatables.net
~~~

And require it in your app.js, for example like this:
~~~
const dt = require('datatables.net');
window.$.DataTable = dt;
window.dt = dt;
~~~

Then you'll have to wrap the table.html.twig in a parent twig file containing the datatables.net initialisation, for example like this (or any other way):
```php
{# prettier-ignore-start #}
<script>
  $( document ).ready(function() {
    $('#' + '{{id|default('datatable')|escape('html_attr')}}').DataTable({/* Optional datatables.net Options */});
  });
</script>
{# prettier-ignore-end #}
<div id="{{ id|default('datatable')|escape('html_attr') }}-wrapper" class="datatable-wrapper">
  {% include 'table.html.twig' %}
</div>
```
In our example we additionally used a table wrapper element, for more flexibility, for example to use scrolling tables, if needed. This part is also optional.
