<html lang="ja">
  <head>
    <meta charset="utf-8">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <style>
      #textPassword {
        border: none; /* デフォルトの枠線を消す */
      }
      #fieldPassword {
        border-style: solid;
        width: 350px;
      }
    </style>
  </head>
  <body>
    <form id="fieldPassword">
      <input type="text" id="textPassword" value="password123">
      <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
    </form>
    <script language="javascript">
      function pushHideButton() {
        var txtPass = document.getElementById("textPassword");
        var btnEye = document.getElementById("buttonEye");
        if (txtPass.type === "text") {
          txtPass.type = "password";
          btnEye.className = "fa fa-eye";
        } else {
          txtPass.type = "text";
          btnEye.className = "fa fa-eye-slash";
        }
      }
    </script>
  </body>
</html>