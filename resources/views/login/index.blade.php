@extends('layouts.main')

@section('container')
<div class="row justify-content-center text-center">
    <div class="col-lg-4">
        <main class="form-signin w-100 m-auto">
            <form action="/login" method="POST" id="loginForm">
                @csrf
                <h1 class="h3 mb-5 mt-2 fw-normal">Selamat Datang!</h1>
                
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="form-floating">
                    <input type="String" class="form-control rounded-top @error('username') is-invalid @enderror" id="username" 
                    placeholder="Username" name="username" value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                    <label for="password">Kata Sandi</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="w-100 btn btn-lg btn-primary btn-submit" type="submit"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
            </form>
        </main>    
    </div>        
</div>    
@endsection

@push('scriptmain')
<script>
    $(document).ready(function() {
        $("#loginForm").submit(function(e){

            $(".btn-submit").find(".bi-box-arrow-in-right").remove();
            $(".btn-submit").prepend('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $(".btn-submit").attr("disabled", 'disabled');
        
        });
    });
</script>
@endpush
