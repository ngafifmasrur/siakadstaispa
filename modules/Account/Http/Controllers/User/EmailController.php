<?php

namespace Modules\Account\Http\Controllers\User;

use App\Models\User;
use App\Models\UserEmail;
use App\Repositories\UserEmailRepository;
use Modules\Account\Notifications\EmailVerificationNotification;
use Modules\Account\Http\Requests\User\UpdateEmailRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class EmailController extends Controller
{
    /**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserEmailRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::user.email.index');
    }

    /**
     * Update data.
     */
    public function update(UpdateEmailRequest $request)
    {
        $data = [
            'address'        => $request->input('email'),
            'verified_at'    => null
        ];

        // if($data['address'] != auth()->user()->email->address) {
        //     if ($user = $this->repo->update($data, auth()->user())) {

        //         $email = UserEmail::where('user_id', $user->id)->firstOrFail();

        //         return redirect()->route('account.user.email.reverify', ['uid' => encrypt($email->id), 'next' => route('account.user')]);
        //     }

        //     return redirect()->back()
        //                      ->withInput()
        //                      ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
        // }

        return redirect($request->get('next', route('account.home')));
    }

    /**
     * Reverifyig email.
     */
    public function reverify(Request $request)
    {
        $email = UserEmail::with('user')->whereNull('verified_at')->findOrFail(decrypt($request->get('uid')));

        if($this->sendEmailVerification($email->user, $email)) {

            return redirect($request->get('next', route('account.home')))
                        ->with(['success' => 'Kami telah mengirimkan tautan verifikasi ke <strong>'.$email->address.'</strong>.']);
        
        }

        return redirect()->back()
                         ->with(['danger' => 'Mohon maaf, terjadi kegagalan, silahkan ulangi beberapa saat lagi!']);
    }

    /**
     * Verify email address.
     */
    public function verify(Request $request)
    {
        $email = UserEmail::whereNull('verified_at')->findOrFail(decrypt($request->get('token')));

        $data = [
            'verified_at' => now()
        ];

        if ($this->repo->update($data, $email->user)) {
            return view('account::user.email.verified', compact('email'));
        }

        return abort(500);
    }

    /**
     * --------------------------------------------------
     * --------------------------------------------------
     * --------------------------------------------------
     */

    /**
     * Send to email.
     */
    public function sendEmailVerification(User $user, $email)
    {
        $link = route('account.user.email.verify', ['token' => encrypt($email->id)]);

        $user->notify(new EmailVerificationNotification($link));

        return true;
    }
}
