> This file describes the general coding conventions that are to be used throughout this repository. Please check that your code follow it fully before submitting a pull request.

# Coding Conventions for PHP Source Files
Files in this category includes only those files that either have extension of ".php" or files that contains at least one block of PHP code.
The above mentioned files should follow the following coding conventions:
* **Character Encoding** MUST be set to UTF-8.
* **Line Endings** MUST be set to Windows (CRLF).
* **Letters in filenames** MUST be all lowercase WITHOUT spaces. Use hyphen(-) instead of spaces if spaces are REALLY required.
* There should be a blank line after opening and before closing of every `<?php` tag.
* There should be a block of comment that explain the code block before every block of code as follows:
```php
<?php

/**
 * Get active website bloggers with profile photo for author page.
 * If no photo exists on website, check intranet.
 * If neither location has photo, send user email to upload one.
 */
foreach ($users as $user) {
	if ($expr1) {
		// ...
	} else {
		// ...
	}
	if ($expr2) {
		// ...
	} elseif ($expr3) {
		// ... 
	} else {
		// ...
	}
	// ...
}

?>
```
* While using a **variable from included/external file** a single line comment MUST tell about the referenced file.
* **Purpose of include file** must be mentioned using a single line comment.
* **Line Indentation** must be implemented using Spaces **(1 tab = 4 spaces)**.
* **Logical blocks of code** MUST be separated using a blank line.
* **Keywords** MUST all be lowercase
* **Variables and Function Names** MUST be declared lowercase and wods MUST be separated by an underscore.
* **Class Names** MUST be lowercase with every word starting with an uppercase alphabet. **No spaces in class names.**
* **CONSTANTS** MUST all be uppercase and words MUST be separated by underscore.
* **Operators** MUST be surrounded by a space.
* **Unary Operators** MUST be attacked to their variable or integer.
* **Concatenation Period** MUST be surrounded by a space.
* **Single Quotes** MUST be used unless you're evaluating something in a string.


# Coding Conventions for JavaScript Source Files

* **Use === Instead of ==**.
* The use of short hand is not allowed.
* Highly Prioratize Script must be placement at the bottom of the page.
* Try to keep variable decleration **outside** of for-loops as much as possible. For example:-
```javascript
var container = document.getElementById('container');
for(var i = 0, len = someArray.length; i < len;  i++) {
   container.innerHtml += 'my number: ' + i;
   ...
}
```
* **Global variables** should be used as less as possible.
* Put all declarations at the top of each script or function.
* Always use **var** before variable decleration. Also always initialize variables after decleration.
* **Line Indentation** must be implemented using Spaces **(1 tab = 4 spaces)**.
* **Single Quotes** MUST be used unless you're evaluating something in a string.
* **Concatenation +** MUST be surrounded by a space. 
* **Variables and Function Names** MUST be declared lowercase and words MUST be separated by an underscore.
* **Class Names** MUST be lowercase with every word starting with an uppercase alphabet. **No spaces in class names.**
* **CONSTANTS** MUST all be uppercase and words MUST be separated by underscore. Also constants must be defined as follows:-
```javascript
const NUMERIC_CONSTANT = 42;
```
* **Operators** MUST be surrounded by a space.
* For new oBject creation, use the following code syntax:-
```javascript
var new_obj = {....};
```
* Use **[]** Instead of **New Array()** for array creation.
* Incase of long list of variables use the following syntax
```javascript
var someItem = 'some string',
    anotherItem = 'another string',
    oneMoreItem = 'one more string';
```
* **ALWAYS, FOR THE LOVE OF ALL THAT IS GOOD, ALWAYS USE SEMICOLONS**.
* To make a function run automatically when a page loads, or a parent function is called use the following syntax:-
```javascript
(function doSomething() {
   return {
      name: 'jeff',
      lastName: 'way'
   };
})();
```
* Always end switch statements with a default.



