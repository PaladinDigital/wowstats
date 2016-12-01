@extends('layouts.admin')

@section('content')

    <section>
        <h1>Character Stats</h1>

        @if (isset($stats) && count($stats) > 0)
            <table class="table">
            <thead>
                <tr>
                    <th>Raid</th>
                    <th>Fight</th>
                    <th>Character</th>
                    <th>Metric</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($stats as $s)
                <tr class="{{ $s->character->cssClass() }}">
                    <td>{{ $s->raidfight->raid->zone->name }}</td>
                    <td>{{ $s->raidfight->boss->name }}</td>
                    <td>{{ $s->character->name }}</td>
                    <td>{{ $s->metric->name }}</td>
                    <td>{{ $s->value }}</td>
                    <td><button class="btn btn-xs btn-danger" onclick="return deleteStat('{{ route('admin.stat.delete', $s->id) }}');"><i class="fa fa-trash"></i> Delete</button></td>
                </tr>
            @endforeach
            </tbody>
            </table>
            {{ $stats->links() }}
        @else
            <p>There are currently no stats recorded.</p>
        @endif
    </section>
@stop

@section('scripts')
    <script>
        function deleteStat(url)
        {
            var data = {
                '_token': '{{ csrf_token() }}',
                '_method': 'DELETE'
            }

            /* Prompt user to confirm action */
            if (confirm('Are you sure you wish to delete this stat?')) {
                $.post(url, data).done(function () {
                    window.location.reload();
                });
            }
        }
    </script>
@stop