Symfony (5) Bundle to represent a HTML Table as Class with Header, Rows and the possibility to set Attributes (& classes especially) on all elements in PHP Code.
Helpful especially to use with DataTables

# Example (in Symfony Controller)
```php

use JPustkuchen\TableClassBundle\Elements\TableRow;
use JPustkuchen\TableClassBundle\TableFactory;

class TsfAgDefaultController extends AbstractController
{
  public function indexAction(Request $request, TableFactory $tableFactory): Response
  {
        $results = [/* Your database query results or custom array as keyed array*/]
        $tableMain = $tableFactory->createTable()
        // Set DataTable classes (optional - just as example)
          ->addClassesFromArray(['ui', 'selectable', 'celled', 'striped', 'stackable', 'table'])
          ->setHeaderFromArray([
            'row1' => 'Row 1 Label',
            'row2' => 'Row 2 Label',
            'tableActions' => 'Actions Example Row',
          ])->addRowsFromArray($results);

        // Iterate rows for actions on the data:
        $tableMain->iterateRows(function (TableRow $row, $index) {
          // Mark red if condition $y
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

        return $this->render('yourTwigTemplate.twig', [
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

See example above!
*Important: The built-in ->render() function doesn't work yet, if someone knows what's missing in the bundle to make Symfony Twig render the template, please help. Currently the bundles template / view directory isn't considered by Twig as it seems?!*

**Until that you'll have to copy the table.html.twig template from the bundle into your templates directory and use that to render the table by Twig include!**
