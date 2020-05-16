@extends('layouts.app')

@section('content')
<div class="p-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <label for="">Regional</label>
                <select id="regional" name="regional" class="form-control getData">
                    <option value="all">ALL TREG</option>
                    <option value="treg-7">TREG 7</option>
                </select>
            </div>
            <div class="col">
                <label for="">Witel</label>
                <select id="witel" name="witel" class="form-control getData">
                    <option value="all">All</option>
                    <option value="sulut-malut">Sulut Malut</option>
                    <option value="papua">Papua</option>
                </select>
            </div>
            <div class="col">
                <label for="">Mode</label>
                <select id="mode" name="mode" class="form-control getData">
                    <option value="all">All</option>
                    <option value="datel">DATEL</option>
                    <option value="sto">STO</option>
                </select>
            </div>
            <div class="col">
                <label for="">Status</label>
                <select id="status" name="status" class="form-control getData">
                    <option value="all">All</option>
                    <option value="issued">Issued</option>
                    <option value="verificated">Verificated</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
            <div class="col">
                <label for="">Task Owner</label>
                <select id="task" name="task_owner" class="form-control getData">
                    <option value="all">All</option>
                    <option value="verificator">Verificator</option>
                    <option value="approver">Approver</option>
                    <option value="deployment">Deployment</option>
                </select>
            </div>
            <div class="col">
                <label for="">From</label>
                <input id="from" name="from" class="datepicker form-control getData" />
            </div>
            <div class="col">
                <label for="">To</label>
                <input id="to" name="to" class="datepicker form-control getData" />
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button id="resetBtn" class="btn btn-primary flex-fill">Reset</button>
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

    var endPoint = `{{ route('dashboard.table') }}`;
    var regional = $('#regional');
    var witel    = $('#witel');
    var mode     = $('#mode');
    var status   = $('#status');
    var task     = $('#task');
    var from     = $('#from');
    var to       = $('#to');

    async function loadData(url) {
        $('#showData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
        return await fetch(`${url}?regional=${regional.val()}&witel=${witel.val()}&mode=${mode.val()}&status=${status.val()}&task=${task.val()}&from=${from.val()}&to=${to.val()}`)
            .then( res => res.json())
            .then( data => $('#showData').html(data))
            .catch( error => console.error(error));
    }

    async function resetData(url) {
        regional.val('all');
        witel.val('all');
        mode.val('all');
        status.val('all');
        task.val('all');
        from.val(null);
        to.val(null);

        $('#showData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
        return await fetch(`${url}?regional=all&witel=all&mode=all&status=all&task=all&from=&to=`)
            .then( res => res.json())
            .then( data => $('#showData').html(data))
            .catch( error => console.error(error));
    }

    $(".getData").change(function() {
        loadData(endPoint);
    });

    $("#resetBtn").click(function() {
        resetData(endPoint);
    });

    loadData(endPoint);
});
</script>
@endpush
