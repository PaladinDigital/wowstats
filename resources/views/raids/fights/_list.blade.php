@if (isset($fights) && count($fights) > 0)
    <table class="table">
    <thead>
        <tr>
            <th>Boss</th>
            <th>Killed</th>
            <th>Length</th>
        </tr>
    </thead>
    <tbody>
    @foreach($fights as $fight)
        <?php
            $killed = $fight->killed;
            $duration = $fight->length;
            $duration = gmdate('i:s', $duration);
        ?>
        <tr><td><a href="{{ route('raid.fight.view', [$raid->id, $fight->id]) }}">{{ $fight->boss->name }}</a></td><td><?php echo ($killed == 1) ? 'Kill' : 'No' ?></td><td>{{ $duration }}</td></tr>
    @endforeach
    </tbody>
    </table>
@endif
