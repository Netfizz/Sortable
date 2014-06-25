<?php namespace Netfizz\Sortable;

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class ModelSortableScope implements ScopeInterface {

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $model = $builder->getModel();

        $builder->orderBy($model->getQualifiedOrderColumn());

        $this->addNotSorted($builder);
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function remove(Builder $builder)
    {
        $column = $builder->getModel()->getQualifiedOrderColumn();

        $query = $builder->getQuery();

        foreach ((array) $query->orders as $key => $order)
        {
            if ($order['column'] === $column)
            {
                unset($query->orders[$key]);
                $query->orders = array_values($query->orders);
            }
        }
    }


    /**
     * Add the not-sorted extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addNotSorted(Builder $builder)
    {
        $builder->macro('notSorted', function(Builder $builder)
        {
            $this->remove($builder);

            return $builder;
        });
    }

}