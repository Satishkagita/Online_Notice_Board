<?php
session_start();
include('../connection.php');
$username = $_SESSION['username'];
$q=mysqli_query($connect,"select * from admin where name='$username'");
$rr=mysqli_num_rows($q);
?>
<?php include 'admin_index.php';?>
    <div class="content">
    
<link rel="stylesheet" href="faculty.css">

    
 
    
    <div>
    <h2 class="font">Profile</h2>
    <?php
    $i=1;
    while($row=mysqli_fetch_assoc($q)){
        echo '<div class="card">';
        
       echo '<form>';
       echo '<label>Name:</label>';
       echo $row['name'];
       echo '</form>';
       echo '<form>';
       echo '<label>Id:</label>';
        echo $id=$row['id'];
        echo '</form>';
        echo '<form>';
       echo '<label>Email:</label>';
        echo $row['email'];
        echo '</form>';
        echo '<form>';
       echo '<label>Phone No:</label>';
        echo $row['phno'];
        echo '</form>';
        echo '<form>';
       echo '<label>Post:</label>';
        echo $row['post'];
        echo '</form>';
       
         echo '<form action="update.php" method="post">';
         echo "<input style='display:none';  name='update' value='{$row['id']}' >";
         echo '<button class="update" type="submit" >Update</button>';
         echo '</form>';
         echo '</div>';
        $i++;
      

        

    }?>

   <?php  ?>
   
</div>
<script>
    var btn=document.getElementById("add_faculty");
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
        window.location.href="facultymanagement.php";
    })
</script>
<script>
    document.getElementById("del_faculty").addEventListener('click',function (){
         
            var selectedRecords = []; // Array to store selected IDs
                var checkboxes = document.querySelectorAll('input[name="recordsToDelete[]"]:checked');
                
                checkboxes.forEach(function (checkbox) {
                    selectedRecords.push(checkbox.value);
                });

                if (selectedRecords.length > 0) {
                    if(confirm("Do you want to delete?"))
          {
                    var uid = selectedRecords.join(",");
                    window.location.href = "delete_faculty.php?ids=" +encodeURIComponent(uid);
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