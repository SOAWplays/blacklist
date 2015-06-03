<?php 

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends BaseController {
    
    public function __construct() {
        App::error(function(ModelNotFoundException $e) {
			if($e->getModel() == 'Plugin') {
				return Blacklist::json(array(
					'message'	=> 'Invalid plugin identifier',
				), 404);
			}
		});
    }

    public function getIndex() {
        return Blacklist::json(
            Profile::paginate(50)
        );
    }
    
    public function getProfile($type = '', $id = -1) {
        if(empty($type) || !in_array($type, Blacklist::profiles())) {
            return Blacklist::json(array(
                'message'   => "Invalid profile type \"$type\"",
                'valid'     => Blacklist::profiles()
            ), 400);    
        }
        
        if($id == -1 || empty($id) || empty($type)) { 
            throw with(new ModelNotFoundException)->setModel('Profile'); 
        }
        
        $type = strtolower($type);
        $profile = Profile::where('type', '=', $type);
        if(is_numeric($id)) {
            $profile = $profile->where('report_id', '=', $id)->first();
        } else {
            $profile = $profile->where('name', '=', $id)->first();
        }
        
        if($profile == null) throw with(new ModelNotFoundException)->setModel('Profile');
        return Blacklist::json($profile);
    }
    
}