@push('scripts')
    <script>
        $(document).ready(function () {
            @foreach ($errors->all() as $error)
            $.notify('{{$error}}', {
                type: "danger",
            });
            @endforeach

            @if(!empty($msgInfo) && is_array($msgInfo))
            @foreach ($msgInfo as $info)
            $.notify('{{$info}}', {
                type: "info"
            });
            @endforeach
            @endif

            @if(!empty($msgSuccess) && is_array($msgSuccess))
            @foreach ($msgSuccess as $success)
            $.notify('{{$success}}', {
                type: "success"
            });
            @endforeach
            @endif

            @if(!empty($success) && is_string($success))
            $.notify('{{$success}}', {
                type: "success"
            });
            @endif
        });
    </script>
@endpush