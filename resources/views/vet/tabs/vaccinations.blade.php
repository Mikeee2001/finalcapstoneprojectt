@foreach ($pet->medicalRecords as $record)
    @foreach ($record->vaccinations as $vaccination)
        <div class="card mb-3">

            <div class="card-body">

                <h6>

                    {{ $vaccination->medicine->medicine_name ?? 'Vaccine' }}

                </h6>

                <p>

                    <strong>Date Given:</strong>

                    {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}

                </p>

                <p>

                    <strong>Notes:</strong>

                    {{ $vaccination->notes }}

                </p>

            </div>

        </div>
    @endforeach
@endforeach
