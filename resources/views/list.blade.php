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
            <th>Oluşuturulma Tarihi</th>
            <th>Ödeme Tarihi</th>
            <th>Ödeme Bağlantısı</th>
            <th>Durum</th>
        </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
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
                { data: 'created_at', name: 'created_at' },
                { data: 'paid_at', name: 'paid_at' },
                { data: 'link', name: 'link' },
                { data: 'status', name: 'status' },
            ]
        });
    });
</script>
<script>
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position="fixed";  //avoid scrolling to bottom
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        alert("Bağlantı kopyalandı");
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
    }
function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        alert("Bağlantı kopyalandı");
    }, function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}
</script>
@endsection
