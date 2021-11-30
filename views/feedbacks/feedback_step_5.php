<!DOCTYPE html>
<html>
<title>GarageWorks - Feedback</title>	
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/feedback/feedback.css">
<link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
 
<body>
<form id="regForm" action="finish_feedback">
<h1><img src="<?= base_url() ?>logo.png"></h1>
  <input type="hidden" value="<?php echo $feedback_id; ?>" name="feedback_id">
  <div class="tab"  >
        <fieldset>      
                <legend>Did the mechanic take a test ride ?</legend>    
                <table id="table">
                <tr>
                      <td> 
                          <label class="radio radio-gradient">
                            <span class="radio__input">
                              <input type="radio" name="test_ride" value="yes">
                              <span class="radio__control"></span>
                            </span>
                            <span class="radio__label">Yes</span>
                          </label>
                        </td>
                
                        <td>
                            <label class="radio radio-before">
                                <span class="radio__input">
                                    <input type="radio" name="test_ride" value="no">
                                    <span class="radio__control"></span>
                                </span>
                                <span class="radio__label">No</span>
                            </label>
                        </td>
                    </tr>
                
                </table>
            </fieldset>  
            <br>
            <fieldset >      
                <legend>Were you informed about the work to be done before it started ?</legend>     
				 <table id="table">
                <tr>
                      <td> 
						  
						  <label class="radio radio-before">
                                <span class="radio__input">
                                    <input type="radio" name="workinformed" value="No">
                                    <span class="radio__control"></span>
                                </span>
                                <span class="radio__label">No</span>
						  </label>
					</td>
					<td> 
				<label class="radio radio-before">
                                <span class="radio__input">
                                    <input type="radio" name="workinformed" value="Yes">
                                    <span class="radio__control"></span>
                                </span>
                                <span class="radio__label">Yes</span>
                </label>
						</td>
                    </tr>
                   
                </table>
            </fieldset>  
            <fieldset >      
                <legend>Was there a change in the final billing after you approved the job card ?</legend>    
                <table id="table">
                <tr>
                      <td> 
                          <label class="radio radio-gradient">
                            <span class="radio__input">
                              <input type="radio" name="billing_change" value="yes">
                              <span class="radio__control"></span>
                            </span>
                            <span class="radio__label">Yes</span>
                          </label>
                        </td>
                
                        <td>
                            <label class="radio radio-before">
                                <span class="radio__input">
                                    <input type="radio" name="billing_change" value="no">
                                    <span class="radio__control"></span>
                                </span>
                                <span class="radio__label">No</span>
                            </label>
                        </td>
                    </tr>
                   
                </table>
            </fieldset> 
            <br>
            <fieldset >      
                <legend>What do you think about GarageWorks doorstep experience ?</legend> 
                <div class="pretty p-icon p-pulse "  >
                <input type="checkbox" name="experience[]" value="Product Mis-selling">
                <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label style="font-size: 20px;" >Product Mis-selling</label>
                  </div>
                </div>
                <br>   
                <div class="pretty p-icon p-pulse "  >
                <input type="checkbox" name="experience[]" value="Booking Experience">
                <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label style="font-size: 20px;"> Booking Experience</label>
                  </div>
                </div>
                <br>   
                <div class="pretty p-icon p-pulse "  >
                <input type="checkbox" name="experience[]" value="Mechanic was rude">
                <div class="state p-success">
                      <i class="icon mdi mdi-check"></i>
                      <label style="font-size: 20px;" >Mechanic was rude</label>
                  </div>
                </div>
          
            </fieldset>   
  </div>
  <div style="overflow:auto;">
    <div style="margin: auto; text-align: center;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;display: none;">
    <span class="step"></span>
    
  </div>
</form>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = true;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>

</body>
</html>
