<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErros;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
class UsersImport implements ToModel, WithHeadingRow
{

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new User([
            //
            'name'=>$row['姓名'],
            'phoneNumber'=>$row['电话号码'],
            // 'password'=>Hash::make($row['密码']),
            'password'=>Hash::make('password'),
             'imei'=>$row['imei'],
             'roleId'=>$row['角色代码'],
             'schoolId'=>$row['学校代码'],
             'gradeId'=>$row['年级代码'],
             'lessonId'=>$row['班级代码'],
             'gender'=>$row['性别'],
             'nation'=>$row['国籍'],
             'cardNum'=>$row['身份证号码'],
             'familyAddress'=>$row['家庭地址'],
             'residenceAddress'=>$row['现住址'],
             'children'=>$row['子女'],
             'introduce'=>$row['简介'],
             'bithday'=>$row['生日'],
             'wechat'=>$row['微信'],
             'qq'=>$row['QQ'],
             'studentId'=>$row['学号'],
            //  'groupArr'=>$row[19],
             'subjectName'=>$row['科目（老师）']
        ]);
    }

    // public function format(){
    //     HeadingRowFomatter::default(HeadingRowFormatter::FORMATTER_NONE);
    //     return $this;
    // }
}
