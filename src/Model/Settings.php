<?php
namespace WFN\Admin\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Settings extends Model
{
    const MEDIA_PATH = 'general' . DIRECTORY_SEPARATOR;

    protected $fillable = [
        'name', 'value'
    ];

    protected static $configCache = [];

    public static function getConfigValueUrl($name)
    {
        return self::getConfigValue($name) ? Storage::url(self::MEDIA_PATH . self::getConfigValue($name)) : false;
    }

    public static function getConfigValue($name)
    {
        if(!isset(self::$configCache[$name])) {
            $config = self::where('name', $name)->first();
            self::$configCache[$name] = $config ? $config->getAttribute('value') : false;
        }
        return self::$configCache[$name];
    }

    public static function getConfigValueArray($name)
    {
        return self::getConfigValue($name) ? json_decode(self::getConfigValue($name), true) : [];
    }

    public static function getConfig($name)
    {
        $config = self::where('name', $name)->first();
        $config = $config ?: new self();
        $config->setAttribute('name', $name);
        return $config;
    }

    public function setValue($value)
    {
        return $this->setAttribute('value', $value);
    }

}
