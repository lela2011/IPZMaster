<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: 'textarea.wysiwyg', // Targets only textareas with id='cv'
        promotion: false, // removes update banner
        branding: false, // removes tinymce logo
        elementpath: false, // removes the hint which html tag is currently used
        plugins: 'link lists',
        toolbar: 'undo redo | blocks | bold italic underline | link | bullist numlist | alignleft aligncenter alignright | indent outdent',
        link_assume_external_targets: true,
        default_link_target: "_blank",
        target_list: [ {title: 'New page', value: '_blank', selected: true} ],
    });
</script>
