@extends('suppliers.layouts.main')
@section('main-section')
    @push('title')
        <title>Wallet Management</title>
    @endpush



    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    Wallet Management
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="card-body">
            @php
                $sno = 1;
            @endphp
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Wallet Limit</th>
                        <th>Used Wallet</th>
                        <th>Current</th>
                        <th>Wallet Interest</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$sno++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->number}}</td>
                            <td>{{$item->wallet}}</td>
                            <td>{{$item->used_wallet}}</td>
                            <td>{{$item->wallet-$item->used_wallet}}</td>
                            <td>{{$item->wallet_interest}}</td>
                            <td>{{$item->updated_at}}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
@endsection
