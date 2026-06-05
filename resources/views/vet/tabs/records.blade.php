@forelse($pet->medicalRecords as $record)
    <div class="card mb-3">

        <div class="card-header">

            {{ $record->created_at->format('M d, Y') }}

        </div>

        <div class="card-body">

            <p>
                <strong>Diagnosis:</strong>
                {{ $record->diagnosis }}
            </p>

            <p>
                <strong>Symptoms:</strong>
                {{ $record->symptoms }}
            </p>

            <p>
                <strong>Treatment:</strong>
                {{ $record->treatment }}
            </p>

            <p>
                <strong>Findings:</strong>
                {{ $record->findings }}
            </p>

            @if ($record->appointment)
                <p>
                    <strong>Service:</strong>
                    {{ $record->appointment->service->service_name ?? '-' }}
                </p>
            @endif

        </div>

    </div>

@empty

    <div class="alert alert-info">
        No medical records found.
    </div>
@endforelse
