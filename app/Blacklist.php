<?php

class Blacklist {
    
    const PROFILE_MINECRAFTFORUM = 'mcf';
    const PROFILE_MCMARKET = 'market';
    const PROFILE_SPIGOT = 'spigot';
    
    private static $names = array(
        self::PROFILE_MINECRAFTFORUM    => 'Minecraft Forums',
        self::PROFILE_MCMARKET          => 'MCMarket',
        self::PROFILE_SPIGOT            => 'Spigot',
    );
    
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
    
    public static function alias($id) {
        if(!in_array($id, self::profiles())) return;
        return self::$names[$id];
    }
    
    public static function profiles() {
        return array(self::PROFILE_MINECRAFTFORUM, self::PROFILE_MCMARKET, self::PROFILE_SPIGOT);
    }
    
}