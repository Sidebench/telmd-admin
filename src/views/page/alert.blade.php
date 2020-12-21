@foreach(Alert::getMessages() as $message)
<div class="alert alert-{{ $message['type'] }} alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div class="alert-icon">
        @switch($message['type'])
            @case('success')
                <i class="icon-check"></i>
                @break
            @case('info')
                <i class="icon-info"></i>
                @break
            @case('danger')
                <i class="icon-close"></i>
                @break
            @case('warning')
                <i class="icon-exclamation"></i>
                @break
        @endswitch
    </div>
    <div class="alert-message">
        <span>
            @switch($message['type'])
                @case('success')
                    <strong>Success!</strong>
                    @break
                @case('info')
                    <strong>Info!</strong>
                    @break
                @case('danger')
                    <strong>Error!</strong>
                    @break
                @case('warning')
                    <strong>Warning!</strong>
                    @break
            @endswitch
            {{ $message['text'] }}
        </span>
    </div>
</div>
@endforeach
@php
Alert::flush();
@endphp
