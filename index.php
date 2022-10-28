<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <title>ZOHO CRM</title>
</head>

<body class="bg-info">
    <!--Navbar-->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo.png" alt="zoho logo" width="60" height="30">
            </a>
        </div>
    </nav>
    <!--Content Goes here-->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <header>HTML FORM</header>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="CompanyName" class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="CompanyName" id="CompanyName">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="LastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="LastName" id="LastName">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="First_Name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="First_Name" id="First_Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="Email" id="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="State" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" name="State" id="State">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/sweet-alerts/sweet-alerts.js"></script>
    <script>
        //Ajax code for sending data to SendData.php file. and get response after inserting data into leads
        $("#submitBtn").click(function(e) {
            e.preventDefault();
            if ($('#CompanyName').val() != "" && $('#LastName').val() != "" && $('#First_Name').val() != "" && $('#State').val() != "" && $('#Email').val() != "") {
                var CompanyName = $("#CompanyName").val();
                var LastName = $("#LastName").val();
                var First_Name = $("#First_Name").val();
                var State = $("#State").val();
                var Email = $("#Email").val();
                data = {};
                data['CompanyName'] = CompanyName;
                data['LastName'] = LastName;
                data['First_Name'] = First_Name;
                data['State'] = State;
                data['Email'] = Email;
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "SendData.php",
                    data: data,
                    success: function(data) {
                        var data = $.parseJSON(data);
                        if (data.status == 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Data is added to leads successfully.",
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire(
                                data.message,
                                "Error in sending data to leads",
                                'error'
                            )
                        }
                    }
                });
            } else {
                Swal.fire(
                    "Error",
                    "The above fields are required",
                    'error'
                )
            }
        });
    </script>

</body>

</html>