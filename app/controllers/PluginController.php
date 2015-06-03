<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PluginController extends BaseController {
	
	public function __construct() {
        App::error(function(ModelNotFoundException $e) {
			if($e->getModel() == 'Plugin') {
				return Blacklist::json(array(
					'message'	=> 'Invalid plugin identifier',
				), 404);
			}
		});
		
		$this->beforeFilter('json', array(
			'except' => array(
				'index',
				'show'
			)	
		));
		
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
		if(Input::has('limit')) {
			$limit = Input::get('limit');
			if(is_numeric($limit)) {
				$data = Plugin::paginate(intval($limit));
			}
		}
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
		$plugin->reasons = Input::get('reasons');
		
		if(Input::has('active')) {
			$plugin->active = Input::get('active') == 'true' ? true : false;
		}
		
		if(!$plugin->save()) {
			return Blacklist::json(array(
				'message' 	=> 'Input failed validation',
				'failed'	=> $plugin->errors()->all(),
			), 400);
		}
		return Blacklist::json(array(
			'message'	=> 'Plugin was created!',
			'link'		=> URL::route('api.plugins.show', array($plugin->id)),
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
			if($plugin->name != Input::get('name')) {
				$plugin->name = Input::get('name');
			}
		}
		
		if(Input::has('active')) {
			$value = Input::get('active') == 'true' ? true : false;
			if($plugin->active != $value) {
				$plugin->active = $value;
			}
		}
		
		if(Input::has('reasons')) {
			if($plugin->reasons != Input::get('reasons', array())) {
				$plugin->reasons = Input::get('reasons', array());
			}
		}
		
		if(Input::has('url')) {
			if($plugin->url != Input::get('url')) {
				$plugin->url = Input::get('url');
			}
		}
		
		if(!$plugin->isDirty()) {
			return Blacklist::json(array(
				'message'	=> 'No changes made!',
				'link'		=> URL::route('api.plugins.show', array($plugin->id)),
				'plugin'	=> $plugin
			));
		}
	
		if(!$plugin->save()) {
			return Blacklist::json(array(
				'message' 	=> 'Input failed validation',
				'failed'	=> $plugin->errors()->all(),
			), 400);
		}
		
		return Blacklist::json(array(
			'message' 	=> 'Plugin was updated!',
			'link'		=> URL::route('api.plugins.show', array($plugin->id)),
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