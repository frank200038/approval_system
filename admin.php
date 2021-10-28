<?php include 'token.php' ?>
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
    <link href="src/css/index.css" rel="stylesheet">
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <a class="navbar-brand" href="#">Project</a>
    </nav>
    <div class="container">
        <div class="d-flex flex-row justify-content-center" style="margin-top:3%;">
            <div class="p-2">
                <input type="text" class="form-control" id="search" placeholder="Search">
            </div>
            <div class="p-2">
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort Option
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#" id="byname">By Name</a></li>
                        <li><a class="dropdown-item" href="#" id="bydate">By Creation Date</a></li>
                    </ul>
                </div>
            </div>
            <div class="p-2">
                <button id="New" class="btn btn-outline-primary" style="align-content: center;">Add New Project</button>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
            
            </div>
            <div class="col approved">
            
            </div>
            <div class="col not-approved">
            
            </div>
        </div>
        <div class="recipe-container"></div>

    </div>
    <script src="src/js/moment.js"></script>
    <script src="src/js/uuidv4.js"></script>
    <script src="src/js/projects-function.js"></script>
    <script src="src/js/projects-view.js"></script>
    <script src="src/js/projects.js"></script>
    
</body>

</html>