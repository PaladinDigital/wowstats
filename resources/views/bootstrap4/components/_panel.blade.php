<?php
if (!isset($panelHeader) && !isset($panelBody)) {
    return;
}
?><div class="card">
    @if(isset($panelHeader))
    <div class="card-header">
        {{ $panelHeader }}
    </div>
    @endif
    @if(isset($panelBody))
    <div class="card-body">
        {{ $panelBody }}
    </div>
    @endif
</div>