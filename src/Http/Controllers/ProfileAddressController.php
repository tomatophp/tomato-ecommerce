<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoAdmin\Facade\Tomato;
use TomatoPHP\TomatoCrm\Models\Location;
use TomatoPHP\TomatoCrm\Tables\LocationTable;

class ProfileAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Location::query();
        $query->where('account_id', auth('accounts')->user()->id);
        $table = new LocationTable($query);
        return view('tomato-ecommerce::profile.address.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tomato-ecommerce::profile.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'account_id' => auth('accounts')->user()->id
        ]);

        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'street' => 'required|max:255|string',
            'area' => 'nullable|max:255|string',
            'city' => 'nullable|max:255|string',
            'country' => 'nullable|max:255|string',
            'home_number' => 'nullable',
            'flat_number' => 'nullable',
            'floor_number' => 'nullable',
            'mark' => 'nullable|max:255|string',
            'map_url' => 'nullable|max:65535',
            'note' => 'nullable|max:255|string',
            'lat' => 'nullable|max:255|string',
            'lng' => 'nullable|max:255|string'
        ]);

        $address = Location::create($request->all());

        if(auth('accounts')->user()->locations()->count() === 1){
            auth('accounts')->user()->address = $address->street;
            auth('accounts')->user()->save();

            auth('accounts')->user()->meta('city_id', $address->city_id);
            auth('accounts')->user()->meta('area_id', $address->area_id);
            auth('accounts')->user()->meta('country_id', $address->country_id);
        }

        Toast::success(__('Location created successfully'))->autoDismiss(2);
        return redirect()->back();

    }

    /**
     * Show the specified resource.
     */
    public function show(Location $address)
    {
        return view('tomato-ecommerce::profile.address.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $address)
    {
        return view('tomato-ecommerce::profile.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $address): RedirectResponse
    {
        $request->validate([
            'account_id' => 'sometimes|exists:accounts,id',
            'street' => 'sometimes|max:255|string',
            'area' => 'nullable|max:255|string',
            'city' => 'nullable|max:255|string',
            'country' => 'nullable|max:255|string',
            'home_number' => 'nullable',
            'flat_number' => 'nullable',
            'floor_number' => 'nullable',
            'mark' => 'nullable|max:255|string',
            'map_url' => 'nullable|max:65535',
            'note' => 'nullable|max:255|string',
            'lat' => 'nullable|max:255|string',
            'lng' => 'nullable|max:255|string'
        ]);

        $address->update($request->all());

        Toast::success(__('Location updated successfully'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $address)
    {
        $address->delete();

        Toast::success(__('Address Has Been Deleted'))->autoDismiss(2);
        return back();
    }

    public function select(Location $address){
        $account = auth('accounts')->user();
        $account->address = $address->street;
        $account->save();

        $account->meta('city_id', $address->city_id);
        $account->meta('area_id', $address->area_id);
        $account->meta('country_id', $address->country_id);

        Toast::success(__('Address Has Been Selected'))->autoDismiss(2);
        return redirect()->back();
    }
}
