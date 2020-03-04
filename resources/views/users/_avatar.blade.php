@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        更换头像
                    </div>
                    <div class="card-body">
                        <avatar avatar="{{ auth()->user()->avatar }}"></avatar>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
