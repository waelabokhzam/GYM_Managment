<?php

namespace App\Services\Receipt;

use App\Models\Receipt;

class DeleteReceiptService
{
    public function delete(Receipt $receipt)
    {
        $receipt->delete();

        return $receipt;
    }
}