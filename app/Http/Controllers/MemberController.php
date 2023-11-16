<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Member::filter(request(['search', 'code', 'name']))->get();

        if ($index->isEmpty()) {
            return $this->sendError('Member not found.', 404);
        }

        foreach ($index as $member) {
            $member->borrowed_books = $member->borrows->where('status', 'Borrowed')->count();
        }

        return $this->sendResponse($index, 'Member retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        $store = Member::create($validated);

        return $this->sendResponse($store, 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return $this->sendResponse($member, 'Member retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $validated = $request->validated();

        $member->update($validated);

        return $this->sendResponse($member, 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return $this->sendResponse($member, 'Member deleted successfully.');
    }
}
