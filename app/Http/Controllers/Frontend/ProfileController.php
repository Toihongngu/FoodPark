<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileAvatarUpdateRequest;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        toastr('Update Successfuly!', 'success');
        return redirect()->back();
    }

    public function updatePasswordProfile(ProfilePasswordUpdateRequest $request)
    {
        $user = Auth::user();

        $user->password = bcrypt($request->password);
        $user->save();
        toastr('Password Update Successfuly!', 'success');
        return redirect()->back();
    }
    public function updateAvatarProfile(ProfileAvatarUpdateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'avatar');
        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->save();
        return response(['status'=>'success' , 'message'=>'Avatar Update Successfully']);
    }
}
