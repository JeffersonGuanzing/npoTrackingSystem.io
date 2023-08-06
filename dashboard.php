<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/npo_logo.png" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="dashboard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  </head>

  <body>
    <style>
      .page-container {
        display: inline-block;
      }

      #toastContainer {
  top: 80px;
  right: 40px;
}
    </style>

<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
          <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="mr-auto" id="toastTitle"></strong>
              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body" id="toastBody">
            </div>
          </div>
        </div>


    <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
      <a class="navbar-brand" href="#">
        <img src="images/npo_logo.png" alt="NPO Logo" class="npo-logo">
      </a>
      <button class="navbar-toggler"   type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link scroll-link" href="#dashboard"><i class="bi bi-columns-gap"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link scroll-link" href="#record"><i class="bi bi-card-text"></i> Record</a>
          </li>
          <li class="nav-item">
            <a class="nav-link scroll-link" href="#report"><i class="bi bi-file-earmark-break"></i> Report</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link scroll-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>

  

    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
      <div class="container-fluid" id="dashboard">
        <div class="row mt-2">
          <div class="col-12">
            <h1 class="display-6">Welcome to the PPCD Monitoring System</h1>
            <p>This is where you can view work order status</p>
          </div>
          
        </div>
            <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body bg-success">
                <h5 class="card-title text-white">Completed</h5>
                <p id="completed"></p>
                
                <?php 
                  include 'operations/db.php';
                  $sql = "SELECT COUNT(*) FROM `main` WHERE status_now = 'COMPLETED';";
                  $result = mysqli_query($conn, $sql);
                  $record = mysqli_fetch_assoc($result);
                ?>
                <p class="card-text text-white"><?php echo $record['COUNT(*)']; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body bg-warning">
                <h5 class="card-title text-dark">On-Process</h5>
                <p id="on-process"></p>

                <?php 
                  include 'operations/db.php';

                  $sql = "SELECT COUNT(*) FROM `main` WHERE status_now = 'On-Process';";
                  $result = mysqli_query($conn, $sql);
                  $record = mysqli_fetch_assoc($result);
                ?>
                <p class="card-text text-black"><?php echo $record['COUNT(*)']; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body bg-danger">
                <h5 class="card-title text-white">At Work Order Writer Section</h5>
                <p id="at_work_order_writer_section"></p>

                <?php 
                  include 'operations/db.php';
                  $sql = "SELECT COUNT(*) FROM `main` WHERE status_now = 'At Work Order Writer Section';";
                  $result = mysqli_query($conn, $sql);
                  $record = mysqli_fetch_assoc($result);
                ?>
                <p class="card-text text-white"><?php echo $record['COUNT(*)']; ?></p>
              </div>
            </div>
          </div>
        </div>

        


        <!--Table Record-->
        <div class="mt-5" id="record">
        <h2>Monitor Work Order Status </h2>
        
        <form id="filterForm">
          <div class="row mb-3">
            <div class="col-12 col-lg-4">
              
              <div class="input-group">
              <select class="form-control" id="status" name="status">
                    <option value="All">All</option>
                    <option value="Completed">Completed</option>
                    <option value="On-Process">On-Process</option>
                    <option value="At Work Order Writer Section">At Work Order Writer Section</option>
              </select>
              <input type="hidden" id="status_filter" value=""> 

                <label for="from-date" class="input-group-text bg-dark text-light">From Date</label>
                <input type="date" class="form-control" id="from-date" name="from-date">
                <input type="hidden" id="from_date_filter" value="">

              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="input-group">
                <label for="to-date" class="input-group-text bg-dark text-light">To Date</label>
                <input type="date" class="form-control" id="to-date" name="to-date">
                <input type="hidden" id="to_date_filter" value="">

               
                <div class="input-group-append">
                  <button class="btn btn-dark filterButton" type="click" id="filterButton">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <div class="col-12 col-lg-4">
              <div class="input-group">
               
                <form id="searchForm">
                    <input type="text" class="form-control" id="search" name="search">
                    <button class="btn btn-dark" id="search-btn" type="button">Go</button>
                </form>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRecord">New Record</button> 
                  <div class="form-group">  
                  </div>
              </div>
            </div>
              <!-- Modal -->
              <div class="modal fade" id="newRecord" tabindex="-1" aria-labelledby="newRecordLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newRecordLabel">Add Work Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                      <div class="modal-body">
                        <form class="add-record-form" id="add-record-form">
                          <div class="mb-3">
                            <label for="work_order_number" class="form-label">Work Order Number:</label>
                            <input type="text" class="form-control" id="work_order_number" name="work_order_number">
                          </div>
                          <div class="mb-3">
                            <label for="agency" class="form-label">Agency:</label>
                            <input type="text" class="form-control" id="agency" name="agency">
                          </div>
                          <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title">
                          </div>
                          <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                          </div>
                            <div class="mb-3">  
                              <label for="monitoring_received" class="form-label">Monitoring Received:</label>
                              <input type="date" class="form-control" id="monitoring_received" name="monitoring_received">
                            </div>
                          <div class="mb-3">  
                            <label for="pre_press_received" class="form-label">Composing Received:</label>
                            <input type="date" class="form-control" id="pre_press_received" name="pre_press_received">
                          </div>
                      </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add-record-button" id="add-record-button">Save changes</button>
                    </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

         <!--Show Data Table-->
         <div class="table-responsive">
              <table class="table table-bordered table-hover" id="table_container"></table>
              
              <!--Edit Modal-->
              <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="edit-modal-label">Edit Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="edit-form">
                          <div class="mb-3">
                            <label for="edit-work-order-number" class="form-label">Work Order Number:</label>
                            <input type="text" class="form-control" id="edit-work-order-number" name="work_order_number" required>
                          </div>
                          <div class="mb-3">
                            <label for="edit-agency" class="form-label">Agency:</label>
                            <input type="text" class="form-control" id="edit-agency" name="agency" required>
                          </div>
                          <div class="mb-3">
                            <label for="edit-title" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                          </div>
                          <div class="mb-3">
                            <label for="edit-quantity" class="form-label">Quantity:</label>
                            <input type="text" class="form-control" id="edit-quantity" name="quantity" required>
                          </div>
                          <div class="mb-3">
                            <label for="edit-monitoring_received" class="form-label">Monitoring Received:</label>
                            <input type="date" class="form-control" id="edit-monitoring_received" name="monitoring_received">
                          </div>
                          <div class="mb-3">
                            <label for="edit-work_order_writer_section" class="form-label">Work Order Writer Section:</label>
                            <input type="date" class="form-control" id="edit-work_order_writer_section" name="work_order_writer_section">
                          </div>
                          <div class="mb-3">
                            <label for="edit-received" class="form-label">Composing Received:</label>
                            <input type="date" class="form-control" id="edit-received" name="pre_press_received">
                          </div>
                          <div class="mb-3">
                            <label for="edit-released" class="form-label">Composing Released:</label>
                            <input type="date" class="form-control" id="edit-released" name="pre_press_released">
                          </div>
                          <div class="mb-3">
                            <label for="edit-photo-released" class="form-label">Photo Released:</label>
                            <input type="date" class="form-control" id="edit-photo-released" name="photo_released">
                          </div>
                          <div class="mb-3">
                            <label for="edit-todc" class="form-label">Target Date of Completion:</label>
                            <input type="date" class="form-control" id="edit-todc" name="target_date_of_completion">
                          </div>
                          <div class="mb-3">
                            <label for="edit-press-received" class="form-label">Press Received:</label>
                            <input type="date" class="form-control" id="edit-press-received" name="press_received">
                          </div>
                          <div class="mb-3">
                            <label for="edit-press-released" class="form-label">Press Released:</label>
                            <input type="date" class="form-control" id="edit-press-released" name="press_released">
                          </div>
                          <div class="mb-3">
                            <label for="edit-dar-number-press" class="form-label">DAR:</label>
                            <input type="text" class="form-control" id="edit-dar-number-press" name="dar_number-press">
                          </div>
                          <div class="mb-3">
                            <label for="edit-finishing-received" class="form-label">Finishing Received:</label>
                            <input type="date" class="form-control" id="edit-finishing-received" name="finishing_received">
                          </div>
                          <div class="mb-3">
                            <label for="edit-finishing-released" class="form-label">Finishing Released:</label>
                            <input type="date" class="form-control" id="edit-finishing-released" name="finishing_released">
                          </div>
                          <div class="mb-3">
                            <label for="edit-dar-number-finishing" class="form-label">DAR:</label>
                            <input type="text" class="form-control" id="edit-dar-number-finishing" name="dar_number-finishing">
                          </div>
                          <div class="mb-3">
                            <label for="edit-smd" class="form-label">SMD:</label>
                            <input type="date" class="form-control" id="edit-smd" name="smd">
                          </div>
                          <div class="mb-3">
                            <label for="edit-status-remarks" class="form-label">Remarks:</label>
                            <textarea class="form-control" id="edit-status-remarks" name="status_remarks"></textarea>
                          </div>
                          <div class="mb-3 form-group">  
                              <select class="form-control" id="status" name="status" class="form-control">
                                  <option value="Completed">Completed</option>
                                  <option value="On-Process" selected>On-Process</option>
                                  <option value="At Work Order Writer Section">At Work Order Writer Section</option>
                              </select>
                          </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary save-edit-button" id="save-edit-button">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="status_remarks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Remarks / Status</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="remark-container">
                          <p name="remarks" id="remarks" class="remarks"></p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

            <div id="pagination_container" class="mt-2">
              
            </div>
            <div class="mt-4" id="report">
            <h2>Print Report <i class="bi bi-file-earmark-pdf"></i></h2>
            <form id="filterForm" method="GET" action="print_record.php" target="_blank">
              <div class="row mb-3">
                <div class="col-md-4">
                  <div class="input-group">
                    <label for="from-date" class="input-group-text bg-dark text-light">From Date</label>
                    <input type="date" class="form-control" id="from" name="from">
                    <input type="hidden" id="from_date_filter" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <label for="to-date" class="input-group-text bg-dark text-light">To Date</label>
                    <input type="date" class="form-control" id="to" name="to">
                    <input type="hidden" id="to_date_filter" value="">
                  </div>
                </div>
                  <div class="col">
                    <div class="form-group">  
                        <select class="form-control" id="status_filter" name="status_filter">
                          <option value="All">All</option>
                          <option value="Completed">Completed</option>
                          <option value="On-Process">On-Process</option>
                          <option value="At Work Order Writer Section">At Work Order Writer Section</option>
                        </select>
                    </div>
                  </div>
                    <div class="col">
                      <button class="btn btn-dark filterButton" type="submit" id="filterButton">
                        <i class="bi bi-download"></i> PDF View
                      </button>
                    </div>
              </div>
            </form>
        </div>  
      </div>
    </div>
     
    <script>
  document.getElementById("filterForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    var form = event.target; // Get the form element
    var url = form.action; // Get the form action URL
    var formData = new FormData(form); // Get the form data

    // Open a new window and submit the form data
    window.open(url, "_blank");
    window.focus();
    form.submit();
  });
</script>
  </body>
</html>
