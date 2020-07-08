<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Image extends Model
{
    //
    const STORAGE_TYPE_IMAGE = 'image';
    const STORAGE_TYPE_VIDEO = 'video';

    public static $storage_type_map = [
        self::STORAGE_TYPE_IMAGE => '图片',
        self::STORAGE_TYPE_VIDEO => '视频',
    ];

    protected $fillable = [
        'type', 
        'path',
        'user_id',
        'storage_type',
        'target_id',
        'target_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target()
    {
        return $this->morphTo();
    }

    /**
     * @param $id
     * @return array|string
     * 获取图片路径
     */
    public static function getPathById($id,$type=1)
    {
        $image = Image::query()->select('id','path','user_id')->find($id);
        if($image){
            switch($type){
                case 1:
                    return [
                        'id' => $image->id,
                        'url' => $image->path,
                        'name' => $image->type == 'user' ? '' : $image->user->name ?? '',
                    ];
                case 2:
                    return $image->path;
                default:
                    return '';
            }
            
        }else{
            return '';
        }
    }

    public static function getImagesByJsonArray($images,$type=1)
    {
        $images = Assert::isJson($images) ? json_decode($images,1) : $images;
        if(is_array($images) && count($images)){
            foreach ($images as &$image){
                if(!is_numeric($image)){
                    $image = '';
                    continue;
                }
                if(!Str::startsWith($image, ['http://', 'https://'])){
                    $image = Image::getPathById($image,$type);
                }
            }
        }
        return $images;
    }
}
