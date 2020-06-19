@extends('layouts.app')

@section('content')
<div class="p-5">
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col">
                <label for="">Provinsi</label>
                <select id="province" name="province" class="form-control getData"></select>
            </div>
            <div class="col">
                <label for="">Kota</label>
                <select id="districts" name="districts" class="form-control getData"></select>
            </div>
            <div class="col">
                <label for="">Range Harga</label>
                <select id="price" name="price" class="form-control getData">
                    <option value="all">Semua</option>
                    <option value="300,500">300 rb - 500 rb</option>
                    <option value="500,700">500 rb - 700 rb</option>
                    <option value="700,1000">700 rb - 1 juta</option>
                    <option value="1000">> 1 juta</option>
                </select>
            </div>
            <div class="col">
                <label for="">Status</label>
                <select id="status" name="status" class="form-control getData">
                    <option value="all">Semua</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Done">Done</option>
                    <option value="Cancel">Cancel</option>
                </select>
            </div>
            {{-- <div class="col">
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
            </div> --}}
            <div class="col-md-1 d-flex align-items-end">
                <button id="resetBtn" class="btn btn-primary flex-fill">Reset</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-bordered mt-5">
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
                            {{-- <th class="align-middle text-center"></th> --}}
                        </tr>
                    </thead>

                    <tbody id="showData"></tbody>
                    {{-- <tbody>
                        @if (count($surveys) > 0)
                            @foreach ($surveys as $survey)
                            <tr>
                                <td class="align-middle text-center">{{ $survey->survey_id }}</td>
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
                                    {{ $survey->handler }} <br>
                                    Keterangan : {{ $survey->note ? $survey->note : 'Belum dihandle' }} <br>
                                    Estimated Time : {{ $survey->estimated_time ? $survey->estimated_time : '-' }}
                                </td>
                                <td class="align-middle text-center">
                                    @if (Auth::user()->role !== 'admin')
                                        @if(strtolower($survey->status) !== 'done')
                                            @if(Auth::user()->role === 'verificator' && strtolower($survey->handler) == 'verificator')
                                                <button type="button" class="btn btn-sm btn-primary btn-handler" data-id="{{ $survey->id }}" data-handler="{{ $survey->handler }}" data-toggle="modal" data-target="#handlerModal">Approve</button>
                                                <button type="button" class="btn btn-sm btn-warning" onclick="confirmForm('formSurvey{{ $survey->id }}')">Not Approve</button>
                                                <form id="formSurvey{{ $survey->id }}" style="display: none;" action="{{ route('not-approve') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="survey" value="{{ $survey->id }}">
                                                </form>
                                            @elseif(Auth::user()->role === 'deployment' && strtolower($survey->handler) == 'deployment')
                                                <button type="button" class="btn btn-sm btn-info estimated_time" data-survey-id="{{ $survey->id }}">Estimated Time</button>
                                                <button type="button" class="btn btn-sm btn-primary btn-handler" onclick="event.preventDefault();
                                                    document.getElementById('approveFormSurvey{{ $survey->id }}').submit();">
                                                    Approve
                                                </button>
                                                <form id="approveFormSurvey{{ $survey->id }}" style="display: none;" action="{{ route('approve') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="survey" value="{{ $survey->id }}">
                                                </form>
                                                <button type="button" class="btn btn-sm btn-warning" data-id="{{ $survey->id }}" data-handler="Not Approve {{ $survey->handler }}" data-toggle="modal" data-target="#handlerModal" data-action="{{ route('not-approve') }}" data-button="Not Approve">Not Approve</button>
                                            @elseif(Auth::user()->role === 'manager cs' && strtolower($survey->handler) == 'manager cs')
                                                <button type="button" class="btn btn-sm btn-primary btn-handler" onclick="event.preventDefault();
                                                    document.getElementById('approveFormSurvey{{ $survey->id }}').submit();">
                                                    Approve
                                                </button>
                                                <form id="approveFormSurvey{{ $survey->id }}" style="display: none;" action="{{ route('approve') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="survey" value="{{ $survey->id }}">
                                                </form>
                                                <button type="button" class="btn btn-sm btn-warning" data-id="{{ $survey->id }}" data-handler="Not Approve {{ $survey->handler }}" data-toggle="modal" data-target="#handlerModal" data-action="{{ route('not-approve') }}" data-button="Not Approve">Not Approve</button>

                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary disabled">{{ $survey->handler }}</button>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-sm btn-success disabled">{{ $survey->status }}</button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-sm btn-secondary btn-handler">{{ $survey->handler }}</button>
                                    @endif

                                    @if (Auth::user()->role !== 'deployment')
                                        <a href="{{ route('survey.edit', $survey->id) }}" class="btn btn-danger btn-sm">Edit</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9" class="text-center">No Data</td></tr>
                        @endif
                    </tbody> --}}
                </table>

                {{ $surveys->links() }}

                <div id="datepicker" style="display: none;" ></div>

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

        var text = button.data('button')
        modal.find('.modal-footer button[type="submit"]').text(text)

        var action = button.data('action')
        modal.find('.modal-content form').attr('action', action);
    });

    var survey_id = 1;
    $('.estimated_time').click(function() {
        survey_id = $(this).data('survey-id');
        $datepicker.open({'survey_id': survey_id});
    });

    var $datepicker = $('#datepicker').datepicker({
        showRightIcon: false,
        modal: true,
        header: true,
        format: 'yyyy-mm-dd',
        change: function (e) {
            var url = "{{ route('survey.updateTime', ':survey_id') }}";
            url = url.replace(":survey_id", survey_id);
            postData(url, 'PUT', {
                'estimated_time' : $datepicker.value()
            });
        }
    });

    async function postData(url, method, data) {
        await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            location.reload(true);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

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

    var endPoint = "{{ route('dashboard.newtable') }}";
    var apiUrl = "{{ route('data.api') }}";
    var province = $('#province');
    var districts = $('#districts');

    async function getDataApi(url, id) {
        id.html('<option value="all">Loading...</option>');
        return await fetch(`${url}`)
            .then( res => res.json())
            .then( data => id.html(data))
            .catch( error => console.error(error));
    }

    getDataApi(`${apiUrl}?get=province`, province);
    getDataApi(`${apiUrl}?get=districts&province=${province.val()}`, districts);

    async function loadData(url) {
        $('#showData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
        return await fetch(`${url}?province=${province.val()}&districts=${districts.val()}`)
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

    province.change(function() {
        getDataApi(`${apiUrl}?get=districts&province=${province.val()}`, districts);
    });

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
