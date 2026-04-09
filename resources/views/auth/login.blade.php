@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h3 text-center mb-4">Login</h1>

                    @if ($errors->has('auth'))
                        <div class="alert alert-danger">
                            {{ $errors->first('auth') }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control {{ $errors->has('auth') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                           <input
                                type="password"
                                name="password"
                                class="form-control {{ $errors->has('auth') ? 'is-invalid' : '' }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Não tem conta?
                        <a href="{{ route('register') }}">Cadastre-se</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection