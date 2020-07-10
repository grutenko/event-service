<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required|integer',
            'limit' => 'integer',
            'page' => 'integer'
        ]);
        $limit = $request->input('limit', 50) <= 50 ? $request->input('limit', 50) : 50;
        $page = $request->input('page', 1);

        return User
            ::join('users_events', function($join) use($request) {
                $join->on('users.id', '=', 'users_events.user_id')
                     ->where('users_events.event_id', $request->input('event_id'));
            })
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public function post(Request $request)
    {
        $params = $request->json();
        $validator = Validator::make($params, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255'
        ]);

        if($validator->fails())
        {
            return $this->buildFailedValidationResponse($request, $validator->errors()->all());
        }
        if(User::where('email', $params['email'])->count() > 0)
        {
            return response()->json(['error' => 'EMAIL_ALREADY_EXIST'], 400);
        }

        User::create($params);
        return response()->json(['success' => true]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return array
     */
    public function put(Request $request, $id)
    {
        $params = $request->json();

        $validator = Validator::make($params, [
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'max:255'
        ]);
        if($validator->fails())
        {
            return $this->buildFailedValidationResponse($request, $validator->errors()->all());
        }

        $user = User::find($id);
        if($user === null)
        {
            return response()->json(['error' => 'USER_NOT_FOUND'], 404);
        }

        $user->fill($params)->save();
        return response()->json(['success' => true]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function delete(Request $request, $id)
    {
        if( null !== ($user = User::find($id)) )
        {
            $user->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return array
     */
    public function link(Request $request, $id)
    {
        $params = $request->json();

        $validator = Validator::make($params, [
            'event_id' => 'required'
        ]);
        if($validator->fails())
        {
            return $this->buildFailedValidationResponse($request, $validator->errors()->all());
        }

        if( null === ($user = User::find($id)) )
        {
            return response()->json(['error' => 'USER_NOT_FOUND'], 404);
        }
        if( null === ($event = Event::find($id)) )
        {
            return response()->json(['error' => 'EVENT_NOT_FOUND'], 404);
        }

        $count = DB::table('users_events')
            ->where('user_id', $user->id)
            ->where('event_id', $params['event_id'])
            ->count();
        if($count == 0)
        {
            DB::table('users_events')->insert([
                'user_id' => $user->id,
                'event_id' => $params['event_id']
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function unlink(Request $request, $id)
    {
        $params = $request->json();
        $validator = Validator::make($params, [
            'event_id' => 'required'
        ]);
        if($validator->fails())
        {
            return $this->buildFailedValidationResponse($request, $validator->errors()->all());
        }

        if( null === ($user = User::find($id)) )
        {
            return response()->json(['error' => 'USER_NOT_FOUND'], 404);
        }

        DB::table('users_events')
            ->where('user_id', $id)
            ->where('event_id', $params['event_id'])
            ->delete();

        return response()->json(['success' => true]);
    }
}