@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Get Content</div>

                <div class="card-body text-center">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="form-inline d-flex justify-content-center" action="{{ route('get-content') }}">
                        <div class="form-group mx-sm-3 mb-2 w-100">
                            <label for="inputPassword2" class="sr-only">Nhập url</label>
                            <input type="text" class="form-control w-100" id="inputPassword2" name="url" value="{{ old('url') }}" placeholder="Nhập url">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection