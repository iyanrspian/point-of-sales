<div>
    {{-- The best athlete wants his opponent at his best. --}}
    {{-- <h1>Test</h1> --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3">Product List</h2>
                    <table class="table table-bordered table-hovered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Image</th>
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
                                <td>{{ $products->image }}</td>
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
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3">Create Product</h2>
                </div>
            </div>
        </div>
    </div>
</div>
