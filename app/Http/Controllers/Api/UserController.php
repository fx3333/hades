<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){
        $token = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        if($token) {
            // return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
            
            return $this->setStatusCode(201)->success([
                'token' => $token,
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60,
                ]);
        }
        return $this->failed('账号或密码错误',400);
    }

    /**
     * 删除token
     * @return mixed
     */
    public function loginOut(){
        // return $this->success('退出成功...');
        // auth('api')->logout();
        auth('api')->logout();
        return response(null, 204);
    }

    /**
     * 刷新token
     *
     * @return void
     */
    public function updateToken()
    {
        // echo "asdf";die;
        $token = auth('api')->refresh();
        return $this->setStatusCode(201)->success([
            'token' => $token,
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60,
            ]);
        // return $this->respondWithToken($token);
    }


    /**
     * 返回当前登录用户信息
     * @param Request $request
     * @return mixed
     */
    public function info(Request $request){

        $user = $request->user();
        return $this->success($user);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function register(Request $request)
    {
        // echo 1;die;
        $member = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];
        
        $flag=User::create($member);
        // var_dump($member,$flag);die;
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changePw(Request $request)
    {
        $user = $request->user();
        $user->update(['password' => bcrypt($request->password)]);
        $token = Auth::guard('api')->refresh();
        return $this->setStatusCode(201)->setToken($token)->success('修改密码成功');
    }

}

