<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class CountriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_locations')->handle();

        return \View::make('admin/locations/countries/all')
                        ->with('page_title', 'Countries List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        \Policy::check('manage_locations')->handle();

        return \View::make('admin/countries/create')
                        ->with('page_title', 'Create Country');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        \Policy::check('manage_locations')->handle();

        $params = [
            'name' => Input::get('name'),
            'ID' => $request->session()->get('user_id')
        ];

        $response = \API::post('countries/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/countries')->with('success', 'Country ' . $response["data"]->name . ' has been created');
        } else {

            return redirect()->back()->withInput()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {

        \Policy::check('manage_locations')->handle();


        $response = \API::get('countries/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $country = $response["code"] == "200" ? $response["data"][0] : new \stdClass();


        return \View::make('admin/locations/countries/edit')
                        ->with('country', $country)
                        ->with('page_title', 'Update Country');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        \Policy::check('manage_locations')->handle();

        $params = [
            'ID' => $request->session()->get('user_id'),
            '_method' => 'PUT',
            'name' => Input::get('name')
        ];

        $response = \API::post('countries/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "Country " . $response["data"]->name . ' has been updated';

            return redirect('/admin/countries')->with('success', $message);
        } else {


            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {

        \Policy::check('manage_locations')->handle();
        if ($id == "1")
            return redirect('/admin/countries')->with('errors', ['Sorry , but this country is untouchable :D']);

        $response = \API::post('countries/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'Country ' . $response['data']->name . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {
        // dd($request);

        return
                (array)
                \API::get('countries/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

    public function getStates($id, Request $request) {
        $country = \API::get('countries/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $name = $country['code'] == 200 ? $country['data'][0]->name : "";
        return \View::make('admin/locations/countries/states')
                        ->with('id', $id)
                        ->with('name', $name)
                        ->with('page_title', 'Country States');
    }

    public function getStatesDataTable($id, Request $request) {
        return
                (array)
                \API::get('countries/' . $id . '/states/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
