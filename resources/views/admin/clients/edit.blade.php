@extends('layouts.admin')

@section('input')
    <form class="row mt-4" method="POST" action="../update/{{$client->id}}">
        @csrf
        @method('PATCH')
        @foreach($inputs as $input)
            <div class="col-6 col-sm-4 col-md-3 form-group">
                <label for="{{$input['name']}}">{{$input['label']}}</label>
                @if ($input['type'] === 'select')
                    <select name="{{$input['name']}}" class="custom-select custom-select-sm">
                        @foreach($input['options'] as $key => $value)
                            <option
                                value="{{$key}}" {{$key == $client->{$input['name']} ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                @else
                    <input name="{{$input['name']}}" class="form-control form-control-sm" type="{{$input['type']}}"
                           placeholder="{{isset($input['placeholder']) ? $input['placeholder'] : ''}}"
                           value="{{isset($client->{$input['name']}) ? $client->{$input['name']} : ''}}">
                @endif
            </div>
        @endforeach
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success w-50">Zatwierdź</button>
        </div>
    </form>
@endsection

@section('main')
    <div class="container">
        @yield('input')
    </div>
@endsection
