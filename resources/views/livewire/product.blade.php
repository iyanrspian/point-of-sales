<div>
    {{-- The best athlete wants his opponent at his best. --}}
    {{-- <h1>Test</h1> --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold mt-2">Product List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hovered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th width="20%">Image</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $index=>$products)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $products->name }}</td>
                                <td><img src="{{ asset('storage/images/'.$products->image) }}" alt="Image Preview" class="img-fluid"></td>
                                <td>{{ $products->desc }}</td>
                                <td>{{ $products->qty }}</td>
                                <td>{{ $products->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold mt-2">Create Product</h3>
                </div>
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
                        <div class="form-group">
                            <label>Product Name</label>
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
