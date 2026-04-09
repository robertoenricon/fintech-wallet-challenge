@extends('layouts.app')

@section('content')
<div>
    
    <h2 style="margin-bottom: 20px;">Transferência</h2>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div>
            <ul style="margin: 0; padding-left: 15px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('transfers.store') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>E-mail do destinatário</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}"
                required
                style="width: 100%; padding: 10px; margin-top: 5px;"
            >
        </div>

        <div style="margin-bottom: 15px;">
            <label>Valor</label>
            <input 
                type="number" 
                step="0.01"
                name="value" 
                value="{{ old('value') }}"
                required
                style="width: 100%; padding: 10px; margin-top: 5px;"
            >
        </div>

        <button type="submit">Transferir</button>
    </form>

</div>
@endsection