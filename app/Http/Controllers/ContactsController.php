<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    
    public function __construct() {

        parent::__construct(new \App\Repositories\MenusRepository(new \App\Models\Menu));

        $this->template = config('settings.theme').'.contacts';

        $this->bar = 'left';

    }


    public function index(Request $request)
    {

        if($request->isMethod('post')) {
            $messages = [
                'required' => "Поле :attribute обов'язкове для заповнення", 
                'email' => "Поле :attribute повинно бути правильним емейлом"
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            $data = $request->all();

             //mail

            $result = Mail::send(config('settings.theme').'.email', ['data' => $data], function($message) use ($data) {

                $mail_admin = config('settings.mail_admin');

                $message->from($data['email'], $data['name']);
                $message->to($mail_admin)->subject('Question');

            });

            if ($result) {
                return redirect()->route('contacts')->with('status', 'Email is send');
            }

        }
        $this->title = 'Контакты';

        $content = view(config('settings.theme').'.contact_content')->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->contentLeftBar = view(config('settings.theme').'.contact_bar')->render();

        return $this->renderOutput();
    }


}
