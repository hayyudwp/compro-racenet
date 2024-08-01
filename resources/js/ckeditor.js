import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

ClassicEditor
    .create(document.querySelector('.ckeditor'))
    .catch(error => {
        console.error(error);
    });