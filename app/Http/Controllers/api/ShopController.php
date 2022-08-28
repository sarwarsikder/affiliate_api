<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Models\UserShopFollow;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryShop = Shop::query();
        $queryShop->with('shop_following');

        if (isset($request['filter']['follow'])) {
            if ($request['filter']['follow'] == 1) {
                $queryShop->whereHas('shop_following',function ($query){
                    $query->where('follow', 1);
                });
            }
        }else{
            $queryShop->with('shop_following');
        }

        if (isset($request['filter']['recent_added'])) {
            if ($request['filter']['recent_added'] == 1) {
                $queryShop->orderBy('id', 'desc');
            }
        }

        $queryResult = $queryShop->paginate(10);

        return ShopResource::collection($queryResult);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ShopResource(Shop::findOrFail($id));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function shop_follow_unfollow(Request $request)
    {


        $user_shop_follow_model = new UserShopFollow();

        $user_shop_follow_model_data = $user_shop_follow_model::where('user_id', auth()->user()->id)
            ->where('shop_id', $request['shop_id'])
            ->get();


        if (count($user_shop_follow_model_data) <= 0) {
            $user_shop_follow_model->follow = !$request['follow'];
            $user_shop_follow_model->user_id = auth()->user()->id;
            $user_shop_follow_model->shop_id = $request['shop_id'];
            $user_shop_follow_model->save();
        } else {
            $user_shop_follow_model = $user_shop_follow_model::find($user_shop_follow_model_data[0]->id);
            $user_shop_follow_model->follow = !$request['follow'];
            $user_shop_follow_model->save();
        }

        if ($user_shop_follow_model->follow) {
            return response()->json(['message' => 'Shop successfully followed'], 201);
        } else {
            return response()->json(['message' => 'Shop successfully unfollowed'], 201);
        }
    }

}
