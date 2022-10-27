<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
// return view index;
    public function index(){
        return view('index');
    }
//add Employee in the Database
    public function store(Request $request){

      $file=$request->file('avatar');
      $fileName=time().'.'.$file->getClientOriginalExtension();
      $file->storeAs('public/imges',$fileName);
      $empData = [
        'first_name' => $request->fname,
         'last_name' =>$request->lname,
        'email' =>$request->email, 
        'phone' => $request->phone, 
        'post' =>$request->post, 
        'avatar' =>$fileName
    ];
  
      //Employee::create($empData);
      DB::table('employees')->insert($empData);
      return response()->json(['status'=>200,]);
    }

// fatch all data in the database and show tabel
public function fetchall() {
    $emps = Employee::all();
    $output = '';
    if ($emps->count() > 0) {
        $output .= '<table class="table table-striped table-sm text-center align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Post</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>';
        //storage\imges\
        foreach ($emps as $emp) {
            $output .= '<tr>
            <td>' . $emp->id . '</td>
            <td><img src="storage/imges/' . $emp->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>
            <td>' . $emp->first_name . ' ' . $emp->last_name . '</td>
            <td>' . $emp->email . '</td>
            <td>' . $emp->post . '</td>
            <td>' . $emp->phone . '</td>
            <td>
              <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

              <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
            </td>
          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    } else {
        echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
}

// click on edit button so show all data in the form
public function edit(Request $request){
  $id=$request->id;
  $emp=Employee::find($id);
  return response()->json($emp);

}

//update Employee in the Database
public function Update(Request $request){
  $fileName='';
  $emp=Employee::find($request->emp_id);
  if($request->hasFile('avatar')){
    $file=$request->file('avatar');
    $fileName=time().'.'.$file->getClientOriginalExtension();
    $file->storeAs('public/imges',$fileName);
    if(Storage::exists('/public/imges/'.$emp->avatar)){
      
      Storage::delete('/public/imges/'.$emp->avatar);
      
  }
  }else{
    $fileName= $request->emp_avatar;
  }
 
      $empData = [
        'first_name' => $request->fname,
         'last_name' =>$request->lname,
        'email' =>$request->email, 
        'phone' => $request->phone, 
        'post' =>$request->post, 
        'avatar' =>$fileName
    ];
  
      $emp->Update( $empData);
      return response()->json(['status'=>200,]);

}

public function delete(Request $request) {
		$id = $request->id;
		$emp = Employee::find($id);
    if(Storage::exists('/public/imges/'.$emp->avatar)){
      
      Storage::delete('/public/imges/'.$emp->avatar);
      Employee::where('id', $id)->delete();
  }
  Employee::where('id', $id)->delete();
	}
}
