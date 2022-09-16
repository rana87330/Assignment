<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Hash;

class UserImport implements ToCollection
{
    private $arr=[];
    private $insert=0;
    private $errors=0;
    private $errors_html = "<ul>";
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        $errors_count       = 0;
    
        $collection = $collection->toArray();
        if($collection){
            foreach ($collection as $key=>$data) 
            {
                if($key > 0)
                {
                    $row_error          = 0 ;
                    $name               = $data['0'];
                    $email              = $data['1'];
                    $password           = $data['2'];
                    $phone_no           = $data['3'];
                    $address            = $data['4'];
                    
                    $name_length        = strlen($name);
                    if($email != null){
                        $is_validEmail  = filter_var($email, FILTER_VALIDATE_EMAIL);
                    }
                    else{
                        $is_validEmail = null;
                    }
                    if($password != null){
                        $password       = Hash::make($password);
                    }
                    $phone_length       = strlen($phone_no);
                    $phone_no = str_replace( array( '\'', '"',',' , ';', '<', '>','#','%','$','@',' ','  ', '-','_','+' ), '' , $phone_no);
                    $address_length      = strlen($address);

                    if($name == null)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Name is required. </li>';
                        continue;
                    }
                    if($name_length > 50)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Name is too Long , greater than 50 letters. </li>';
                        continue;
                    }
                    if($phone_no   == null)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Phone number is required. </li>';
                        continue;
                    }
                    if (intval($phone_no) == 0)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed.Interger is required for phone number. </li>';
                        $errors_count++ ;
                        continue;
                    }
                    if($phone_length > 7 && $phone_length > 11)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed.Phone number length must be between 7 to 11. </li>';
                        $errors_count++ ;
                        continue;
                    }
                    if($is_validEmail == null)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Email is required. </li>';
                        continue;
                    }
                    if(!$is_validEmail)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Email format is not Valid. </li>';
                        continue;
                    }
                    if($address_length > 100)
                    {
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. Address is too Long , greater than 100 letters. </li>';
                        continue;
                    }
                    
                    //Check Is User already Exist or not 
                    $is_existUser     = User::where('email', $is_validEmail)->where('phone', $phone_no)->first();
                    if($is_existUser!=null){
                        $this->errors +=1;
                        $row_error =  1;
                        $errors_count++ ;
                        $this->errors_html .=  '<li> Row  '.$key.' is failed. This User is aleady exist in Database. </li>';
                        continue;
                    }

                    //this->insert users if no Error in currect row
                    if($row_error == 0){
                        
                        $user = new User();
                        $user->name         = $name;
                        $user->email        = $email;
                        $user->password     = $password;
                        $user->phone        = $phone_no;
                        $user->address      = $address;
                        $is_save = $user->save();
                        if($is_save)
                        {
                            $this->insert = $this->insert + 1; 
                        }
                    }
                }
            }
        }
        else{
            $this->errors +=1;
            $row_error =  1;
            $errors_count = 'All' ;
            $this->errors_html .=  '<li>No Record Found in the file </li>';
        }

        $this->errors_html .= "</ul>";
        $this->arr = ["insert"=>$this->insert , "errors"=>$this->errors , "errors_html"=>$this->errors_html];
    }
    public function getinsertRecord(){
        return $this->arr;
    }
}