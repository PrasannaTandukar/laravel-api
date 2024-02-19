<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller
{
    use ApiTrait;
    public function index(Request $request)
    {
        $request->validate([
            'page' => ['required', 'integer'],
            'itemsPerPage' => ['required', 'integer'],
            'sortBy' => ['nullable', 'array']
        ]);

        try {
            $users = User::select('id', 'name', 'email');
            if ($request->filled('sortBy')) {
                $users = $users->orderBy($request->input('sortBy')[0]['key'], $request->input('sortBy')[0]['order']);
            }
            $users = $users->paginate($request->input('itemsPerPage'));

            return $this->successResponse($users);
        } catch (Exception $exception) {
            return $this->errorResponse([], $exception->getMessage(), $exception->getCode());
        }

    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'userIdArray' => ['required', 'array', 'min:1'],
            'userIdArray.*' => ['integer']
        ]);

        try {
            User::whereIn('id', $request->input('userIdArray'))->delete();
            return $this->successResponse();
        } catch (Exception $exception) {
            return $this->errorResponse([], $exception->getMessage(), $exception->getCode());
        }
    }
}
