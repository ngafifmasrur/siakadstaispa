<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CurrentInstance implements Scope
{
	public $default_college = 1;

    private $relationship;

    /**
     * Define a controller instance.
     */
    public function __construct($relationship = 'period')
    {

        $this->relationship = $relationship;

    }

    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas($this->relationship, function($period) {
        	$period->where('inst_id', $this->default_college);
        });
    }
}