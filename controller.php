<?php
function create_column_to_readable($column)
{
$new_column_name="";
$column_name_captalize=ucwords($column);
$column_arr=preg_split("/[-,_,#,\s]+/", $column_name_captalize);
foreach($column_arr as $data):
$new_column_name.=ucwords($data)." ";
endforeach;

return	$new_column_name;	

}


function get_controller_data($arr,$table_name,$controller_name,$model_name)
{

	$page_data = <<<EOF
<?php

namespace App\Http\Controllers;
use App\Models\\$model_name;
use Illuminate\Http\Request;

class $controller_name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \$data = $model_name::orderBy('created_date', 'desc')->paginate(5); 
        return view('$model_name/index', compact('data'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store(Request \$request)
    {
        \$request->validate([
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'image'         =>  'required|image|max:2048'
        ]);

        \$image = \$request->file('image');

        \$new_name = rand() . '.' . \$image->getClientOriginalExtension();
        \$image->move(public_path('images'), \$new_name);
        \$form_data = array(
            'first_name'       =>   \$request->first_name,
            'last_name'        =>   \$request->last_name,
            'image'            =>   \$new_name
        );

        $model_name::create(\$form_data);

        return redirect('route_url')->with('success', 'Data Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function show(\$id)
    {
        \$data = $model_name::findOrFail(\$id);
        return view('view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
        \$data = $model_name::findOrFail(\$id);
        return view('edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function update(Request \$request, \$id)
    {
        \$image_name = \$request->hidden_image;
        \$image = \$request->file('image');
        if(\$image != '')
        {
            \$request->validate([
                'first_name'    =>  'required',
                'last_name'     =>  'required',
                'image'         =>  'image|max:2048'
            ]);

            \$image_name = rand() . '.' . \$image->getClientOriginalExtension();
            \$image->move(public_path('images'), \$image_name);
        }
        else
        {
            \$request->validate([
                'first_name'    =>  'required',
                'last_name'     =>  'required'
            ]);
        }

        \$form_data = array(
            'first_name'       =>   \$request->first_name,
            'last_name'        =>   \$request->last_name,
            'image'            =>   \$image_name
        );
  
        $model_name::whereId(\$id)->update(\$form_data);

        return redirect('route_url')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\$id)
    {
        \$data = $model_name::findOrFail(\$id);
        \$data->delete();

        return redirect('route_url')->with('success', 'Data is successfully deleted');
    }
}

	
	
EOF;



	return	$page_data;

}


?>