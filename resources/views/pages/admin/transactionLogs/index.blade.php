@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Transaction Logs
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('transactionLogs.downloadPdf') }}" class="btn btn-primary mt-3">Download Detail PDF</a>

                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Loggable Type</th>
                                        <th>User Role</th>
                                        <th>Quantity</th>
                                        <th>Request Type</th>
                                        <th>Request Date</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactionLogs as $key => $log)
                                        <tr>
                                            <td>{{ $transactionLogs->total() - ($transactionLogs->currentPage() - 1) * $transactionLogs->perPage() - $key }}</td>
                                            <td>{{ class_basename($log->loggable_type) }}</td>
                                            <td>{{ $log->user->getRoleNames()->implode(', ') }}</td> <!-- Role of the user -->
                                            <td>{{ $log->quantity }}</td>
                                            <td>{{ ucfirst($log->request_type) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log->request_date)->format('d M Y H:i:s') }}</td>
                                            <td>{{ $log->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <p>No transaction logs found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $transactionLogs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
