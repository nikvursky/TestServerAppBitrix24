<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quick start. Local static application</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <div id="name"></div>
    <script src="//api.bitrix24.com/api/v1/"></script>
    <script>
        //Make a call to REST when JS SDK is loaded
        $(function() {
        BX24.init(function(){

            BX24.callMethod('crm.deal.list', {
                // order: {'ID'},
                // select: {'ID', 'TITLE'}
            }, function(result){
                if(result.error())
            console.error(result.error());
        else
        {
            console.dir(result.data());             
            if(result.more())
                result.next();

            var dealid = document.getElementById('dealid');
            var dealurl = document.getElementById('dealurl');


            for (var i = 0; i < result.data().length; i++) {
                    $('table').find('tbody').append('<tr id="dealstr"><td id="dealid">'+result.data()[i]['ID']+'</td><td id="dealurl"><a href="https://b24-3h90gk.bitrix24.ru/crm/deal/details/'+result.data()[i]['ID']+'/" target="_blank">'+result.data()[i]['TITLE']+'</td></tr>');
                console.log(result.data()[i])
            }

        }
            });
        });

            console.log('B24 SDK is ready!', BX24.isAdmin());
        });
    </script>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Сделка</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    </table>

    <form action="" method="post">
        <input type="text" name="dealname" ></input>
        <input type="text" name="DOMAIN" value="<?php echo $_REQUEST['DOMAIN'];?>"></input>
        <input type="text" name="AUTH_ID" value="<?php echo $_REQUEST['AUTH_ID'];?>"></input>
        <input type="submit" name="send" value="Создать">
    </form>

    <?php
    if( isset( $_POST['send'] ) )
    {
        $value = $_POST['dealname'];
        $domain = 'https://'.$_REQUEST['DOMAIN'];
        $new_token = $_REQUEST['AUTH_ID'];
        $postfields = http_build_query(
            array(
                'fields'=>array(
                    'TITLE'=> $value
                ),
                'auth' => $new_token
            )
        );
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://b24-ozpsbg.bitrix24.ru/rest/1/hfqp38jx1cukjdbg/crm.deal.add');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        // $result = curl_exec($ch);
        // curl_close($ch);
        
            $res = file_get_contents($domain."/rest/crm.deal.add.json?".$postfields);
            $invoice = json_decode($res,true);
            $invoice = $invoice['result'];
    }
    ?>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>