<?php
    $item = 'RaidAttendee';
    $hidden_fields = [
        'raid_id' => $raid->id,
    ];
    $url = route('api.post.raid.attendee', $raid->id);
    $done = 'reload';
?>
<?php
// Required Fields: $item (eg Player), $fields[],
// Optional Fields: $hidden_fields, $modal_id, $flash_id, $pre_send (javascript), $done (javascript|'reload')

$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;

if (!isset($modal_id)) {
    $modal_id = "addAttendeeModal";
}
?>
<script>
    function addAttendee()
    {
        var data = {
            "character_id": $('#character_id').val(),
            @if(isset($hidden_fields))
                @foreach($hidden_fields as $name => $value)
                "{{ $name }}": {{ $value }},
                @endforeach
            @endif
            "_token": "{{ csrf_token() }}"
        }

        $.post( "{{ $url }}", data, function() {
            window.location.reload();
        });
    }
</script>
<div class="modal fade" id="<?=$modal_id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Raid Attendee</h4>
            </div>
            <div class="modal-body">
                <label for="character_id">Character</label>
                <select class="form-control" id="character_id">
                    @foreach($raiders as $r)
                        <option value="{{ $r->id }}" class="{{ $r->cssClass() }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="return addAttendee(id);">Add Attendee</button>
            </div>
        </div>
    </div>
</div>