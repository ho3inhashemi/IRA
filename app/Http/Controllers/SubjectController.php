<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $subject = request('subject');
        
        DB::transaction(function() use($subject) {

            $subject_object = Subject::lockForUpdate()->where('subject',$subject)->first();

            if($subject_object->capacity == 0){
                return null; // it could be return back in previous page by a message that state there is no capacity
            }

            sleep(5);
            $capacity = $subject_object->capacity;
            $capacity-- ;
            $subject_object->capacity = $capacity;    
            $subject_object->save();

            $user_id = auth()->user()->id;
            $user = User::find($user_id);

            if($user->selected_lessons){
                $decoded_selected_lessons = json_decode($user->selected_lessons ,true); 
                $decoded_selected_lessons[$subject_object->id] = $subject_object->subject;
                $encoded_selected_lessons = json_encode($decoded_selected_lessons );
                $user->selected_lessons = $encoded_selected_lessons;
            }else{
                $array = array();
                $array[$subject_object->id] = $subject_object->subject;
                $user->selected_lessons = json_encode($array);
            }

            $user->save();
        });

    }

}
