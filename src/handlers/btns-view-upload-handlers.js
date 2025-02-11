document.addEventListener('DOMContentLoaded', () => {
    const btnViewUploads = document.getElementById('btn-view-your-uploads');
    const btnUploadPicture = document.getElementById('btn-upload-picture');
    const fileUploadInput = document.getElementById('file-upload');
    const uploadsContainer = document.querySelector(
        '.view-your-uploads-container',
    );
    const uploadFormContainer = document.querySelector(
        '.upload-picture-container',
    );

    btnViewUploads.addEventListener('click', () => {
        window.location.href = 'viewuploads.php'; // Redirect to viewuploads.php
    });

    btnUploadPicture.addEventListener('click', () => {
        window.location.href = 'uploadpicture.php'; // Redirect to viewuploads.php
    });

    btnUploadPicture.addEventListener('click', () => {
        fileUploadInput.click(); // Trigger the file input click
    });

    fileUploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            alert(`Selected file: ${file.name}`);
            // Here you can add the code to handle the file upload
        }
    });
});
