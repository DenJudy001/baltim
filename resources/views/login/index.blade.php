@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden card-form border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">

                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <main class="form-signin w-100 m-auto">
                        <form action="/login" method="POST" id="loginForm">
                            @csrf
                            <h1 class="h3 mb-4 mt-2 text-center fw-normal">Selamat Datang</h1>
                            
                            @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <b>Gagal! </b>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="form-floating">
                                <input type="String" class="form-control rounded-top @error('username') is-invalid @enderror" id="username" 
                                placeholder="Username" name="username" value="{{ old('username') }}">
                                <label for="username">Username</label>
                                @error('username')
                                    <div class="invalid-feedback invalid-user">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                <label for="password">Kata Sandi</label>
                                @error('password')
                                    <div class="invalid-feedback invalid-user">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="w-100 btn btn-primary btn-submit" type="submit"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
                        </form>
                    </main>    
                </div>      
            </div>
        </div>
    </div>
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
