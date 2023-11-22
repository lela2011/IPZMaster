<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#cv', // Targets only textareas with id='cv'
        promotion: false, // removes update banner
        branding: false, // removes tinymce logo
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright | indent outdent | table'
    });
</script>
