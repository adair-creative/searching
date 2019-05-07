# Searching
## About
A tool for flexible and advanced search functionality including:
* CMS Analytics
* Search term routing
* Non-intrusive implementation

## Installation
```bash
composer require adair-creative/searching
```

## Guide
### Basic Usage
```php
use AdairCreative\Searching;

class YourPage_Controller extends PageController {
	 public function index(HTTPRequest $request) {
		if ($query = $request->getVar('q')) {
			return $this->customise([
				"Results" => Searching::search(Product::class, "Title", $search);
			]);
		}
	}
}
```
### Term Linking
```php
// ...

$link = null;
$resources = Searching::search(Product::class, "Title", $query, $link, true);

if ($link != null) {
	if ($link->Type == 1) return $this->redirect($link->Redirect()->Link());
	else $query = $link->Substitute;
}

// ...
```

## Reference
### AdairCreative\Searching
>_function_ `search()` : _ArrayList_
>>_string_|_string[]_ `$from` - The model(s) to search from
>
>>_string_|_string[]_ `$fieldName` - The field(s) to search from, if array items will map to corresponding model
>
>>_string_ `$query` - Value to seach with; trimmed and no-case
>
>>**Default _null_** _TermLink_ `&$term` - A pointer to the first found term (null if none)
>
>>**Default _false_** _bool_ `$useSubstitute` - When _true_, If `$term` is of type substitute then update `$search` to the substitute value

### AdairCreaitve\Searching\TermLink
> _string_ `$Term` - the search term to override

> _int_ `$Type` - The action to perform on override
>
>> 0 - Use substitute
>
>> 1 - Use redirect

> _string_ `$Substitute` - The search value substitute

> _function_ `Redirect()` : _SiteTree_