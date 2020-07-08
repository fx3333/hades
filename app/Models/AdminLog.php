<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'status',
        'type',
        'remark',
        'extra',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
        'extra'=>"array",
    ];


    public function getExtraAttribute($value)
    {
        return $value;
    }

    /**
     * 添加日志
     *
     * @return void
     */
    public static function addLog($data){

        // $insert_data['user_id']=isset($data['user_id'])?intval($data['user_id']):"0";
        // $insert_data['status']=isset($data['status'])?$data['status']:"0";
        // $insert_data['type']=isset($data['type'])?$data['type']:"";
        // $insert_data['remark']=isset($data['status'])?$data['remark']:"";
        // $insert_data['extra']=isset($data['extra'])?$data['extra']:[];
        // AdminLog::query()->firstOrCreate($insert_data);

        $log = new AdminLog();
        $log->user_id = isset($data['user_id'])?intval($data['user_id']):"0";
        $log->status = isset($data['status'])?$data['status']:"0";
        $log->type = isset($data['type'])?$data['type']:"";
        $log->remark = isset($data['status'])?$data['remark']:"";
        $log->extra = isset($data['extra'])?$data['extra']:[];

        $log->save();


        

    }
}
