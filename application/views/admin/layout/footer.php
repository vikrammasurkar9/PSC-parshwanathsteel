</div>
<div class="sidebar-overlay" data-reff=""></div>


<script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>


function bindcities()
    {
        let state = document.getElementById('state');
        
        $.ajax({
            url : "<?php echo base_url('admin/getcities');?>",
            method : "POST",
            data : {state: state.value},
            async : true,
            dataType : 'json',
            success: function(data){                        
                var html = '<option value="">Select City</option>';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option  value='+data[i].city+'>'+data[i].city+'</option>';
                }
                document.getElementById("city").innerHTML = html;                
            }
        });
    }

    function show()
	{

        let profession = document.getElementById("type").value;
        let state = document.getElementById("states").value;
        let city = document.getElementById("cities").value;

        
        let parameter = "";
        if(profession == 0)
        {
            parameter = "";
        }
        else{
            parameter = "?profession="+profession;
        }
        if(state !=0)
        parameter += (parameter == "" ? "?state=" + state : "&state=" + state);
        
        if(city !=0)
        parameter += (parameter == "" ? "?city=" + city : "&city=" + city);	
               
		
		window.location.replace("<?php echo base_url('admin/contacts/0'); ?>" + parameter);
	}



function mySearch() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        var show = false;
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                show = true;
                break;
            }
        }
        if (show)
            tr[i].style.display = "";
        else
            tr[i].style.display = "none";
    }
}

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            var show = false;
            for (j = 0; j < td.length; j++) {    
                if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    show = true;
                    break;
                }
            }
            if(show)
                tr[i].style.display = "";
            else
                tr[i].style.display = "none";
        }
    }

 var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    //window.location.href = uri + base64(format(template, ctx))

    if (navigator.msSaveBlob) {
        var blob = new Blob([format(template, ctx)], { type: 'application/vnd.ms-excel', endings: 'native' });
        navigator.msSaveBlob(blob, 'export.xlsx')
    } else {
        window.location.href = uri + base64(format(template, ctx))
    }
  }
})()


// var tableToExcel = (function () {
// var uri = 'data:application/vnd.ms-excel;base64,'
// , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table cellspacing="0" rules="rows" border="1" style="color:Black;background-color:White;border-color:#CCCCCC;border-width:1px;border-style:None;width:100%;border-collapse:collapse;font-size:9pt;text-align:center;">{table}</table></body></html>'
// , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
// , format = function (s, c) { return s.replace(/{(w+)}/g, function (m, p) { return c[p]; }) }
// return function (table, name) {
//     if (!table.nodeType) table = document.getElementById(table)
//     var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
//     if (navigator.msSaveBlob) {
//         var blob = new Blob([format(template, ctx)], { type: 'application/vnd.ms-excel', endings: 'native' });
//         navigator.msSaveBlob(blob, 'export.xlsx')
//     } else {
//         window.location.href = uri + base64(format(template, ctx))
//     }
// }
// })()



</script>

<script>
        function confirmSubmit()
{
var agree=confirm("Send to customer?");
if (agree)
{
    document.getElementById('send').value = "Yes";
    return true ;
}
else
return true ;
 }


//  function hidemainbox()
//  {
//     let firmid = document.getElementById("firmid").value;
//     console.log(firmid);
//     if(firmid == 0)
//     {
//         document.getElementById("mainbox").style.display="none";
//     }
//  }
//  function firmChange()
//  {
//     let firmid = document.getElementById("firmid").value;
    
//     if(firmid == 0)
//     {
//         document.getElementById("mainbox").style.display="none";
//     }
//     else if(firmid == 1)
//     {
//         document.getElementById("mainbox").style.display="block";
//         document.getElementById("header").style.backgroundColor ="#F89504";
//     }
//     else if(firmid == 3)
//     {
//         document.getElementById("mainbox").style.display="block";
//         document.getElementById("header").style.backgroundColor ="#8C252C";
//     }
//     else
//     {
//         document.getElementById("mainbox").style.display="block";
//         document.getElementById("header").style.backgroundColor ="#F89504";
        
//     }
//  }

 function SetCookieForFirm(name, firm, firmid, firmcolor)
 {
    document.cookie = name + "=" + firm;
    document.cookie = "firmid=" + firmid;
    document.cookie = "firmcolor=" + firmcolor;

    // if(firmid == 1)
    // {
        
    //     document.cookie = "firmcolor=#F89504";
    // }
    // else if(firmid == 3)
    // {
        
       
    //     document.cookie = "firmcolor=#8C252C";
    // }
    // else
    // {
    //     document.cookie = "firmcolor=#F89504";
        
    // }

    window.location.reload();
 }

 
        </script>

</body>


</html>