<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-1-strong">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="font-weight-bold mt-1">Product List</h5>
                        </div>
                        <div class="col-md-3">
                            <input wire:model="search" type="text" class="form-control form-control-sm" placeholder="Search..">
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="row">
                        @forelse ($product as $products)
                            <div class="col-md-3 mb-3">
                                <div class="card shadow-1-strong">
                                    <img src="{{ asset('storage/images/'.$products->image) }}" alt="Product" style="object-fit: cover; width: 100%; height: 120px">
                                    <button wire:click="addItem({{ $products->id }})" class="btn btn-sm btn-primary btn-sm" style="position: absolute; top:8px; right:8px; padding: 8px"><i class="fas fa-cart-plus fa-lg"></i></button>
                                    <div class="card-body">
                                        <h6 class="card-title text-dark" style="font-size: 14pt">{{ $products->name }}</h6>
                                        <p class="card-text" style="font-size: 12pt">
                                            {{ $products->desc }} <br>
                                            <strong class="text-primary">Rp. {{ number_format($products->price) }}</strong>
                                        </p>
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
            <div class="card shadow-1-strong">
                <div class="card-body">
                    <h5 class="font-weight-bold">Cart</h5>
                    <p class="text-danger font-weight-bold">
                        @if (session()->has('error'))
                            {{ session('error') }}
                        @endif
                    </p>
                    <table class="table table-responsive-sm table-sm table-borderless table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th style="width: 70%">Name</th>
                                <th class="text-center" style="width: 30%">Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart as $index=>$carts)
                                <tr>
                                    <th scope="row">
                                        {{ $index+1 }}<br>
                                        <span wire:click="removeItem('{{ $carts['rowId'] }}')" class="text-dark" style="cursor:pointer"><i class="fas fa-trash fa-sm"></i></span>
                                    </th>
                                    <td style="width: 60%">
                                        {{ $carts['name'] }}<br>
                                        Rp {{ number_format($carts['price']) }}
                                    </td>
                                    <td class="text-center">
                                        <span wire:click="decreaseItem('{{ $carts['rowId'] }}')" class="text-danger" style="cursor:pointer"><i class="fas fa-minus-square fa-sm"></i></span>
                                        {{ $carts['qty'] }}
                                        <span wire:click="increaseItem('{{ $carts['rowId'] }}')" class="text-success" style="cursor:pointer"><i class="fas fa-plus-square fa-sm"></i></span>
                                    </td>
                                    <td class="text-right">{{ number_format($carts['prices']) }}</td>
                                </tr>
                            @empty
                                <td colspan="5"><h6 class="text-center mt-2">Empty Cart</h6></td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow-1-strong mt-3">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-3">Cart Summary</h5>
                    <table class="table table-sm">
                        <tr>
                            <td>Subtotal</td>
                            <td width="60">Rp.</td>
                            <td class="text-right" width="100">{{ number_format($summary['subtotal']) }}</td>
                        </tr>
                        <tr>
                            <td>Tax (10%)</td>
                            <td width="60">Rp.</td>
                            <td class="text-right" width="100">{{ number_format($summary['taxes']) }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td width="60">Rp.</td>
                            <td class="text-right" width="100">{{ number_format($summary['total']) }}</td>
                        </tr>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button wire:click="disableTax" class="btn btn-sm btn-danger btn-block">Remove Tax</button>
                        </div>
                        <div class="col-md-6">
                            <button wire:click="enableTax" class="btn btn-sm btn-primary btn-block">Add Tax</button>
                        </div>
                    </div>
                    <div class="mt-3 mb-1">
                        <button class="btn btn-sm active btn-success btn-block"><i class="fas fa-save"></i>&nbsp;&nbsp;&nbsp;Save Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
