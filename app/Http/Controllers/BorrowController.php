<?php

namespace App\Http\Controllers;

use App\Enums\BorrowStatus;
use App\Models\Borrow;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Member;

class BorrowController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Borrow::filter(request(['search', 'status']))->get();

        if ($index->isEmpty()) {
            return $this->sendError('Borrow not found.', 404);
        }

        return $this->sendResponse($index, 'Borrow retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {
        $validated = $request->validated();

        $borrow = new Borrow();

        if ($borrow->checkHowManyBooksAreBorrowedByMember($validated['member_id']) > 2) {
            return $this->sendError('Member has reached the maximum number of borrowed books.', 400);
        }else {
            if (!$borrow->checkIfBookIsAvailable($validated['book_id'])) {
                return $this->sendError('Book is not available.', 400);
            }else {
                if ($borrow->checkIfMemberIsPenalized($validated['member_id'])) {
                    return $this->sendError('Member is penalized.', 400);
                }else {
                    $validated['status'] = BorrowStatus::Borrowed;

                    $store = Borrow::create($validated);

                    return $this->sendResponse($store, 'Borrow created successfully.');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        return $this->sendResponse($borrow, 'Borrow retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        $validated = $request->validated();

        if ($borrow->checkIfReturnDateIsPassed($validated['return_date'])) {
            $member = new Member();
            $member->PenalizeMember($validated['member_id']);

            return $this->sendError('Return date is passed.', 400);
        }else{
            $validated['status'] = BorrowStatus::Returned;

            $borrow->update($validated);

            return $this->sendResponse($borrow, 'Borrow updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();

        return $this->sendResponse($borrow, 'Borrow deleted successfully.');
    }
}
