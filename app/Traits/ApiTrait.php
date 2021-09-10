<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait ApiTrait{
    /********* INCLUIR LOS DATOS DE UNA TABLA FORAREA */
    public function scopeIncluded(Builder $query)
    {
        if(empty($this->allowIncluded) || empty(request('included')))
            return;
        
        $relations = explode(',', request('included')); //[posts, relacion2]
        $allowIncluded = collect($this->allowIncluded);

        foreach($relations as $key => $relationship){
            if(!$allowIncluded->contains($relationship))
                unset($relations[$key]);        
        }
        $query->with($relations);
    }

    /********** FILTRAR LOS DATOS POR BUSQUEDA EN LA URL */
    public function scopeFilter(Builder $query)
    {
        if(empty($this->allowFilter)  || empty(request('filter')))
            return;
        
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach($filters as $key => $value){
            if($allowFilter->contains($key))
                $query->where($key, 'LIKE', '%'. $value . '%');
        }
    }

    /*********** DATOS ORDENADOR Y ASCENDENTES O DESCENDENTER */
    public function scopeSort(Builder $query)
    {
        if(empty($this->allowSort) || empty(request('sort')))
            return;
                
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);
        
        foreach($sortFields as $sortField){

            $direction = 'asc';

            if(substr($sortField, 0, 1) == '-'){
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

            if($allowSort->contains($sortField))
                $query->orderBy($sortField,  $direction);
        }
    }

    /************* PAGINAR TABLA SE AGREGA DE CUANTO QUIERE LA PAGINACION */
    public function scopeGetOrPaginate(Builder $query)
    {
        if(request('perPage')){
            $perPage = intval(request('perPage'));
            
            if($perPage)
                return $query->paginate($perPage);        
        }
        return $query->get();
    }
}

