<?php
    // Required Fields: $id, $options
    // Optional Fields: $label

    if(isset($label)) {
        echo '<label for="'. $id .'">'. $label .'</label>';
    }
?><select class="form-control" id="{{ $id }}">
    @if (is_object($options))
        @foreach($options as $option)
            @if (is_array($option))
                <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
            @elseif(is_object($option))
                <option value="{{ $option->id }}">{{ $option->name }}</option>
            @endif
        @endforeach
    @elseif (is_array($options))
        @foreach($options as $value => $name)
            <option value="{{ $value }}">{{ $name }}</option>
        @endforeach
    @endif


</select>