@extends($layout)

@section('content')
    <?php

    ?>
    <form
        action="{{ route('raid.fight.csv.store', [$raid_id, $fight_id]) }}"
        method="post"
        enctype="multipart/form-data"
    >

        <label for="metric_select">Metric:
        <select onchange="csvName();" id="metric_select" name="metric">
            <option>Please Select</option>
            @foreach($metrics as $m)
            <option value="{{ $m->name }}">{{ $m->name }}</option>
            @endforeach
        </select>
        </label>
        <input id="fileInput" type="file">
        <input type="hidden" name="raid_id" value="{{ $raid_id }}">
        <input type="hidden" name="fight_id" value="{{ $fight_id }}">
        {{ csrf_field() }}
        <input type="submit">
    </form>

    <script>
        function csvName() {
            var metric = $('#metric_select').val();
            var metric_csv = metric + '_csv';
            var fileInput = $('#fileInput');
            fileInput.attr('name', metric_csv);
        }
    </script>
@endsection
