<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request['password'])
        ]);

        $user = User::create($request->all());
        if ($user) {
            return response()->json(['message' => 'Added Successfully']);
        }
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // ignore password fields if blank
        if ($request->has('password') and isset($request->password)) {
            $request->merge([
                'password' => bcrypt($request['password'])
            ]);
        }

        $user = $user->update($request->all());
        if ($user) {
            return response()->json(['message' => 'Updated Successfully']);
        }
    }

    public function destroy(User $user)
    {
        $user = $user->delete();
        if ($user) {
            return response()->json(['message' => 'Deleted Successfully']);
        }
    }
}
