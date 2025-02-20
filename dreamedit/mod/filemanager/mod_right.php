<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";


?>
<link href="/dreamedit/includes/ckeditor5-build-classic/ckfinder/_samples/sample.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.js"></script>
<p style="padding-left: 30px; padding-right: 30px;">
	<script type="text/javascript">

        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.basePath = '../';
        // The default height is 400.
        finder.height = 600;
        finder.width = "100%";
        // Change the skin to bootstrap.
        finder.skin = 'bootstrap';
        // Create CKFinder instance.
        finder.create();

	</script>
</p>