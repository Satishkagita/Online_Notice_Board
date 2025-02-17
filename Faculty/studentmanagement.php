<?php
session_start();
include('../connection.php');
include('dept.php');
$q=mysqli_query($connect,"select * from student where dept='$dept'");
$rr=mysqli_num_rows($q);
?>
<?php include 'faculty_index.php';?>
    <div class="content">
    
<link rel="stylesheet" href="faculty.css">

    <?php
if(!$rr){
    echo '<span style="font-size:25px;">No Student Data  available.!</span>';?>
  <div >
    <button style="float:none;" id="add_student">Add Student</button></div>

    <?php
}
else
{
    ?>
 
    
    <div>
    <h2><center>Student Details</center></h2>
    <div ><button id="add_student">Add Student</button></div>
    <button id="showCheckBox">Delete Student</button>
    <button id="back" class="recordCheckbox" style="display:none;">Back</button></div>
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
    <?php include 'studentsearch.html';?>
    <div class="tablewrapper">
            <table class="table table_border">
                <thead>
                <tr class="heading">
                <th><button  id="del_student" class="recordCheckbox" name="delete_student" style="display:none;">Delete</button></th>
                    <th>SNo.</th>
                    <th> Id</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th> MobileNo.</th>
                    <th> Department</th>
                    <th> Year</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php
    if(isset($_POST['search'])){
        $search=$_POST['search'];
        $res=mysqli_query($connect,"select * from student where (id= '$search' or name='$search' or email='$search' or phno='$search'  or year='$search') and  dept='$dept' ");
        $num_rows = mysqli_num_rows($res);
        if($num_rows!=0){
    $i=1;
    while($row=mysqli_fetch_assoc($res)){
    echo "<tr>";
    echo '<td><input type="checkbox" class="recordCheckbox" name="recordsToDelete[]" value="' . $row['id'] . '" style="display:none;"></td>';
     echo "<td>".$i."</td>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['phno']."</td>";
    echo "<td>".$row['dept']."</td>";
    echo "<td>".$row['year']."</td>";
 
        
    echo "<tr>";
    $i++;

    }
}
else{
    echo '<td colspan="10" style="padding-top:50px;font-size:20px;">NO DATA FOUND</td>';
}
    }
    else{
        $i=1;
        while($row=mysqli_fetch_assoc($q)){
            echo "<tr>";
            echo '<td><input type="checkbox" class="recordCheckbox" name="recordsToDelete[]" value="' . $row['id'] . '" style="display:none;"></td>';
            echo "<td>".$i."</td>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['phno']."</td>";
            echo "<td>".$row['dept']."</td>";
            echo "<td>".$row['year']."</td>";
          
           
            echo "<tr>";
            $i++;
    }
}

?>
         </tbody>
    </table>
</div>
   <?php  }?>
   <div id="mymodal" class="modal">
   <div class=modal-content>
    <div class="header">
    <span class="close"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30"
style="fill:#FFFFFF;">
    <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
</svg></span>
    
    <span class="form-heading"><center>Student Registration Form</center></span>
</div>
    <form action="register.php" method="post">
    <div class="user-exists-message" style=" display: none; color: red; font-size:20px;text-align:center ;">User Already Exists!</div>

    <label for="name">Name</label>
        <input type="text" id="name" name="name" required><br>

        <label for="rollno">Roll No</label>
        <input type="text" id="rollno" name="rollno"  required><br>
        <label for="dept">Department</label>
<select id="dept" name="dept" required disabled style="appearance: none;">
    <option value="<?php echo $dept; ?>" selected><?php echo $dept; ?></option>
</select><br>

         
<label for="section">Section</label>
        <select id="section" name="section" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
</select><br>
      <label for="mobileno">Mobile No</label>
        <input type="text" id="phno" name="phno"  required><br>
        <label for="email">Email</label>
      
        <input type="email" id="email" name="email"required><br>
        
        <label for="year">Year</label>
        <select id="year" name="year" required>
            <option value="1">First Year</option>
            <option value="2">Second Year</option>
            <option value="3">Third Year</option>
            <option value="4">Fourth Year</option>
        </select><br>
        <button class="register" value="register" name="register">Register</button>
</form>
</div>
</div>
<script>
    var btn=document.getElementById("add_student");
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
        window.location.href="studentmanagement.php";
    })
</script>
<script>
    document.getElementById("del_student").addEventListener('click',function (){
         
            var selectedRecords = []; // Array to store selected IDs
                var checkboxes = document.querySelectorAll('input[name="recordsToDelete[]"]:checked');
                
                checkboxes.forEach(function (checkbox) {
                    selectedRecords.push(checkbox.value);
                });

                if (selectedRecords.length > 0) {
                    if(confirm("Do you want to delete?"))
          {
                    var uid = selectedRecords.join(",");
                    window.location.href = "delete_student.php?ids=" +encodeURIComponent(uid);
                } 
            }
                else {
                    alert("No records selected for deletion.");
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