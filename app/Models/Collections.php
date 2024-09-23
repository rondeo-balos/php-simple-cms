<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collections extends Model {
   use HasFactory;

   protected $fillable = [ 'key' ];

   public function metaData(): HasMany {
      return $this->hasMany(CollectionMeta::class, 'meta_id'); 
   }

   // Custom accessor to pivot meta_data into key-value pairs
   public function getPivotedMetaAttribute() {
       return $this->metaData->pluck('value', 'key')->toArray();
   }
}