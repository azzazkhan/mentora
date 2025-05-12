<?php

namespace Modules\Classroom\Http\Controllers\API;

use Modules\Classroom\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Http\Resources\ClassroomResource;
use Modules\Classroom\Models\Classroom;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Classroom::query()
            ->ofStatus([Status::Pending, Status::RegistrationOpen]);

        return ClassroomResource::collection($query->get());
    }

    /**
     * Get the classrooms the user is enrolled in.
     */
    public function enrolled(Request $request)
    {
        $request->validate([
            'with_pending' => ['nullable', 'boolean'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        $query = $request->boolean('with_pending')
            ? $user->classrooms()
            : $user->enrolledClassrooms();

        $query = $query->ofStatus([Status::RegistrationOpen, Status::RegistrationClosed, Status::Started]);

        return ClassroomResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
