<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'security.php';

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($dbcon, $_POST['title']);
    $description = mysqli_real_escape_string($dbcon, $_POST ['description']);
    $slug = slug($title);
    $date = date('Y-m-d H:i');
    $posted_by = mysqli_real_escape_string($dbcon, $_SESSION['username']);

    $sql = "INSERT INTO posts (title,meta_description,meta_keywords,og_image, description, slug,posted_by, date) VALUES('$title','$meta_description','$meta_keywords','$og_title', '$description', '$slug', '$posted_by', '$date')";
    mysqli_query($dbcon, $sql) or die("failed to post" . mysqli_connect_error());

    $permalink = "p/".mysqli_insert_id($dbcon) ."/".$slug;

    printf("Posted successfully. <meta http-equiv='refresh' content='2; url=%s'/>",
       $permalink);

} else {
    ?>
    <div class="w3-container">
        <div class="w3-card-4">
            <div class="w3-container w3-teal">
                <h2>New Post</h2>
            </div>

            <form class="w3-container" method="POST" novalidate>

                <p>
                    <label>Title</label>
                    <input type="text" class="w3-input w3-border" name="title" required>
                    <label>Meta Description</label>
                    <input type="text" class="w3-input w3-border" name="meta_description" required>
                     <label>Meta Keywords</label>
                    <input type="text" class="w3-input w3-border" name="meta_keywords" required>
                    <label>Og Image</label>
                    <input type="text" class="w3-input w3-border" name="og_image" required>
                </p>

                <p>
                    <label>Description</label>
                    <textarea id = "editor" row="30" cols="50" class="w3-input w3-border" name="description" required/></textarea>
                    <script src="https://cdn.ckbox.io/CKBox/1.1.0/ckbox.js"></script>
    <!--
        The "super-build" of CKEditor 5 served via CDN contains a large set of plugins and multiple editor types.
        See https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start.html#running-a-full-featured-editor-from-cdn
    -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/super-build/ckeditor.js"></script>
    <script>
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
            toolbar: {
                items: [
                    'ckbox', 'uploadImage', '|',
                    'exportPDF','exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: 'Welcome to CKEditor 5 + CKBox!',
            ckbox: {
                // The development token endpoint is a special endpoint to help you in getting started with
                // CKEditor Cloud Services.
                // Please note the development token endpoint returns tokens with the CKBox administrator role.
                // It offers unrestricted, full access to the service and will expire 30 days after being used for the first time.
                // -------------------------------------------------------------
                // !!! You should not use it on production !!!
                // -------------------------------------------------------------
                // Read more: https://ckeditor.com/docs/ckbox/latest/guides/configuration/authentication.html#token-endpoint

                // You need to provide your own token endpoint here
                tokenUrl: 'https://91926.cke-cs.com/token/dev/Sc11mSoT3n7NBjSLYE2wlLU6YI4xRmuKYIGf?limit=10'
            },
            // The "super-build" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you reqd the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType
                'MathType'
            ]
        });
    </script>
                </p>
                <p>
                    <input type="submit" class="w3-btn w3-teal w3-round" name="submit" value="Post">
                </p>
            </form>

        </div>
    </div>
         
    <?php
}

include("footer.php");
