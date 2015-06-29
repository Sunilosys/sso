<?php
// make an associative array of senders we know, indexed by phone number
$people = array(
"+14085078019"=>"Sunil",
"+14087506218"=>"Srivats"

);
// if the sender is known, then greet them by name
// otherwise, consider them just another monkey
if(!$name = $people[$_REQUEST['From']]) {
$name = "Local Joe";
}
// now greet the sender
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
<Sms><?php echo $name ?>, Welcome to local Joe!</Sms>
</Response>