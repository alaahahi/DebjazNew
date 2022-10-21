<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use App\Product;
use App\Category;
use App\SubCategory;
use App\ProductAttribute;
use App\OrderProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\CreateProductRequest;
use Illuminate\Support\Facades\DB;
use PDF;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('verifyCategoryCount')->only('create', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->with('photos', 'category', 'subCategory')->paginate(10);
        $orderProduct = OrderProduct::all();
       

        return view('admin.products.index', compact('products','orderProduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $subCategories = SubCategory::all();

        return view('admin.products.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        // dd($request->all());
        
        $product = Product::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'name_sw' => $request->name_sw,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'description_sw' => $request->description_sw,
            'gift' => $request->gift,
            'gift_ar' => $request->gift_ar,
            'gift_sw' => $request->gift_sw,
            'gift_description' => $request->gift_description,
            'gift_description_ar' => $request->gift_description_ar,
            'gift_description_sw' => $request->gift_description_sw,
            'code' => $request->code,
            'price' => $request->price,
            'is_new' => $request->is_new,
            'on_sale' => $request->on_sale,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'slug' => Str::slug($request->name),
            'start' => $request->start,
            'winner' => $request->winner,
            'end' =>  ($request->category_id ==1 ? date('Y-m-d', strtotime($request->start. ' + 1 days')) : $request->category_id ==9 ) ? date('Y-m-d', strtotime($request->start. ' + 3 days')) : ''  ,
            'early' => date('Y-m-d', strtotime($request->start. ' + 1 days')),
        ]);

        foreach ($request->images as $photo) {
            $name = Str::random(14);

            $extension = $photo->getClientOriginalExtension();

            $image = Image::make($photo)->fit(1200, 1200)->encode($extension);

            Storage::disk('public')->put($path = "products/{$product->id}/{$name}.{$extension}", (string) $image);

            $photo = Photo::create([
                'images' => $path,
                'product_id' => $product->id,
            ]);
        }

        $attributeValues = $request->attribute_value;

        $product->attributes()->createMany(
            collect($request->attribute_name)
                ->map(function ($name, $index) use ($attributeValues) {
                    return [
                        'attribute_name' => $name,
                        'attribute_value' => $attributeValues[$index],
                    ];
                })
        );

        session()->flash('success', "$request->name added successfully.");

        return redirect(route('products.index'));


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
    public function edit(Product $product)
    {
        $categories = Category::all();

        $subCategories = SubCategory::all();

        // $productSubCategory = $product->subcategory()->get();

        // dd($productSubCategory);
    //    $attributes = $product->attributes()->get();

        return view('admin.products.create', compact('product', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
        ]);
        $data = $request->only(['name',  'name_ar','name_sw','description_ar','description_sw','gift','gift_ar','gift_sw','gift_description','gift_description_ar','gift_description_sw','code', 'description', 'price', 'category_id', 'sub_category_id', 'quantity', 'meta_description', 'meta_keywords', 'is_new', 'on_sale','start','end','winner','draw_date']);
        //dd($data);
        $product->update($data);

        if($request->hasFile('images')) {

            foreach ($request->images as $photo) {
                $name = Str::random(14);

                $extension = $photo->getClientOriginalExtension();
                //$image = Image::make($photo)->fit(1200, 1200)->encode($extension);
                $image = Image::make($photo)->encode($extension);

                Storage::disk('public')->put($path = "products/{$product->id}/{$name}.{$extension}", (string) $image);

                $photo = Photo::create([
                    'images' => $path,
                    'product_id' => $product->id,
                ]);
            }
        }



        session()->flash('success', "$product->name updated successfully.");

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // delete all product images
        $allImages = $product->photos;

        foreach ($allImages as $key => $img) {
            Storage::disk('public')->delete($img->images);
        }

        $product->photos()->delete();
        //delete product
        $product->attributes()->delete();

        $product->delete();

        session()->flash('success', "$product->name deleted successfully.");

        return redirect(route('products.index'));
    }
    public function print(Request $product,$id,$order_id="")
    {
        //session()->flash('success', "$product->name print successfully.");

        $product =  DB::table('order_product')
        ->join('orders', 'orders.id', '=', 'order_product.order_id')
        ->join('products', 'products.id', '=', 'order_product.product_id')
        ->where('order_product.product_id',  $id  );
        if( $order_id != "")
        {
        $products=$product->where('order_product.order_id', $order_id)->select(['products.name','products.description','products.price','products.gift','products.gift_description','orders.order_number','orders.billing_fullname', 'orders.billing_phone' ,'orders.created_at','order_product.quantity'])
        ->get();
        }
        else
        {
        $products=$product->select(['products.name','products.description','products.price','products.gift','products.gift_description','orders.order_number','orders.billing_fullname', 'orders.billing_phone' ,'orders.created_at','order_product.quantity'])
        ->get();
        }       
        //return response()->json($id );
        //Product::orderBy('created_at', 'DESC')->with('photos', 'category', 'subCategory');


     
        return  view('report.card_from_to_pdf', compact('products'));
        $new="ALL";

        return $pdf->download(' '.$new.'..pdf');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        $image = Photo::find($id);

        Storage::disk('public')->delete($image->images);

        $image->delete();

        session()->flash('success', "Image deleted successfully.");

        return redirect()->back();
    }


    /**
     * Remove the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAttribute($id)
    {
        $attribute = ProductAttribute::find($id);

        $attribute->delete();

        session()->flash('success', "Attribute deleted successfully.");

        return redirect()->back();
    }
}
