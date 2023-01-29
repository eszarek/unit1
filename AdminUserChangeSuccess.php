<?php
header('refresh:5;url=allusers.php');
/* 
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  12/5/2022
  * Time:  8:34 AM
*/
?>
<div class="redirect">
<p class='Success'>User information updated. Redirecting to "All Users" page.</p>
<p id="countdown">You will be redirected in <span id="counter">5</span> second(s).</p></div>
<script type="text/javascript">
    function countdown() {
        var i = document.getElementById('counter');
        if (parseInt(i.innerHTML)<=0) {
            location.href = 'allusers.php';
        }
        if (parseInt(i.innerHTML)!=0) {
            i.innerHTML = parseInt(i.innerHTML)-1;
        }
    }
    setInterval(function(){ countdown(); },1000);
</script>
