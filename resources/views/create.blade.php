<!-- resources/views/form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        #image-preview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .image-container {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .image-container button {
            margin-left: 10px;
        }
        .image-container {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .image-container button {
            margin-left: 10px;
        }
        #image-container {
            display: flex;
            flex-direction: column;
        }
        #add-more-btn {
            margin-top: 10px;
        }
        .all-previews {
            display: flex;
            flex-wrap: wrap;
        }
        .all-previews img {
            width: 50px;
            height: 80px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Submit Form</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <div id="image-container">
            <div class="image-container">
                <label for="image">Image:</label>
                <input type="file" name="image[]" accept="image/*" required onchange="previewImage(this)">
                <button type="button" onclick="removeImageField(this)">Remove</button>
            </div>
            <button type="button" id="add-more-btn" onclick="addImageField()">Add More</button>
        </div>


        <br>

        <div class="all-previews"></div>

        <br>

        <button type="submit">Submit</button>
    </form>

    <!-- ... (previous HTML and styles) ... -->

<script>
    function previewImage(input) {
        const previewContainer = document.querySelector('.all-previews');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const preview = document.createElement('img');
                preview.style.width = '50px';
                preview.style.height = '80px';
                preview.src = e.target.result;
                previewContainer.appendChild(preview);

                // Create an object to associate input with its preview
                const inputPreviewPair = {
                    input: input,
                    preview: preview,
                };

                // Store the input-preview pair in an array
                inputPreviewPairs.push(inputPreviewPair);
            };

            reader.readAsDataURL(file);
        }
    }

    function addImageField() {
        const container = document.getElementById('image-container');
        const newImageField = document.createElement('div');
        newImageField.classList.add('image-container');

        newImageField.innerHTML = `
            <label for="image">Image:</label>
            <input type="file" name="image[]" accept="image/*" required onchange="previewImage(this)">
            <button type="button" onclick="removeImageField(this)">Remove</button>
        `;

        container.appendChild(newImageField);
    }

    function removeImageField(button) {
        const container = button.parentNode;
        const previewContainer = document.querySelector('.all-previews');

        // Find the corresponding input-preview pair and remove it
        const inputPreviewPair = inputPreviewPairs.find(pair => pair.input === container.querySelector('input'));
        if (inputPreviewPair) {
            previewContainer.removeChild(inputPreviewPair.preview);
        }

        // Remove the entire container
        container.parentNode.removeChild(container);
    }

    // Array to store input-preview pairs
    const inputPreviewPairs = [];
</script>

<!-- ... (remaining HTML and styles) ... -->

</body>
</html>