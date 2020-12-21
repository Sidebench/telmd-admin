<select 
    class="form-control multiple-select"
    name="{{ $name }}[]"
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly="readonly"
    @endif
    multiple="multiple"
>
    @foreach($source->getOptions() as $_value => $_label)
    <option value="{{ $_value }}"
    @if(is_array($value) && in_array($_value, $value))
        selected="selected"
    @endif
    >{{ $_label }}</option>
    @endforeach
</select>
