<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use App\Models\BusSeat;
use App\Http\Requests\StoreBusSeatRequest;
use App\Http\Requests\UpdateBusSeatRequest;




class BusSeatController extends Controller
{
    const PATH_VIEW = 'admin.bus_seats.';

    public function index()
    {
        $data = BusSeat::with(['bus'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buses = Bus::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusSeatRequest $request)
    {

        $data = $request->all();
        $model = BusSeat::query()->create($data);
        if ($model) {
            $bus = Bus::find($model->bus_id); // Tìm xe tương ứng
            if ($bus) {
                $bus->is_active = true; // Hoặc là bạn có thể tạo một trường mới để đánh dấu
                $bus->save(); // Lưu thay đổi vào cơ sở dữ liệu
            }
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BusSeat $busSeat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusSeat $busSeat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBusSeatRequest $request, string $id)
    {
        $data = BusSeat::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Chuyến xe không sửa thành công');
        }
    }

    public function destroy(string $id)
    {
        $data = BusSeat::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.bus_seats.index')->with('success', 'bus_seats deleted successfully');
    }

    public function statusTrip(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = BusSeat::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
} 
