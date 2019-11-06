                
                </div> <!-- content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo date('Y'); ?> © WebySEO - <a href="https://webyseo.cl" target="_blank">webyseo.cl</a>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-md-block">
                                    <a href="">Soporte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right Sidebar -->
        <?php include 'inc/_barra_settings.php'; ?>


        <div class="rightbar-overlay"></div>
        <!-- /Right-bar -->


        <!-- App js -->
        <script src="/js/app.min.js"></script>

        <!-- Summernote js -->
        <script src="/js/vendor/summernote-bs4.min.js"></script>
        <!-- SimpleMDE js -->
        <script src="/js/vendor/simplemde.min.js"></script>
        <!-- Summernote demo -->
        <script src="/js/pages/demo.summernote.js"></script>

        <script>
            $('#summernote').summernote('removeFormat');
        </script>

        <!-- SimpleMDE demo -->
        <script src="/js/pages/demo.simplemde.js"></script>

        <!-- Typehead -->
        <script src="/js/vendor/handlebars.min.js"></script>
        <script src="/js/vendor/typeahead.bundle.min.js"></script>

        <!-- Demo -->
        <script src="/js/pages/demo.typehead.js"></script>

    </body>

</html>