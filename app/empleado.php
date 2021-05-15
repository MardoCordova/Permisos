<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empleado extends Model
{
    
	protected $primaryKey = 'cod_empleado';
    
    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class,'cod_empleado_fk');
    }

}
