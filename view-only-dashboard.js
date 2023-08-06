$(document).on("click", ".status_remarks_modal", function(){
  var row_id = $(this).data('row-id')
  $.ajax({
      url: 'search.php',
      method: 'GET',
      data: {id: row_id},
      dataType: 'json',
      success: function(data) {
          $(".remark-container p[name='remarks']").text(data.status_remarks);
          $("#status_remarks").modal("show");
      }
  })
})  

$(document).ready(function() {
  $('#search-btn').click(function() {
      var searchTerm   = $('#search').val(); // Get the value of the search input field
      
      $.ajax({
          url: 'search_record.php',
          method: 'GET',
          dataType: 'json',
          data: {id: searchTerm},
          success: function(data) {
            var monitoring_received = data.monitoring_received ? new Date(data.monitoring_received) : null;
            if (monitoring_received && !isNaN(monitoring_received)) {
              monitoring_received = monitoring_received.toLocaleDateString();
            } else {
              monitoring_received = "";
            }
            var work_order_writer_section = data.work_order_writer_section ? new Date(data.work_order_writer_section) : null;
            if (work_order_writer_section && !isNaN(work_order_writer_section)) {
              work_order_writer_section = work_order_writer_section.toLocaleDateString();
            } else {
              work_order_writer_section = "";
            }
            var pre_press_received = data.pre_press_received? new Date(data.pre_press_received) : null;
            if (pre_press_received && !isNaN(pre_press_received)) {
              pre_press_received = pre_press_received.toLocaleDateString();
            } else {
              pre_press_received = "";
            }

            var pre_press_released = data.pre_press_released? new Date(data.pre_press_released) : null;
            if (pre_press_released && !isNaN(pre_press_released)) {
              pre_press_released = pre_press_released.toLocaleDateString();
            } else {
              pre_press_released = "";
            }
            
            var press_press_released = data.press_press_released? new Date(data.press_press_released) : null;
            if (press_press_released && !isNaN(press_press_released)) {
              press_press_released = press_press_released.toLocaleDateString();
            } else {
              press_press_released = "";
            }

            var target_date_of_completion = data.target_date_of_completion ? new Date(data.target_date_of_completion) : null;
            if (target_date_of_completion && !isNaN(target_date_of_completion)) {
              target_date_of_completion = target_date_of_completion.toLocaleDateString();
            } else {
              target_date_of_completion = "";
            }

            var press_received = data.press_received? new Date(data.press_received) : null;
            if (press_received && !isNaN(press_received)) {
              press_received = press_received.toLocaleDateString();
            } else {
              press_received = "";
            }

            var press_released = data.press_released? new Date(data.press_released) : null;
            if (press_released && !isNaN(press_released)) {
              press_released = press_released.toLocaleDateString();
            } else {
              press_released = "";
            }

            var finishing_received = data.finishing_received? new Date(data.finishing_received) : null;
            if (finishing_received && !isNaN(finishing_received)) {
              finishing_received = finishing_received.toLocaleDateString();
            } else {
              finishing_received = "";
            }

            var finishing_released = data.finishing_released? new Date(data.finishing_released) : null;
            if (finishing_released && !isNaN(finishing_released)) {
              finishing_released = finishing_released.toLocaleDateString();
            } else {
              finishing_released = "";
            }

            var smd = data.smd? new Date(data.smd) : null;
            if (smd && !isNaN(smd)) {
              smd = smd.toLocaleDateString();
            } else {
              smd = "";
            }

              // Handle the success response from the server
              var table_html = ""
                table_html += '<thead class="text-center bg-dark text-light"><tr><th class="bg-dark text-light">Work Order Number</th><th>Monitoring Received</th><th>Work Order Writer Section </th><th>Agency</th><th>Job Description</th><th>Quantity</th><th>Composing Received</th><th> Composing Released</th><th> Photo Released</th><th>Target Date of Completion</th><th>Press Received</th><th>Press Released</th><th>Finishing Received</th><th>Finishing Released</th><th>SMD</th><th>Remarks</th></tr></thead>';
                table_html += "<tr style='white-space: nowrap' class='text-center'><td>" + (data.work_order_number || "") + "</td><td>"+ (monitoring_received || "") +"</td><td>" + (work_order_writer_section || "") + "</td><td>" + (data.agency || "") + "</td><td>" + (data.title || "") + "</td><td>" + (data.quantity || "") + "</td><td>" + (pre_press_received || "") + "</td><td>" + (pre_press_released || "") + "</td><td>" + (press_press_released || "") + "</td><td>" + (target_date_of_completion || "") + "</td><td>" + (press_received || "") + "</td><td>" + (press_released || "") + "</td><td>" + (finishing_received || "") + "</td><td>" + (finishing_released || "") + "</td><td>" + (smd || "") + "</td><td><button type='button' class='btn btn-secondary status_remarks_modal' data-bs-toggle='modal' data-row-id='" + data.id + "' id='status_remarks_modal' data-bs-target='#status_remarks'><i class='bi bi-question-diamond'></i></button></td></tr>";
                table_html += "</tbody>";
                // Append the table to the HTML element with the ID "table-container"
                $("#table_container").html(table_html);
                $("#pagination_container").html('');
                 },
          error: function(xhr, status, error) {
              // Handle the error response from the server
              console.log(xhr.responseText);
          }
      });
  });
});

