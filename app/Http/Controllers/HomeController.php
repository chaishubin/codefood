<?php
namespace App\Http\Controllers;


use App\Goodscategory;
use App\Goodsinfo;
use App\Order;
use App\Usercollection;
use Illuminate\Http\Request;

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
    public function sellerregister(Request $request)
    {
        $username = $request->all();
        return $username;
    }


}