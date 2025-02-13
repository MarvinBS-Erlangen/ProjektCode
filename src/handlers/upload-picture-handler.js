// Function to check if the URL is a valid image
function isValidImageUrl(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(true); // If image loads, it's a valid URL
        img.onerror = () => reject(false); // If image fails to load, it's an invalid URL
        img.src = url;
    });
}

// Function to show the image preview
async function showPreview() {
    const title = document.getElementById('description').value; // Get title input value
    const imageUrl = document.getElementById('image-url').value; // Get image URL input value
    const preview = document.getElementById('preview'); // Select the preview container
    const previewImage = document.getElementById('preview-image'); // Select the image element
    const previewTitle = document.getElementById('preview-title'); // Select the title element
    const errorMessage = document.getElementById('error-message'); // Error message element

    // Reset error message
    errorMessage.textContent = '';

    if (imageUrl) {
        try {
            const isValid = await isValidImageUrl(imageUrl); // Check if the image URL is valid
            if (isValid) {
                previewImage.src = imageUrl; // Set the image source to the entered URL
                previewTitle.textContent = title; // Set the text of the title below the image
                preview.classList.remove('hidden'); // Show the preview section
            } else {
                throw new Error('Invalid image URL.');
            }
        } catch (error) {
            preview.classList.add('hidden'); // Hide the preview section
            errorMessage.textContent =
                'The provided image URL is invalid. Please provide a valid image URL.'; // Show error message
        }
    }
}

// Function to handle the upload button click (only uploads if image is valid)
async function uploadImage() {
    const title = document.getElementById('description').value;
    const imageUrl = document.getElementById('image-url').value;
    const errorMessage = document.getElementById('error-message'); // Error message element

    // Reset error message
    errorMessage.textContent = '';

    if (!title || !imageUrl) {
        alert('Please provide both a title and an image URL.');
        return;
    }

    try {
        const isValid = await isValidImageUrl(imageUrl); // Check if the image URL is valid
        if (isValid) {
            alert(
                'We received your image! Waiting for admin approval to upload.'
            );

            // Proceed with the actual upload logic here

            // Redirect to contest.php after a delay
            setTimeout(() => {
                window.location.href = 'contest.php';
            }, 3000); // 3 seconds delay
        } else {
            throw new Error('Invalid image URL.');
        }
    } catch (error) {
        errorMessage.textContent =
            'Unable to upload, the image URL is invalid.'; // Show error message
    }
}

// Event listener for the preview button
document
    .querySelector('.preview-button')
    .addEventListener('click', showPreview);

// Event listener for the upload button
document.querySelector('.upload-submit').addEventListener('click', uploadImage);
