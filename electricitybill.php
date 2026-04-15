<?php
if ($_SERVER["REQUEST_METHOD"]=="POST"){
$cno=$_POST["cno"];
$cname=$_POST["cname"];
$pread=$_POST["pread"];
$cread=$_POST["cread"];

echo ("Customer number:".$cno);
echo ("<br>Customer name:".$cname);
echo ("<br>Previous reading:".$pread);
echo ("<br>Current reading:".$cread);

$units=$cread-$pread;
$amount=0;

if($units <= 200)
{
    $amount=$units*1;
}
else if($units <= 300){
    $amount=(200*1)+(($units-200)*1.25);
}
else if($units <= 400){
    $amount=(200*1)+(100*1.25)+($units-300)*1.5;
}
else if ($units <= 500){
    $amount=(200*1)+(100*1.25)+(100*1.5)+($units-400)*1.75;
}
else {
    $amount=(200*1)+(100*1.25)+(100*1.5)+(100*1.75)+($units-500)*2;
}


echo ("<br> Units :".$units);
echo ("<br> Amount :".$amount);

$subcharge=$amount*0.1;

$total=$amount+$subcharge;

echo ("<br>Subcharge :".$subcharge);
echo ("<br>Total Amount :".$total);
}else{
    echo ("please use post method to call this api");
}
?>