<div>
    {{-- Stop trying to control. --}}
    {{-- <h1>Ini adalah cart</h1> --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="font-weight-bold mt-1">Product List</h5>
                        </div>
                        <div class="col-md-4">
                            <input wire:model="search" type="text" class="form-control form-control-sm" placeholder="Search..">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($product as $products)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/images/'.$products->image) }}" alt="Product" class="img-fluid">
                                    </div>
                                    <div class="card-footer">
                                        <h6 class="font-weight-bold">{{ $products->name }}</h6>
                                        {{-- <h6>{{ $products->desc }}</h6> --}}
                                        <h6>Rp. {{ number_format($products->price) }}</h6>
                                        <button wire:click="addItem({{ $products->id }})" class="btn btn-sm btn-primary btn-sm btn-block">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <h4 class="text-center">Product not found!</h4>
                            </div>
                        @endforelse
                    </div>
                    <div style="display:flex;justify-content:flex-end">
                        {{ $product->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold">Cart</h5>
                    <p class="text-danger font-weight-bold">
                        @if (session()->has('error'))
                            {{ session('error') }}
                        @endif
                    </p>
                    <table class="table table-sm table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th width="35">No</th>
                                <th>Name</th>
                                <th class="text-center" width="60">Qty</th>
                                {{-- <th class="text-center" width="80">Price</th> --}}
                                <th class="text-center" width="80">Total (Rp.)</th>
                                <th class="text-center" width="35">Ket.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart as $index=>$carts)
                                <tr>
                                    <td class="text-center">{{ $index+1 }}</td>
                                    <td>{{ $carts['name'] }}</td>
                                    <td class="text-center">
                                        <a href="#" wire:click="decreaseItem('{{ $carts['rowId'] }}')" class="text-secondary"><i class="fas fa-minus-square fa-sm"></i></a>
                                        {{ $carts['qty'] }}
                                        <a href="#" wire:click="increaseItem('{{ $carts['rowId'] }}')" class="text-secondary"><i class="fas fa-plus-square fa-sm"></i></a>
                                    </td>
                                    {{-- <td class="text-right">{{ $carts['price'] }}</td> --}}
                                    <td class="text-right">{{ number_format($carts['prices']) }}</td>
                                    <td class="text-center">
                                        <a href="#" wire:click="removeItem('{{ $carts['rowId'] }}')" class="text-secondary"><i class="fas fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="5"><h6 class="text-center mt-2">Empty Cart</h6></td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-3">Cart Summary</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Subtotal</td>
                            <td width="30">Rp.</td>
                            <td class="text-right" width="90">{{ number_format($summary['subtotal']) }}</td>
                        </tr>
                        <tr>
                            <td>Tax (10%)</td>
                            <td width="30">Rp.</td>
                            <td class="text-right" width="90">{{ number_format($summary['taxes']) }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td width="30">Rp.</td>
                            <td class="text-right" width="90">{{ number_format($summary['total']) }}</td>
                        </tr>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <button wire:click="enableTax" class="btn btn-sm btn-primary btn-block">Add Tax</button>
                        </div>
                        <div class="col-md-4">
                            <button wire:click="disableTax" class="btn btn-sm btn-danger btn-block">Remove Tax</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-sm active btn-success btn-block">Save Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
