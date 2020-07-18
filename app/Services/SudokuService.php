<?php


namespace App\Services;
use App\Exceptions\InvalidRequestException;
use App\Models\UserRelease;
use App\Models\Release;
/**
 * 数独处理
 */
class SudokuService
{
   protected $initdata=[];

   protected $skip_data=[];//处理的步骤
   protected $length=0;//处理的步骤的长度
   protected $tmp_data=[];


   /** 解决数独问题 */
   public function handle($data){

    $this->initdata=$data;
    $this->tmp_data=$data;

    $this->getSkipdata();


    $skip_len=count($this->skip_data);
    echo $skip_len;

    for($i=1;$i<=$skip_len;$i++){
        for($j=1;$j<=$skip_len;$j++){

        }

    }



    die;

   }

   /**注入数据后，判断是否合理
    * 每一行每一列不能有重复的数据
    */
   public function isValide(){

   }

   public function getSkipdata(){

    $this->length=count($this->initdata);
    //echo $length;
    $result=[];
    foreach($this->initdata as $k1=>$v1){
        foreach($v1 as $k2=>$v2){
            if($v2==0){
                $result[]=[
                    "tran"=>$k1,
                    "cross"=>$k2,
                ];
            }
        }


    }

    // echo json_encode($result);
    $this->skip_data=$result;
   }
}
