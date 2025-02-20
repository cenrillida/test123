<?php
include_once "AspPageBuilders/class.AspLoginFormPageBuilder.php";
include_once "AspPageBuilders/class.AspPersonalPageBuilder.php";
include_once "AspPageBuilders/class.AspResetPasswordFormPageBuilder.php";
include_once "AspPageBuilders/class.AspUpdatePasswordFormPageBuilder.php";
include_once "AspPageBuilders/class.AspRegisterFormPageBuilder.php";
include_once "AspPageBuilders/class.AspAddDataPageBuilder.php";
include_once "AspPageBuilders/class.AspDocumentApplicationPageBuilder.php";
include_once "AspPageBuilders/class.AspPhotoPageBuilder.php";
include_once "AspPageBuilders/class.AspCreateDocumentPageBuilder.php";
include_once "AspPageBuilders/class.AspDocumentUploadPageBuilder.php";
include_once "AspPageBuilders/class.AspGetPdfPageBuilder.php";
include_once "AspPageBuilders/class.AspSendDocumentPageBuilder.php";
include_once "AspPageBuilders/class.AspTechSupportPageBuilder.php";
include_once "AspPageBuilders/class.AspAdminTableBuilder.php";
include_once "AspPageBuilders/class.AspAdminTableSourceBuilder.php";
include_once "AspPageBuilders/class.AspChangeUserStatusPageBuilder.php";
include_once "AspPageBuilders/class.AspUserDataPageBuilder.php";
include_once "AspPageBuilders/class.AspEditRegDataPageBuilder.php";
include_once "AspPageBuilders/class.AspEducationChoosePageBuilder.php";
include_once "AspPageBuilders/class.AspEducationUploadPageBuilder.php";
include_once "AspPageBuilders/class.AspXlsxPageBuilder.php";
include_once "AspPageBuilders/class.AspApplyForEntryPageBuilder.php";
include_once "AspPageBuilders/class.AspApplyForEntryUploadPageBuilder.php";

interface AspPageBuilder {
    public function build();
}