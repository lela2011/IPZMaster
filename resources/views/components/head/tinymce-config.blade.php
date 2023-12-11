<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea.wysiwyg', // Targets only textareas with id='cv'
        promotion: false, // removes update banner
        branding: false, // removes tinymce logo
        elementpath: false, // removes the hint which html tag is currently used
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright | indent outdent | table'
    });
</script>
