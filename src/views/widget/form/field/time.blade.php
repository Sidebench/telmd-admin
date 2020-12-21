<input 
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    type="time" 
    name="{{ $name }}" 
    class="form-control" 
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly="readonly"
    @endif
    value="{{ $value }}" />