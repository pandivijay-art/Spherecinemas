<?php
$conn = mysqli_connect("localhost","root","","newproject");


if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM contact_messages WHERE id='$id'");
}


if(isset($_GET['seen'])){
    $id = $_GET['seen'];
    mysqli_query($conn,"UPDATE contact_messages SET status='seen' WHERE id='$id'");
}

$data = mysqli_query($conn,"SELECT * FROM contact_messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Messages</title>

<style>
body{
font-family:Arial;
background:#0f172a;
color:white;
padding:20px;
}

h2{
text-align:center;
margin-bottom:20px;
}


.search-box{
width:50%;
margin:auto;
display:block;
padding:10px;
border-radius:8px;
border:none;
margin-bottom:20px;
}


table{
width:95%;
margin:auto;
border-collapse:collapse;
background:#1e293b;
border-radius:10px;
overflow:hidden;
}

th,td{
padding:12px;
border-bottom:1px solid #333;
}

th{
background:#020617;
color:#00e5ff;
}

tr:hover{
background:#334155;
}


.new{
background:#064e3b;
}


.btn{
padding:6px 10px;
border:none;
border-radius:6px;
cursor:pointer;
}

.view{
background:#00e5ff;
color:black;
}

.delete{
background:red;
color:white;
}

.seen{
background:green;
color:white;
}


.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.7);
justify-content:center;
align-items:center;
}

.modal-content{
background:#020617;
padding:20px;
border-radius:10px;
width:50%;
}

.close{
float:right;
cursor:pointer;
font-size:20px;
}
</style>

<script>
function viewMessage(msg){
document.getElementById("modal").style.display="flex";
document.getElementById("fullMsg").innerText = msg;
}

function closeModal(){
document.getElementById("modal").style.display="none";
}

function searchTable(){
let input = document.getElementById("search").value.toLowerCase();
let rows = document.querySelectorAll("tbody tr");

rows.forEach(row=>{
let text = row.innerText.toLowerCase();
row.style.display = text.includes(input) ? "" : "none";
});
}
</script>

</head>

<body>

<h2>📩 User Messages</h2>

<input type="text" id="search" class="search-box" placeholder="Search..." onkeyup="searchTable()">

<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
<th>phone</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($data)){ ?>

<tr class="<?php echo ($row['status']=='new') ? 'new' : ''; ?>">

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td>
<?php echo substr($row['message'],0,20); ?>...
<button class="btn view" 
onclick="viewMessage(`<?php echo htmlspecialchars($row['message']); ?>`)">
View
</button>
</td>

<td><?php echo $row['created_at']; ?></td>

<td>
<?php echo $row['status']; ?>
</td>

<td>

<a href="?seen=<?php echo $row['id']; ?>">
<button class="btn seen">Seen</button>
</a>

<a href="?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this message?')">
<button class="btn delete">Delete</button>
</a>

</td>

</tr>

<?php } ?>

</tbody>
</table>

<!-- MODAL -->
<div id="modal" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal()">✖</span>
<h3>Full Message</h3>
<p id="fullMsg"></p>
</div>
</div>

</body>
</html>