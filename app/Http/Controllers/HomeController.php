<?php
namespace App\Http\Controllers;


use App\Goodscategory;
use App\Goodsinfo;
use App\Http\Data\Encrypt;
use App\Http\Requests\SellerRegisterPost;
use App\Order;
use App\Sellerinfo;
use App\Usercollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{

    /**
     * 分类列表
     */
    public function Goodscategorylist()
    {
        $category = Goodscategory::all();
//        dd($category);
        return $category;
    }

    /**
     * 商品列表
     */
    public function goodslist()
    {
        $goods = Goodsinfo::all();
        return $goods;
    }

    /**
     * 订单列表
     */
    public function orderlist()
    {
        $order = Order::all();
        return $order;
    }

    /**
     * 收藏列表
     */
    public function collectionlist()
    {
        $collection = Usercollection::all();
        return $collection;
    }

    /**
     * 商家注册
     */
    public function sellerregister(SellerRegisterPost $request)
    {
        $info = $request->all();
        $info['user_head'] = $info['user_head'] ?: 'https://ceshi.rongyao.huobanys.com/img/doctor.png';


        $user = new Sellerinfo();
        $user->id = Encrypt::createid();
        $user->username = $info['username'];
        $user->password = Encrypt::my_md5($info['password']);
        $user->user_head = $info['user_head'];
        $res = $user->save();

        if ($res){
            return Response::HTTP_OK;
        }else{
            return Response::HTTP_CONTINUE;
        }
//        return $uuid;
    }


}