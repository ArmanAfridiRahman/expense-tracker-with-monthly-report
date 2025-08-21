<form class="row g-3 filter-form">
    <div class="col-md-3">
        <label>Year</label>
        <select class="form-select" name="year">
            @php
                $currentYear = \Carbon\Carbon::now()->year;
            @endphp
            @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                <option value="{{ $y }}" 
                    @selected(request('year', $currentYear) == $y)>
                    {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3">
        <label>Month</label>
        <select class="form-select" name="month">
            @php
                $currentMonth = \Carbon\Carbon::now()->month;
            @endphp
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" 
                    @selected(request('month', $currentMonth) == $m)>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label>Category</label>
        <select class="form-select" name="category_id">
            <option value="">All</option>
            @foreach(\App\Models\Category::all() as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 align-self-end">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>
