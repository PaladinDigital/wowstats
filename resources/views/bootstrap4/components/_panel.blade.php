<div class="card">
    <div class="card-header">
        {!! $header !!}
    </div>
    {!! $slot !!}
    @if(isset($body))
    <div class="card-body">
        {!! $body !!}
    </div>
    @endif
</div>