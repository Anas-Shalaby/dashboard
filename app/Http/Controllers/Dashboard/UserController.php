<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{

    public function __construct()
    {

        // create , read , update , delete
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');

    }// end of constructor


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::whereHasRole('admin')->where(function($query) use($request){
            return $query->when($request->search ,function($q) use($request){
                return $q->where('first_name',  'like' , '%' . $request->search . '%')
                    ->orWhere('last_name',  'like' , '%' . $request->search . '%');
            });

        })->latest()->paginate(4);
        return view('dashboard.users.index' ,compact('users'));


    } // end of index


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }// end of create

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'image'=>'image|mimes:jpeg,png,jpg,gif',
            'permissions'=>'required',
        ]);



        $request_data = $request->except(['password' , 'password_confirmation ','permissions' ,'image' ]);

        $request_data['password'] = bcrypt($request->password);

        if ($request->image)
        {
            $img = Image::make($request->image);
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));


            $request_data['image'] = $request->image->hashName();

        }// end of if

        $user = User::create($request_data);

        $user->addRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.added_successfully'));

        return redirect(route('dashboard.users.index'));
    } // end of store


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    } // end of edit

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required' , Validation\Rule::unique('users')->ignore($user->id)],
            'image'=>'image|mimes:jpeg,png,jpg,gif',
            'permissions'=>'required|min:1',

        ]);


        $request_data = $request->except(['permissions','image']);
        if ($request->image)
        {
            if($user->image != 'default.png')
            {


                Storage::disk('public_uploads')->delete('users_images/'.$user->image);


            }// end of internal if


            $img = Image::make($request->image);
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/' . $request->image->hashName()));


            $request_data['image'] = $request->image->hashName();
        }// end of if
        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.updated_successfully'));

        return redirect(route('dashboard.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if ($user->image != 'default.png'){

            Storage::disk('public_uploads')->delete('users_images/'.$user->image);

        }
        $user->delete();


        session()->flash('success',__('site.deleted_successfully'));

        return redirect(route('dashboard.users.index'));
    }
}
