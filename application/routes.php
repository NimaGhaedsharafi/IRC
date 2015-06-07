<?php

#Basic GET Routes
Route::get('', array('before' => 'loggedin', 'uses' => 'login@index' , 'as' => 'base'));
Route::get('login',array('before' => 'loggedin', 'as' => 'login_form' , 'uses' => 'login@index' ));
Route::post('login',array( 'before' => 'csrf', 'as' => 'login_attempt', 'uses' => 'login@index' ));
Route::get('logout',array('as' => 'logout' , 'uses' => 'login@logout' ));
Route::get('admin',array('before' => 'auth|admin_permission_check', 'as' => 'admin', 'uses' => 'discussion@index' ));
Route::get('staff',array('before' => 'auth|staff_permission_check', 'as' => 'staff', 'uses' => 'discussion@index' ));
Route::get('redirect',array('as' => 'redirect_to', 'uses' => 'login@redirect'));
Route::get('download/(:all)',array( 'before' => 'auth', 'as' => 'download', function($url){ $url = Misc::decrypt($url); return Response::download($url); }));


# Elements Routes
Route::group(array('before' => 'staff_permission_check|auth'), function(){

	Route::get('element/add', array('as' => 'add_element' , 'uses' => 'elements@add'));
	Route::post('element/add', array( 'before' => 'csrf', 'as' => 'add_element' , 'uses' => 'elements@add'));
	Route::get('element/(:num)/edit', array('as' => 'edit_element' , 'uses' => 'elements@edit'));
	Route::post('element/edit', array( 'before' => 'csrf', 'as' => 'edit_element' , 'uses' => 'elements@edit'));
	Route::get('element/show', array('as' => 'show_elements' , 'uses' => 'elements@show'));
	Route::get('element/(:num)/remove', array('as' => 'remove_element' , 'uses' => 'elements@remove'));	
	Route::post('element/name', array('as' => 'element_name' , 'uses' => 'elements@element_name'));
});

# Admin Routes
Route::group(array('before' => 'admin_permission_check|auth'), function()
{	
	Route::get('user/add', array('as' => 'add_user' , 'uses' => 'users@add'));
	Route::post('user/add', array( 'before' => 'csrf', 'as' => 'add_user' , 'uses' => 'users@add'));
	Route::get('user/show/(:any?)/(:any?)', array('as' => 'show_users' , 'uses' => 'users@show'));
	Route::get('remove_users/(:num)', array('as' => 'remove_user' , 'uses' => 'users@remove'));
	Route::get('user/change_password/(:num)', array('as' => 'change_password' , 'uses' => 'users@change_password'));
	Route::post('user/change_password', array('before' => 'csrf', 'as' => 'change_password' , 'uses' => 'users@change_password'));
	Route::get('user/edit/(:num?)', array('as' => 'edit_user' , 'uses' => 'users@edit'));
	Route::post('user/edit', array( 'before' => 'csrf', 'as' => 'edit_user' , 'uses' => 'users@edit'));
});

# Discussion Routes
Route::group(array('before' => 'staff_permission_check|auth'), function(){

	Route::get('discussion/add', array('as' => 'add_discussion', 'uses' => 'discussion@add'));
	Route::get('discussion/(:num?)/add', array('as' => 'add_discussion', 'uses' => 'discussion@add'));
	Route::post('discussion/add', array('before' => 'csrf', 'as' => 'add_discussion', 'uses' => 'discussion@add'));
	Route::get('discussion', array('as' => 'discussions_list', 'uses' => 'discussion@index'));
	Route::get('discussion/(:num)/show', array('as' => 'view_discussion', 'uses' => 'discussion@show'));
	Route::post('discussion/reply', array('before' => 'csrf', 'as' => 'reply_post', 'uses' => 'discussion@reply_post'));

});

# ChangeLog Route
Route::group(array('before' => 'staff_permission_check|auth'), function() {

	Route::get('changelog/(:num)/show', array( 'as' => 'show_changelog', 'uses' => 'changelog@show' ));
	Route::get('changelog/(:num)/delete', array( 'as' => 'delete_changelog', 'uses' => 'changelog@delete' ));
	Route::get('changelog/new', array( 'as' => 'new_changelog', 'uses' => 'changelog@new' ));
	Route::get('changelog/add', array( 'as' => 'add_changelog', 'uses' => 'changelog@add' ));
	Route::post('changelog/add', array( 'as' => 'add_changelog', 'uses' => 'changelog@add' ));
	Route::get('changelog/(:any?)/(:any?)', array( 'as' => 'list_changelog', 'uses' => 'changelog@index' ));
});

# Groups Routes
Route::group(array('before' => 'admin_permission_check'), function() {

	Route::get('groups/new', array( 'as' => 'new_group', 'uses' => 'group@new' ));
	Route::get('groups/edit', array( 'as' => 'edit_group', 'uses' => 'group@edit' ));
	Route::get('groups/(:num)/show', array( 'as' => 'show_group', 'uses' => 'group@show' ));
	Route::get('groups/(:num)/delete', array( 'as' => 'delete_group', 'uses' => 'group@destory' ));
	Route::get('groups', array('as' => 'group_index', 'uses' => 'group@index'));

	Route::post('groups/edit', array( 'before' => 'csrf', 'as' => 'edit_group', 'uses' => 'group@update' ));
	Route::post('groups/add', array( 'before' => 'csrf', 'as' => 'add_group', 'uses' => 'group@create' ));
});


Route::group(array('before' => 'staff_permission_check|auth'), function()
{	
	Route::get('view_profile/(:num?)', array('before' => 'auth', 'as' => 'view_profile', 'uses' => 'users@view_profile'));
	Route::get('edit_user/(:num?)', array('as' => 'edit_user' , 'uses' => 'users@edit'));
});

#Filter Access Routes
Route::get('denied' ,array('as' => 'denied' , function () { return View::make('error.denied'); } ));
Route::get('invalid' ,array('as' => 'invalid', function () { return View::make('error.invalid'); } ));

# ------------------------------------------------------------------------------------------------------ #

#									EVENT LISTENER AND FILTERS 											 #

# ------------------------------------------------------------------------------------------------------ #

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if ( Auth::guest() ) return Redirect::to_route('login_form');
});

Route::filter('loggedin', function()
{
	if ( Auth::check() ) return Redirect::to_route('redirect_to')->with('msg' , 'ابتدا وارد سایت شوید');
});

Route::filter('staff_permission_check', function()
{
	if ( Auth::User()->acl > 1 ) return Redirect::to_route('denied');
});

Route::filter('admin_permission_check', function()
{
	if ( Auth::User()->acl != 0 ) return Redirect::to_route('denied');
});

