<div>
    {{-- Stop trying to control. --}}
    {{-- <h1>Ini adalah cart</h1> --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold mt-2">Product List</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($product as $products)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/images/'.$products->image) }}" alt="Product" class="img-fluid">
                                    </div>
                                    <div class="card-footer">
                                        <h6 class="text-center font-weight-bold">Test</h6>
                                        <button wire:click="addItem({{ $products->id }})" class="btn btn-primary btn-sm btn-block">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-weight-bold mt-2">Cart</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-hovered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart as $index=>$carts)
                                <tr>
                                    <td class="text-center">{{ $index+1 }}</td>
                                    <td>{{ $carts['name'] }}</td>
                                    <td class="text-center">{{ $carts['qty'] }}</td>
                                    <td>{{ $carts['price'] }}</td>
                                    <td>{{ $carts['prices'] }}</td>
                                </tr>
                            @empty
                                <td colspan="5"><h6 class="text-center mt-2">Empty Cart</h6></td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="font-weight-bold mt-2">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <h5>Subtotal : {{ $summary['subtotal'] }}</h5>
                    <h5>Pajak : {{ $summary['pajak'] }}</h5>
                    <h5>Total : {{ $summary['total'] }}</h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button wire:click="enableTax" class="btn btn-primary btn-block">Add Tax</button>
                        </div>
                        <div class="col-md-6">
                            <button wire:click="disableTax" class="btn btn-danger btn-block">Remove Tax</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn active btn-success btn-block">Save Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>