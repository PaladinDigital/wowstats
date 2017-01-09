<?php namespace WoWStats\Models;

class Attributes extends Model
{
    protected $table = 'attributes';

    protected $fillable = ['id', 'name'];

    public static function getAttributeId($attribute)
    {
        try {
            $attr = Attributes::where('name', $attribute)->firstOrFail();
            return $attr->id;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function exists($attribute)
    {
        try {
            $attr = Attributes::where('name', $attribute)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function createIfNotExist($attribute)
    {
        if (!self::exists($attribute)) {
            Attributes::create(['name' => $attribute]);
        } else {
            return false;
        }
    }
}
