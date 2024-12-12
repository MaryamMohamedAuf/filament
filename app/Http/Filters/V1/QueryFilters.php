<?php
namespace App\Http\Filters\V1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
abstract class QueryFilters
{
    protected $builder;
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function filter($arr){
        foreach ($arr as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }
    }
    protected function sort($value){
        $sortAttr = explode(',',$value);
        foreach ($sortAttr as $sortsAttr) {
           $direction = 'asc';
           if(strpos($sortsAttr,'-') !== false){
               $direction = 'desc';
               $sortsAttr = substr($sortsAttr,1);
           }
           return $this->builder->orderBy($sortsAttr,$direction);
        }
        return $this->builder;
    }
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->request->all() as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $builder;
    }
}