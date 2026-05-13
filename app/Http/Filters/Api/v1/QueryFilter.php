<?php

namespace App\Http\Filters\Api\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter {
   protected $builder;
   protected $request;
   protected $sortable = [];

   public function __construct(Request $request) {
       $this->request = $request;
   }

   protected function filter($arr) {
       foreach ($arr as $key => $value) {
           if(method_exists($this, $key)) {
               $this->$key($value);
           }
       }

       return $this->builder;
   }

    public function apply(Builder $builder) {
       $this->builder = $builder;

       foreach ($this->request->all() as $key => $value) {
           if(method_exists($this, $key)) {
               $this->$key($value);
           }
       }
       return $this->builder;
   }

   // parameter $value
   protected function sort($value) {
       // since its a coma separated string, we need to explode it
       $sortAttributes = explode(',', $value);

       foreach ($sortAttributes as $sortAttribute) {
           // here we can determine the direction of our sort

           $direction = 'asc'; // as default

           // if desc, we can check the first character
           if (str_starts_with($sortAttribute, '-')) {
               // so we can change the direction
               $direction = 'desc';

               // normalize the $sortAttribute here, because this is going to have a minus sign in front of it and we can take that out so we can do substr the $sortAttribute in the position 1
               $sortAttribute = substr($sortAttribute, 1);
           }

           // if not in the sortable array, we can skip this because its not an attribute we want to sort by
           if (!in_array($sortAttribute, $this->sortable, true) && !array_key_exists($sortAttribute, $this->sortable)) {
               continue;
           }

           // so if this is a key in the sortable array, we will get the value otherwise its going to be null
           $columnName = $this->sortable[$sortAttribute] ?? $sortAttribute;

           // then we check if columnName is null, then we are going to set the column name equal to the sortAttribute so that in case of the status and title, this is going to set our column name to status and title or back to those values
           if ($columnName === null) {
               $columnName = $sortAttribute;
           }

           // but we can add to query builder if its in the sortable array
           $this->builder->orderBy($columnName, $direction);
       }
   }
}
