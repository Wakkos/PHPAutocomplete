# Autocomplete with PHP / MySQL and jQuery
This is an auto comlete I created for a project but it's been usefull in other projects, so I isolated it.

## The SEARCH part
Whenever the input changes an event triggers a PHP query (in `query.php`) and search for that input in the `airports` and `cities` table in the `airport_iata`, `airport_name` and `city_name` respectively to get a list of possible results based on IATA code, Airport Name or City name.

The query on the file `query.php` has a limit or 15, change or remove as you need.

## The ADD part
When we click ADD, it splits the result incoming from `query.php` and paints it on the DOM after inserting the selected airport in the `userairports` table.

## Keep in mind
- We need a `$userId` to insert the values with the current user (I have done it with `$_SESSION['id']` before, currently I just added a `2` so it gets user with ID 2)
- The database is included, it has all the airports and cities and some users, but you can adapt this to whatever you want.
- All `.php` files have a DB conection hardcoded.
- I used jQuery because it was easier, I did some of the Ajax with FETCH instead. Feel fre to refactor as you like (Pull Requests are welcome if you remove jQuery ;D)

