<!--begin::Base Scripts -->
<script src="/assets/vendors/base/vendors.bundle.js"></script>
<script src="/assets/demo/default/base/scripts.bundle.js"></script>
<!--end::Base Scripts -->

@php
if(file_exists($_SERVER['DOCUMENT_ROOT']."/js".$_SERVER['REQUEST_URI'].".js")){
    echo "<!-- page js -->";
    echo "<script src='/js".$_SERVER['REQUEST_URI'].".js'></script>";
}
@endphp