<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\UserProductClaim;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $queryProduct = Product::query();
        $queryProduct->with('shop');
        $queryProduct->with('product_category');

        if (isset($request['filter']['claim'])) {
            if ($request['filter']['claim'] == 1) {
                $queryProduct->whereHas('product_claimed', function ($query) {
                    $query->where('claim', 1);
                });
            }
        } else {
            $queryProduct->with('product_claimed');
        }

        if (isset($request['filter']['available'])) {
            if ($request['filter']['available'] == 1) {
                $queryProduct->WhereDoesntHave('product_claimed');
            }
        }

        $queryProduct->orderBy('id', 'desc');
        $queryResult = $queryProduct->paginate(10);

        return ProductResource::collection($queryResult);
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
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function product_claim(Request $request)
    {
        $user_product_claim_model = new UserProductClaim();

        $user_product_claim_model_data = $user_product_claim_model::where('user_id', auth()->user()->id)
            ->where('product_id', $request['product_id'])
            ->get();

        if (count($user_product_claim_model_data) <= 0) {
            $user_product_claim_model->user_id = auth()->user()->id;
            $user_product_claim_model->product_id = $request['product_id'];
            $user_product_claim_model->claim = 1;
        } else {
            return response()->json(['message' => 'Product already claimed'], 200);
        }

        if ($user_product_claim_model->save()) {
            return response()->json(['message' => 'Product successfully claimed'], 201);
        }
    }
}
