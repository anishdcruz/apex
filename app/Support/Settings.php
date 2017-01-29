<?php
namespace App\Support;

use Cache;
use File;

class Settings {

    protected $config;

    public function __construct()
    {
        $this->config = $this->read();
    }

    public function get($key)
    {
        return array_get($this->config, $key);
    }

    public function set($key, $value)
    {
        array_set($this->config, $key, $value);
        $this->write();
    }

    public function read()
    {
        return Cache::remember('settings.all', 60 * 24, function() {
            return json_decode(File::get(storage_path('app/settings.json')), true);
        });
    }

    public function write()
    {
        Cache::forget('settings.all');
        File::put(storage_path('app/settings.json'), json_encode($this->config));
    }
}