$(document).ready(function() {
  // Add event listener to button
  $('#save-edit-button').on('click', function() {
    // Get form data
    
    var formData = $('.edit-form').serialize();
    console.log(formData)
    //Make AJAX call
    $.ajax({
      type: 'POST',
      url: 'operations/update.php',
      data: formData,
      success: function(response) {
        if(response == 'success') {
          update_table(current_page);
          $('#edit-modal').modal('hide');
        } 
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });
});

$(document).on('click', '#delete-button', function() {
  console.log('Delete Record')
  var row_id = $(this).data("row-id");
  $.ajax({
      type: 'POST',
      url: 'operations/delete.php',
      data: {id: row_id},
      success: function(response) {
          update_table(current_page);
          $('#table-container').html(response);
      }, error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
  })
})

// Call this function after editing or deleting a record
function update_table(page) {
  // Call the load_table_records function with the current page number
  load_table_records(page);
}

var current_page = 1;

function load_table_records(page_number){
    //Make Ajax request to get table data for specified page number
    var from_date = $('#from_date_filter').val();
    var to_date = $('#to_date_filter').val();
    var status_filter = $('#status').val();
    
  console.log(status_filter)
    $.ajax({
        url: "operations/get_table_record.php",
        method: "GET",
        data: {page: page_number, from_date: from_date, to_date:  to_date, status_filter: status_filter, order_by: "id DESC" },
        dataType: "json", 
        success: function(data){
          console.log(data)
          //Build table HTML and append to table container
          var table_html = '';
          if(data.table_data.length > 0) {
              table_html += '<thead class="text-center bg-dark text-light"><tr><th class="bg-dark text-light">Work Order Number</th><th>Monitoring Received</th><th>Work Order Writer Section</th><th>Agency</th><th>Job Description</th><th>Quantity</th><th>Composing Received</th><th> Composing Released</th><th> Photo Released</th><th>Target Date of Completion</th><th>Press Received</th><th>Press Released</th><th>Finishing Received</th><th>Finishing Released</th><th>SMD</th><th>Remarks</th></tr></thead>';
          }
          table_html += '<tbody>';
          $.each(data.table_data, function(index, row){
            var monitoring_received = row.monitoring_received ? new Date(row.monitoring_received) : null;
            if (monitoring_received && !isNaN(monitoring_received)) {
              monitoring_received = monitoring_received.toLocaleDateString();
            } else {
              monitoring_received = "";
            }
            var work_order_writer_section = row.work_order_writer_section ? new Date(row.work_order_writer_section) : null;
            if (work_order_writer_section && !isNaN(work_order_writer_section)) {
              work_order_writer_section = work_order_writer_section.toLocaleDateString();
            } else {
              work_order_writer_section = "";
            }
            var pre_press_received = row.pre_press_received? new Date(row.pre_press_received) : null;
            if (pre_press_received && !isNaN(pre_press_received)) {
              pre_press_received = pre_press_received.toLocaleDateString();
            } else {
              pre_press_received = "";
            }
            var pre_press_released = row.pre_press_released? new Date(row.pre_press_released) : null;
            if (pre_press_released && !isNaN(pre_press_released)) {
              pre_press_released = pre_press_released.toLocaleDateString();
            } else {
              pre_press_released = "";
            }
            var press_press_released = row.press_press_released? new Date(row.press_press_released) : null;
            if (press_press_released && !isNaN(press_press_released)) {
              press_press_released = press_press_released.toLocaleDateString();
            } else {
              press_press_released = "";
            }
            var target_date_of_completion = row.target_date_of_completion ? new Date(row.target_date_of_completion) : null;
            if (target_date_of_completion && !isNaN(target_date_of_completion)) {
              target_date_of_completion = target_date_of_completion.toLocaleDateString();
            } else {
              target_date_of_completion = "";
            }

            var press_received = row.press_received? new Date(row.press_received) : null;
            if (press_received && !isNaN(press_received)) {
              press_received = press_received.toLocaleDateString();
            } else {
              press_received = "";
            }
            var press_released = row.press_released? new Date(row.press_released) : null;
            if (press_released && !isNaN(press_released)) {
              press_released = press_released.toLocaleDateString();
            } else {
              press_released = "";
            }
            var finishing_received = row.finishing_received? new Date(row.finishing_received) : null;
            if (finishing_received && !isNaN(finishing_received)) {
              finishing_received = finishing_received.toLocaleDateString();
            } else {
              finishing_received = "";
            }
            var finishing_released = row.finishing_released? new Date(row.finishing_released) : null;
            if (finishing_released && !isNaN(finishing_released)) {
              finishing_released = finishing_released.toLocaleDateString();
            } else {
              finishing_released = "";
            }
            var smd = row.smd? new Date(row.smd) : null;
            if (smd && !isNaN(smd)) {
              smd = smd.toLocaleDateString();
            } else {
              smd = "";
            }

            table_html += "<tr style='white-space: nowrap' class='text-center'><td>" + (row.work_order_number || "") + "</td><td>"+ (monitoring_received || "") +"</td><td>" + (work_order_writer_section || "") + "</td><td>" + (row.agency || "") + "</td><td>" + (row.title || "") + "</td><td>" + (row.quantity || "") + "</td><td>" + (pre_press_received || "") + "</td><td>" + (pre_press_released || "") + "</td><td>" + (press_press_released || "") + "</td><td>" + (target_date_of_completion || "") + "</td><td>" + (press_received || "") + "</td><td>" + (press_released || "") + "</td><td>" + (finishing_received || "") + "</td><td>" + (finishing_released || "") + "</td><td>" + (smd || "") + "</td><td><button type='button' class='btn btn-secondary status_remarks_modal' data-bs-toggle='modal' data-row-id='" + row.id + "' id='status_remarks_modal' data-bs-target='#status_remarks' data-page-number='" + page_number + "' ><i class='bi bi-question-diamond'></i></button></td></tr>";
        });
      
          table_html += "</tbody>";
          $("#table_container").html(table_html);
          
            // Update pagination links
            var pagination_html = "";
            for(var i = 1; i <= data.total_pages; i++){
                if(i == current_page){
                    pagination_html += "<a href='#' data-page='" + i + "' class='page-link'>" + i + "</a>";
                }
                else{
                    pagination_html += "<a href='#' data-page='" + i + "' class='page-link'>" + i + "</a>";
                }
            }

            $("#pagination_container").html(pagination_html);
        }
    });
}

$(document).ready(function(){
    // Load table records for first page
    load_table_records(current_page);

    // Add event listener for pagination links
    $(document).on("click", ".page-link", function(e){
        e.preventDefault();
        var page_number = $(this).data("page");
        load_table_records(page_number);
    });
});

// Add event listener for edit button click
$(document).on("click", ".edit-button", function(){

    current_page = $(this).data('page-number');
    var row_id = $(this).data("row-id");
    // Get data for the selected row
    $.ajax({ 
        url: "search.php",
        method: "GET",
        data: {id: row_id},
        dataType: "json",
        success: function(data){ 
          console.log(data)
            $(".edit-form input[name='work_order_number']").val(data.work_order_number);
            $(".edit-form input[name='agency']").val(data.agency);
            $(".edit-form input[name='title']").val(data.title);
            $(".edit-form input[name='quantity']").val(data.quantity);
            $(".edit-form input[name='monitoring_received']").val(data.monitoring_received);
            $(".edit-form input[name='work_order_writer_section']").val(data.work_order_writer_section);
            $(".edit-form input[name='pre_press_received']").val(data.pre_press_received);
            $(".edit-form input[name='pre_press_released']").val(data.pre_press_released);
            $(".edit-form input[name='press_press_released']").val(data.press_press_released);
            $(".edit-form input[name='target_date_of_completion']").val(data.target_date_of_completion);
            $(".edit-form input[name='press_received']").val(data.press_received);
            $(".edit-form input[name='press_released']").val(data.press_released);
            $(".edit-form input[name='dar_number-press']").val(data.press_dar_number);
            $(".edit-form input[name='finishing_received']").val(data.finishing_received);
            $(".edit-form input[name='finishing_released']").val(data.finishing_released);
            $(".edit-form input[name='dar_number-finishing']").val(data.finishing_dar_number);
            $(".edit-form input[name='smd']").val(data.smd);
            $(".edit-form textarea[name='status_remarks']").val(data.status_remarks);
            $(".edit-form select[name='status']").val(data.status_now);

            // Show the modal
            $("#edit-modal").modal("show");

        }, error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX error:', textStatus, errorThrown);
          }
    });
});

$(document).ready(function() {
  $('#newRecord').on('shown.bs.modal', function() {
    // Your code here
    $('#add-record-button').on('click', function() {
      var workOrderNumber = document.getElementById("work_order_number").value
      var agency = document.getElementById("agency").value
      var title = document.getElementById("title").value
      var composing_pre_press = document.getElementById("pre_press_received").value
      var monitoring_received = document.getElementById("monitoring_received").value
      var quantity = document.getElementById("quantity").value
      console.log(monitoring_received)
      $.ajax({
        method: 'POST',
        url: 'operations/add.php',
        data: {work_order_number: workOrderNumber, agency: agency, title: title, quantity: quantity, pre_press_received: composing_pre_press, monitoring_received: monitoring_received, status: "On-Process"},
        
        success: function(response) {
          if(response == 'success') {
            update_table(current_page);
            $('#newRecord').modal('hide');
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
});

$(document).ready(function() {
  $('#filterButton').on('click', function(e) {

  e.preventDefault()

  var selectedValue = $("#status").val();
  var from_date = $('#from-date').val(); // Get the value of the search input field
  var to_date = $('#to-date').val(); // Get the value of the search input field

  $('#status_filter').val(selectedValue);
  $('#from_date_filter').val(from_date);
  $('#to_date_filter').val(to_date);

  // Call the load_table_records() function to update the table
  load_table_records(1, from_date, to_date);
  })
})


$(document).ready(function() {
  $('#print').on('click', function(e) {
    e.preventDefault();
  
    var selectedValue = $("#status_filter").val();
    var fromDate = $('#from').val();
    var toDate = $('#to').val();

    // Redirect to filterData.php with the selected filter values
    var url = 'filterData.php?from=' + fromDate + '&to=' + toDate + '&status=' + selectedValue;
    window.location.href = url;
  });
});

