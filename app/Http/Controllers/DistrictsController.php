<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class DistrictsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_locations')->handle();

        return \View::make('admin/locations/districts/all')
                        ->with('page_title', 'Districts List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request) {

        \Policy::check('manage_locations')->handle();
        
        $state = \API::get('states/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $name = $state['code'] == 200 ? $state['data']->name : "";

        return \View::make('admin/locations/districts/create')
                        ->with('id', $id)
                        ->with('name', $name)
                        ->with('page_title', 'Create District');
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
            'state_id' => Input::get('state_id'),
            'ID' => $request->session()->get('user_id')
        ];

        $response = \API::post('districts/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/states/districts/' . $params['state_id'])->with('success', 'District ' . $response["data"]->name . ' has been created');
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


        $response = \API::get('districts/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $district = $response["code"] == "200" ? $response["data"] : new \stdClass();


        return \View::make('admin/locations/districts/edit')
                        ->with('district', $district)
                        ->with('page_title', 'Update District');
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
            'state_id' => Input::get('state_id')
        ];

        $response = \API::post('districts/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "District " . $response["data"]->name . ' has been updated';

            return redirect('/admin/states/districts/' . $params['state_id'])->with('success', $message);
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
            return redirect('/admin/districts')->with('errors', ['Sorry , but this district is untouchable :D']);

        $response = \API::post('districts/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'District ' . $response['data']->name . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function getDistricts($id, Request $request) {
        $state = \API::get('states/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $name = $state['code'] == 200 ? $state['data']->name : "";
        return \View::make('admin/locations/states/districts')
                        ->with('id', $id)
                        ->with('name', $name)
                        ->with('page_title', 'State Districts');
    }

    public function getDistrictsDataTable($id, Request $request) {
        return
                (array)
                \API::get('states/' . $id . '/districts/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
