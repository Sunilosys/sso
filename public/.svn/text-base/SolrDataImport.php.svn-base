<html>
<head>
<script language="JavaScript" type="text/javascript" src='/jquery.min.js'></script>
<script type="text/javascript">
function alertMsg()
{
//alert("Hello");
$.ajax({
	type: "GET",
	url: "http://localjoe.com:8080/solr/dataimport?command=delta-import",
	success: function(data){                      
      $("#outputSection").html();
	  $('<div id="sectionHtml"></div>').appendTo('#outputSection')
                    $("#sectionHtml").replaceWith(data);
	}
}); 

}
</script>
</head>
<body onload="setInterval ( 'alertMsg()', 60000 );">
<div id="outputSection">Delta load of Solr</div>
</body>
</html>


