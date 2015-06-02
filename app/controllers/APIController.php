<?php 

use Illuminate\Database\Eloquent\ModelNotFoundException;

class APIController extends BaseController {

    public function __construct($model = null, $message = '') {
        if($model == null) return;
        
		App::error(function(ModelNotFoundException $e) {
			if($e->getModel() == $model) {
				return Blacklist::json(array(
					'message'	=> $message,
				), 404);
			}
		});
    }
}