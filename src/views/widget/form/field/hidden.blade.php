<input 
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    type="hidden" 
    name="{{ $name }}" 
    value="{{ $value }}" />