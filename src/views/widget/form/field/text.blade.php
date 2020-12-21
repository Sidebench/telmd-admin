<input 
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    type="text" 
    name="{{ $name }}" 
    class="form-control" 
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly="readonly"
    disabled="disabled"
    @endif
    value="{{ $value }}" />