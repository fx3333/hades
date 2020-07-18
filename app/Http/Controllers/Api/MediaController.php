<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Models\Image;
use App\Http\Resources\ImageResource;
use Illuminate\Support\Str;
use App\Services\SudokuService;

class MediaController extends Controller
{
    //

    public function imgStore(Request $request, ImageUploadHandler $uploader, Image $image)
    {

        $user = auth('api')->user();
        // $user = $request->user();
        // var_dump($user);die;

//        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size = false);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user()->associate($user);
        $image->storage_type = Image::STORAGE_TYPE_IMAGE;
        $image->save();

        return new ImageResource($image);
    }

    /**
     * 数独问题处理
     *
     * @return void
     */
    public function calc(SudokuService $sudokuService){

        $data=[];
        

        //初始化题目
        // $data=[
        //     [0,0,0,0,0,3],
        //     [0,0,3,6,0,0],
        //     [0,0,0,0,1,2],
        //     [5,1,0,0,0,0],
        //     [0,0,6,2,0,0],
        //     [4,0,0,0,0,0],
        // ];

        $data=[
            [1,0,3],
            [2,0,0],
            [0,0,2],
        ];

        $result=$sudokuService->handle($data);

        return $this->setStatusCode(200)->success('解题成功');



    }

    
}
