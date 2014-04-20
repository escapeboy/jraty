Laravel 4 Rating Package
=====

Rating Package using jQuery Raty plugin for item ratings + optional microdata format.


![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "1")
![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "2")
![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "3")
![alt text](http://wbotelhos.com/raty/lib/images/star-off.png "4")
![alt text](http://wbotelhos.com/raty/lib/images/star-off.png "5")

The package is doing everything for you - from displaying rating to receiving rating and stores it into database.

***
Installation
=====
```
{
    ...
    "require": {
        "escapeboy/jraty": "dev-master"
    }
}
```
Register in `app/config/app.php`
```php
'providers' => array(
    'Escapeboy\Jraty\JratyServiceProvider',
)
```
Creating table for ratings
```
php artisan migrate --package="escapeboy/jraty"
```
Publish jQuery Raty assets
```
php artisan asset:publish escapeboy/jraty
```
Prepare for usage
====
First you need to load jQuery
```html
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
```
then need to load Raty plugin. You can use it like this:
```php
echo Jraty::js()
```
or
```html
<script src="packages/escapeboy/jraty/raty/lib/jquery.raty.min.js"></script>
```
After we need to initialize Raty plugin.

Using library:
```php
echo Jraty::js_init($params=array());
```
Jraty::js_init accepts array with options for Raty. More info can be found on [Raty website](http://wbotelhos.com/raty)

For example this and it is default:
```php
Jraty::js_init(array(
    'score' => 'function() { return $(this).attr(\'data-score\'); }',
    'number' => 5,
    'click' => 'function(score, evt) {
                $.post(\'save/item_rating\',{
                    item_id: $(\'[data-item]\').attr(\'data-item\'),
                    score: score
                });
              }',
    'path' => '\'packages/escapeboy/jraty/raty/lib/img\''
));
```
returns
```javascript
$(document).ready(function () {
    $('#item-rating').raty({
        'score': function () {
            return $(this).attr('data-score');
        },
        'number': 5,
        'click': function (score, evt) {
            $.post('save/item_rating', {
                item_id: $('[data-item]').attr('data-item'),
                score: score
            });
        },
        'path': 'packages/escapeboy/jraty/raty/lib/img'
    });
});
```
**Important:** If you noticed in php call single quotes are escaped.

Usage
=====
```php
echo Jraty::html($item_id, $item_name='', $item_photo='', $seo=true);
```
*If you are using seo option (true by default) its good to set a item_name*

And result will be 
![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "1")
![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "2")
![alt text](http://wbotelhos.com/raty/lib/images/star-on.png "3")
![alt text](http://wbotelhos.com/raty/lib/images/star-off.png "4")
![alt text](http://wbotelhos.com/raty/lib/images/star-off.png "5")

*Library is accepting only one rating per item from single IP.*

Additional
----
Deleting record
```php
Jraty::delete($id)
```
Adding manual rating
```php
$data = array(
    		'item_id'    => Input::get('item_id'),
			'score'      => Input::get('score'),
			'added_on'   => DB::raw('NOW()'),
			'ip_address' => Request::getClientIp()
		);
Jraty::add($data);
```
Getting rating data for item
```php
$rating = Jraty::get($item_id);
echo $rating->avg; // avarage score
echo $rating->votes; // total votes
```
