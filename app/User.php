<?php

namespace WoWStats;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WoWStats\Models\Character;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return ($this->admin == 1);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public static function getCount()
    {
        $results = DB::select('select COUNT(*) as count from users');
        return $results[0]->count;
    }

    public function __debugInfo()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'characters' => $this->characters,
        ];
    }
}
