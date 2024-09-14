<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Internal Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h1 class="display-1 text-danger">500</h1>
                <h2 class="mb-4">Internal Server Error</h2>
                <a class="btn" href="{{url('/')}}">Back to home</a>
                <p class="lead">
                    <!-- Display the error message if passed -->
                    {{ $errors ?? 'The request could not be understood by the server due to malformed syntax.' }}
                </p><a href="/" class="btn btn-primary mt-3">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
