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

    public static function exists($metric)
    {
        $metrics = Metric::where('name', $metric)->get();
        return (count($metrics) > 0);
    }

    public static function createIfNotExist($metric)
    {
        if (!Metric::exists($metric)) {
            Metric::create(['name' => $metric]);
        } else {
            return false;
        }
    }
}
