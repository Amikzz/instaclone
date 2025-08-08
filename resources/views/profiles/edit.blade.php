@extends('layouts.app')
@section('content')

    <!-- Cropper.js CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>

    <style>
        /* Card styling */
        .edit-profile-card {
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
        /* Input and textarea styling */
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
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
        /* Image preview container */
        .image-upload-container {
            position: relative;
            border: 2px dashed #ff2e63;
            border-radius: 50%; /* Circular container */
            padding: 5px;
            width: 150px;
            height: 150px;
            margin: 0 auto 10px;
            cursor: pointer;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            overflow: hidden;
        }
        .image-upload-container.dragover {
            background-color: #ffe6f0;
            border-color: #e02656;
        }
        /* Cropper container */
        #cropperContainer {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            display: none; /* hidden initially */
        }
        /* Cropper image */
        #cropperImage {
            max-width: 100%;
            max-height: 400px;
            display: block;
            margin: 0 auto;
        }
        /* Preview image */
        #imagePreview {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: contain;
            background-color: white;
            border: 3px solid #ff2e63;
            transition: box-shadow 0.3s ease;
            user-select: none;
        }
        #imagePreview:hover {
            box-shadow: 0 0 15px #ff2e63;
        }
        /* Hidden file input */
        #profile_image {
            display: none;
        }
        /* Upload instructions */
        .upload-instructions {
            font-size: 0.95rem;
            color: #555;
            margin-top: 10px;
            user-select: none;
            text-align: center;
        }
        /* Error feedback */
        .invalid-feedback {
            font-size: 0.9rem;
            color: #d9534f;
        }
        /* Crop buttons */
        .cropper-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .cropper-buttons button {
            border: none;
            border-radius: 10px;          /* Rounded pill shape */
            padding: 10px 20px;           /* Comfortable clickable area */
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Specific colors per button type for clarity */
        #rotateLeftBtn,
        #rotateRightBtn {
            background-color: #6c757d;    /* Bootstrap secondary */
            color: white;
        }

        #rotateLeftBtn:hover,
        #rotateRightBtn:hover {
            background-color: #5a6268;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        #cropBtn {
            background-color: #28a745;    /* Bootstrap success */
            color: white;
        }

        #cropBtn:hover {
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        #cancelCropBtn {
            background-color: #dc3545;    /* Bootstrap danger */
            color: white;
        }

        #cancelCropBtn:hover {
            background-color: #c82333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 edit-profile-card">
                <h3 class="mb-4 text-center">Edit Profile</h3>

                <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name', $user->name) }}"
                               required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               name="username" value="{{ old('username', $user->username) }}">
                        @error('username')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" rows="3"
                                  class="form-control @error('bio') is-invalid @enderror"
                                  name="bio">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4 text-center">
                        <label class="form-label d-block">Profile Image</label>
                        <div id="imageUpload" class="image-upload-container" title="Drag & drop or click to select image">
                            <img id="imagePreview"
                                 src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                                 alt="Profile Image Preview" />
                        </div>
                        <div class="upload-instructions">Drag & drop image here or click to select</div>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display:none;">
                        @error('profile_image')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Cropper Container -->
                    <div id="cropperContainer">
                        <img id="cropperImage" src="" alt="Cropper Image" />
                        <div class="cropper-buttons">
                            <button type="button" class="btn btn-secondary" id="rotateLeftBtn">Rotate Left</button>
                            <button type="button" class="btn btn-secondary" id="rotateRightBtn">Rotate Right</button>
                            <button type="button" class="btn btn-success" id="cropBtn">Crop & Use</button>
                            <button type="button" class="btn btn-danger" id="cancelCropBtn">Cancel</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageUpload = document.getElementById('imageUpload');
            const fileInput = document.getElementById('profile_image');
            const imagePreview = document.getElementById('imagePreview');
            const cropperContainer = document.getElementById('cropperContainer');
            const cropperImage = document.getElementById('cropperImage');
            let cropper;

            // Click container triggers file input click
            imageUpload.addEventListener('click', () => {
                fileInput.click();
            });

            // Function to start cropping
            function startCropper(imageSrc) {
                cropperImage.src = imageSrc;
                cropperContainer.style.display = 'block';
                imageUpload.style.display = 'none';

                // Destroy previous cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1, // square crop
                    viewMode: 1,
                    autoCropArea: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: false,
                    background: false,
                    modal: true,
                });
            }

            // On file select, read and launch cropper
            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        startCropper(e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop handlers
            imageUpload.addEventListener('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.add('dragover');
            });

            imageUpload.addEventListener('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.remove('dragover');
            });

            imageUpload.addEventListener('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                imageUpload.classList.remove('dragover');

                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        startCropper(event.target.result);
                    };
                    reader.readAsDataURL(e.dataTransfer.files[0]);
                }
            });

            // Rotate buttons
            document.getElementById('rotateLeftBtn').addEventListener('click', () => {
                if (cropper) cropper.rotate(-45);
            });
            document.getElementById('rotateRightBtn').addEventListener('click', () => {
                if (cropper) cropper.rotate(45);
            });

            // Cancel cropping
            document.getElementById('cancelCropBtn').addEventListener('click', () => {
                cropperContainer.style.display = 'none';
                imageUpload.style.display = 'flex';
                fileInput.value = null; // reset input
                if (cropper) cropper.destroy();
            });

            // Crop & update preview
            document.getElementById('cropBtn').addEventListener('click', () => {
                if (!cropper) return;

                // Get cropped canvas
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingQuality: 'high',
                });

                // Convert canvas to blob and update file input with cropped image blob
                canvas.toBlob((blob) => {
                    if (!blob) return;

                    // Create new File from Blob
                    const croppedFile = new File([blob], 'cropped_profile.png', { type: 'image/png', lastModified: Date.now() });

                    // Use DataTransfer to update file input files list (needed for form submission)
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fileInput.files = dataTransfer.files;

                    // Update preview image with cropped result
                    imagePreview.src = URL.createObjectURL(blob);

                    // Hide cropper, show preview uploader again
                    cropperContainer.style.display = 'none';
                    imageUpload.style.display = 'flex';

                    // Destroy cropper instance
                    cropper.destroy();
                }, 'image/png');
            });
        });
    </script>

@endsection
