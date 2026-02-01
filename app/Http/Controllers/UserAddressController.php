<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SaveAddressRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\AddressResource;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id',Auth::user()->id)->get();

        return AddressResource::collection($addresses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveAddressRequest $request)
    {
        try{
            $address = new UserAddress();
            $address->user_id = Auth::user()->id;
            $address->name = $request->name;
            $address->city = $request->city;
            $address->full_address = $request->full_address;
            if($request->is_default){
                $address->is_default = $request->is_default;
            }
            $address->save();
            
            return new SuccessResource(Response::HTTP_OK,"Address Added Successfuly.");
        }catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,null,$ex->getTrace());
        }  
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = UserAddress::find($id);
        Gate::authorize('view', $address);
        return new AddressResource($address);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveAddressRequest $request, string $id)
    {
        // This checks the 'update' method in AddressPolicy
        $address = UserAddress::find($id);
        Gate::authorize('update', $address);
        //$this->authorize('update', $address);
        try{
            $address->name = $request->name;
            $address->city = $request->city;
            $address->full_address = $request->full_address;
            if($request->is_default){
                $address->is_default = $request->is_default;
            }
            $address->save();
            
            return new SuccessResource(Response::HTTP_OK,"Address Updated Successfuly.");
        }catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,null,$ex->getTrace());  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = UserAddress::find($id);
        Gate::authorize('delete', $address);
        $address->delete();
        return new SuccessResource(Response::HTTP_OK,"Address Deleted Successfuly.");  
    }
}
