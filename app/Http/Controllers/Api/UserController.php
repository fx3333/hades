<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $guard = 'api';

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){

        $name=isset($request->name)?$request->name:"";
        $password=isset($request->password)?$request->password:"";
        $token = Auth::guard('api')->attempt(['name'=>$name,'password'=>$password]);
        if($token) {
            // return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
            $user = \Auth::guard($this->guard)->user();
            // echo $user->id;die;
            //操作日志添加
            AdminLog::addLog([
                "user_id"=>$user->id,
                "status"=>'1',
                "type"=>'login',
                "remark"=>"".$user->name."登录成功",
                "extra"=>"",
            ]);
            
            return $this->setStatusCode(201)->success([
                'token' => $token,
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60,
                ]);
        }

        //操作日志添加
        AdminLog::addLog([
            "user_id"=>"0",
            "status"=>'0',
            "type"=>'login',
            "remark"=>"账号:".$name.",密码:".$password."登录失败",
            "extra"=>"",
        ]);
        return $this->failed('账号或密码错误',400);
    }

    /**
     * 修改个人信息
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request,User $user){

        $user->fill($request->all());
        $user->save();

        return $this->success($user);



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
        $password=isset($request->password)?$request->password:"";
        $user->update(['password' => bcrypt($password)]);
        $token = Auth::guard('api')->refresh();


        //操作日志添加
        AdminLog::addLog([
            "user_id"=>"".$user->id,
            "status"=>'1',
            "type"=>'changePw',
            "remark"=>"新密码修改为:".$password."",
            "extra"=>"",
        ]);
        return $this->setStatusCode(201)->setToken($token)->success('修改密码成功');
    }


    /**管理人员列表 */
    public function list(Request $request){

    }

}

