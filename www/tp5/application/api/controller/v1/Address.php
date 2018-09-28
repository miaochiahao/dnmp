<?php
/**
 * Created by shmilyelva
 * Date: 2018-09-28
 * Time: 12:00
 */

namespace app\api\controller\v1;
use app\api\validate\AddressValidate;
use app\api\service\Token as TokenService;
use app\api\model\User as modelUser;
use app\lib\exception\UserException;
use app\lib\exception\SuccessException;

class Address
{
    public function saveAddress()
    {
        $validate = new AddressValidate();
        $validate->goCheck();
        /**
         * 根据Token获取uid
         * 用uid查找用户是否存在
         * 获取用户提交的数据
         * 判断数据是否已存在，不存在则添加，存在则更新
         */
        $uid = TokenService::getCurrentUid();
        $user = modelUser::getUserById($uid);
        if (!$user) {
            throw new UserException();
        }
        $filterData = $validate->getDataByRule(request()->post());
        if(!$user->address){//新增
            $user->address()->save($filterData);
        }else {
            $user->address->save($filterData);
        }
//        return new SuccessException();
        return json(new SuccessException())->code(201);//http状态码
    }
}