<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EditProfileRequest;
use App\Models\Administrator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AccountsController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Dashboard';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'dashboard';

    public function dashboard()
    {
        try {
            config(['app.name' => __('Dashboard')]);

            return view('backEnd.accounts.dashboard');
        } catch (Exception $exc) {
            abort(404);
        }
    }

    public function showEditForm()
    {
        config(['app.name' => 'Edit Profile']);

        return view('backEnd.accounts.edit_profile');
    }

    public function editProfile(EditProfileRequest $request)
    {
        try {
            $updateData = [];
            $updateData = $request->all();
            $admin = Administrator::findOrFail(Auth::guard('administrator')->user()->id);
            if ($request->has('current_password') || $request->has('new_password') || $request->has('confirm_password')) {
                if (!empty($request->new_password) && !empty($request->current_password)) {
                    if (Hash::check($request->current_password, $admin->password)) {
                        $updateData['password'] = $request->new_password;
                    } else {
                        $request->session()->flash('error', 'Please enter valid passwords.');

                        return back();
                    }
                } else {
                    $request->session()->flash('error', 'Please enter valid passwords.');

                    return back();
                }
            }
            if (!empty($request->file('avatar'))) {
                $avatarName = $this->saveAvatar($request->file('avatar'));
                if ($avatarName) {
                    $updateData['avatar'] = $avatarName;
                    $this->deleteAvatar($admin->avatar);
                } else {
                    $updateData['avatar'] = $admin->avatar;
                }
            }
            if ($admin->update($updateData)) {
                $request->session()->flash('success', 'Profile updated successfully.');

                return redirect()->route('administrator.edit.form')->with('success', 'Profile updated successfully');
            }
            $request->session()->flash('error', 'Profile not updated successfully.');
        } catch (Exception $exc) {
            $request->session()->flash('error', 'Profile not updated successfully.');
        }
    }

    /**
     * Upload avtar
     * @param Array $avatar
     * @return bool
     */
    public function saveAvatar($avatar = [])
    {
        $name = Storage::disk(config('constants.IMAGE_PATH.DRIVER'))->put(config('constants.IMAGE_PATH.AVATAR'), $avatar);

        return ($name) ? $avatar->hashName() : false;
    }

    public function deleteAvatar($avatar = null)
    {
        $imagePath = config('constants.IMAGE_PATH.AVATAR') . $avatar;
        $disk = Storage::disk(config('constants.IMAGE_PATH.DRIVER'));
        if ($disk->exists($imagePath)) {
            $disk->delete($imagePath);
        }

        return true;
    }

    /**
     * Check email for user
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkEmail(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $checkEmail = Administrator::notDeleted()->where('email', $request['email']);
        if (!empty($request['id'])) {
            $checkEmail->where('id', '<>', $request['id']);
        }
        $flag = $checkEmail->count() > 0 ? 'false' : 'true';

        return $flag;
    }

    public function checkPassword(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $administrators = Administrator::where('id', '=', $request->id)->get();
        if ($administrators->count() > 0 && (Hash::check($request->current_password, $administrators[0]->password))) {
            $flag = 'true';
        } else {
            $flag = 'false';
        }

        return $flag;
    }
}
