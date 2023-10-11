<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Knit Dyeing Program</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
        }

        .fabric-row {
            margin-top: 10px;
        }

        .grid-buttons {
            margin-top: 10px;
        }

        .yarn-summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Knit Dyeing Program</h2>

    <!-- Tab System -->
    <ul class="nav nav-tabs" id="myTabs">
        <!-- Section 1: Order Detail -->
        <li class="nav-item">
            <a class="nav-link active" id="section1-tab" data-toggle="tab" href="#section1">Order Detail</a>
        </li>
        <!-- Section 2: Fabric Detail -->
        <li class="nav-item">
            <a class="nav-link" id="section2-tab" data-toggle="tab" href="#section2">Fabric Detail</a>
        </li>
        <!-- Section 3: Yarn Data -->
        <li class="nav-item">
            <a class="nav-link" id="section3-tab" data-toggle="tab" href="#section3">Yarn Data</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Section 1: Order Detail -->
        <div id="section1" class="tab-pane fade show active">
            <h3>Section 1: Order Detail</h3>
            <!-- Your order detail form goes here -->
            <label for="kdpNo">Knit Dyeing Program No:</label>
            <input type="text" id="kdpNoInput" class="form-control">

            <label for="style">Style:</label>
            <input type="text" id="styleInput" class="form-control">

            <label for="buyer">Buyer Name:</label>
            <input type="text" id="buyerInput" class="form-control">

            <label for="merchandiser">Merchandiser Name:</label>
            <input type="text" id="merchandiserInput" class="form-control">

            <label for="programDate">Program Date:</label>
            <input type="date" id="programDateInput" class="form-control">

            <label for="shipmentDate">Shipment Date:</label>
            <input type="date" id="shipmentDateInput" class="form-control">
            <button class="btn btn-primary mt-3" onclick="goToNextTab('#section2-tab')">Next</button>
            <button class="btn btn-primary mt-3" >Submit</button>
        </div>

        <!-- Section 2: Fabric Detail -->
        <div id="section2" class="tab-pane fade">
            <h3>Section 2: Fabric Detail</h3>
            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#fabricModal">Add Fabric Detail</button>
            <!-- Fabric Data Grid -->
            <div id="fabricGrid" class="fabric-row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Fabric No</th>
                        <th>Fabric Composition</th>
                        <th>Fabric Type</th>
                        <th>Required Fabric</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Dynamic fabric data rows will be added here -->
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary mt-3" onclick="goToNextTab('#section3-tab')">Next</button>
            <button class="btn btn-primary mt-3" onclick="goToNextTab('#section1-tab')">Previous</button>

        </div>

        <!-- Section 3: Yarn Data -->
        <div id="section3" class="tab-pane fade">
            <h3>Section 3: Yarn Data</h3>
            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#yarnModal">Add Yarn Data</button>
            <!-- Yarn Data Grid -->
            <div id="yarnGrid" class="fabric-row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Yarn Name</th>
                        <th>Yarn Quantity</th>
                        <th>Fabric No</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Dynamic yarn data rows will be added here -->
                    </tbody>
                </table>
            </div>
            
            <!-- Yarn Summary -->
            <div class="yarn-summary">
                <h4>Yarn Name-wise Summation</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Yarn Name</th>
                        <th>Total Quantity</th>
                    </tr>
                    </thead>
                    <tbody id="yarnSummaryTableBody">
                    <!-- Dynamic yarn name-wise summation will be added here -->
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary mt-3" onclick="goToNextTab('#section1-tab')">Home</button>
    <button class="btn btn-primary mt-3" onclick="goToNextTab('#section2-tab')">Previous</button>
        </div>
        
    </div>


</div>

<!-- Fabric Modal -->
<div class="modal" id="fabricModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- ... (Modal header remains unchanged) ... -->
            <div class="modal-header">
                <h4 class="modal-title">Add Fabric</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <label for="kdpNo">Fabric No:</label>
                <input type="text" id="fabricNo" class="form-control">

                <label for="style">Fabric Composition:</label>
                <input type="text" id="fabricComposition" class="form-control">

                <label for="buyer">Fabric Type:</label>
                <input type="text" id="fabricType" class="form-control">

                <label for="requiredFabric">Required Fabric:</label>
                <input type="text" id="requiredFabric" class="form-control">

                <label for="programDate">Price:</label>
                <input type="number" id="price" class="form-control">
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addFabricToGrid()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Yarn Modal -->
<div class="modal" id="yarnModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- ... (Modal header remains unchanged) ... -->
            <div class="modal-header">
                <h4 class="modal-title">Add Yarn Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <label for="fabricNoForYarn">Select Fabric No:</label>
                <select id="fabricNoForYarn" class="form-control"></select>

                <label for="yarnName">Yarn Name:</label>
                <input type="text" id="yarnName" class="form-control">

                <label for="yarnQuantity">Yarn Quantity:</label>
                <input type="text" id="yarnQuantity" class="form-control">
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addYarnToGrid()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Add your JavaScript functions for handling modals, adding data to grids, etc.
    // Function to initialize the fabric count
    var fabricCount = 1;

    // Function to initialize the yarn count
    var yarnCount = 1;

    // Function to add fabric data to the grid
    function addFabricToGrid() {
        var fabricNo = $("#fabricNo").val();
        var fabricComposition = $("#fabricComposition").val();
        var fabricType = $("#fabricType").val();
        var requiredFabric = $("#requiredFabric").val();
        var price = $("#price").val();

        var newRow = "<tr>" +
            "<td>" + fabricNo + "</td>" +
            "<td>" + fabricComposition + "</td>" +
            "<td>" + fabricType + "</td>" +
            "<td>" + requiredFabric + "</td>" +
            "<td>" + price + "</td>" +
            "<td>" +
            "<button class='btn btn-warning btn-sm' onclick='editFabric(this)'>Edit</button>" +
            "<button class='btn btn-danger btn-sm' onclick='deleteFabric(this)'>Delete</button>" +
            "</td>" +
            "</tr>";

        $("#fabricGrid tbody").append(newRow);

        // Clear modal fields
        $("#fabricNo, #fabricComposition, #fabricType, #requiredFabric, #price").val("");

        // Close the modal
        $("#fabricModal").modal("hide");

        // Add the fabricNo to the dropdown in the yarn modal
        $("#fabricNoForYarn").append("<option value='" + fabricNo + "'>" + fabricNo + "</option>");
    }

    // Function to edit fabric data in the grid
    function editFabric(button) {
        var row = $(button).closest("tr");
        var fabricNo = row.find("td:eq(0)").text();
        var fabricComposition = row.find("td:eq(1)").text();
        var fabricType = row.find("td:eq(2)").text();
        var requiredFabric = row.find("td:eq(3)").text();
        var price = row.find("td:eq(4)").text();

        // Set modal fields with existing data
        $("#fabricNo").val(fabricNo);
        $("#fabricComposition").val(fabricComposition);
        $("#fabricType").val(fabricType);
        $("#requiredFabric").val(requiredFabric);
        $("#price").val(price);

        // Open the modal for editing
        $("#fabricModal").modal("show");

        // Remove the row from the grid
        row.remove();

        // Remove the fabricNo from the dropdown in the yarn modal
        $("#fabricNoForYarn option[value='" + fabricNo + "']").remove();
    }

    // Function to delete fabric data from the grid
    function deleteFabric(button) {
        var row = $(button).closest("tr");
        var fabricNo = row.find("td:eq(0)").text();

        // Remove the row from the grid
        row.remove();

        // Remove the fabricNo from the dropdown in the yarn modal
        $("#fabricNoForYarn option[value='" + fabricNo + "']").remove();
    }

    // Function to add yarn data to the grid
    function addYarnToGrid() {
        var fabricNo = $("#fabricNoForYarn").val();
        var yarnName = $("#yarnName").val();
        var yarnQuantity = $("#yarnQuantity").val();

        var newRow = "<tr>" +
            "<td>" + yarnName + "</td>" +
            "<td>" + yarnQuantity + "</td>" +
            "<td>" + fabricNo + "</td>" +
            "<td>" +
            "<button class='btn btn-warning btn-sm' onclick='editYarn(this)'>Edit</button>" +
            "<button class='btn btn-danger btn-sm' onclick='deleteYarn(this)'>Delete</button>" +
            "</td>" +
            "</tr>";

        $("#yarnGrid tbody").append(newRow);

        // Clear modal fields
        $("#yarnName, #yarnQuantity").val("");

        // Close the modal
        $("#yarnModal").modal("hide");

        // Update the yarn summary
        updateYarnSummary();
    }

    // Function to edit yarn data in the grid
    function editYarn(button) {
        var row = $(button).closest("tr");
        var yarnName = row.find("td:eq(0)").text();
        var yarnQuantity = row.find("td:eq(1)").text();
        var fabricNo = row.find("td:eq(2)").text();

        // Set modal fields with existing data
        $("#yarnName").val(yarnName);
        $("#yarnQuantity").val(yarnQuantity);
        $("#fabricNoForYarn").val(fabricNo);

        // Open the modal for editing
        $("#yarnModal").modal("show");

        // Remove the row from the grid
        row.remove();

        // Update the yarn summary
        updateYarnSummary();
    }

    // Function to delete yarn data from the grid
    function deleteYarn(button) {
        var row = $(button).closest("tr");
        row.remove();

        // Update the yarn summary
        updateYarnSummary();
    }

    // Function to update the yarn summary
    function updateYarnSummary() {
        // Clear the existing summary
        $("#yarnSummaryTableBody").empty();

        // Get unique yarn names
        var uniqueYarns = [...new Set($("#yarnGrid tbody td:first-child").map(function () {
            return $(this).text();
        }).get())];

        // Calculate total quantity for each yarn name
        uniqueYarns.forEach(function (yarnName) {
            var totalQuantity = 0;
            $("#yarnGrid tbody tr").each(function () {
                if ($(this).find("td:first-child").text() === yarnName) {
                    totalQuantity += parseFloat($(this).find("td:nth-child(2)").text());
                }
            });

            // Add a row to the summary table
            $("#yarnSummaryTableBody").append("<tr><td>" + yarnName + "</td><td>" + totalQuantity + "</td></tr>");
        });
    }

    // Function to go the next tab fabric data
    function goToNextTab(tabId) {
        $(tabId).tab('show');
    }
</script>

</body>
</html>
