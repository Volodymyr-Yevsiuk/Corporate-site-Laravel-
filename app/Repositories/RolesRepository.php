<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Repository;

class RolesRepository extends Repository {

    public function __construct(Role $role) {

        $this->model = $role;
        
    }

}
?>