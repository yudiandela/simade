@extends('layouts.app')

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('task.nav-tab', ['active' => 'search'])

                <div class="card">
                    <div class="card-body">

                        <form action="#" method="POST" class="form-inline" id="formSearch">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label class="sr-only">No Order</label>
                                    <input id="noOrder" type="text" class="form-control" placeholder="No Order" required autocomplete="off">
                                </div>
                                <div class="col">
                                    <label class="sr-only">Type of Task</label>
                                    <select id="type-of-task" name="typeOfTask" class="form-control">
                                        <option value="all">-- Type of Task --</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="sr-only">Work Order</label>
                                    <select id="work-order" name="workOrder" class="form-control">
                                        <option value="all">-- Work Order --</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="sr-only">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="all">-- Status --</option>
                                        <option value="New">New</option>
                                        <option value="On Progress">On Progress</option>
                                        <option value="Done">Done</option>
                                        <option value="Cancel">Cancel</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="sr-only">Status Date</label>
                                    <input id="statusDate" type="date" name="statusDate" class="form-control" placeholder="Status Date">
                                </div>
                                <div class="col">
                                    <label class="sr-only">Work Date</label>
                                    <input id="workDate" type="date" name="workDate" class="form-control" placeholder="Work Date">
                                </div>
                                <div class="col">
                                    <label class="sr-only">Role</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="all">-- Role --</option>
                                        <option value="verificator">Verificator</option>
                                        <option value="deployment">Deployment</option>
                                        <option value="manager">Manager CS</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>
                        </form>

                        <table class="mt-3 table table-bordered">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th class="align-middle text-center">Survey ID</th>
                                    <th class="align-middle text-center">Nama</th>
                                    <th class="align-middle text-center">No HP</th>
                                    <th class="align-middle text-center">Provinsi</th>
                                    <th class="align-middle text-center">Kota</th>
                                    <th class="align-middle text-center">Kecamatan</th>
                                    <th class="align-middle text-center">Range Harga</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Handler</th>
                                    <th class="align-middle text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="showData">
                                <tr><td colspan="10" class="text-center">Belum ada pencarian</td></tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $().ready(function() {
            $('#formSearch').submit(function(event) {
                event.preventDefault();

                var endpoint = "{{ route('task.search') }}";
                var noOrder = $('#noOrder').val();
                var typeOfTask = $('#type-of-task').val();
                var workOrder = $('#work-order').val();
                var status = $('#status').val();
                var statusDate = $('#statusDate').val();
                var workDate = $('#workDate').val();
                var role = $('#role').val();

                loadData(`${endpoint}?ajax=1&order=${noOrder}&type=${typeOfTask}&work=${workOrder}&status=${status}&sDate=${statusDate}&wDate=${workDate}&role=${role}`)
            });

            async function loadData(url) {
                $('#showData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
                return await fetch(url)
                    .then( res => res.json())
                    .then( data => $('#showData').html(data))
                    .catch( error => console.error(error));
            }
        });
    </script>
@endpush
