<div class="row">

    <div class="col-md-6">

        <table class="table table-bordered">

            <tr>
                <th>Pet Name</th>
                <td>{{ $pet->pet_name }}</td>
            </tr>

            <tr>
                <th>Owner</th>
                <td>{{ $pet->user->fullname }}</td>
            </tr>

            <tr>
                <th>Species</th>
                <td>{{ $pet->species->species_name }}</td>
            </tr>

            <tr>
                <th>Breed</th>
                <td>{{ $pet->breed->breed_name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Gender</th>
                <td>{{ ucfirst($pet->gender) }}</td>
            </tr>

            <tr>
                <th>Age</th>
                <td>{{ $pet->age }}</td>
            </tr>

        </table>

    </div>

    <div class="col-md-6">

        <div class="card">

            <div class="card-body">

                <h6>Total Medical Records</h6>

                <h3>
                    {{ $pet->medicalRecords->count() }}
                </h3>

            </div>

        </div>

    </div>

</div>
