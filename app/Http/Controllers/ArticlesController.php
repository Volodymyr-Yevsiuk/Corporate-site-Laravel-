<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Repositories\PortfoliosRepository;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;

use App\Models\Category;

class ArticlesController extends SiteController
{
    
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep) {

        parent::__construct(new \App\Repositories\MenusRepository(new \App\Models\Menu));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

        $this->template = config('settings.theme').'.articles';
        $this->bar = 'right';

        $this->keywords = 'Home Page';
        $this->meta_desc ='Home Page';
        $this->title = 'Home Page';

    }


    public function index($cat_alias = false)
    {
        
        $articles = $this->getArticles($cat_alias);  
        
        $this->title = 'Категория';
        $this->keywords = 'String';
        $this->meta_desc = 'String';


        $content = view(config('settings.theme').'.articles_content')->with('articles', $articles)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('settings.theme').'.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios]);

        return $this->renderOutput();
    }


    public function show($alias = false)
    {

        $article = $this->a_rep->one($alias, ['comments' => true]);
        
        if($article) {
            $article->img = json_decode($article->img);
        }

        if(isset($article)) {
            $this->title = $article->title;
            $this->keywords = $article->keywords;
            $this->meta_desc = $article->meta_desc;
        }
      

        $content = view(config('settings.theme').'.article_content')->with('article', $article)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('settings.theme').'.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios]);

        return $this->renderOutput();
       
    }


    public function getComments($take) {

        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        // if($comments) {
        //     $comments->load('article', 'user');
        // }

        return $comments;
    }


    public function getPortfolios($take) {

        $portfolios = $this->p_rep->get(['text', 'title', 'customer', 'alias', 'img', 'filter_alias'], $take);;

        return $portfolios;
    }


    public function getArticles($alias = false) {

        $where = false;

        if($alias) {
            // WHERE `alias` = $alias
            $id = Category::select('id')->where('alias', $alias)->first()->id;

            // WHERE `category_id` = $id
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id', 'keywords', 'meta_desc'], false, true, $where);

        if($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;

    }


}
