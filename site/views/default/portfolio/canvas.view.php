<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $title ?>": "<?= $app->page_full ?>" }
</view>

<view key="body">
    <!-- The design page -->
    <div id="editorPage" class="area">
        <div id="iframeWrapper">
            <iframe id="editorFrame" width="100%" height="800px"></iframe>
        </div>
        <div id="saveAndNextButtonsWrapper">
            <!-- The Save button -->
            <input id="saveButton" type="button" class="btn btn-info btn-lg" value="Save" />
            <!-- The Finish design button -->
            <input id="nextButton" type="button" class="btn btn-success btn-lg" value="Finish design >" />
        </div>
    </div>

    <!-- The approval page -->
    <div id="approvePage" class="area" style="display: none">
        <div class="container-fluid">
            <h1>Approve Your Product</h1>
            <!-- proof images -->
            <img class="previewImg" id="preview" />
            <img class="previewImg" id="previewPage2" />
        </div>
        <p>
            <div id="approveButtonWrapper">
                <input id="approveButton" type="button" class="btn btn-success btn-lg" value="Approve >" />
            </div>
        </p>
        <div class="return">
            <a id="lnkEditAgain">&lt; I want to make some changes</a>
        </div>
    </div>

    <!-- The finish page -->
    <div id="finishOrderPage" class="area" style="display: none">
        <h1 class="">Your Product is Ready</h1>
        <!-- The link for downloading the hi-res output. -->
        The print-ready file can be downloaded from <a id="hiResLink">this link</a>
        <div class="right">
            <input id="newDesign" type="button" class="btn btn-info btn-lg" value="< New design" />
        </div>
    </div>


</view>


<view key="page_scripts">
    <script id="CcIframeApiScript" type="text/javascript" src="https://h.customerscanvas.com/Users/f3a5367c-f7ea-4bed-b361-7c9b1f537ca1/SimplePolygraphy/Resources/Generated/IframeApi.js">
    </script>
    <script type="text/javascript">
        let username = '<?= $username ?>';
        init_canvas(username);
    </script>
</view>