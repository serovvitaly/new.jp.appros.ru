<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    public $table = 'action_log';

    protected $fillable = ['user_id', 'action', 'json_data'];

    public static function action($name, array $data = [])
    {
        $user_id = 0;

        $user = \Auth::user();

        if ($user) {
            $user_id = $user->id;
        }

        return self::create([
            'user_id' => $user_id,
            'action' => $name,
            'json_data' => json_encode($data),
        ]);
    }
}
