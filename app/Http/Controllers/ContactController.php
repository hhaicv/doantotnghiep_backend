<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.contacts.';

    public function index()
    {
        $data = Contact::query()->get();
        return view( self::PATH_VIEW. __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $data = $request->all();
       
        $model = Contact::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Thêm liên hệ thành công');
        } else {
            return redirect()->back()->with('failes', 'Bạn không thêm thành công liên hệ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view(self::PATH_VIEW. __FUNCTION__,compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.contacts.index')->with('success', 'Contacts deleted successfully');
    }
    public function statusContact(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $contact = Contact::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $contact->is_active = $request->input('is_active');
        $contact->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
