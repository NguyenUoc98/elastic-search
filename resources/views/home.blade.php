@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body text-center">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in!
                    <br>
                    <br>
                    <br>
                    <form class="form-inline d-flex justify-content-center" action="{{ route('home') }}">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2" class="sr-only">Keyword</label>
                            <input type="text" class="form-control" id="inputPassword2" name="key" value="{{ old('key') }}" placeholder="Keyword">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>

                    @if(isset($users))
                    <ul class="list-group text-left">
                    @forelse($users as $key=>$user)
                        <li class="list-group-item">{{ $key + 1 . '. ' . $user->name . ' - ' . $user->email }}</li>
                    @empty
                        <li class="list-group-item">Không tìm thấy kết quả</li>
                    @endforelse
                    </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection