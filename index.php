<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted to add a new order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitOrder"])) {
    // Retrieve form data if set
    $order_number = isset($_POST["order_number"]) ? $_POST["order_number"] : null;
    $style = isset($_POST["style"]) ? $_POST["style"] : null;
    $buyer = isset($_POST["buyer"]) ? $_POST["buyer"] : null;
    $merchandiser_name = isset($_POST["merchandiser_name"]) ? $_POST["merchandiser_name"] : null;
    $order_date = isset($_POST["order_date"]) ? $_POST["order_date"] : null;
    $shipment_date = isset($_POST["shipment_date"]) ? $_POST["shipment_date"] : null;

    // Insert data into the temporary table (knit_dyeing_order_temp)
    $sql = "INSERT INTO knit_dyeing_order_temp (knit_dyeing_program_no, style, buyer, merchandiser, program_date, shipment_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $order_number, $style, $buyer, $merchandiser_name, $order_date, $shipment_date);

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
}

// Check if the DataTable form is submitted to add data to order_list and clear knit_dyeing_order_temp
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitDataTable"])) {
    // Insert DataTable data into the order_list table
    $sqlInsert = "INSERT INTO order_list (knit_dyeing_program_no, style, buyer, merchandiser, program_date, shipment_date) SELECT knit_dyeing_program_no, style, buyer, merchandiser, program_date, shipment_date FROM knit_dyeing_order_temp";
    $conn->query($sqlInsert);

    // Clear DataTable data
    $sqlClear = "TRUNCATE TABLE knit_dyeing_order_temp";
    $conn->query($sqlClear);
}

// Check if the DataTable form is submitted to delete a record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteRecord"])) {
    $recordId = $_POST["deleteRecord"];
    $sqlDelete = "DELETE FROM knit_dyeing_order_temp WHERE knit_dyeing_program_no = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("s", $recordId);

    if ($stmt->execute()) {
        // Send a success response
        echo "Record deleted successfully";
    } else {
        // Send an error response
        echo "Error deleting record";
    }

    $stmt->close();
}

// Fetch details for editing a record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editRecord"])) {
    $recordId = $_POST["editRecord"];
    $sqlEdit = "SELECT * FROM knit_dyeing_order_temp WHERE knit_dyeing_program_no = ?";
    $stmt = $conn->prepare($sqlEdit);
    $stmt->bind_param("s", $recordId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2>Order Management</h2>

        <!-- Button to trigger modal for adding a new order -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOrderModal">
            Add Order
        </button>

        <!-- Modal for adding a new order -->
        <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderModalLabel">Add Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for adding an order -->
                        <form id="orderForm" method="post">
                            <div class="form-group">
                                <label for="order_number">Knit Dyeing Order:</label>
                                <input type="text" class="form-control" name="order_number" required>
                            </div>
                            <div class="form-group">
                                <label for="style">Style:</label>
                                <input type="text" class="form-control" name="style" required>
                            </div>
                            <div class="form-group">
                                <label for="buyer">Buyer:</label>
                                <input type="text" class="form-control" name="buyer" required>
                            </div>
                            <div class="form-group">
                                <label for="merchandiser_name">Merchandiser Name:</label>
                                <input type="text" class="form-control" name="merchandiser_name" required>
                            </div>
                            <div class="form-group">
                                <label for="order_date">Program Date:</label>
                                <input type="date" class="form-control" name="order_date" required>
                            </div>
                            <div class="form-group">
                                <label for="shipment_date">Shipment Date:</label>
                                <input type="date" class="form-control" name="shipment_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submitOrder">Save Program</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table to display orders -->
        <table class="table" id="orderTable">
            <thead>
                <tr>
                    <th>Knit Dyeing Order</th>
                    <th>Style</th>
                    <th>Buyer</th>
                    <th>Merchandiser Name</th>
                    <th>Program Date</th>
                    <th>Shipment Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display data from the knit_dyeing_order_temp table
                $sqlSelect = "SELECT * FROM knit_dyeing_order_temp";
                $result = $conn->query($sqlSelect);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["knit_dyeing_program_no"] . "</td>";
                        echo "<td>" . $row["style"] . "</td>";
                        echo "<td>" . $row["buyer"] . "</td>";
                        echo "<td>" . $row["merchandiser"] . "</td>";
                        echo "<td>" . $row["program_date"] . "</td>";
                        echo "<td>" . $row["shipment_date"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-info btn-sm edit-record' data-toggle='modal' data-target='#editOrderModal' data-id='" . $row["knit_dyeing_program_no"] . "'>Edit</button> ";
                        echo "<button class='btn btn-danger btn-sm delete-record' data-id='" . $row["knit_dyeing_program_no"] . "'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal for editing an order -->
        <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing an order -->
                        <form id="editOrderForm">
                            <input type="hidden" name="editRecordId" id="editRecordId">
                            <div class="form-group">
                                <label for="edit_order_number">Knit Dyeing Order:</label>
                                <input type="text" class="form-control" name="edit_order_number" id="edit_order_number" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_style">Style:</label>
                                <input type="text" class="form-control" name="edit_style" id="edit_style" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_buyer">Buyer:</label>
                                <input type="text" class="form-control" name="edit_buyer" id="edit_buyer" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_merchandiser_name">Merchandiser Name:</label>
                                <input type="text" class="form-control" name="edit_merchandiser_name" id="edit_merchandiser_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_order_date">Program Date:</label>
                                <input type="date" class="form-control" name="edit_order_date" id="edit_order_date" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_shipment_date">Shipment Date:</label>
                                <input type="date" class="form-control" name="edit_shipment_date" id="edit_shipment_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button to insert DataTable data into the order_list table -->
        <form action="index.php" method="post">
            <input type="hidden" name="submitDataTable" value="1">
            <button type="submit" class="btn btn-success mt-3">Insert DataTable Data into Order List and Clear DataTable</button>
        </form>

        <!-- Handle click on edit button -->
       <!-- Handle click on edit button -->
<script>
    $(document).ready(function () {
        $('#orderTable').on('click', '.edit-record', function () {
            var orderId = $(this).data('id');

            // Fetch the details of the selected record
            $.ajax({
                type: 'POST',
                url: 'get_order_details.php', // Change this to the correct URL for fetching order details
                data: { orderId: orderId },
                dataType: 'json',
                success: function (data) {
                    // Populate the edit modal with the fetched data
                    $('#editRecordId').val(orderId);
                    $('#edit_order_number').val(data.knit_dyeing_program_no);
                    $('#edit_style').val(data.style);
                    $('#edit_buyer').val(data.buyer);
                    $('#edit_merchandiser_name').val(data.merchandiser);
                    $('#edit_order_date').val(data.program_date);
                    $('#edit_shipment_date').val(data.shipment_date);

                    // Show the edit modal
                    $('#editOrderModal').modal('show');
                },
                error: function () {
                    alert('Error fetching order details.');
                }
            });
        });
    });
</script>


        <!-- Handle submit of the edit form -->
        <script>
            $(document).ready(function () {
                $('#editOrderForm').submit(function (e) {
                    e.preventDefault();

                    // Submit the form using Ajax
                    $.ajax({
                        type: 'POST',
                        url: 'index.php',
                        data: $('#editOrderForm').serialize(),
                        success: function (data) {
                            // Close the edit modal
                            $('#editOrderModal').modal('hide');

                            // Refresh the page or update the DataTable
                            location.reload();
                        },
                        error: function () {
                            alert('Error updating order.');
                        }
                    });
                });
            });
        </script>

        <!-- Handle click on delete button -->
        <script>
            $(document).ready(function () {
                $('#orderTable').on('click', '.delete-record', function () {
                    var orderId = $(this).data('id');

                    // Confirm before deleting
                    var confirmDelete = confirm("Are you sure you want to delete this record?");
                    if (confirmDelete) {
                        // Use orderId to delete the record from the database and remove from the DataTable
                        $.post('index.php', { deleteRecord: orderId }, function (data) {
                            // Refresh the page or update the DataTable
                            location.reload();
                        });
                    }
                });
            });
        </script>
    </div>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function () {
            $('#orderTable').DataTable();
        });
    </script>

</body>

</html>
