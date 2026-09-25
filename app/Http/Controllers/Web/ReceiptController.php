<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Receipt\ReceiptStoreRequest;
use App\Http\Requests\Receipt\ReceiptUpdateRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\Receipt;
use App\Services\Receipt\CreateReceiptService;
use App\Services\Receipt\DeleteReceiptService;
use App\Services\Receipt\IndexService;
use App\Services\Receipt\UpdateReceiptService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private IndexService $indexService,
        private CreateReceiptService $createReceiptService,
        private UpdateReceiptService $updateReceiptService,
        private DeleteReceiptService $deleteReceiptService,
    ) {}
    public function index(Request $request)
    {
        $this->authorize("viewAny", Receipt::class);
        $receipts = $this->indexService->index($request);
        return view("receipt.index", compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("create", Receipt::class);
        $players = Player::get('*');
        $games = Game::get('*');
        return view("receipt.create", compact(['games','players']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceiptStoreRequest $request)
    {
        $this->authorize("create", Receipt::class);
        $this->createReceiptService->create($request->validated());
        return redirect()->route("receipts.index")->with('success', 'Receipt created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        $this->authorize("view", $receipt);
        return view("receipt.show", compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        $this->authorize("update", $receipt);
        $players = Player::get('*');
        $games = Game::get('*');
        return view("receipt.edit", compact(["receipt", "players", "games"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceiptUpdateRequest $request, Receipt $receipt)
    {
        $this->authorize("update", $receipt);
        $this->updateReceiptService->update($request->validated(), $receipt);
        return redirect()->route("receipts.show", $receipt)->with('success', 'Receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        $this->authorize("delete", $receipt);
        $this->deleteReceiptService->delete($receipt);
        return redirect()->route("receipts.index")->with('success', 'Receipt deleted successfully.');

    }
}
