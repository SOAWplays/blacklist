<?php

class Blacklist {
    
    public static function json($data, $status = 200, $headers = []) {
        if(self::debug()) {
            return Response::json($data, $status, $headers, JSON_PRETTY_PRINT);
        }
        return Response::json($data, $status, $headers);
    }
    
    public static function debug() {
        return Config::get('app.debug');
    }
    
    public static function title() {
        if(Route::currentRouteName() == 'plugins') return "The Blacklist: Plugins";
        if(Route::currentRouteName() == 'users') return "The Blacklist: Users";
        return "The Blacklist";
    }
    
}