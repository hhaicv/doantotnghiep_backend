<?php
 
 namespace App\Http\Controllers;

 use App\Http\Controllers\Controller;
 use App\Models\Contact;
use App\Models\Review;
use Illuminate\Http\Request;
 
 class HomeEmployeeController extends Controller
 {
     public function contacts()
     {   
         $data = Contact::all(); // Lấy tất cả các bản ghi từ bảng contacts
         return view('employee.contacts.index', compact('data'));
     }
     public function reviews()
     {   
         $data = Review::all(); // Lấy tất cả các bản ghi từ bảng contacts
         return view('employee.reviews.index', compact('data'));
     }
 }
 