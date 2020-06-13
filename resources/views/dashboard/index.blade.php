@extends('layouts.app')

@section('content')
<div class="p-5">
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif
        {{-- <div class="row">
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
        </div> --}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-bordered mt-5">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="align-middle text-center">No</th>
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

                    {{-- <tbody id="showData"></tbody> --}}
                    <tbody>
                        @if (count($surveys) > 0)
                            @foreach ($surveys as $survey)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle text-left">
                                    <a href="{{ route('inbox.maps') }}?lat={{ $survey->latitude }}&lng={{ $survey->longitude }}">
                                        {{ $survey->name }}
                                    </a>
                                </td>
                                <td class="align-middle text-center">{{ $survey->phone }}</td>
                                <td class="align-middle text-left">{{ $survey->province }}</td>
                                <td class="align-middle text-left">{{ $survey->districts }}</td>
                                <td class="align-middle text-left">{{ $survey->sub_district }}</td>
                                <td class="align-middle text-center">{{ $survey->price }}</td>
                                <td class="align-middle text-center">{{ $survey->status }}</td>
                                <td class="align-middle text-left">
                                    {{ $survey->handler }} <br> Keterangan : {{ $survey->note ? $survey->note : 'Belum dihandle' }}
                                </td>
                                <td class="align-middle text-center">
                                    @if (Auth::user()->role !== 'admin')
                                        @if($survey->status !== 'Done')
                                            @if (strtolower($survey->handler) == Auth::user()->role)
                                                @if($survey->handler == 'Deployment')
                                                    <button type="button" class="btn btn-sm btn-info">Estimated Time</button>
                                                @endif

                                                @if($survey->status == 'Cancel')
                                                    <button type="button" class="btn btn-sm btn-warning disabled">
                                                        Not Approve
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-warning" onclick="confirmForm('formSurvey{{ $survey->id }}')">
                                                        Not Approve
                                                    </button>
                                                    <form id="formSurvey{{ $survey->id }}" style="display: none;" action="{{ route('not-approve') }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="survey" value="{{ $survey->id }}">
                                                    </form>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-primary btn-handler" data-id="{{ $survey->id }}" data-handler="{{ $survey->handler }}" data-toggle="modal" data-target="#handlerModal">Approve</button>
                                            @else
                                                <button type="button" disabled class="btn btn-sm btn-warning disabled">Not Approve</button>
                                                <button type="button" disabled class="btn btn-sm btn-primary disabled">Approve</button>
                                            @endif
                                        @else
                                            <button type="button" disabled class="btn btn-sm btn-warning disabled">Not Approve</button>
                                            <button type="button" disabled class="btn btn-sm btn-primary disabled">Approve</button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary btn-handler" data-id="{{ $survey->id }}" data-handler="{{ $survey->handler }}" data-toggle="modal" data-target="#handlerModal">Approve</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9" class="text-center">No Data</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="handlerModal" tabindex="-1" role="dialog" aria-labelledby="handlerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('approve') }}" method="POST">
                @csrf
                @method('patch')
                <div class="modal-header">
                    <h5 class="modal-title" id="handlerModalLabel">Verificator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="survey_id" type="hidden" name="survey">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Keterangan :</label>
                        <textarea class="form-control" id="message-text" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Appprove</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

function confirmForm(id) {
    var retVal = confirm("Are you sure?");
    if( retVal == true ) {
        $('#' + id).submit();
    }
}

$(document).ready(function() {
    $('#handlerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)

        var id = button.data('id')
        modal.find('.modal-body input#survey_id').val(id)

        var recipient = button.data('handler')
        modal.find('.modal-title').text(`${recipient} Handler`)
    });

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
