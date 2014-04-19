<?php
Route::post('save/item_rating', function()
{
	$data = array(
			'item_id'    => Input::get('item_id'),
			'score'      => Input::get('score'),
			'added_on'   => DB::raw('NOW()'),
			'ip_address' => Request::getClientIp()
		);
	Jraty::add($data);
});
?>