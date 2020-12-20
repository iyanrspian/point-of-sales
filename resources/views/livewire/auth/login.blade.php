<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card shadow-1-strong">
                <form wire:submit.prevent="submit" class="text-center border border-light pt-5 px-4 pb-3">
                    <p class="h4 mb-4">Sign in</p>
                    @if (session()->has('error'))
                    <span class="text-danger" role="alert" style="font-size: 10pt">
                        <strong>{{ session('error') }}</strong>
                    </span>
                    @endif
                    <input wire:model="form.email" type="email" class="form-control @error('form.email') is-invalid @enderror" placeholder="E-mail" autofocus>
                    @error('form.email')
                        <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input wire:model="form.password" type="password" class="form-control mt-4 @error('form.password') is-invalid @enderror" placeholder="Password">
                    @error('form.password')
                        <span class="invalid-feedback" role="alert" style="font-size: 8pt">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="defaultLoginFormRemember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
                            </div>
                        </div>
                        <div>
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block my-4" type="submit">Sign in</button>
                    <p>Not a member?
                        <a href="/register">Register</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
