<?php
    include 'token.php';
?>

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
    <link href="src/css/view.css" rel="stylesheet">
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <img src="src/img/Logo 2021.svg" alt="" width="100" height="100" style="margin-left:50px;">
        <a class="navbar-brand" href="" style="margin-left:10px;">Projects Proposals</a>
    </nav>
    <div class="container" style="margin-top:1%;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Name:</h4>
                <p id="name"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Date:</h4>
                <p id="date"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" >Status:</h4>
                <p id="status" style="color:red"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Proposals</h4>
                <hr />
                <div id="photo"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Description</h4>
                <hr />
                <p id="description"></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Comment</h4>
                <hr />
                <textarea class="form-control" rows="5" id="comment"></textarea>
            </div>
        </div>
         <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="color:red;font-weight:bold;">Warnings:</h4>
                <hr />
                <div  id="warning">
                    <ul>
                        <li>
                            <p>
                                <span style="font-size:20px;font-weight:bold;">Please proofread carefully for typographical errors.</span> Please check artwork carefully as we are not responsible for errors that are not marked nor mentioned once the project is approved
                            </p>
                        </li>
                        <li>
                            <p>
                                Color may vary depending on monitor/printer calibration. The customer understands that due to variations in the calibration of computer monitors and differences in equipment, papers, and inks, color variations between the PDF proof and the printed piece are to be expected. For color critical results, please request a hard copy proof.
                            </p>
                        </li>
                        <li>
                            <p>
                                If you approve this proof, please click <b>“APPROVE”</b>
                            </p>
                        </li>
                    </ul>
                    <p style="text-align:center;font-size:20px;">Thank you for your business!</p>
                </div>
            </div>
        </div>
        <div style="margin-left:30%;">
            <button type="button" class="btn btn-primary btn-block" id="approve" > Approve </button>
            <button  type="button" class="btn btn-primary btn-block" id="change"> Submit Comment </button>
        </div>
    </div>
    <script src="src/js/project-approval-view.js"></script>

</body>

</html> 