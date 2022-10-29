<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles" />


<?php 
if(isset($_SESSION["status_diff"]))
{?>
    <script>
    $(function(){
        swal("<?=$_SESSION["title_diff"]?>", "<?=$_SESSION["text_diff"]?>", "<?=$_SESSION["status_diff"]?>");
    });
    </script>
<?php
    unset($_SESSION["title_diff"]);
    unset($_SESSION["text_diff"]);
    unset($_SESSION["status_diff"]);
} 
?>

