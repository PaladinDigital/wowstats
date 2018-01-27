@extends('layouts/admin')

@section('content')

<?php
    use WoWStats\Models\CharacterRole;

    function buildSpecSelection($spec = 'main', $character, $cssClass) {
        $specOptions = CharacterRole::getOptions();
        $name = ($spec === 'main') ? 'main_role_id' : 'os_role_id';
        $currentValue = ($spec === 'main') ? $character->main_role_id : $character->os_role_id;
        $select = '<select name="'.$name.'" class="form-control form-control-sm '.$cssClass.'" onchange="updateSpec(this, '.$character->id.')">';
        foreach ($specOptions as $id => $specName) {
            if ($id === $currentValue) {
                $select .= '<option value="'.$id.'" selected>'.$specName.'</option>';
            } else {
                $select .= '<option value="'.$id.'">'.$specName.'</option>';
            }
        }
        $select .= '</select>';
        return $select;
    }
?>

<table class="table">
<thead>
<tr>
    <th>Raider</th>
    <th>Main Spec</th>
    <th>Off Spec</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($raiders as $raider)
<?php
$class_name = $raider->cssClass($raider->class_id);
$mainSpec = buildSpecSelection('main', $raider, $class_name);
$offSpec = buildSpecSelection('off', $raider, $class_name);
?>
<tr class="{{ $class_name }}">
    <td>{{ $raider->name }}</td>
    <td>{!! $mainSpec !!}</td>
    <td>{!! $offSpec !!}</td>
    <td><button class="btn btn-xs btn-danger" onclick="return deleteCharacter({{ $raider->id }});">Delete</button></td>
</tr>
@endforeach
</tbody>
</table>

@stop