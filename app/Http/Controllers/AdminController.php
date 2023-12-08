<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
     //admin change password
     public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        /*
        1. Old password must be fill.
        2. New password must be fill.
        3. COnfirm password must be fill.
        4. New and Confirm password are the same
        5. password change
        */
        $this->passwordValidatorCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword,$dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];

            User::where('id',Auth::user()->id)->update($data);

            Auth::logout();
            return redirect()->route('auth#loginPage');
            // dd('success');
        }
        else{
            return back()->with(['notMatch' => 'The old password does not match!Try Again...']);
        }

    }

    //direct admin details
    public function details(){
        return view('admin.account.details');
    }

    //admin profile edit
    public function edit(){
        return view('admin.account.edit');
    }

    //update profile data
    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details');
    }

    //admin list
    public function list(){
        $admin = User::where('role','admin')
                        ->when(request('key'),function($query){
                        $query->where('name','like','%'.request('key').'%')
                              ->where('email','like','%'.request('key').'%')
                              ->where('gender','like','%'.request('key').'%')
                              ->where('address','like','%'.request('key').'%')
                              ->where('phone','like','%'.request('key').'%');
                        })
                        ->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.list',compact('admin'));
    }

    //delete admin list
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    //change role Page
    public function changeRolePage($id){
        $data = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('data'));
    }

    //change role
    public function change($id,Request $request){
        $updateRole = $this->requestUserData($request);
        User::where('id',$id)->update($updateRole);
        return redirect()->route('admin#list');
    }

    //change Role with Ajax
    public function changeRole(Request $request){
        logger($request->all());
        User::where('id',$request->adminId)->update([
            'role' => $request->role
        ]);
    }

    //user contact page
    public function userContactPage(){
        $data = Contact::get();
        return view('admin.user.contactList',compact('data'));
    }

    //user contact delete
    public function userContactDelete($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Contact delete Successful!']);
    }

    //user edit page
    public function userEditPage($id){
        $userData = User::where('id',$id)->first();
        // dd($userData->toArray());
        return view('admin.user.editUser',compact('userData'));
    }

    //user update data
    public function userUpdateInfo(Request $request,$id){
        $this->accountValidationCheck($request);
        $updateData = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImageName = $dbImage->image;

            if($request->image != null){
                Storage::delete('public/'.$dbImageName);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/',$fileName);
            $updateData['image'] = $fileName;

        }

        User::where('id',$id)->update($updateData);
        return redirect()->route('admin#userList');
        // dd($id);
    }

    //request user data
    private function requestUserData($request){
        return [
            'role' => $request->role
        ];
    }

    //check validation
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg|file',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();
    }

    //get userData
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    //validation password
    private function passwordValidatorCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword'
        ])->validate();

    }
}

/*
join For image --
php artisan storage:link
*/
