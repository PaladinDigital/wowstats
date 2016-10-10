<?php namespace WoWStats\Models;

class Metric extends Model
{
    protected $table = 'metrics';

    protected $fillable = ['id', 'name'];

    public static function getMetricId($attribute)
    {
        try {
            $attr = Metric::where('name', $attribute)->firstOrFail();
            return $attr->id;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function exists($attribute)
    {
        try {
            $attr = Metric::where('name', $attribute)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function createIfNotExist($metric)
    {
        if (!self::exists($metric)) {
            Metric::create(['name' => $metric]);
        } else {
            return false;
        }
    }
}