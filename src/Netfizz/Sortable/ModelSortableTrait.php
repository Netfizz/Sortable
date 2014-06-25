<?php namespace Netfizz\Sortable;

trait ModelSortableTrait {

    /**
     * Boot the sortable trait for a model.
     *
     * @return void
     */
    public static function bootModelSortableTrait()
    {
        static::addGlobalScope(new ModelSortableScope);
    }


    /**
     * Get a new query builder that excludes sort.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function notSorted()
    {
        return with(new static)->newQueryWithoutScope(new ModelSortableScope);
    }


    /**
     * Get the name of the "order" column.
     *
     * @return string
     */
    public function getOrderColumn()
    {
        return defined('static::ORDER') ? static::ORDER : 'order';
    }


    /**
     * Get the fully qualified "order" column.
     *
     * @return string
     */
    public function getQualifiedOrderColumn()
    {
        return $this->getTable().'.'.$this->getOrderColumn();
    }


} 