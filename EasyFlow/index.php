﻿<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理</title>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($conf['EasyFlowServer']);

if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {

        // 參數設定
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $eid = $_POST['eid'];
        $msg = $_POST['msg'];
		$date1= $_POST['date1'];
		$date2= $_POST['date2'];
		$date3= $_POST['date3'];
		$item=$_POST['item'];
		$item2=$_POST['item2'];
        

        // 送到流程管理
        try{
            $procesesStr = $client->findFormOIDsOfProcess($oid);

            $proceses = explode(",", $procesesStr);
            $process = $proceses[0];
            $template = $client->getFormFieldTemplate($process);

            $form = simplexml_load_string($template);
			$form->Textbox9 = $uid;
            $form->Textbox10 = $eid;
			$form->Textbox11 = $date1;
			$form->Textbox12 = $date2;
			$form->Textbox13 = $date3;
			$form->Textbox14 = $msg;
			$form->RadioButton15 = $item;
			$form->RadioButton16 = $item2;
           

            $result = $form->asXML();
            $client->invokeProcess($oid, $eid, $uid, $process, $result, "伺服器代管申請作業");
        }catch(Exception $e){
        echo $e->getMessage();
        }

    } else {
        echo "系統錯誤";
    }
    
}

?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
		
		<div class="row">
              <div class="col-md-6 mb-3">
                  <label for="uid">員工單位編號</label>
                  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    員工單位編號 必填
                  </div>
                </div>
          
            <div class="col-md-6 mb-3">
              <label for="eid">員工編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
          </div>
		  
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="date1">申請日期</label>
                  <input name="date1" type="text" class="form-control" id="date1" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    申請日期 必填
                  </div>
                </div>
          </div>
		  
		  
		  <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="date2">刊登日期</label>
                  <input name="date2" type="text" class="form-control" id="date2" placeholder="" value="" required>
                  <div class="invalid-feedback">
                   刊登日期 必填
                  </div>
                </div>
				<div class="col-md-6 mb-3">
                  <label for="date3">至</label>
                  <input name="date3" type="text" class="form-control" id="date3" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    刊登日期 必填
                  </div>
                </div>
          </div>
		  
		  
		  <div class="row">
		   <div>申請事項</div><br>
	          <div class="col-md-12 mb-3">
			     <input type ="radio"  id="item" name="item" value="A">Banner(1004x300像素)<br>
				 <input type ="radio"  id="item" name="item" value="B">跑馬燈<br>
				 <input type ="radio"  id="item" name="item" value="C">快速連結<br>
				 <input type ="radio"  id="item" name="item" value="D">網頁內容<br>
				 <input type ="radio"  id="item" name="item" value="E">網頁版面<br>
				 <input type ="radio"  id="item" name="item" value="F">增件帳號<br>
				 <input type ="radio"  id="item" name="item" value="G">其他<br>
			  </div>
		  </div>
		  
		  
		  
		  <div class="row">
		  <div>協助事項</div><br>
	          <div class="col-md-12 mb-3">
			     <input type ="radio"  id="item2" name="item2" value="0">新增<br>
				 <input type ="radio"  id="item2" name="item2" value="1">修改<br>
				 <input type ="radio"  id="item2" name="item2" value="2">刪除<br>
			  </div>
		  </div>
		  
		  
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="msg">申請事項說明</label>
                  <input name="msg" type="text" class="form-control" id="msg" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    申請事項說明 必填
                  </div>
                </div>
          </div>
		  
		  <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="">申請事項說明<br>1.申請事項說明以簡單扼要為原則。<br>
				  2.申請單位應負刊登文字責任。<br>3.相關檔案請寄到公務信箱banner bcoffice@nkust.edu.tw(請在刊登日前3天寄出)
				  <br>其他 : chunting@nkust.edu.tw</label>
                  
                  
                </div>
          </div>
		  
		  
		  
		  

          

         

          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>