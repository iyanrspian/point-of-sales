<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card shadow-1-strong">
                <form wire:submit.prevent="submit" class="text-center border border-light pt-5 px-4 pb-3">
                    <p class="h4 mb-4">Sign up</p>
                    <input wire:model="form.name" type="text" class="form-control @error('form.name') is-invalid @enderror" placeholder="Name">
                    @error('form.name')
                        <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input wire:model="form.email" type="email" class="form-control mt-4 @error('form.email') is-invalid @enderror" placeholder="E-mail">
                    @error('form.email')
                        <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-row mt-4">
                        <div class="col">
                            <input wire:model="form.password" type="password" class="form-control @error('form.password') is-invalid @enderror" placeholder="Password">
                            @error('form.password')
                                <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <input wire:model="form.password_confirmation" type="password" class="form-control @error('form.password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                            @error('form.password_confirmation')
                                <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary my-4 btn-block" type="submit">Register</button>
                    <p>Already have an account?
                        <a href="/login">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
