<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });

        @if(session('success'))
            toastr.success('{{ session('success') }}')
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}')
        @endif

        @if(session('info'))
            toastr.info('{{ session('info') }}')
        @endif

        @if(session('warning'))
            toastr.warning('{{ session('warning') }}')
        @endif
    });

</script>
