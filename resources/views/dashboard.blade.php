@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Dashboard</h1>

                <a href="{{ route('transfers.create') }}" 
                   class="btn btn-success">
                    Nova Transferência
                </a>
            </div>

            <p class="mb-2">
                <strong>{{ $user->name }}</strong>
            </p>

            <p class="mb-3">
                Saldo:
                <strong>
                    R$ {{ number_format($user->wallet->balance ?? 0, 2, ',', '.') }}
                </strong>
            </p>

        </div>
    </div>
</div>
@endsection