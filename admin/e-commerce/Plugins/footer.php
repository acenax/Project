</div>

<script>
var resizefunc = [];
</script>

<!-- jQuery  -->
<!-- <script src="Assets/js/jquery.min.js"></script> -->
<script src="Assets/js/bootstrap.min.js"></script>
<script src="Assets/js/detect.js"></script>
<script src="Assets/js/fastclick.js"></script>
<script src="Assets/js/jquery.blockUI.js"></script>
<script src="Assets/js/waves.js"></script>
<script src="Assets/js/jquery.slimscroll.js"></script>
<script src="Assets/js/jquery.scrollTo.min.js"></script>
<script src="Assets/plugins/switchery/switchery.min.js"></script>

<script src="Assets/plugins/switchery/switchery.min.js"></script>


<!--Summernote js-->
<script src="Assets/plugins/summernote/0.8.18/summernote.min.js"></script>
<!-- Select 2 -->
<script src="Assets/plugins/select2/js/select2.min.js"></script>
<!-- Jquery filer js -->
<script src="Assets/plugins/jquery.filer/1.3.0/js/jquery.filer.min.js"></script>

<!-- page specific js -->
<script src="Assets/pages/jquery.blog-add.init.js"></script>

<!-- App js -->
<script src="Assets/js/jquery.core.js"></script>
<script src="Assets/js/jquery.app.js"></script>

<script>
jQuery(document).ready(function() {

    $('.summernote').summernote({
        height: 120, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });
    // Select2
    $(".select2").select2();

    $(".select2-limiting").select2({
        maximumSelectionLength: 2
    });
});
</script>

<script>
// var editor1 = document.getElementById('editor1')
// CKEDITOR.replace(editor1);
</script>

</body>

</html>