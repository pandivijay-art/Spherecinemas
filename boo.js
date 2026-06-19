function pay(){

let total=document.getElementById("total").innerText;
let time=document.getElementById("showTime").value;

if(time==""){
alert("Please select show time");
return;
}

if(total==0){
alert("Select seats first");
return;
}

alert("Show Time : "+time+" | Total ₹"+total);

}