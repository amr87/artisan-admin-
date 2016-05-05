<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class CategoriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        \Policy::check('manage_categories')->handle();

        return \View::make('admin/workshops/categories/all')
                        ->with('page_title', 'Categories List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        \Policy::check('manage_categories')->handle();
        $response = \API::get('categories/', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $categories = $response["code"] == "200" ? $response["data"] : [];
        return \View::make('admin/workshops/categories/create')
                        ->with('categories', $categories)
                        ->with('page_title', 'Create Category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        \Policy::check('manage_categories')->handle();

        $params = [
            'name' => Input::get('name'),
            'parent_id' => Input::get('parent_id'),
            'ID' => $request->session()->get('user_id')
        ];

        $response = \API::post('categories/create', ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "201") {

            return redirect('/admin/categories')->with('success', 'Category ' . $response["data"]->name . ' has been created');
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

        \Policy::check('manage_categories')->handle();


        $response = \API::get('categories/show/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);

        $category = $response["code"] == "200" ? $response["data"] : new \stdClass();

        $response = \API::get('categories/', ['Authorization' => $request->session()->get('user_data')['auth']], ['ID' => $request->session()->get('user_id')]);
        $categories = $response["code"] == "200" ? $response["data"] : [];
        return \View::make('admin/workshops/categories/edit')
                        ->with('category', $category)
                        ->with('categories', $categories)
                        ->with('page_title', 'Update Category');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        \Policy::check('manage_categories')->handle();

        $params = [
            'ID' => $request->session()->get('user_id'),
            '_method' => 'PUT',
            'name' => Input::get('name'),
            'parent_id' => Input::get('parent_id'),
        ];

        $response = \API::post('categories/update/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], $params);


        if ($response["code"] == "200") {

            $message = "Category " . $response["data"]->name . ' has been updated';

            return redirect('/admin/categories')->with('success', $message);
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

        \Policy::check('manage_categories')->handle();


        $response = \API::post('categories/delete/' . $id, ['Authorization' => $request->session()->get('user_data')['auth']], ['_method' => 'DELETE', 'ID' => $request->session()->get('user_id')]);
        if ($response["code"] == "200") {

            return redirect()->back()->with('success', 'Category ' . $response['data']->name . ' deleted successfuly');
        } else {

            return redirect()->back()->with('errors', $response['data']->messages);
        }
    }

    public function dataTables(Request $request) {
        // dd($request);

        return
                (array)
                \API::get('categories/dataTables', ['Authorization' => $request->session()->get('user_data')['auth']], array_merge(Input::all(), ['ID' => $request->session()->get('user_id')])
                )['data'];
    }

}
