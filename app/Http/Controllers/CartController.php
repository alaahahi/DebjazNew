<?php

namespace App\Http\Controllers;

use App\Product;
use App\SystemSetting;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Currency;
use Session;
class CartController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency_def= Session::get('currency') ? Session::get('currency') :'SEK';
        $systemInfo = SystemSetting::first(); 

        $mightAlsoLike = Product::inRandomOrder()->with('photos')->take(4)->get();
        $currency = Currency::where('currency', strtoupper($currency_def))->first();
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::subtotal() - $discount);
        $newTotal = $newSubtotal;

        return view('cart', compact('mightAlsoLike', 'systemInfo','currency'))->with([
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTotal' => $newTotal,
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency_def= Session::get('locale') ? Session::get('locale') :'it';
       // dd($request->card);
        // dd($request->all());
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id  === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            session()->flash('success', "$request->name already in your cart!");

            return redirect(route('cart.index'));
        }
        if($currency_def == "it")
        {
       
        Cart::add($request->id, $request->name_sw, $request->card, $request->quantity, $request->price, ['size' => $request->Size, 'color' => $request->Color])->associate('App\Product');
        session()->flash('success', "$request->name_sw added to your cart successfully!");
        }
        if($currency_def == "ar")
        {
        Cart::add($request->id, $request->name_ar, $request->card, $request->quantity, $request->price, ['size' => $request->Size, 'color' => $request->Color])->associate('App\Product');
        session()->flash('success', "$request->name_ar added to your cart successfully!");
        }
        if($currency_def == "en")
        {
        Cart::add($request->id, $request->name, $request->card, $request->quantity, $request->price, ['size' => $request->Size, 'color' => $request->Color])->associate('App\Product');
        session()->flash('success', "$request->name added to your cart successfully!");
        }

        return redirect(route('cart.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd(Cart::content());

        Cart::update($id, $request->quantity, $request->card);

        session()->flash('success', "Item updated successfully!");

        return redirect(route('cart.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);

        session()->flash('success', "Item removed successfully!");

        return redirect()->back();
    }

}
