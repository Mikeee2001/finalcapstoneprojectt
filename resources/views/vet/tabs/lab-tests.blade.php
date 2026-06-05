@foreach ($pet->medicalRecords as $record)
    @foreach ($record->labTests as $lab)
        <div class="card mb-3">

            <div class="card-body">

                <h6>{{ $lab->test_name }}</h6>

                <p>
                    <strong>Description:</strong>
                    {{ $lab->description }}
                </p>

                <p>
                    <strong>Result:</strong>
                    {{ $lab->results }}
                </p>

                <p>
                    <strong>Notes:</strong>
                    {{ $lab->notes }}
                </p>

            </div>

        </div>
    @endforeach
@endforeach
