@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
        <tr>
            <th>#Id</th>
            <th>Adı</th>
            <th>Açıklama</th>
            <th>Tutar</th>
            <th>E-mail</th>
            <th>Tarih</th>
        </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script>
    $(document).ready( function () {
        $('#laravel_datatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Turkish.json"
            },
            processing: true,
            serverSide: true,

            ajax: "{{ route('payments.json') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'amount', name: 'amount' },
                { data: 'email', name: 'email' },
                { data: 'created_at', name: 'created_at' }
            ]
        });
    });
</script>
@endsection
