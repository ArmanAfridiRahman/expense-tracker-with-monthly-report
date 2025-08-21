@extends('user.master')

@section('content')


<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>All Expenses</h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#expenseModal">
            Add Expense
        </button>
    </div>

    @include('user.partials.filter')
    
    @include('user.partials.table', [
        'logs' => $expenses,
        'columns' => [
            'title'       => ['label' => 'Title', 'type' => 'string'],
            'category'    => ['label' => 'Category', 'type' => 'relation', 'relation' => 'category', 'relation_field' => 'name'],
            'amount'      => ['label' => 'Amount', 'type' => 'number'],
            'date'        => ['label' => 'Date', 'type' => 'date'],
        ]
    ])

    @include("user.partials.pagination", ["logs" => $expenses])
</div>

@include('user.partials.expense-modal', [
    'url' => route('expenses.store'),
    'categories' => \App\Models\Category::orderBy('name')->get()
])

@endsection
