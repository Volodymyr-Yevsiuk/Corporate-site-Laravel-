<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'path', 'parent'];


    public function delete($options = []) {

        // $this - вказівник об'єкта даного класу
        self::where('parent', $this->id)->delete();

        return parent::delete($options);

    }

}
