<textarea rows="4" 
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    class="form-control"
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly disabled
    @endif
    name="{{ $name }}">{{ $value }}</textarea>