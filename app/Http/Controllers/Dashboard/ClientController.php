<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request){

        $clients = Client::when($request->search , function($q) use ($request){
            return $q->where('name' , 'like' , '%' . $request->search . '%' )
                ->orWhere('address', 'like','%'.$request->search . '%')
                ->orWhere('phone', 'like','%'.$request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.clients.index',compact('clients') );

    }// end of index
    public function create(){

        return view('dashboard.clients.create' );

    }// end of create
    public function store(Request $request){

        $rules = [
            'name'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'phone'=>['required ' , Rule::unique('clients' , 'phone')]
        ];

        $request->validate($rules);

        Client::create($request->all());


        session()->flash('success' , __('site.added_successfully'));

        return redirect(route('dashboard.clients.index' ));

    }// end of store
    public function edit(Client $client){

        return view('dashboard.clients.edit',compact('client'));

    }// end of edit

    public function update(Request $request , Client $client){
        $rules = [
            'name'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'phone'=>['required '],
        ];

        $request->validate($rules);

        $client->update($request->all());

        session()->flash('success' , __('site.updated_successfully'));

        return redirect(route('dashboard.clients.index'));


    }// end of update
    public function destroy(Client $client){


        $client->delete();


        session()->flash('success' , __('site.deleted_successfully'));

        return redirect(route('dashboard.clients.index'));

    }// end of destroy
}
