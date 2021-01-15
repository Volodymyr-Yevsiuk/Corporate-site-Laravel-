<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Arr;

use App\Repositories\PortfoliosRepository;
use App\Repositories\MenusRepository;

use App\Models\Menu;

class PortfoliosController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep) {
        parent::__construct(new MenusRepository(new Menu));

            $this->p_rep = $p_rep;
    
            $this->template = config('settings.theme').'.portfolios';
    
            $this->keywords = 'Portfolios Page';
            $this->meta_desc ='Portfolios Page';
            $this->title = 'Portfolios';
    }

    public function index()
    {
        
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';

        $portfolios = $this->getPortfolios();

        $content = view(config('settings.theme').'.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        

        return $this->renderOutput();
    }


    public function getPortfolios($take = false, $paginate = true) {
        $portfolios = $this->p_rep->get('*', $take, $paginate);

        if($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }


    public function show($alias) {

        $portfolio = $this->p_rep->one($alias, $attr = []);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);


        $content = view(config('settings.theme').'.portfolio_content')->with(['portfolio'=>$portfolio, 'portfolios' => $portfolios])->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

    
        // dd($portfolios);

        return $this->renderOutput();

    }


  
    
}
