<?php

namespace App\Services\InternalRequests;

use App\Models\InternalRequest;
use Illuminate\Support\Facades\DB;

class InternalRequestService
{
    public function create(array $data): InternalRequest
    {
        return DB::transaction(function () use ($data) {

            $data['requested_by'] = auth()->id();
            $data['status'] = 'pending';

            return InternalRequest::create($data);

        });
    }

    public function update(
        InternalRequest $request,
        array $data
    ): InternalRequest {

        return DB::transaction(function () use ($request, $data) {

            $request->update($data);

            return $request;

        });
    }

    public function delete(
        InternalRequest $request
    ): bool {

        return DB::transaction(function () use ($request) {

            return $request->delete();

        });
    }
}