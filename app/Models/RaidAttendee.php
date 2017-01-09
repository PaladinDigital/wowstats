<?php namespace WoWStats\Models;

use WoWStats\Models\Character;

class RaidAttendee extends Model
{
    protected $table = 'raid_attendees';

    protected $hidden = [];

    protected $fillable = ['raid_id', 'character_id'];

    public static function valid($data)
    {
        $rules = [
            'raid_id' => ['required', 'integer', 'min:1'],
            'character_id' => ['required', 'integer', 'min:1'],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        return false;
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
