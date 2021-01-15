<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Repositories\MenusRepository;

class SiteController extends Controller
{
    
    protected $p_rep; // Репозиторій для портфоліо
    protected $s_rep; // Репозиторій для слайдера
    protected $a_rep; // Репозиторій для постів(articles)
    protected $m_rep; // Репозиторій для menus

    protected $keywords; // Для зберігання ключів
    protected $meta_desc; // 
    protected $title; // 

    protected $template; // Шаблон, який містить назву шаблона який показується

    protected $vars = []; // Масив даних які передаються з шаблоном

    protected $contentRightBar = false; // Чи є правий сайдбар
    protected $contentLeftBar = false; // Чи є лівий сайдбар

    protected $bar = 'no'; // Чи є взагалі сайдбар і який

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
        
    }

    protected function renderOutput() {

        $menu = $this->getMenu();

        // dd($menu);

        $navigation = view(config('settings.theme').".navigation")->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if($this->contentRightBar) {
            $rightBar = view(config('settings.theme').'.rightBar')->with('content_rightBar', $this->contentRightBar);
            $this->vars = Arr::add($this->vars, 'rightBar', $rightBar);
        }

        if($this->contentLeftBar) {
            $leftBar = view(config('settings.theme').'.leftBar')->with('content_leftBar', $this->contentLeftBar);
            $this->vars = Arr::add($this->vars, 'leftBar', $leftBar);
        }

        $this->vars = Arr::add($this->vars, 'bar', $this->bar);

        $this->vars = Arr::add($this->vars, 'keywords', $this->keywords);
        $this->vars = Arr::add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = Arr::add($this->vars, 'title', $this->title);


        $footer = view(config('settings.theme').'.copyright')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {

        $menu = $this->m_rep->get(); 

        $mBuilder = \Menu::make('MyNav', function($m) use ($menu) {
            foreach($menu as $item) {

                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        return $mBuilder;
        
    }

}
