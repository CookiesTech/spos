
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
    body {
        width: 6.5in;
        margin-left: 24px;
        margin-top:10px;
        }
    .label{
        width: 35mm;
        height: 70px;
        margin-right: 40px;
        float: left;
        text-align: center;
        overflow: hidden;
        font-family: fantasy;
        }
    .page-break  {
        clear: left;
        display:block;
        page-break-after:always;
        }
    </style>

</head>
<body>
    <?php 
    
    for($i=1;$i<=21;$i++)
    {
        ?>
    
@foreach($datas as $data)
<div class="label">
<?php  echo '<img src="data:image/png;base64,'.$data->barcode_image.'" style="height:auto;width: 70px"/>'; ?>
    <p style='font-size:9px;margin:0px;'>MRP: 12000</p></div>
@endforeach
    <?php  }  ?>
<div class="page-break"></div>
</body>
</html>