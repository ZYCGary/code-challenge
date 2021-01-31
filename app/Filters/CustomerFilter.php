<?php


namespace App\Filters;


use Illuminate\Http\Request;

class CustomerFilter
{
    protected $request;
    protected $queryBuilder;
    protected $filters = ['limit'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->queryBuilder = $builder;

        // Get filters passed from the request and exist in $this->>filters
        $filters = array_filter($this->request->only($this->filters));

        foreach ($filters as $filter => $value) {
            // $filter illustrates the method name called
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->queryBuilder;
    }

    protected function limit($filter)
    {
        switch ($filter) {
            case 'all':
                return $this->queryBuilder;
            case 'active':
            default:
                return $this->queryBuilder->where('active', 1);
            case 'not-active':
                return $this->queryBuilder->where('active', 0);
        }
    }
}
