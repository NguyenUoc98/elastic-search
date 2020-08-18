<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use ElasticScoutDriverPlus\CustomSearch;

class Test extends Model
{
    use Searchable, CustomSearch;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'tests_index';
    }
}
