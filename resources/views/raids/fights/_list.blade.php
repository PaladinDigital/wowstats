@if (isset($fights) && count($fights) > 0)
    <table class="table">
    <thead>
        <tr>
            <th>Boss</th>
            <th>Killed</th>
            <th>Length</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($fights as $fight)
        <?php
            $killed = $fight->killed;
            $duration = $fight->length;
            $duration = gmdate('i:s', $duration);
            die;
        ?>
        <tr<?php if ($killed === 1) { echo ' class="killed"'; } ?>>
            <td><a href="{{ route('raid.fight.view', [$raid->id, $fight->id]) }}">{{ $fight->boss->name }}</a></td>
            <td><?php echo ($killed == 1) ? 'Kill' : 'No' ?></td>
            <td>{{ $duration }}</td>
            <td>@if ($fight->locked > 0) <i class="fa fa-lock"></i> @endif</td>
        </tr>
    @endforeach
    </tbody>
    </table>
@endif
