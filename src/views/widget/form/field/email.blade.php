<input type="email"
    name="{{ $name }}"
    class="form-control"
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    value="{{ $value }}"
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    disabled="disabled"
    @endif
    />