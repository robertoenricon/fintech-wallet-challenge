@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h3 mb-3">Dashboard</h1>

            <p class="mb-2">
                <strong>{{ $user->name }}</strong>
            </p>

            <p class="mb-0">
                Saldo:
                <strong>
                    R$ {{ number_format($user->wallet->balance ?? 0, 2, ',', '.') }}
                </strong>
            </p>
        </div>
    </div>
</div>
@endsection