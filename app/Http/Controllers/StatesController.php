<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class StatesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_locations')->handle();

        return \View::make('admin/locations/states/all')
                        ->with('page_title', 'States List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request) {

        \Policy::check('manage_locations')->handle();
        $country = \API::get('countries/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $name = $country['code'] == 200 ? $country['data'][0]->name : "";
        return \View::make('admin/locations/states/create')
                        ->with('id', $id)
                        ->with('name', $name)
                        ->with('page_title', 'Create State');
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
            'country_id' => Input::get('country_id'),
            'ID' => $request->session()->get('user_id')
        ];

        $response = \API::post('states/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/country/states/' . $params['country_id'])->with('success', 'State ' . $response["data"]->name . ' has been created');
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


        $response = \API::get('states/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $state = $response["code"] == "200" ? $response["data"] : new \stdClass();


        return \View::make('admin/locations/states/edit')
                        ->with('state', $state)
                        ->with('page_title', 'Update State');
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
            'name' => Input::get('name'),
            'country_id' => Input::get('country_id')
        ];

        $response = \API::post('states/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "State " . $response["data"]->name . ' has been updated';

            return redirect('/admin/country/states/' . $params['country_id'])->with('success', $message);
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
            return redirect('/admin/states')->with('errors', ['Sorry , but this country is untouchable :D']);

        $response = \API::post('states/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'State ' . $response['data']->name . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

}
