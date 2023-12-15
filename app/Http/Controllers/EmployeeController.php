<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //
    public function loginForm()
    {
        // session()->flush();
        return view('employee.auth.login');
    }
    public function login(Request $request)
    {
        $employee = Employee::where('email', $request->email)->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            $error = 'Employee email or Password is not matched';
            return view('employee.auth.login', compact('error'));
        } else {
            session()->forget('user');
            session()->forget('admin');
            session()->put('employee', $employee);
        }
        return redirect('/hotel/');

    }
    public function logout()
    {
        session()->forget('employee');
        return redirect('/employee/login');
    }
    public function index()
    {
        $employee = session('employee');
        $rooms = Room::where('hotel_id', $employee->hotel_id)->paginate(10);

        // $hotels = Hotel::all();

        $amenities = Amenity::whereIn('room_id', $rooms->pluck('id'))
            ->get()
            ->groupBy('room_id');

        $images = RoomImage::whereIn('room_id', $rooms->pluck('id'))
            ->get()
            ->groupBy('room_id');

        $enumAmenities = ['BreakFast', 'Air Conditioning', 'Bath Tub', 'Garage', 'Pool', 'Bar', 'Internet', 'Sofa', 'Toilet Faucet', 'Love Chair Sofa'];

        return view('employee.contents.room', compact('rooms', 'amenities', 'images', 'enumAmenities'));
    }
    public function getEmployee()
    {
        $employees = Employee::where('hotel_id', session('employee')->hotel_id)->get();
        return view('employee.contents.employee', compact('employees'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:employees|max:255',
            'password' => 'required|string|min:8',
            'position' => 'required|string',
            'salary' => 'numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/employee/get')
                ->withErrors($validator)
                ->withInput();
        }

        $employee = new Employee;
        $employee->full_name = $request->input('full_name');
        $employee->email = $request->input('email');
        $employee->password = $request->input('password');
        $employee->position = $request->input('position');
        $employee->salary = $request->input('salary');
        if (session()->has('employee')) {
            $employee->hotel_id = session()->get('employee')->hotel_id;
        } else {
            $employee->hotel_id = $request->input('hotel_id');
        }
        $employee->save();

        return redirect()->back()->with('success', 'Successfully created');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'position' => 'required|string',
            'salary' => 'numeric',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee = Employee::find($id);
        $employee->full_name = $request->input('full_name');
        $employee->email = $request->input('email');
        $employee->position = $request->input('position');
        $employee->salary = $request->input('salary');

        $employee->save();

        return redirect()->back()->with('success', 'Successfully created');
    }
    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Successfully deleted.');
    }
    public function admin()
    {
        $employees = Employee::with('hotel')->orderBy('hotel_id')->paginate(10);
        $hotels = Hotel::all();
        return view('admin.contents.employee', compact('employees', 'hotels'));
    }
}
