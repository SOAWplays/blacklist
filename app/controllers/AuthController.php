<?php

class AuthController extends BaseController {
    
    public function getIndex() {
        if(Auth::check()) {
            return Redirect::route('home');
        }
        return Redirect::action(__CLASS__ . '@getLogin');
    }
    
    public function getList() {
        return Blacklist::json(User::paginate(25));
    }
    
    public function getLogout() {
        if(Auth::check()) {
            Auth::logout();
        }
        return Redirect::route('home');
    }
    
    public function getLogin() {
        if(Auth::check()) {
            return Redirect::route('home');
        }
        return View::make('auth.login');
    }
    
    public function getRegister() {
        if(Auth::check()) {
            return Redirect::route('home');
        }
        return View::make('auth.register');
    }
    
    public function postLogin() {
        $missing = array();
        
        if(!Input::has('email')) {
            array_push($missing, 'email');    
        }
        
        if(!Input::has('password')) {
            array_push($missing, 'password');    
        }
        
        if(!empty($missing)) {
            return Blacklist::json(array(
                'message'   => 'Missing required fields',
                'fields'    => $missing
            ), 400);
        }
        
        $remember = false;
        if(Input::has('remember')) {
            $remember = Input::get('remember') == true ? true : false;    
        }
        
        $data = array(
            'email'     => Input::get('email'),
            'password'  => Input::get('password')  
        );
        
        if(Auth::attempt($data, $remember)) {
            return Blacklist::json(array(
                'message'   => 'Login successful!',
                'redirect'  => URL::route('home'),
            ));
        }
        
        return Blacklist::json(array(
            'message'   => 'Login failed, incorrect email or password',
        ), 400);
    }
    
    public function postRegister() {
        if(!Input::has('captcha')) {
            return Blacklist::json(array(
                'message'   => 'Invalid captcha provided!'
            ), 400);
        }
        
        $captcha = new \ReCaptcha\ReCaptcha(Config::get('app.captcha', ''));
        if($captcha == '') {
            return Blacklist::json(array(
                'message'   => 'Captcha not set by site administrator!'
            ), 500);
        }
        
        $response = $captcha->verify(Input::get('captcha'), Request::getClientIp());
        if(!$response->isSuccess()) {
            return Blacklist::json(array(
                'message'   => 'You failed the captcha!'
            ), 400);
        }
        
        $missing = array();
        if(!Input::has('name')) {
            array_push($missing, 'name');
        }
        
        if(!Input::has('email')) {
            array_push($missing, 'email');    
        }
        
        if(!Input::has('password')) {
            array_push($missing, 'password');    
        }
        
        if(!Input::has('confirm')) {
            array_push($missing, 'confirm');    
        }
        
        if(!empty($missing)) {
            return Blacklist::json(array(
                'message'   => 'Missing required fields',
                'fields'    => $missing
            ), 400);
        }
        
        $user = new User;
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = Input::get('password');
        $user->password_confirmation = Input::get('confirm');

        if(!$user->save()) {
            return Blacklist::json(array(
                'message'   => 'Registration failed!',
                'failed'    => $user->errors()->all()
            ), 400);
        }
        
        Auth::login($user);
        return Blacklist::json(array(
            'message'   => 'Registration successful!',
            'redirect'  => URL::route('home'),
        ));
    }
}