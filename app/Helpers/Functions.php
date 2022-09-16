<?php
use Illuminate\Support\Facades\Auth;

function request_validator(array $data, $id = 0)
{
    $messages = [
        'agent_name.required' => 'The agent name is required',
        'projects.required' => 'Projects name is Required',
        'login_email.unique' => 'The agent email has already been taken',
        'login_email.required' => 'The agent email is Required',
        'location.required' => 'The location is Required',
        'employee_id.required' => 'The employee id is Required',
        'password.required' => 'The password is Required',
        'hiring_date.required' => 'The hiring date is Required',
        'outbound_calls.required' => 'The outbound calls is Required',
        'program.required' => 'The program name is Required',
        'skill_id.required' => 'The skill is Required',
    ];
    return Validator::make($data, [
        'agent_name'   => 'required',
        'projects'   => 'required',
        'login_email'   => 'required|unique:csr',
        'location'      => 'required',
        'employee_id' => 'required',
        'password'   => 'required|min:6',
        'hiring_date'      => 'required',
        'outbound_calls'      => 'required',
        'program'      => 'required',
        'skill_id'      => 'required',
    ] , $messages );
}

?>