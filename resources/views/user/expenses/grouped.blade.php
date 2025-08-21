@extends('user.master')
@push('custom-css')
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--bs-primary);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: transparent;
        }

        .table-responsive {
            border-radius: 0.375rem;
        }

        .badge {
            font-size: 0.875em;
        }
    </style>
@endpush
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Monthly Expense Summary</h2>
                <span class="badge bg-primary fs-6">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
            </div>

            <div class="row mb-4">
                @forelse($categories as $category)
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <h3 class="text-primary">{{ number_format($category->total, 2) }}</h3>
                                <small class="text-muted">{{ $category->expenses->count() }} {{ Str::plural('expense', $category->expenses->count()) }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h5>No expenses found</h5>
                            <p class="mb-0">You haven't added any expenses for {{ \Carbon\Carbon::now()->format('F Y') }} yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($categories->isNotEmpty())
            <div class="card border-success mb-4">
                <div class="card-body text-center">
                    <h4 class="card-title text-success">Total Monthly Expenses</h4>
                    <h2 class="text-success">{{ number_format($total, 2) }}</h2>
                    <hr>
                    <small class="text-muted">Total for {{ \Carbon\Carbon::now()->format('F Y') }}</small>
                </div>
            </div>
            @endif

            @if($categories->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detailed Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="expenseAccordion">
                        @foreach($categories as $category)
                            @if($category->expenses->count() > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $category->id }}">
                                    <button class="accordion-button collapsed" type="button" 
                                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->id }}" 
                                            aria-expanded="false" aria-controls="collapse-{{ $category->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <span><strong>{{ $category->name }}</strong></span>
                                            <span class="badge bg-primary">{{ number_format($category->total, 2) }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $category->id }}" class="accordion-collapse collapse" 
                                     aria-labelledby="heading-{{ $category->id }}" data-bs-parent="#expenseAccordion">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            @include('user.partials.table', [
                                                'logs' => $category->expenses,
                                                'columns' => [
                                                    'title' => ['label' => 'Title', 'type' => 'string'],
                                                    'date' => ['label' => 'Date', 'type' => 'date'],
                                                    'amount' => ['label' => 'Amount', 'type' => 'number'],
                                                ],
                                                'tableId' => 'table-category-' . $category->id,
                                            ])
                                        </div>
                                        
                                        <div class="mt-3 p-2 bg-light rounded">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>{{ $category->name }} Subtotal:</strong>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <strong class="text-primary">{{ number_format($category->total, 2) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list"></i> View All Expenses
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
