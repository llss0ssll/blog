<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/avatar/';
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

public function show($id){
    $user = $this->user->findOrFail($id);
    return view('users.show')->with('user',$user);
}



public function edit($id){
    $user = $this->user->findOrFail($id);
    return view('users.edit')->with('user',$user);
}

public function update(Request $request){

    // validate input
    $request->validate([
        'name' => 'required|min:1|max:50', //less than 50 char o not greater than
        'email' => 'required|min:1|max:50|unique:users,email,' . Auth::user()->id,
    ]);
    //unique means no dupulicate
    // user table
    // email column
    // except the user who is currently logged in

    // getting the user currently log in
    $user = $this->user->findOrFail(Auth::user()->id);
    $user->name = $request->name;
    $user->email = $request->email;

    // check if user update image
    if($request->avatar){


        $request->validate([
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        // check if the user has already an avatar
        if($user->avatar){

            $this->deleteAvatar($user->avatar);
        }


        // saving the image to  storage
        $user->avatar = $this->saveAvatar($request);
        // saveAvatar is user defines function
    }
    $user->save();
    return redirect()->route('profile.show', $user->id);
}

public function saveAvatar($request){
    // rename the file to prevent duplicate - overwrite
    $avatar_name = time()."".$request->avatar->extension();

    //saving to strage folder
    $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER,$avatar_name);

    // return the avatar name to be save in db
    return $avatar_name;
}

public function deleteAvatar($avatar_name){
    $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;

    // check if the user has already
    if(Storage::disk('local')->exists($avatar_path)){


        Storage::disk('local')->delete($avatar_path);
    }
}

public function change_password(){
    return view('users.change_password');
}

public function update_password(Request $request){
    if(!Hash::check($request->current_password, Auth::user()->password)){
        return redirect()->back()->with('current_password_error','Incorrect current password')->with('error_password',
        'Unable to change password');
    }
    if($request->current_password === $request->new_password){
        return redirect()->back()->with('current_password_error','New password cannot be the same with current password')->with('error_password',
        'Unable to change password');

    }
    $request->validate([
        'new_password' => ['required','confirmed',Password::min(8)->letters()->numbers()]
    ]);
    $user = $this->user->findOrFail(Auth::user()->id);
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success_password','Password Changed Successfully');
}
}
