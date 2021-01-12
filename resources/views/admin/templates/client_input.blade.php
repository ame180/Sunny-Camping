<div class="col-6 col-sm-4 col-md-3 form-group">
    <label for="{{$input['name']}}">{{$input['label']}}</label>
    @if ($input['type'] === 'select')
        <select name="{{$input['name']}}" class="custom-select custom-select-sm">
            @foreach($input['options'] as $key => $value)
                <option
                    value="{{$key}}" }}>{{$value}}</option>
            @endforeach
        </select>
    @else
        <input name="{{$input['name']}}" class="form-control form-control-sm" type="{{$input['type']}}"
               placeholder="{{isset($input['placeholder']) ? $input['placeholder'] : ''}}"
            {{isset($input['required']) ? 'required' : ''}}>
    @endif
</div>
