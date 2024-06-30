<?php
    $title = "Add Exchange Book";
    include_once 'header.php';
?>
    <?php
        include_once 'sidebar.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function validateISBN() {
            // Get the value of the input field
            var isbnInput = document.getElementById("input1").value.trim();

            // Remove any hyphens or spaces
            var isbn = isbnInput.replace(/[-\s]/g, '');

            // Check if the ISBN is either ISBN-10 or ISBN-13
            if (isbn.length === 10 || isbn.length === 13) {
                // Validate ISBN-10
                if (isbn.length === 10) {
                    if (!isValidISBN10(isbn)) {
                        showErrorAlert("Invalid ISBN-10 number");
                        return false;
                    }
                }
                // Validate ISBN-13
                else if (isbn.length === 13) {
                    if (!isValidISBN13(isbn)) {
                        showErrorAlert("Invalid ISBN-13 number");
                        return false;
                    }
                }
                return true; // ISBN is valid
            } else {
                showErrorAlert("Invalid ISBN number");
                return false;
            }
        }

        // Function to validate ISBN-10
        function isValidISBN10(isbn) {
            var sum = 0;
            for (var i = 0; i < 9; i++) {
                sum += (i + 1) * parseInt(isbn[i]);
            }
            var checksum = isbn[9].toUpperCase();
            if (checksum === 'X') {
                checksum = 10;
            } else {
                checksum = parseInt(checksum);
            }
            sum += 10 * checksum;
            return sum % 11 === 0;
        }

        // Function to validate ISBN-13
        function isValidISBN13(isbn) {
            var sum = 0;
            for (var i = 0; i < 12; i++) {
                sum += (i % 2 === 0) ? parseInt(isbn[i]) : 3 * parseInt(isbn[i]);
            }
            return sum % 10 === 0;
        }

        // Function to show error alert using SweetAlert
        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message
            });
        }
    </script>

    <div class="container">
        <div class="add-content">
            <div class="back-btn-div">
                <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-double-left"></i> Go Back</button>
            </div>
            <form action="<?php echo URLROOT; ?>/customer/AddExchangeBook" enctype="multipart/form-data" class="book-add" method="POST" onsubmit="return validateISBN()">

                <h1>Add a Exchange Book</h1>
                
                <div class="topic-book">
                    <label class="label-topic">Book Name</label><br>
                    <input type="text" name="bookName" class="form-topic" required>
                </div>
                
                <div class="topic-book author">
                    <label class="label-topic">Author of Book</label><br>
                    <input type="text" name="author" class="form-topic" required>
                </div>
                

                <div class="upload-pages book-cate">
                    <div class="topic-book author">
                        <label class="label-topic">Book Category</label><br>
                        <select id="category" name="category" required>
                            <!-- <option value="" selected disabled>Select Book Category</option> -->
                            <?php foreach($data['bookCategoryDetails'] as $bookCategoryDetails): ?>
                                <option><?php echo $bookCategoryDetails->category; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- <input type="text" class="form-topic"> -->
                    </div>
                
                    <div class="topic-book author">
                        <label class="label-topic">Condition</label><br>
                        <select id="category" name="bookCondition" required>
                            <option value="Used">Used</option>
                            <option value="Not Used">Not Used</option>
                            <option value="Good">Good</option>
                            <option value="Acceptable">Acceptable</option>
                            <!-- <option value="health">Classics</option> -->
                            <!-- Add more categories as needed -->
                        </select>
                        <!-- <input type="text" class="form-topic"> -->
                    </div>

                    <div class="topic-book author">
                        <label class="label-topic">Published Year</label><br>
                        <input type="number" id="publishedYear" name="publishedYear" class="form-topic" min="1500" max="<?php echo date('Y'); ?>" required>
                        <span id="publishedYearError" style="color: red; display: none;">Please select a year.</span>
                    </div>

                </div>


                <div class="upload-pages book-cate">
                    <div class="topic-book author weight">
                        <label class="label-topic">Weight (grams)</label><br>
                        <input type="number"   name="weights" class="form-topic" min=0 required>
                    </div>
                    <div class="topic-book author weight2">
                        <a href="#"><button  class="weight-cal" onclick='viewBookOnly()'>Weight Calculator</button></a>
                    </div>
                </div>
        
                <div class="topic-book author">
                    <label class="label-topic" for="input1">ISBN Number</label><br>
                    <input type="text" name="isbnNumber" class="form-topic" id="input1" required>
                </div>
        
                <div class="disc-book">
                    <label class="label-topic">Description</label><br>
                    <textarea id="description" name="description1" rows="12" class="form-topic" required></textarea>
                </div>

                <div class="disc-book book-want">
                    <label class="label-topic">Which Books do you want</label><br>
                    <!-- <textarea id="description" name="description2" rows="12" class="form-topic" required></textarea> -->
                    <div class="bookList">
                        <input type="text" name="input[]" required>
                    </div>
                    <div class="add-remove-btn">
                        <!-- <button type="button" class="RemoveInputButton" onclick="removeInput(this)">Remove</button><br> -->
                        <button type="button" class="AddOneButton" onclick="addInput()">Add One</button>
                    </div>
                </div>
        
                <div class="upload-pages">
                    <div class="img-cont">
                        <label class="label-topic">Upload Front Page</label><br>
                        <input type="file" id="picture" name="imgFront" accept="image/*" required>
                    </div>
        
                    <div class="img-cont">
                        <label class="label-topic">Upload Back Page</label><br>
                        <input type="file" id="picture" name="imgBack" accept="image/*" required>
                    </div>
        
                    <div class="img-cont">
                        <label class="label-topic">Upload a Inside Page</label><br>
                        <input type="file" id="picture" name="imgInside" accept="image/*" required>
                    </div>
                </div>
                <hr>

                <div class="upload-pages book-cate">
                    <div class="topic-book author">
                        <label class="label-topic">Town</label><br>
                        <input type="text"  name="town" class="form-topic" value="<?php echo $data['town']; ?>" required>
                    </div>
    
                    <div class="topic-book author">
                        <label class="label-topic">District</label><br>
                        <select id="category" name="district" required>
                            <!-- <option value="">Select a type</option> -->
                            <option value="Ampara" <?php echo ($data['district'] == 'Ampara') ? 'selected' : ''; ?>>Ampara</option>
                            <option value="Anuradhapura" <?php echo ($data['district'] == 'Anuradhapura') ? 'selected' : ''; ?>>Anuradhapura</option>
                            <option value="Badulla" <?php echo ($data['district'] == 'Badulla') ? 'selected' : ''; ?>>Badulla</option>
                            <option value="Batticaloa" <?php echo ($data['district'] == 'Batticaloa') ? 'selected' : ''; ?>>Batticaloa</option>
                            <option value="Colombo" <?php echo ($data['district'] == 'Colombo') ? 'selected' : ''; ?>>Colombo</option>
                            <option value="Galle" <?php echo ($data['district'] == 'Galle') ? 'selected' : ''; ?>>Galle</option>
                            <option value="Gampaha" <?php echo ($data['district'] == 'Gampaha') ? 'selected' : ''; ?>>Gampaha</option>
                            <option value="Hambantota" <?php echo ($data['district'] == 'Hambantota') ? 'selected' : ''; ?>>Hambantota</option>
                            <option value="Jaffna" <?php echo ($data['district'] == 'Jaffna') ? 'selected' : ''; ?>>Jaffna</option>
                            <option value="Kalutara" <?php echo ($data['district'] == 'Kalutara') ? 'selected' : ''; ?>>Kalutara</option>
                            <option value="Kandy" <?php echo ($data['district'] == 'Kandy') ? 'selected' : ''; ?>>Kandy</option>
                            <option value="Kegalla" <?php echo ($data['district'] == 'Kegalla') ? 'selected' : ''; ?>>Kegalla</option>
                            <option value="Kilinochchi" <?php echo ($data['district'] == 'Kilinochchi') ? 'selected' : ''; ?>>Kilinochchi</option>
                            <option value="Kurunegala" <?php echo ($data['district'] == 'Kurunegala') ? 'selected' : ''; ?>>Kurunegala</option>
                            <option value="Mannar" <?php echo ($data['district'] == 'Mannar') ? 'selected' : ''; ?>>Mannar</option>
                            <option value="Matale" <?php echo ($data['district'] == 'Matale') ? 'selected' : ''; ?>>Matale</option>
                            <option value="Matara" <?php echo ($data['district'] == 'Matara') ? 'selected' : ''; ?>>Matara</option>
                            <option value="Moneragala" <?php echo ($data['district'] == 'Moneragala') ? 'selected' : ''; ?>>Moneragala</option>
                            <option value="Mullaitivu" <?php echo ($data['district'] == 'Mullaitivu') ? 'selected' : ''; ?>>Mullaitivu</option>
                            <option value="Nuwara Eliya" <?php echo ($data['district'] == 'Nuwara Eliya') ? 'selected' : ''; ?>>Nuwara Eliya</option>
                            <option value="Polonnaruwa" <?php echo ($data['district'] == 'Polonnaruwa') ? 'selected' : ''; ?>>Polonnaruwa</option>
                            <option value="Puttalam"  <?php echo ($data['district'] == 'Puttalam') ? 'selected' : ''; ?>>Puttalam</option>
                            <option value="Ratnapura" <?php echo ($data['district'] == 'Ratnapura') ? 'selected' : ''; ?>>Ratnapura</option>
                            <option value="Trincomalee" <?php echo ($data['district'] == 'Trincomalee') ? 'selected' : ''; ?>>Trincomalee</option>
                            <option value="Vavuniya" <?php echo ($data['district'] == 'Vavuniya') ? 'selected' : ''; ?>>Vavuniya</option>
                            <!-- <option value="Colombo">Health</option> -->
                            <!-- Add more categories as needed -->
                        </select>
                    </div>

                    <div class="topic-book author">
                        <label class="label-topic">Postal Code</label><br>
                        <input type="text" id="postalCode" name="postalCode" class="form-topic" value="<?php echo $data['postal_code']; ?>" maxlength="5" required>
                        <span class="error" id="postalCodeError" style="color: red;"></span>
                    </div>
                </div>

                <input type="submit" value="Submit">
            </form>
        </div>

        <div id="myModal" class="modal0">
            <div class="modal-content0">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Weight Calculator</h2>
                <div class="form1" id="bookDetailsTable">
                    <!-- Event details will go here -->
                </div>
            </div>
        </div>

        <div id="myModal1" class="modal">
            <div class="modal-content">
                <!-- <span class="close" onclick="closeModal()">&times;</span> -->
                <h2>Record Added!</h2>
                <p>Your record has been recorded. Wait for admin approval</p>
                <button onclick="closeModal1()">OK</button>
            </div>
        </div>

        <script>
            function showModal() {
                var modal = document.getElementById("myModal1");
                modal.style.display = "block";
            }

            function closeModal1() {
                var modal = document.getElementById("myModal1");
                modal.style.display = "none";
                window.location.href = "<?php echo URLROOT; ?>/customer/ExchangeBooks"; // Redirect to the event page
            }

            <?php
            // Check if the showModal flag is set, then call showModal()
            if (isset($_SESSION['showModal']) && $_SESSION['showModal']) {
                echo "window.onload = showModal;";
                // Unset the session variable after use
                unset($_SESSION['showModal']);
            }
            ?>

            // Submit form function
            // function submitForm() {
            //     document.getElementById("eventForm").submit();
            // }
        </script>

        <?php
            // include_once 'footer.php';
            require APPROOT . '/views/customer/footer.php';
        ?>
    </div>

    <script>
        // JavaScript code for validating published year
        document.getElementById("publishedYear").addEventListener("input", function() {
            var year = this.value;
            // Validate if the year is within the allowed range
            var minYear = 1500; // Adjusted to 1800 based on typical use cases
            var maxYear = new Date().getFullYear(); // Get the current year
            if (year < minYear || year > maxYear) {
                document.getElementById("publishedYearError").style.display = "block";
            } else {
                document.getElementById("publishedYearError").style.display = "none";
            }
        });
    </script>

    <script>
        function viewBook() {
            var modal = document.getElementById("myModal");
            var bookDetailsTable = document.getElementById("bookDetailsTable");

            var detailsHTML = `
                <form id="bookWeightCalculator">
                    <input type="number" id="width" name="width" placeholder="Page Width (cm):"required><br>
                    <input type="number" id="height" name="height" placeholder="Page Height (cm):"required><br>
                    <input type="number" id="pages" name="pages" placeholder="Number of Pages:"required><br>
                    <div class="tooltip">
                        <input type="number" id="paperWeight" name="paperWeight" placeholder="Paper Weight (GSM):" required>
                        <span class="tip-icon" onclick="toggleTooltip('paperWeight')">!</span>
                        <div class="tooltiptext" id="paperWeightTip">
                            90 -120 GSM paper: The average weight of regular office paper or copy paper<br>30 - 250 GSM paper: The weight most commonly used for promotional posters
                            <br>
                        </div>
                    </div>
                    <br>
                    <div class="tooltip">
                        <input type="number" id="coverWeight" name="coverWeight" placeholder="Cover Weight (GSM, if applicable):">
                        <span class="tip-icon" onclick="toggleTooltip('coverWeight')">!</span>
                        <div class="tooltiptext" id="coverWeightTip">
                            Standard values: 200-300 GSM for covers
                        </div>
                    </div>
                    <br>
                    <button class="submit" type="button" onclick="calculateWeight()">Calculate Weight</button>
                </form>
                <div id="result">
                    
                </div>
            `;

            bookDetailsTable.innerHTML = detailsHTML;
            modal.style.display = "block";
        }

        function viewBookOnly() {
            // Display only the book details table
            viewBook();
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>


    <script>
        function calculateWeight() {
            // Get values from the form
            var width = parseFloat(document.getElementById("width").value);
            var height = parseFloat(document.getElementById("height").value);
            var pages = parseInt(document.getElementById("pages").value);
            var paperWeight = parseFloat(document.getElementById("paperWeight").value);
            var coverWeight = parseFloat(document.getElementById("coverWeight").value) || 0;

            if (width <= 0 || height <= 0 || pages <= 0 || paperWeight <= 0) {
                document.getElementById("result").innerHTML = "All input values must be positive.";
                return; // Exit the function if any value is not positive
            }

            // Calculate area of one page
            var areaPerPage = width * height;

            // Calculate total weight
            var totalWeight = areaPerPage * pages * paperWeight / 10000 + coverWeight;

            // Display the result
            document.getElementById("result").innerHTML = "Estimated Weight: " +"<br>"+ totalWeight.toFixed(2) + " grams";
        }
    </script>

<script>
        function goBack() {
            // Use the browser's built-in history object to go back
            window.history.back();
        }
        function toggleTooltip(inputId) {
            var tooltip = document.getElementById(inputId + 'Tip');
            tooltip.classList.toggle('active');
        }
</script>

<script>
    function addInput() {
        var bookList = document.querySelector('.bookList');
        var newInput = document.createElement('div');
        newInput.innerHTML = `
            <input type="text" name="input[]" required>
            <button type="button" class="RemoveInputButton" onclick="removeInput(this)">Remove</button><br>
        `;
        bookList.appendChild(newInput);
    }

    function removeInput(button) {
        var inputDiv = button.parentElement;
        inputDiv.remove();
    }
</script>


<script>
    document.getElementById('postalCode').addEventListener('input', function(event) {
        var postalCode = event.target.value;
        var postalCodeError = document.getElementById('postalCodeError');

        // Check if postal code is exactly 5 digits long
        if (postalCode.length !== 5 || isNaN(postalCode)) {
            postalCodeError.textContent = 'Postal code must be a 5-digit number.';
            event.target.setCustomValidity('Invalid postal code');
        } else {
            postalCodeError.textContent = '';
            event.target.setCustomValidity('');
        }
    });
</script>