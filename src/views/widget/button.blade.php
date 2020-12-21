@if(Auth::guard('admin')->user()->role->isAvailable($route))
<button type="button" class="btn {{ !empty($class) ? 'btn-' . $class : 'btn-primary' }} waves-effect waves-light ml-2 btn-sm" 
    @if(!empty($action))
    onclick="{{ (!empty($confirmation) ? 'confirmSetLocation(\'' : 'setLocation(\'') . $action . '\')' }}"
    @elseif(!empty($jsaction))
    onclick="{{ $jsaction }}"
    @endif
    title="{{ $label }}"
    >
    @if(!empty($type))
        @switch ($type)
            @case('delete')
                <i class="fa fa-trash-o"></i>
                @break
            @case('add')
                <i class="fa fa-plus-circle"></i>
                @break
            @case('edit')
                <i class="fa fa-pencil"></i>
                @break
            @case('save')
                <i class="fa fa-check-circle"></i>
                @break
            @case('back')
                <i class="fa fa-arrow-circle-o-left"></i>
                @break
        @endswitch
    @endif
    @if(empty($hide_label))
        <span>{{ $label }}</span>
    @endif
</button>
@endif