@extends('layouts.app')
@section('content')

    {{-- Cropper.js CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet"/>

    <style>
        /* Card styling */
        .create-post-card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
            padding: 30px;
            margin-top: 40px;
            background: #fff;
        }
        /* Form label styling */
        label.form-label {
            font-weight: 600;
            color: #333;
        }
        /* Textarea styling */
        textarea.form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            resize: vertical;
        }
        textarea.form-control:focus {
            border-color: #ff2e63;
            box-shadow: 0 0 8px #ff2e63aa;
            outline: none;
        }
        /* Button styling */
        .btn-primary {
            background-color: #ff2e63;
            border: none;
            padding: 12px 25px;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #e02656;
        }
        /* Image upload container with drag and drop */
        .image-upload-container {
            position: relative;
            border: 2px dashed #ff2e63;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            margin-bottom: 15px;
            max-height: 320px;
        }
        .image-upload-container.dragover {
            background-color: #ffe6f0;
            border-color: #e02656;
        }
        /* Preview image styling */
        #imagePreview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 15px;
            object-fit: contain;
            margin-bottom: 10px;
            box-shadow: 0 0 10px #ff2e63;
            display: none; /* hidden initially */
            transition: box-shadow 0.3s ease;
            filter: none;
        }
        #imagePreview:hover {
            box-shadow: 0 0 20px #ff2e63;
        }
        /* Hidden file input */
        #image {
            display: none;
        }
        /* Upload instructions */
        .upload-instructions {
            font-size: 1rem;
            color: #555;
            user-select: none;
            margin-bottom: 10px;
        }
        /* Error feedback */
        .invalid-feedback {
            font-size: 0.9rem;
            color: #d9534f;
        }
        /* Cropper container */
        #cropperModal {
            display: none;
            position: fixed;
            top:0; left:0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        #cropperContent {
            background: white;
            padding: 15px;
            border-radius: 12px;
            max-width: 90vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #cropperImage {
            max-width: 100%;
            max-height: 60vh;
            border-radius: 10px;
            background: #f8f8f8;
        }
        .cropper-buttons {
            margin-top: 15px;
            display: flex;
            gap: 12px;
        }
        .cropper-buttons button {
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: white;
        }
        #rotateLeftBtn,
        #rotateRightBtn {
            background-color: #6c757d;
        }
        #rotateLeftBtn:hover,
        #rotateRightBtn:hover {
            background-color: #5a6268;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        #cropBtn {
            background-color: #28a745;
        }
        #cropBtn:hover {
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        #cancelCropBtn {
            background-color: #dc3545;
        }
        #cancelCropBtn:hover {
            background-color: #c82333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        /* Filter controls container */
        #filterControls {
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        #filterControls label {
            font-weight: 600;
            color: #333;
            user-select: none;
        }
        #filterControls select {
            border-radius: 8px;
            padding: 5px 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.3s ease;
        }
        #filterControls select:focus {
            border-color: #ff2e63;
            box-shadow: 0 0 5px #ff2e63aa;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 create-post-card">
                <h3 class="mb-4 text-center">Create New Post</h3>

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" id="postForm">
                    @csrf

                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption</label>
                        <textarea id="caption" class="form-control @error('caption') is-invalid @enderror" name="caption" rows="3" required></textarea>
                        @error('caption')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Image</label>
                        <div id="imageUpload" class="image-upload-container">
                            <img id="imagePreview" alt="Image Preview" src="">
                            <div class="upload-instructions">
                                Drag & drop image here or click to select
                            </div>
                            <input type="file" class="@error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        </div>
                        @error('image')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Hidden input to store cropped & filtered image data --}}
                    <input type="hidden" name="cropped_image" id="cropped_image" />

                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary w-100">Post</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Cropper Modal --}}
    <div id="cropperModal">
        <div id="cropperContent">
            <img id="cropperImage" src="" alt="Cropper Image" />
            <div class="cropper-buttons">
                <button type="button" id="rotateLeftBtn">Rotate Left</button>
                <button type="button" id="rotateRightBtn">Rotate Right</button>
                <button type="button" id="cropBtn">Crop & Use Image</button>
                <button type="button" id="cancelCropBtn">Cancel</button>
            </div>
            <br>
            <div id="filterControls">
                <label for="filterSelect">Filter:</label>
                <select id="filterSelect" title="Choose a filter">
                    <option value="none">None</option>
                    <option value="grayscale(100%)">Black & White</option>
                    <option value="brightness(0.8)">Darken</option>
                    <option value="brightness(1.2)">Brighten</option>
                    <option value="sepia(60%)">Sepia</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Cropper.js Script CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageUpload = document.getElementById('imageUpload');
            const fileInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const croppedImageInput = document.getElementById('cropped_image');

            // Cropper elements
            const cropperModal = document.getElementById('cropperModal');
            const cropperImage = document.getElementById('cropperImage');
            const rotateLeftBtn = document.getElementById('rotateLeftBtn');
            const rotateRightBtn = document.getElementById('rotateRightBtn');
            const cropBtn = document.getElementById('cropBtn');
            const cancelCropBtn = document.getElementById('cancelCropBtn');
            const filterSelect = document.getElementById('filterSelect');

            let cropper = null;
            let currentRotation = 0;
            let currentFilter = 'none';

            // Show image preview & open cropper modal on image select
            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        cropperImage.src = e.target.result;
                        filterSelect.value = 'none';
                        cropperModal.style.display = 'flex';

                        // Initialize cropper
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 4 / 3,
                            viewMode: 1,
                            background: false,
                            autoCropArea: 1,
                            movable: true,
                            zoomable: true,
                            rotatable: true,
                            scalable: false,
                        });
                        currentRotation = 0;
                        currentFilter = 'none';
                        cropperImage.style.filter = 'none';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });

            // Rotate buttons
            rotateLeftBtn.addEventListener('click', () => {
                currentRotation -= 90;
                cropper.rotate(-90);
            });
            rotateRightBtn.addEventListener('click', () => {
                currentRotation += 90;
                cropper.rotate(90);
            });

            // Filter select
            filterSelect.addEventListener('change', () => {
                currentFilter = filterSelect.value;
                cropperImage.style.filter = currentFilter;
            });

            // Crop and apply filter
            cropBtn.addEventListener('click', () => {
                if (!cropper) return;

                // Get cropped canvas
                const canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 600,
                    imageSmoothingQuality: 'high',
                });

                // Apply CSS filter on canvas using an offscreen canvas
                if (currentFilter !== 'none') {
                    const offCanvas = document.createElement('canvas');
                    offCanvas.width = canvas.width;
                    offCanvas.height = canvas.height;
                    const ctx = offCanvas.getContext('2d');

                    ctx.filter = currentFilter;
                    ctx.drawImage(canvas, 0, 0);
                    const filteredDataUrl = offCanvas.toDataURL('image/jpeg', 0.9);

                    imagePreview.src = filteredDataUrl;
                    croppedImageInput.value = filteredDataUrl;
                } else {
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    imagePreview.src = dataUrl;
                    croppedImageInput.value = dataUrl;
                }

                imagePreview.style.display = 'block';
                cropperModal.style.display = 'none';
                cropper.destroy();
                cropper = null;

                // Clear original file input to prevent double submissions
                fileInput.value = '';
            });

            // Cancel cropping
            cancelCropBtn.addEventListener('click', () => {
                cropperModal.style.display = 'none';
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                fileInput.value = '';
            });

            // Click container triggers file input click
            imageUpload.addEventListener('click', () => {
                fileInput.click();
            });

            // Drag & drop handlers
            imageUpload.addEventListener('dragover', e => {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.add('dragover');
            });

            imageUpload.addEventListener('dragleave', e => {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.remove('dragover');
            });

            imageUpload.addEventListener('drop', e => {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.remove('dragover');

                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });

            // On form submit, replace image file input with cropped image data
            document.getElementById('postForm').addEventListener('submit', function (e) {
                if (!croppedImageInput.value) {
                    e.preventDefault();
                    alert("Please upload and crop an image before submitting.");
                    return false;
                }
                // Remove name attribute to avoid raw file upload (but after validation)
                fileInput.removeAttribute('name');
            });

        });
    </script>

@endsection
