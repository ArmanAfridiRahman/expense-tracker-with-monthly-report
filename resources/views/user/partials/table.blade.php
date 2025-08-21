<table class="table table-striped" id="{{ $tableId ?? 'data-table' }}">
    <thead>
        <tr>
            @foreach($columns as $key => $column)
                @php
                    $alignClass = $loop->first ? 'text-start' : ($loop->last ? 'text-end' : 'text-center');
                @endphp
                <th class="{{ $alignClass }}">{{ $column['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($logs as $log)
            <tr>
                @foreach($columns as $key => $column)
                    @php
                        $field = isset($column['relation']) 
                            ? $key . '.' . $column['relation_field'] 
                            : $key;

                        $value = \Illuminate\Support\Arr::get($log, $field);

                        if ($column['type'] === 'date' && $value) {
                            $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                        }

                        if ($column['type'] === 'number' && $value !== null) {
                            $value = number_format($value);
                        }

                        $alignClass = $loop->first ? 'text-start' : ($loop->last ? 'text-end' : 'text-center');
                    @endphp
                    <td class="{{ $alignClass }}">{{ $value ?? '-' }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) }}" class="text-center">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
