// Function to show the image preview
function showPreview() {
    const title = document.getElementById("title").value; // Get title input value
    const imageUrl = document.getElementById("image-url").value; // Get image URL input value
    const preview = document.getElementById("preview"); // Select the preview container
    const previewImage = document.getElementById("preview-image"); // Select the image element
    const previewTitle = document.getElementById("preview-title"); // Select the title element

    if (imageUrl) {
        previewImage.src = imageUrl; // Set the image source to the entered URL
        previewTitle.textContent = title; // Set the text of the title below the image
        preview.classList.remove("hidden"); // Show the preview section
    }
}

// Function to handle the upload button click (you can add actual upload logic here)
function uploadImage() {
    const title = document.getElementById("title").value;
    const imageUrl = document.getElementById("image-url").value;

    // Example upload logic - you can replace this with your actual upload functionality
    if (title && imageUrl) {
        alert("Image uploaded successfully!");
        // Reset form or handle upload actions here
    } else {
        alert("Please provide both a title and an image URL.");
    }
}

// Event listener for the preview button
document.querySelector(".preview-button").addEventListener("click", showPreview);

// Event listener for the upload button
document.querySelector(".upload-submit").addEventListener("click", uploadImage);
