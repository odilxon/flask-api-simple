<?php 
function CallAPI($method, $url, $data = false) // Bu funksiya Curl bilan ishledi
{
    $curl = curl_init();
    // Malumotlar: array("parametr" => "malumot") ==> index.php?parametr=malumot
    switch ($method)
    {
        case "POST":  // POST so'rov jo'natsak 
            curl_setopt($curl, CURLOPT_POST, 1); //Parametrlarini to'girlemiz
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT": //PUT uchun to'girlemiz
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default: //qolganlar uchun GET bilan bir hilda bo'ladi
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // Ixtiyoriy parametrlar:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl); 
    curl_close($curl);
    return json_decode($result); // Bizga JSON da keladi malumot shuning uchun uni Object qivolamiz
}
$data = CallAPI("GET", "http://127.0.0.1:5000/sinflar");
?>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   </head>
   <body>
      <div class="container">
         <div class="row">
            <table class="table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>O'quvchilar soni</th>
                  <th>Sinf</th>
                  <th>Sinf raxbar</th>
                  <th>Sinf xona raqami</th>
               </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $item){
                    echo "<tr><td>$item->id</td><td>$item->oquvchilar_soni</td><td>$item->sinf</td><td>$item->sinf_raxbar</td><td>$item->sinf_xonasi</td></tr>";
                }
                ?>
            </tbody>
            <table>
         </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   </body>
</html>