<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinancialTransactions\StoreFinancialTransactionRequest;
use App\Http\Requests\FinancialTransactions\UpdateFinancialTransactionRequest;
use App\Models\FinancialTransaction;
use App\Models\User;
use App\Services\FinancialTransactions\FinancialTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FinancialTransactionController extends Controller
{
    public function __construct(
        private FinancialTransactionService $service
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        Gate::authorize('viewAny',FinancialTransaction::class);

        $query = FinancialTransaction::query()
            ->with('approver');

        /*
        |--------------------------------------------------------------------------
        | فلتر نوع العملية
        |--------------------------------------------------------------------------
        */

        if ($request->filled('transaction_type')) {

            $query->where(
                'transaction_type',
                $request->transaction_type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | فلتر الموظف المعتمد
        |--------------------------------------------------------------------------
        */

        if ($request->filled('approved_by')) {

            $query->where(
                'approved_by',
                $request->approved_by
            );
        }

        /*
        |--------------------------------------------------------------------------
        | البحث في الوصف
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(
                'description',
                'like',
                "%{$search}%"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | من تاريخ
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        /*
        |--------------------------------------------------------------------------
        | إلى تاريخ
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | الموظفون الذين يمكن عرضهم في الفلتر
        |--------------------------------------------------------------------------
        */

        $employees = User::query()
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [
                    'admin',
                    'reception',
                ]);
            })
            ->orderBy('fullname')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | النتائج
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'financial_transactions.index',
            compact(
                'transactions',
                'employees'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        Gate::authorize(
            'create',
            FinancialTransaction::class
        );

        return view(
            'financial_transactions.create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(
        StoreFinancialTransactionRequest $request
    ) {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | التحقق من صلاحية نوع العملية
        |--------------------------------------------------------------------------
        */

        if ($data['transaction_type'] === 'income') {

            Gate::authorize(
                'createIncome',
                FinancialTransaction::class
            );

        } else {

            Gate::authorize(
                'createExpense',
                FinancialTransaction::class
            );
        }

        $this->service->create($data);

        return redirect()
            ->route('financial-transactions.index')
            ->with(
                'success',
                'تم تسجيل الحركة المالية بنجاح.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        FinancialTransaction $financialTransaction
    ) {

        Gate::authorize(
            'view',
            $financialTransaction
        );

        $financialTransaction->load('approver');

        return view(
            'financial_transactions.show',
            compact('financialTransaction')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        FinancialTransaction $financialTransaction
    ) {

        Gate::authorize(
            'update',
            $financialTransaction
        );

        return view(
            'financial_transactions.edit',
            compact('financialTransaction')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        UpdateFinancialTransactionRequest $request,
        FinancialTransaction $financialTransaction
    ) {

        Gate::authorize(
            'update',
            $financialTransaction
        );

        $this->service->update(
            $financialTransaction,
            $request->validated()
        );

        return redirect()
            ->route('financial-transactions.index')
            ->with(
                'success',
                'تم تحديث الحركة المالية.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(
        FinancialTransaction $financialTransaction
    ) {

        Gate::authorize(
            'delete',
            $financialTransaction
        );

        $this->service->delete(
            $financialTransaction
        );

        return redirect()
            ->route('financial-transactions.index')
            ->with(
                'success',
                'تم حذف الحركة المالية.'
            );
    }
}