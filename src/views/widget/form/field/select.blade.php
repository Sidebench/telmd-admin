<select 
    class="form-control"
    name="{{ $name }}"
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly="readonly"
    disabled="disabled"
    @endif
>
    @if(empty($required))
    <option value="">-- Please select --</option>
    @endif
    @foreach($source->getOptions() as $_value => $_label)
    <option value="{{ $_value }}"
    @if($value == $_value)
        selected="selected"
    @endif
    >{{ $_label }}</option>
    @endforeach
</select>