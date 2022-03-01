<?php

namespace Modules\Account\Http\Controllers;

use App\Models\User;
use Modules\Account\Repositories\UserRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppController;

class Controller extends AppController
{
    /**
     * Instance the main property.
     */    
    public $user;

    /**
     * Create a new controller instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        return view('account::home');
    }
}
