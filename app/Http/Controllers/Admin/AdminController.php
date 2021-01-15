<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    
    protected $p_rep; // portfolio
    protected $a_rep; // articles
    protected $user; // user object
    protected $template; //template view
    protected $content = false;
    protected $title;
    protected $vars; //array for template view

    public function __construct()
    {
        

    }


    public function renderOutput() {

        $this->user = Auth::user();
        
        if(!$this->user) {
            abort(403);
        }

        $this->vars = Arr::add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $navigation = view(config('settings.theme').'.admin.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if($this->content) {
            $this->vars = Arr::add($this->vars, 'content', $this->content);
        }

        $footer = view(config('settings.theme').'.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }


    public function getMenu() {
        return \Menu::make('adminMenu', function($menu) {

            if(Gate::allows('VIEW_ADMIN_ARTICLES')) {
                $menu->add('Статьи', ['route'=>'adminArticles.index']);
            }
            
            if(Gate::allows('VIEM_ADMIN_PORTFOLIOS')) {
                $menu->add('Портфолио', ['route'=>'adminArticles.index']);
            }
            
            if(Gate::allows('VIEM_ADMIN_MENU')) {
                $menu->add('Меню', ['route'=>'menus.index']);
            }
            
            if(Gate::allows('VIEM_ADMIN_USERS')) {
                $menu->add('Пользователи', ['route'=>'users.index']);
            }
            
            if(Gate::allows('VIEM_ADMIN_PERMISSIONS')) {
                $menu->add('Привилегии', ['route'=>'permissions.index']);
            }

        });
    }

}
