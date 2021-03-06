@extends('layouts.app')

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('task.nav-tab', ['active' => 'overview'])

                <div class="card rounded-0">
                    <div class="card-body">
                        Account Role (Jenis Akun) : {{ auth()->user()->role }}

                        <!-- Example single danger button -->
                        <div class="mx-4 btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih Aksi
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item{{ request('d') == 'New' ? ' active' : '' }}" href="{{ route('task.overview', 'd=New') }}">New : {{ $new }}</a>
                                <a class="dropdown-item{{ request('d') == 'On Progress' ? ' active' : '' }}" href="{{ route('task.overview', 'd=On Progress') }}">On Progress : {{ $onProgress }}</a>
                                <a class="dropdown-item{{ request('d') == 'Done' ? ' active' : '' }}" href="{{ route('task.overview', 'd=Done') }}">Done : {{ $done }}</a>
                            </div>
                        </div>

                        @if(count($datas) > 0)
                            <table class="mt-3 table table-bordered">
                                <thead class="bg-danger text-white">
                                    <tr>
                                        <th class="align-middle text-center">No order / SID</th>
                                        <th class="align-middle text-center">Type of Task</th>
                                        <th class="align-middle text-center">Status</th>
                                        <th class="align-middle text-center">Status Date</th>
                                        <th class="align-middle text-center">Work Date</th>
                                    </tr>
                                </thead>

                                <tbody id="showData">
                                    @foreach($datas as $data)
                                        <tr>
                                            <td rowspan="2" class="text-center">
                                                <p class="text-uppercase font-weight-bold">
                                                    {{ $data->survey_id }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ auth()->user()->role }} 1
                                            </td>
                                            <td class="align-middle text-center">
                                                <select name="{{ $validate1 }}" class="form-control{{ $deployment ? ' dValidate' : ' validate' }}" data-survey-id="{{ $data->id }}">
                                                    <option value="Pending"{{ $data->$validate1 == 'Pending' ? ' selected' : '' }}>Pending</option>
                                                    <option value="Complete"{{ $data->$validate1 == 'Complete' ? ' selected' : '' }}>Complete</option>
                                                    <option value="Reject"{{ $data->$validate1 == 'Reject' ? ' selected' : '' }}>Reject</option>
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ !is_null($data->$validate1Date) ? $data->$validate1Date->format('d M Y') : '-' }}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ !is_null($data->work_date) ? $data->work_date->format('d M Y') : '-' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="align-middle text-center">
                                                {{ auth()->user()->role }} 2
                                            </td>
                                            <td class="align-middle text-center">
                                                <select name="{{ $validate2 }}" class="form-control validate" data-survey-id="{{ $data->id }}">
                                                    <option value="Pending"{{ $data->$validate2 == 'Pending' ? ' selected' : '' }}>Pending</option>
                                                    <option value="Complete"{{ $data->$validate2 == 'Complete' ? ' selected' : '' }}>Complete</option>
                                                    <option value="Reject"{{ $data->$validate2 == 'Reject' ? ' selected' : '' }}>Reject</option>
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ !is_null($data->$validate2Date) ? $data->$validate2Date->format('d M Y') : '-' }}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ !is_null($data->work_date) ? $data->work_date->format('d M Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $datas->withQueryString()->links() }}
                        @else
                            <table class="mt-3 table table-bordered">
                                <thead class="bg-danger text-white">
                                    <tr>
                                        <th class="align-middle text-center">No order / SID</th>
                                        <th class="align-middle text-center">Type of Task</th>
                                        <th class="align-middle text-center">Status</th>
                                        <th class="align-middle text-center">Status Date</th>
                                        <th class="align-middle text-center">Work Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr><td colspan="5" class="text-center">Tidak ada data yang ditampilkan</td></tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Catatan :</label>
                    <textarea name="note" id="note" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="btnSubmit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="datepicker" style="display: none;"></div>
@endsection

@push('scripts')
    <script>
        $().ready(function () {
            let survey_id, name, value, date, url, note;
            $('.dValidate').change(function() {
                survey_id = $(this).data('survey-id');
                name = $(this).attr('name');
                value = $(this).val();
                date = "{{ Carbon\Carbon::now() }}";

                url = "{{ route('survey.validate', ':survey_id') }}";
                url = url.replace(':survey_id', survey_id);

                datepicker.open();

            });

            $('.validate').change(function() {
                survey_id = $(this).data('survey-id');
                name = $(this).attr('name');
                value = $(this).val();
                date = "{{ Carbon\Carbon::now() }}";

                url = "{{ route('survey.validate', ':survey_id') }}";
                url = url.replace(':survey_id', survey_id);

                if (value !== 'Complete') {
                    $('.modal').modal('show');
                    $('.modal-title').text(`Task ${value}`);

                    note = $('#note');
                    note.attr('placeholder', `Berikan keterangan ${value}`);

                    $('#btnSubmit').click(function() {
                        postData(url, 'PUT', {
                            [name]: value,
                            [name + "_date"]: date,
                            'note' : note.val(),
                            'status' : value
                        });
                    });
                } else {
                    postData(url, 'PUT', {
                        [name]: value,
                        [name + "_date"]: date
                    });
                }

            });

            let datepicker = $('#datepicker').datepicker({
                modal: true,
                format: 'yyyy-mm-dd',
                change: function(e) {
                    postData(url, 'PUT', {
                            [name] : value,
                            [name + "_date"] : date,
                            'work_date' : datepicker.value()
                        });
                }
            });

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
                alert('Berhasil merubah status');
                location.reload(true);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endpush
