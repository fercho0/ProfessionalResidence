<?php

namespace Residence\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $filleble=
    [
    	'DOC_nombre','DOC_descripcion','DOC_fecha','DOC_archivo','ANT_id_'
    ];

    #uno a Anteproyecto 
    public function anteproyectos()
    {
    	return $this->hasMany('Residence\Models\Anteproyecto');
    }
    #uno a muchos cometario
    public function comentariodocumento()
    {
        return $this->belongsTo('Residence\Models\Comentariodocumento');
    }
}
