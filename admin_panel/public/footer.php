            <!-- Large Size -->
            <div class="modal fade" id="modal-package-name" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">What is my package name?</h4>
                        </div>
                        <div class="modal-body">
                            <li>Open Android Studio Project</li>
                            <li>Select <b></> Gradle Scripts > build.gradle (Module: app)<br><br></b><img src="assets/images/package-name.jpg" class="img-responsive"></li>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-youtube-api-key" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Get YouTube API Key</h4>
                        </div>
                        <div class="modal-body">
                           <ol>
                                <li>Go to <a href="https://console.developers.google.com/" target="_blank"><b>Google Developers Console</b></a> and log in with your Google account.</li>
                                <li>Create the new project (name does not matter for the plugin).</li>
                                <li>Go to your project (by clicking on its name in the list).</li>
                                <li>In the sidebar on the left, expand APIs & Services → Library. In the list of APIs go to <b>YouTube Data API (v3)</b> and make sure that it’s <b>enabled (Enable API)</b>.</li>
                                <li>In the same sidebar click Credentials. Then click on Create New Key and choose API key.</li>
                                <li>Copy API key and paste it in the admin panel youtube api key settings form.</li>
                                <li>For video tutorial, klik this link <a href="https://youtu.be/eAkyaEHMJUE" target="_blank"><b>HERE</b></a></li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-server-key" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Obtaining your Firebase Server API Key</h4>
                        </div>
                        <div class="modal-body">
                           <p>Firebase provides Server API Key to identify your firebase app. To obtain your Server API Key, go to firebase console, select the project and go to settings, select Cloud Messaging tab and copy your Server key.</p>
                            <img src="assets/images/fcm-server-key.jpg" class="img-responsive">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-api-key" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Where I have to put my API Key?</h4>
                        </div>
                        <div class="modal-body">
                            <ol>
                                <li>for security needed, Update <b>API_KEY</b> String value.</li>
                                <li>Open Android Studio Project.</li>
                                <li>Click <b>CHANGE API KEY</b> to generate new API Key.</li>
                                <li>go to app > java > yourpackage name > config > <b>AppConfig.java</b>, and update with your own API Key. <br><br><img src="assets/images/api_key.jpg" class="img-responsive"></li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-onesignal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Where do I get my OneSignal APP ID and Rest API Key?</h4>
                        </div>
                        <div class="modal-body">
                            <ol>
                                <li>Login to your <a href="https://onesignal.com/" target="_blank"><b>OneSignal</b></a> Account and select your app</li>
                                <li>Select <b></> SETTINGS > Keys & IDs.<br><br></b> <img src="assets/images/onesignal_key.jpg" class="img-responsive"></li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-admob-app-id" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Update your AdMob App ID</h4>
                        </div>
                        <div class="modal-body">
                            <p>Put your <b>AdMob App ID</b> to <b>res/value/ads.xml</b> in the <b>admob_app_id</b> string tag.</p>
                            <img src="assets/images/admob_app_id.jpg" class="img-responsive">
                            <p><b>Important:</b> This step is required! Failure to add your app id in the string tag results in a crash with the message: The Google Mobile Ads SDK was initialized incorrectly.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Large Size -->
            <div class="modal fade" id="modal-applovin-sdk-key" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Update your AppLovin SDK Key</h4>
                        </div>
                        <div class="modal-body">
                            <p>Put your <b>AppLovin SDK Key</b> to <b>res/value/ads.xml</b> in the <b>applovin_sdk_key</b> string tag.</p>
                            <img src="assets/images/admob_app_id.jpg" class="img-responsive">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OK, I AM UNDERSTAND</button>
                        </div>
                    </div>
                </div>
            </div>

     <!-- Wait Me Plugin Js -->
    <script src="assets/plugins/waitme/waitMe.js"></script>

    <!-- Jquery Core Js -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/i18n/defaults-*.min.js"></script> -->


    <!-- Slimscroll Plugin Js -->
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="assets/plugins/node-waves/waves.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="assets/plugins/autosize/autosize.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="assets/plugins/jquery-validation/jquery.validate.js"></script>

    <script src="assets/js/dropify.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="assets/js/admin.js"></script>
    <script src="assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="assets/js/pages/forms/form-validation.js"></script>

    <!-- Demo Js -->
    <script src="assets/js/demo.js"></script>

    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove:  'Supprimer',
                    error:   'Désolé, le fichier trop volumineux'
                }
            });

            $('.dropify-image').dropify({
                messages: {
                    default : '<center>Drag and drop a image here or click</center>',
                    error   : 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': '<center>The file size is too big broo ({{ value }} max).</center>',
                    'minWidth': '<center>The image width is too small ({{ value }}}px min).</center>',
                    'maxWidth': '<center>The image width is too big ({{ value }}}px max).</center>',
                    'minHeight': '<center>The image height is too small ({{ value }}}px min).</center>',
                    'maxHeight': '<center>The image height is too big ({{ value }}px max).</center>',
                    'imageFormat': '<center>The image format is not allowed ({{ value }} only).</center>',
                    'fileExtension': '<center>The file is not allowed ({{ value }} only).</center>'
                },
            });

            $('.dropify-video').dropify({
                messages: {
                    default: '<center>Drag and drop a video here or click</center>'
                }
            });

            $('.dropify-notification').dropify({
                messages: {
                    default : '<center>Drag and drop a image here or click<br>(Optional)</center>',
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function(event, element){
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element){
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function(event, element){
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e){
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>

    <!-- <footer class="footer">
        <div class="container">
            <span class="right span-padding">Copyright © 2017 
                <a href="https://codecanyon.net/user/solodroid/portfolio" target="_blank">Solodroid Developer</a> All rights reserved.</span>
        </div>
    </footer> -->

</body>

</html>