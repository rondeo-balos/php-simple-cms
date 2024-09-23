<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionMeta extends Model {
    use HasFactory;

    protected $table = 'collection_meta';

    protected $fillable = [ 'meta_id', 'key', 'value' ];

    public function collection(): BelongsTo {
        return $this->belongsTo( Collections::class, 'meta_id' );
    }

    // Mutator to automatically serialize the data before inserting into the database
    public function setValueAttribute($value) {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value);
            $this->attributes['type'] = 'array'; // Optional: Store type if needed
        } elseif (is_object($value)) {
            $this->attributes['value'] = json_encode($value);
            $this->attributes['type'] = 'object';
        } elseif (is_bool($value)) {
            $this->attributes['value'] = $value ? 'true' : 'false';
            $this->attributes['type'] = 'boolean';
        } elseif (is_numeric($value)) {
            $this->attributes['value'] = $value;
            $this->attributes['type'] = is_float($value) ? 'float' : 'integer';
        } else {
            $this->attributes['value'] = (string) $value;
            $this->attributes['type'] = 'string';
        }
    }

    // Accessor to automatically deserialize the data when retrieving from the database
    public function getValueAttribute($value) {
        $type = $this->attributes['type'] ?? 'string'; // Use the stored type or assume string

        switch ($type) {
            case 'array':
            case 'object':
                return json_decode($value, true); // true for array, false for object
            case 'boolean':
                return $value === 'true';
            case 'float':
                return (float) $value;
            case 'integer':
                return (int) $value;
            default:
                return (string) $value; // Default to string
        }
    }
}
