@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<h3>{{ isset($product) ? 'Update Product' : 'Add Product' }}</h3>
	</div>
	<div class="card-body">
		<!-- product images -->
		<div class="row justify-content-around">
			@if(isset($product))
				@foreach($product->photos as $image)
					<div class="form-group">
						<img src="https://savingservices.net/debjaz/storage/app/public/{{ $image->images }}" style="width: 200px;">
						<form action="{{ route('destroyImage', $image->id) }}" method="post">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger mt-3">Delete Image</button>
						</form>
					</div>
				@endforeach
			@endif
		</div>
		<!-- product attributes start-->
		@if(isset($attributes))
		    <table class="table table-dark table-bordered table-hover">
    			<thead>
    				<th>Attribute Name</th>
    				<th>Attribute Value</th>
    				<th>Delete</th>
    			</thead>
    			<tbody>
    				@foreach($attributes as $at)
    				<tr>
    					<td>{{ $at->attribute_name }}</td>
    					<td>{{ $at->attribute_value }}</td>
    					<td>
    						<form action="{{ route('destroyAttribute', $at->id) }}" method="post">
    							@csrf
    							@method('DELETE')
    							<button type="submit" class="btn btn-danger btn-sm">Delete</button>
    						</form>
    					</td>
    				</tr>
    				@endforeach
    			</tbody>
    		</table>
		@endif
		<!-- product attributes end-->
		<form action="{{ isset($product) ? route('products.update', $product->slug) : route('products.store')}}" method="post" enctype="multipart/form-data">
			@csrf
			@if(isset($product))
				@method('PATCH')
			@endif
			<div class="row justify-content-between m-auto">
			<!-- product code -->
				<div class="form-group">
					<label for="code">Product Code</label>
					<input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ isset($product) ? $product->code : old('code') }}">

					@error('code')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
			<!-- product category -->
			<div class="form-group">
					<label for="category_id">Product Category</label>
					<select name="category_id" id="category_id" class="form-control @error('category') is-invalid @enderror">
						@if(isset($product))
							<option selected value="{{$product->category->id}}">{{ $product->category->name }}</option>
						@endif
						@foreach($categories as $cat)
							<option value="{{ $cat->id }}">{{ $cat->name }}</option>
						@endforeach
					</select>

					@error('category')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
			</div>
			<!-- product sub-category -->
			<div class="form-group">
					<label for="sub_category_id">Sub-Category (Optional)</label>
					<select name="sub_category_id" id="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror">
						@if(isset($product))
							@if($product->sub_category_id != null)
								<option selected value="{{$product->subCategory->id}}">{{ $product->subCategory->name }}</option>
							@endif
						@endif
						@foreach($subCategories as $cat)
							<option value="{{ $cat->id }}">{{ $cat->name }}</option>
						@endforeach
					</select>

					@error('sub_category_id')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
			</div>
			</div>
			<div class="row justify-content-between m-auto">
				<!-- product name -->
				<div class="form-group">
					<label for="name">Product Name</label>
					<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($product) ? $product->name :  old('name') }}">

					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product name_ar -->
				<div class="form-group">
					<label for="name_ar">Product Name Arbic</label>
					<input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ isset($product) ? $product->name_ar :  old('name_ar') }}">

					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product name_sw -->
				<div class="form-group">
					<label for="name_sw">Product Name Sweden</label>
					<input type="text" name="name_sw" id="name_sw" class="form-control @error('name_sw') is-invalid @enderror" value="{{ isset($product) ? $product->name_sw :  old('name_sw') }}">

					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="row justify-content-between m-auto">
			<!-- product description -->
			<div class="form-group">
				<label for="description">Product Description</label>
				<textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ isset($product) ? $product->description : old('description') }}</textarea>

				@error('description')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>
			<!-- product description_ar -->
			<div class="form-group">
				<label for="description_ar">Product Description Arbic</label>
				<textarea type="text" name="description_ar" id="description_ar" class="form-control @error('description_ar') is-invalid @enderror">{{ isset($product) ? $product->description_ar : old('description_ar') }}</textarea>

				@error('description_ar')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>
			<!-- product description_sw -->
			<div class="form-group">
				<label for="description_sw">Product Description Sweden</label>
				<textarea type="text" name="description_sw" id="description_sw" class="form-control @error('description_sw') is-invalid @enderror">{{ isset($product) ? $product->description_sw : old('description_sw') }}</textarea>

				@error('description_sw')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>
			</div>
			<div class="row justify-content-between m-auto">
				<!-- gift name -->
				<div class="form-group">
					<label for="gift">Gift Name</label>
					<input type="text" name="gift" id="gift" class="form-control @error('gift') is-invalid @enderror" value="{{ isset($product) ? $product->gift :  old('gift') }}">

					@error('gift')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product gift_ar -->
				<div class="form-group">
					<label for="gift_ar">Gift Name Arbic</label>
					<input type="text" name="gift_ar" id="gift_ar" class="form-control @error('gift_ar') is-invalid @enderror" value="{{ isset($product) ? $product->gift_ar :  old('gift_ar') }}">

					@error('gift_ar')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product name_sw -->
				<div class="form-group">
					<label for="gift_sw">Gift Name Sweden</label>
					<input type="text" name="gift_sw" id="gift_sw" class="form-control @error('gift_sw') is-invalid @enderror" value="{{ isset($product) ? $product->gift_sw :  old('gift_sw') }}">

					@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				
			</div>
			<div class="row justify-content-between m-auto">
			<!-- product description -->
			<div class="form-group">
				<label for="gift_description">Gift Description</label>
				<textarea type="text" name="gift_description" id="gift_description" class="form-control @error('gift_description') is-invalid @enderror">{{ isset($product) ? $product->gift_description : old('gift_description') }}</textarea>

				@error('gift_description')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>
			<!-- product gift_description_ar -->
			<div class="form-group">
				<label for="gift_description_ar">Gift Description Arbic</label>
				<textarea type="text" name="gift_description_ar" id="gift_description_ar" class="form-control @error('gift_description_ar') is-invalid @enderror">{{ isset($product) ? $product->gift_description_ar : old('gift_description_ar') }}</textarea>

				@error('description_ar')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>
			<!-- product gift_description_sw -->
			<div class="form-group">
				<label for="gift_description_sw">Product Description Sweden</label>
				<textarea type="text" name="gift_description_sw" id="gift_description_sw" class="form-control @error('gift_description_sw') is-invalid @enderror">{{ isset($product) ? $product->gift_description_sw : old('gift_description_sw') }}</textarea>

				@error('gift_description_sw')
					<span class="invalid-feedback" role="alert">
						<strong>{{$message}}</strong>
					</span>
				@enderror
			</div>

			</div>
			<div class="row justify-content-between m-auto">
				<!-- product images -->
				<div class="form-group">
					<label for="images">Product Image</label>
					<input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple>

					@error('images')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product price -->
				<div class="form-group">
					<label for="price">Product Price</label>
					<input type="decimal" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ isset($product) ? $product->price : old('price') }}">

					@error('price')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product qty -->
				<div class="form-group">
					<label for="quantity">Product Quantity</label>
					<input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ isset($product) ? $product->quantity : old('quantity') }}">

					@error('quantity')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="form-group">
				<label for="gift_description_sw">Winner</label>
				<input type="text" name="winner" id="winner" class="form-control @error('winner') is-invalid @enderror" value={{ isset($product) ? $product->winner : old('winner') }} />

				@error('gift_description_sw')
					<span class="invalid-feedback" role="alert">
						<strong>{{$winner}}</strong>
					</span>
				@enderror
			</div>
			<div class="row  m-auto">
				<!-- product start -->
				<div class="form-group">
					<label for="start">start</label>
					<input type="date" name="start" id="start" class="form-control @error('start') is-invalid @enderror" value="{{ isset($product) ? $product->start : old('start') }}">

					@error('start')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
				<!-- product end -->
			
			</div>
			<!-- product status 
			<div class="row ml-2">
				
				<div class="form-group">
					<label for="on_sale">On Sale</label>
					<select name="on_sale" id="on_sale" class="form-control @error('on_sale') is-invalid @enderror">
						<option value="0">NO</option>
						<option value="1">YES</option>
					</select>

					@error('on_sale')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
			
				<div class="form-group ml-5">
					<label for="is_new">New Product</label>
					<select name="is_new" id="is_new" class="form-control @error('is_new') is-invalid @enderror">
						<option value="0">NO</option>
						<option value="1">YES</option>
					</select>

					@error('is_new')
						<span class="invalid-feedback" role="alert">
							<strong>{{$message}}</strong>
						</span>
					@enderror
				</div>
			</div>
			-->
			<!-- product seo start -->
			<div class="form-group">
				<label for="meta_description">Product Meta Description</label>
				<textarea name="meta_description" class="form-control" placeholder="Make your product visible on search engine by describing your product...">{{ isset($product) ?  $product->meta_description : '' }}</textarea>
			</div>
			<div class="form-group">
				<label for="meta_keywords">Product Meta Keywords</label>
				<textarea name="meta_keywords" class="form-control" placeholder="Seperate keywords using comma...">{{ isset($product) ? $product->meta_keywords : '' }}</textarea>
			</div>
			<!-- product seo start -->

			<!-- products attributes start -->
			
			<!-- products attributes end -->

			<!-- product add btn -->
			<div class="form-group">
				<button class="btn btn-primary">{{ isset($product) ? 'Update Product Details': 'Add Product' }}</button>
			</div>
		</form>
	</div>
</div>

@endsection