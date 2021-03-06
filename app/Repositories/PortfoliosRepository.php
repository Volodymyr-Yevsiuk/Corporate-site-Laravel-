<?php

namespace App\Repositories;

use App\Models\Portfolio;
use App\Repositories\Repository;

class PortfoliosRepository extends Repository {

    public function __construct(Portfolio $portfolio) {
        $this->model = $portfolio;   
    }

    public function one($alias, $attr = []) {
        $portfolio = parent::one($alias);

        if($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }

        return $portfolio;

    }

}


?>