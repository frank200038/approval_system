<?php include 'token.php'; ?>
<!DOCTYPE html>

<html>

<head>
    <meta name = "csrf-token" content ="<?php echo $_SESSION['csrf_token']; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</head>
<body>
    <link href="src/css/edit.css" rel="stylesheet">
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <a class="navbar-brand" href="admin">Project</a>
    </nav>
    <div class="container" style="margin-top:1%;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Name:</h4>
                <input type="text" class="form-control" id="name">
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Link:</h4>
                <p id="link"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Status:</h4>
                <p id="status"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Proposals</h4>
                <hr />
                <div id="photo"></div>
                <div class = "rounded" id="drop-zone">
                    <form class="file-form">
                        <p id="drop-zone-text">
                            <img src="src/img/upload-image.svg" class="mx-auto d-block" width="50" height="50" style="padding-bottom:2%;">
                            Drop or Drag image here to upload
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Comment</h4>
                <hr />
                <p id="comment"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Description</h4>
                <hr />
                <textarea class="form-control" rows="5" id="content"></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-block" id="save">Save Project</button>
        <button type="button" class="btn btn-danger btn-block" id="remove">Remove Project</button>
    </div>
    <script src="src/js/uuidv4.js"></script>
    <script src="src/js/projects-function.js"></script>
    <script src="src/js/projects-edit.js"></script>

</body>

</html>