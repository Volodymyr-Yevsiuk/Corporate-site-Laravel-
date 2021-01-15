<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Repository;

class CommentsRepository extends Repository {

    public function __construct(Comment $comment) {

        $this->model = $comment;
        
    }

}


?>