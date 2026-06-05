@foreach ($pet->medicalRecords as $record)
    @foreach ($record->prescriptions as $prescription)
        <div class="card mb-3">

            <div class="card-header">

                Prescription
                {{ $prescription->prescription_date }}

            </div>

            <div class="card-body">

                <p>
                    <strong>Notes:</strong>
                    {{ $prescription->notes }}
                </p>

                <p>
                    <strong>Recommendations:</strong>
                    {{ $prescription->recommendations }}
                </p>

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($prescription->items as $item)
                            <tr>

                                <td>
                                    {{ $item->medicine->medicine_name }}
                                </td>

                                <td>
                                    {{ $item->dosage }}
                                </td>

                                <td>
                                    {{ $item->frequency }}
                                </td>

                                <td>
                                    {{ $item->duration }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>
    @endforeach
@endforeach
