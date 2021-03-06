<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-1-strong">
                <h5 class="card-header font-weight-bold my-1">Product List</h5>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="35">No</th>
                                <th>Name</th>
                                <th width="13%">Image</th>
                                <th>Description</th>
                                <th width="40">Qty</th>
                                <th width="130">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $index=>$products)
                            <tr>
                                <td class="text-center">{{ $index+1 }}</td>
                                <td>{{ $products->name }}</td>
                                <td><img src="{{ asset('storage/images/'.$products->image) }}" alt="Image Preview" class="img-fluid"></td>
                                <td>{{ $products->desc }}</td>
                                <td class="text-center">{{ $products->qty }}</td>
                                <td>Rp. {{ number_format($products->price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display:flex;justify-content:center">
                        {{ $product->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-1-strong">
                <h5 class="card-header font-weight-bold my-1">Create Product</h5>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input wire:model="name" type="text" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Image</label>
                            <div class="custom-file">
                                <input wire:model="image" type="file" id="customFile" class="custom-file-input">
                                <label for="customFile" class="custom-file-label">Choose Image</label>
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($image)
                                <label class="mt-2">Preview Image:</label>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview Image" class="img-fluid">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model="desc" class="form-control"></textarea>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input wire:model="qty" type="number" class="form-control">
                            @error('qty')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label>Price</label>
                            <input wire:model="price" type="number" class="form-control">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit Product</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="card mt-3">
                <div class="card-body">
                    <h3>{{ $name }}</h3>
                    <h3>{{ $image }}</h3>
                    <h3>{{ $desc }}</h3>
                    <h3>{{ $qty }}</h3>
                    <h3>{{ $price }}</h3>
                </div>
            </div> --}}
        </div>
    </div>
</div>
