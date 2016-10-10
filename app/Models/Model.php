<?php namespace WoWStats\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public static function getCount()
    {
        $results = DB::select('select COUNT(*) as count from self::table');
        return $results[0]->count;
    }
}
