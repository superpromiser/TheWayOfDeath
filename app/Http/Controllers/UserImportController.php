<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Contact;
class UserImportController extends Controller
{
    //
    public function show(){

    }

    public function store(Request $request){
        $file = $request->file('file')->store('import');
        // Excel::import(new UsersImport, $file);
        // (new UsersImport)->import($file);
        $import = new UsersImport;
        $import->import($file);
        return true;
    }

    public function storeJsonExcel(Request $request){
        $this->validate($request,[
            'serverData'=>'required'
        ]);
        foreach($request->serverData as $userData){
            $groups = explode(",",$userData['groupArr']);
            $groupArr = array();
            foreach($groups as $group){
                array_push($groupArr,$group);
            }
            $user = User::create([
                'name'=>$userData['name'],
                'phoneNumber'=>$userData['phoneNumber'],
                'password'=>bcrypt('password'),
                'imei'=>$userData['imei'],
                'roleId'=>$userData['roleId'],
                'schoolId'=>$userData['schoolId'],
                'gradeId'=>$userData['gradeId'],
                'lessonId'=>$userData['lessonId'],
                'gender'=>$userData['gender'],
                'nation'=>$userData['nation'],
                'cardNum'=>$userData['cardNum'],
                'familyAddress'=>json_encode($userData['familyAddress']),
                'residenceAddress'=>json_encode($userData['residenceAddress']),
                'introduce'=>$userData['introduce'],
                'birthday'=>$userData['birthday'],
                'wechat'=>$userData['wechat'],
                'qq'=>$userData['qq'],
                'studentId'=>$userData['studentId'],
                'subjectName'=>$userData['subjectName'],
                'groupArr'=>$groupArr
            ]);

            //create contact with chatbot
            $contactInfo['userId'] = $user->id;
            $contactInfo['contactUserId'] = 1;
            $contact = Contact::create($contactInfo);
        }
        return true;
    }
}
