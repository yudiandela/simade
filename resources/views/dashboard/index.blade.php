@extends('layouts.app')

@section('content')
<div class="p-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <select name="all_treg" class="form-control">
                    <option>ALL TREG</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="all_treg" class="form-control">
                    <option>WTEL</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="all_treg" class="form-control">
                    <option>DEMAND</option>
                </select>
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

                    <tbody>
                        @foreach($surveys as $survey)
                        <tr>
                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle text-center">Lokasi</td>
                            <td class="align-middle text-left">{{ $survey->name }}</td>
                            <td class="align-middle text-center">{{ $survey->phone }}</td>
                            <td class="align-middle text-center">Paket</td>
                            <td class="align-middle text-left">{{ $survey->address }}</td>
                            <td class="align-middle text-center">{{ $survey->occupant }}</td>
                            <td class="align-middle text-center">Milik Pribadi</td>
                            <td class="align-middle text-center">7x12</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
