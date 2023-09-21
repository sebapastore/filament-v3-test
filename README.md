# Filament V3 Test

### Description
* The purpose of this project is to try Filament PHP version 3 and find out if is possible to build a "Header/Detail" form.

### List of features to try
* ✅ Customer CRUD.
* ✅ Item CRUD.
* ✅ Create Sale with N items.
* ✅ Calculate total price for each item, multiplying by quantity on real time. 
* Calculate sale total price in real time.
* Save sale and sale detail with custom Action and extra validation.
* Make Unit and Feature tests.
* Evaluate to use static analysis.

### Conclusions
* Use ```Filament\Forms\Components\Repeater``` to add N "details" to a "header" in a form.
* Use ```Filament\Forms\Components\Placeholder``` with ```content(function (Forms\Get $get) { ... }``` to show a "calculated data" in a form such as "total price".
* Use ```live()``` function in conjunction with ```content()``` in order to refresh the placeholder when another input changes.
* Use ```->mask(RawJs::make(<<<'JS' $money($input) JS))``` to format a number with thousands separator in a form.
