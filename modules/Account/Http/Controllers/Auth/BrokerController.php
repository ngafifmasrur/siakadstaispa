<?php

namespace Modules\Account\Http\Controllers\Auth;

use App\Models\UserPasswordReset;
use Modules\Account\Repositories\UserRepository;
use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class BrokerController extends Controller
{
    /**
     * Repository pattern.
     */
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     */
    public function index()
    {
        return view('account::auth.repass')->with([
                    'token' => request('token')
                ]);
    }

    /**
     * Break the user password.
     */
    public function broke(Request $request)
    {
        $request->validate($this->validator());

        if ($this->attemptBroke($request->only(['token', 'password']))) {

            return redirect()->route('account.login')
                             ->with(['success' => 'Sukses, password telah berhasil dirubah.']);

        }

        return redirect()->route('account.login')
                         ->withInput(['token'])
                         ->withErrors(['password' => 'Mohon maaf, terjadi kegagalan, token telah kadaluarsa.']);
    }

    /**
     * --------------------------------------------------
     * --------------------------------------------------
     * --------------------------------------------------
     */

    /**
     * Validate the request.
     */
    public function validator()
    {
        return [
            'password'   => 'required|string|min:4|max:191|confirmed',
        ];
    }

    /**
     * Attempt broke.
     */
    public function attemptBroke(array $data)
    {
        if ($broker = UserPasswordReset::where('token', $data['token'])->where('expired_in', '>=', time())->first()) {

            $data['password'] = bcrypt($data['password']);

            $user = $this->repo->update($data, $broker->user);

            $broker->delete();

            return $user;
        }

        return false;
    }
}
