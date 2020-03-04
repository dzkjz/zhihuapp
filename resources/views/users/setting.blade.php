@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        设置个人信息
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="city">现居城市</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ $settings['city'] }}">
                                @error('city') <span class="alert alert-danger">{{ $message }}</span>@enderror
                            </div>


                            <div class="form-group">
                                <label for="info">个人简介</label>
                                <textarea type="text" name="info" id="info"
                                          class="form-control">{{ $settings['info'] }}</textarea>
                                @error('info') <span class="alert alert-danger">{{ $message }} </span>@enderror
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block form-control">更新资料</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
