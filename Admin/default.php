<?php
session_start();
include('../connection.php');

$q=mysqli_query($connect,"select * from notice ORDER BY id DESC ;");
$rr=mysqli_num_rows($q);

$q2=mysqli_query($connect,"select * from notice ORDER BY ID DESC LIMIT 1;");

?>
    <div class="content">
    
<link rel="stylesheet" href="faculty.css">

    <?php
if(!$rr){
    echo '<span style="font-size:25px;">Notice is not available.!</span>';?>
  <div >
    <button style="float:none;" id="add_notice"><center>Add Notice</center></button></div>

    <?php
}
else
{
    ?>
 
    
    <div>
    <div ><button id="add_notice">Add Notice</button></div>
    <button id="showCheckBox">Delete Notice</button>
    <button id="back" class="recordCheckbox" style="display:none;">Back</button></div>
    <div class="delete">
    <button  id="del_notice" class="recordCheckbox" name="del_notice" style="display:none;" >Delete</button></div>
    <?php
    if(isset($_SESSION['status']))
    {  if($_SESSION['status']=="Data Not Deleted!"){
         echo '<span style="color:red;font-size:25px">'.$_SESSION['status'].'</span>';
    }
    else{
        echo '<span style="color:green;font-size:25px">'.$_SESSION['status'].'</span>';
    }
        unset($_SESSION['status']);
    }?>
    
    
    
    
   
    <?php
    $i=1;
    while($row=mysqli_fetch_assoc($q)){
        
        echo '<div class="card">';
        echo '<div class="chechbox">';
        echo '<td><input type="checkbox" class="recordCheckbox" name="recordsToDelete[]" value="' . $row['id'] . '" style="display:none;"></td>';
        echo '</div>';
        echo '<div class="inner_header">';
        echo $row['postedby'];
        echo '</div>';
        echo '<div class="under">';
        $dateString = $row['date']; // Replace this with your actual date string
        $dateTime = new DateTime($dateString);
        echo $dateTime->format('d M Y H:i');
        echo '</div>';

        echo $row['description'];
       
            //echo '<form method="get" action="$rows=$file->fetch_assoc()">';
            if ($row['file']) {
                echo '<form action="download.php" method="get">';
                echo "<input value='{$row['file']}' name='file' style='display:none'>";
                echo '<button type="submit">Download PDF</button>';
                echo '</form>';
            }
            

        
        
        echo '</div>';
        
       

        $i++;


    }?>
    
    
</div>

   <?php  }?>
   <div id="mymodal" class="modal">
   <div class="modal-content">
    <div class="header">
    <span class="close"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30"
style="fill:#FFFFFF;">
    <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
</svg></span>
    
    <span class="form-heading"><center>Add Notice Here</center></span>
</div>
    <form action="add_notice.php" method="post" enctype="multipart/form-data">
        

        <?php
         $i=1;
         $value=99;
         while($row=mysqli_fetch_assoc($q2)){
           
            $value=$row['id'];
             $i++;
     
         }
         $value=$value+1;
         echo '<input type="text" id="id" name="id" value="'. $value .' " style=" display:none"><br> ';
         ?>
        
        <label for="dept">SendTo</label>
        <select id="dept" name="sendto" required>
            <option value="All">All</option>
            <option value="HOD">HOD</option>
            <option value="Faculty">Faculty</option>
            <option value="Student">Student</option>
            
</select><br>
        <label for="year" id="yearLabel" style="display: none;">Year</label>
        <select id="year" name="year" style="display: none;">
            <option value="All">All</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
</select><br>

      <label for="textAreaField">Description</label> 
        <textarea name="description" id="textAreaField" rows="4"  cols="50" max="30" required ></textarea><br>
        <label for="file">Add File</label>

        <input type="file" name="file"><br>
         <!-- <label for="date">Date</label>
         <input type="date" id="date" name="date" ><br> -->
         <label for="postedby">PostedBy</label>
        <input type="text" id="postedby" name="postedby"  required><br>
  <button class="submit" value="submit" name="submit">Send Notice</button>
</form>
</div>
</div>
<script>
    var btn=document.getElementById("add_notice");
    var modal=document.getElementById("mymodal");
    var span=document.getElementsByClassName("close")[0];
    btn.onclick=function(){
        modal.style.display="block";
    }
    span.onclick=function(){
        modal.style.display="none";
    }
    
</script>
<script>
    document.getElementById("showCheckBox").addEventListener('click',function(){
        var checkboxes=document.querySelectorAll('.recordCheckbox');
        checkboxes.forEach(function(checkbox){
            checkbox.style.display='inline';
        });
        this.style.display='none';
    });
    document.getElementById("back").addEventListener('click',function(){
        window.location.href="notice.php";
    })
</script>
<script>
    document.getElementById("del_notice").addEventListener('click',function (){
         
            var selectedRecords = []; // Array to store selected IDs
                var checkboxes = document.querySelectorAll('input[name="recordsToDelete[]"]:checked');
                
                checkboxes.forEach(function (checkbox) {
                    selectedRecords.push(checkbox.value);
                });

                if (selectedRecords.length > 0) {
                    if(confirm("Do you want to delete?"))
          {
                    var uid = selectedRecords.join(",");
                    window.location.href = "delete_notice.php?ids=" +encodeURIComponent(uid);
                } 
            }
                else {
                    alert("No records selected for deletion.");
                }
          
    });
    </script>
    <script>
    // Get references to the select elements
    var sendToSelect = document.getElementById("dept");
    var yearSelect = document.getElementById("year");
    var yearLabel = document.getElementById("yearLabel");

    // Add an event listener to the "SendTo" select element
    sendToSelect.addEventListener("change", function () {
        // Check the selected value
        if (sendToSelect.value === "Student") {
            // If "Student" is selected, show the "Year" select element and label
            yearSelect.style.display = "block";
            yearLabel.style.display = "block";
        } else {
            // If any other option is selected, hide the "Year" select element and label
            yearSelect.style.display = "none";
            yearLabel.style.display = "none";
        }
    });
</script>




   


<script>
// Check if the "message" parameter is set in the URL
const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');
var modal=document.getElementById("mymodal");
const userExistsMessage = document.querySelector('.user-exists-message');
// If the message is "userexists", show the message in the modal

if (message&&userExistsMessage) {
    
        userExistsMessage.textContent=message;
        
        modal.style.display="block";
        userExistsMessage.style.display = 'block';
    }

    document.getElementsByClassName("close")[0].onclick=function(){
        
        modal.style.display="none";
        userExistsMessage.style.display = "none";
    
}
</script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script>
            const navigationLinks = document.querySelectorAll('.nav-area a');
        
            navigationLinks.forEach(link => {
            link.addEventListener('click', () => {
            navigationLinks.forEach(item => item.classList.remove('active'));
            link.classList.add('active');
          });
        });
    </script>
</body>
</html>