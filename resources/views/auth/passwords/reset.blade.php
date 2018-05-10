@extends('layouts.app')

@section('content')
{{ $token }}
<auth-passwords-reset old="{{ $email or old('email') }}" token="{{ $token }}">
</auth-passwords-reset>
@endsection
