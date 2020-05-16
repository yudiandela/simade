@extends('layouts.app')

@section('content')
<div class="p-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <label for="">Regional</label>
                <select id="regional" name="regional" class="form-control">
                    <option value="all">ALL TREG</option>
                    <option value="treg-7">TREG 7</option>
                </select>
            </div>
            <div class="col">
                <label for="">Witel</label>
                <select id="witel" name="witel" class="form-control">
                    <option value="all">All</option>
                    <option value="sulut-malut">Sulut Malut</option>
                    <option value="papua">Papua</option>
                </select>
            </div>
            <div class="col">
                <label for="">Mode</label>
                <select id="mode" name="mode" class="form-control">
                    <option value="all">All</option>
                    <option value="datel">DATEL</option>
                    <option value="sto">STO</option>
                </select>
            </div>
            <div class="col">
                <label for="">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="all">All</option>
                    <option value="issued">Issued</option>
                    <option value="verificated">Verificated</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
            <div class="col">
                <label for="">Task Owner</label>
                <select id="task" name="task_owner" class="form-control">
                    <option value="all">All</option>
                    <option value="verificator">Verificator</option>
                    <option value="approver">Approver</option>
                    <option value="deployment">Deployment</option>
                </select>
            </div>
            <div class="col">
                <label for="">From</label>
                <input id="from" name="from" class="datepicker form-control" />
            </div>
            <div class="col">
                <label for="">To</label>
                <input id="to" name="to" class="datepicker form-control" />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-bordered mt-5">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">Lokasi</th>
                            <th class="align-middle text-center">Nama</th>
                            <th class="align-middle text-center">No HP</th>
                            <th class="align-middle text-center">Paket</th>
                            <th class="align-middle text-center">Alamat</th>
                            <th class="align-middle text-center">Jumlah Penghuni</th>
                            <th class="align-middle text-center">Status Hunian</th>
                            <th class="align-middle text-center">Luas Rumah</th>
                        </tr>
                    </thead>

                    <tbody id="showData"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    $('#from').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        maxDate: function () {
            return $('#to').val();
        }
    });

    $('#to').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        minDate: function () {
            return $('#from').val();
        }
    });

    async function loadData(url) {
        return await fetch(url)
            .then( res => res.json())
            .then( data => $('#showData').html(data))
            .catch( error => console.error(error));
    }

    var regional = $('#regional').val();
    var witel    = $('#witel').val();
    var mode     = $('#mode').val();
    var status   = $('#status').val();
    var task     = $('#task').val();
    var from     = $('#from').val();
    var to       = $('#to').val();

    $('select').change(function() {
        var regional = $('#regional').val();
        var witel    = $('#witel').val();
        var mode     = $('#mode').val();
        var status   = $('#status').val();
        var task     = $('#task').val();
        var from     = $('#from').val();
        var to       = $('#to').val();

        $('#showData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
        loadData(`{{ route('dashboard.table') }}?regional=${regional}&witel=${witel}&mode=${mode}&status=${status}&task=${task}&from=${from}&to=${to}`);
    });

    loadData(`{{ route('dashboard.table') }}?regional=${regional}&witel=${witel}&mode=${mode}&status=${status}&task=${task}`);
});
</script>
@endpush
