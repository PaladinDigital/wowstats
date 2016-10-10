<?php
    // Required Fields: $id, $options
    // Optional Fields: $label

    if(isset($label)) {
        echo '<label for="'. $id .'">'. $label .'</label>';
    }
?><select id="{{ $id }}">
    @foreach($options as $option)
        @if (is_array($option))
            <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
        @elseif(is_object($option))
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endif

    @endforeach
</select>