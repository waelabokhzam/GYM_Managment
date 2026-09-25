<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionRequest;
use App\Models\Player;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Support\Facades\Gate;

class SubscriptionController extends Controller
{
    public function __construct(
        private SubscriptionService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', Subscription::class);

        $subscriptions = Subscription::with('player.user')
            ->latest()
            ->paginate(10);

        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        Gate::authorize('create', Subscription::class);

        $players = Player::with('user')->get();

        return view('subscriptions.create', compact('players'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'تم إنشاء الاشتراك بنجاح.');
    }

    public function show(Subscription $subscription)
    {
        Gate::authorize('view', $subscription);

        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        Gate::authorize('update', $subscription);

        $players = Player::with('user')->get();

        return view('subscriptions.edit', compact('subscription', 'players'));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $this->service->update($subscription, $request->validated());

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'تم تحديث الاشتراك.');
    }

    public function destroy(Subscription $subscription)
    {
        Gate::authorize('delete', $subscription);

        $this->service->delete($subscription);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'تم حذف الاشتراك.');
    }
}
