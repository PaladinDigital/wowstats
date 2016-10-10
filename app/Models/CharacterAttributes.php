<?php namespace WoWStats\Models;

class CharacterAttributes extends Model
{
    protected $table = 'character_attributes';

    protected $fillable = ['character_id', 'attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo('Attributes');
    }

    public static function attributeExists($character_id, $attribute_id)
    {
        try {
            $attr = CharacterAttributes::where('character_id', $character_id)->where('attribute_id', $attribute_id)->firstOrFail();
            return $attr->id;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function createOrUpdateAttribute($character_id, $attribute_id, $value)
    {
        $id = self::attributeExists($character_id, $attribute_id);
        if ($id === false) {
            CharacterAttributes::create([
                'character_id' => $character_id,
                'attribute_id' => $attribute_id,
                'value' => $value
            ]);
        } else {
            $pl_attr = CharacterAttributes::where('character_id', $character_id)->where('attribute_id', $attribute_id)->first();
            $pl_attr->value = $value;
            $pl_attr->save();
        }
    }
}