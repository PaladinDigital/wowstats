<?php
// Required Fields: $item (eg Player), $fields[],
// Optional Fields: $hidden_fields, $modal_id, $flash_id, $pre_send (javascript), $done (javascript|'reload')

$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;

if (!isset($modal_id)) {
    $modal_id = "create{$trimmed_item}Modal";
}
?>
<script>
    function create<?php echo ucfirst($trimmed_item); ?>()
    {
        var data = {
            @foreach($fields as $f)
            "{{ $f['name'] }}": $('#{{$f['name']}}').val(),
            @endforeach

            @if(isset($hidden_fields))
            @foreach($hidden_fields as $name => $value)
            "{{ $name }}": {{ $value }},
            @endforeach
            @endif

            "_token": "{{ csrf_token() }}"
        }

        @if(isset($pre_send))
            <?php echo $pre_send; ?>
        @endif

        /* Send the post request */
        @if(isset($done))
            $.post( "{{ $url }}", data, function() {
            <?php
                if ($done == 'reload') {
                    echo 'window.location.reload();';
                } else {
                    echo $done;
                }
            ?>
        });
        @else
            $.post("{{ $url }}", data);
        @endif
    }
</script>
<div class="modal fade" id="<?=$modal_id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create {{ $item }}</h4>
            </div>
            <div class="modal-body">
                @if (isset($flash_id))
                    <div id="{{ $flash_id }}" class="alert" style="display: none;"></div>
                @endif

                @if(isset($content))
                    <?php echo $content; ?>
                @endif

                @foreach($fields as $f)
                    @if ($f['type'] == 'select')

                        @if (isset($f['options']))
                            @include('html.select', ['options' => $f['options'], 'label' => $f['label'], 'id' => $f['name']])
                        @endif

                    @else

                        <div class="input-group">
                            <label class="label" for="{{ $f['name'] }}">{{ $f['label'] or ucfirst($f['name']) }}</label>
                            <?php
                                $output = ' class="form-control" id="'. $f['name'] .'" type="'. $f['type'] . '"';
                                if (isset($f['value'])) {
                                    $output .= ' value="'. $f['value'] .'"';
                                }
                                if (isset($f['min'])) { $output .= ' min="'. $f['min'] .'"'; }
                                if (isset($f['max'])) { $output .= ' max="'. $f['max'] .'"'; }
                                if (array_key_exists('required', $f)) { $output .= ' required'; }
                                /* Show placeholder on text-type inputs */
                                if (in_array($f['type'], ['text', 'url', 'email'])) {
                                    if (array_key_exists('label', $f)) {
                                        $output .= ' placeholder="'. $f['label'] .'" ';
                                    } else {
                                        $output .= ' placeholder="'. $f['name'] .'" ';
                                    }
                                }
                            ?>

                            @if(in_array($f['type'], ['text', 'url', 'date', 'datetime', 'time', 'email', 'number']))
                            <input {!! $output !!} />

                        @endif
                        </div>

                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="return create<?php echo ucfirst($trimmed_item); ?>();">Create {{ $item }}</button>
            </div>
        </div>
    </div>
</div>
