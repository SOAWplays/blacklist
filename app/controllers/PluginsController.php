<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PluginsController extends \BaseController {
	
	function __construct() {
		App::error(function(ModelNotFoundException $e) {
			if($e->getModel() == 'Plugin') {
				return Blacklist::json(array(
					'message'	=> 'Invalid plugin ID',
				), 404);
			}
		});
		
		$this->beforeFilter('csrf', array(
			'except' => array(
				'index',
				'show'
			)
		));
	}

	/**
	 * Display a listing of the resource.
	 * GET /plugins
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Plugin::paginate(15);
		return Blacklist::json($data);
	}
	
	/**
	 * Display a listing of the resource.
	 * GET /plugins/{id}
	 *m
	 * @return Response
	 */
	public function show($id) 
	{
		$plugin = Plugin::findOrFail($id);
		return Blacklist::json($plugin);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /plugins
	 *
	 * @return Response
	 */
	public function store()
	{
		$plugin = new Plugin;
		$plugin->url = Input::get('url');
		$plugin->name = Input::get('name');
		$plugin->reason = Input::get('reason');
		
		if(!$plugin->save()) {
			return Blacklist::json(array(
				'message' 	=> 'Input failed validation',
				'failed'	=> $plugin->errors()->all(),
			), 400);
		}
		return Blacklist::json(array(
			'message'	=> 'Plugin was created!',
			'plugin'	=> $plugin
		));
	}
	
	/**
	 * Update the specified resource in storage.
	 * PUT /plugins/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$plugin = Plugin::findOrFail($id);
		
		if(Input::has('name')) {
			$plugin->name = Input::get('name');
		}
		
		if(Input::has('active')) {
			$plugin->active = Input::get('active') == 'true' ? true : false;
		}
		
		if(Input::has('reason')) {
			$plugin->reason = Input::get('reason');
		}
		
		if(Input::has('url')) {
			$plugin->url = Input::get('url');
		}
	
		if(!$plugin->save()) {
			return Blacklist::json(array(
				'message' 	=> 'Input failed validation',
				'failed'	=> $plugin->errors()->all(),
			), 400);
		}
		
		return Blacklist::json(array(
			'message' 	=> 'Plugin was updated!',
			'plugin'	=> $plugin
		));
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /plugins/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$plugin = Plugin::findOrFail($id);
		if($plugin->delete() == null) {
			return Blacklist::json(array(
				'message'	=> 'Unable to delete plugin due to internal server error!'
			), 500);	
		}
		return Blacklist::json(array(
			'message'	=> 'Plugin deleted!'
		));
	}

}