<input 
    type="password"
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    name="{{ $name }}" 
    @if(!empty($readonly))
    readonly="readonly"
    @endif
    @if(!empty($required))
    required
    @endif
    class="form-control" 
    placeholder="********"
    autocomplete="new-password" />