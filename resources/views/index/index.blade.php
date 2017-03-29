@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a link</div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('links.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="url">Url:</label>
                            <input type="text" name="url" id="url" value="{{ old('url') }}" class="form-control">
                        </div>
                        @include('partials.errors')
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Cut your link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection