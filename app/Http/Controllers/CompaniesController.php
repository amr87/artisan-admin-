<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class CompaniesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_companies')->handle();

        return \View::make('admin/companies/all')
                        ->with('page_title', 'Companies List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        \Policy::check('manage_companies')->handle();

        return \View::make('admin/companies/create')
                        ->with('page_title', 'Create Company');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        \Policy::check('manage_companies')->handle();

        $params = [
            'name' => Input::get('name'),
            'address' => Input::get('address'),
            'phone' => Input::get('phone'),
            'email' => Input::get('email'),
            'logo' => Input::get('logo'),
            'ID' => $request->session()->get('user_id')
        ];

        $response = \API::post('companies/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/companies')->with('success', 'Company ' . $response["data"][0]->name . ' has been created');
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

        \Policy::check('manage_companies')->handle();


        $response = \API::get('companies/profile/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $company = $response["code"] == "200" ? $response["data"] : new \stdClass();

        return \View::make('admin/companies/edit')
                        ->with('company', $company)
                        ->with('page_title', 'Update Company');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        \Policy::check('manage_companies')->handle();

        $params = [
            'name' => Input::get('name'),
            'address' => Input::get('address'),
            'phone' => Input::get('phone'),
            'email' => Input::get('email'),
            'logo' => Input::get('logo'),
            'ID' => $request->session()->get('user_id'),
            '_method' => 'PUT',
        ];

        $response = \API::post('companies/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "Company " . $response["data"][0]->name . ' has been updated';

            return redirect('/admin/companies')->with('success', $message);
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

        \Policy::check('manage_companies')->handle();


        $response = \API::post('companies/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'Company ' . $response['data']->name . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {
        // dd($request);

        return
                (array)
                \API::get('companies/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
