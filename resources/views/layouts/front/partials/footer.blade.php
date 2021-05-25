<footer id="tw-footer" class="tw-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="tw-footer-info-box">
                    <a href="index.html" class="footer-logo">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="footer_logo" class="img-fluid">
                    </a>
                    <p class="footer-info-text">
                        L'AGENDA DU QUÉBEC VOUS OUVRE LES PORTES VERS L'AVENTURE!
                    </p>
                    <!-- End Social link -->
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-12 col-lg-8">
                <!-- End Contact Row -->
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget footer-left-widget">
                            <div class="section-heading">
                                <h3>Liens utiles</h3>
                                <span class="animate-border border-black"></span>
                            </div>
                            <ul>
                                <li><a href="{{route('page','a-propos-1')}}">A propos</a></li>
                                <li><a href="{{route('page','comment-ca-marche')}}">Services</a></li>
                                <li><a href="{{route('contact')}}">Contactez-Nous</a></li>
                                <!-- <li><a href="#">FAQ</a></li> -->
                            </ul>
                            <!-- <ul>
                                <li><a href="#">Contact us</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Testimonials</a></li>
                                <li><a href="#">Faq</a></li>
                            </ul> -->
                        </div>
                        <!-- End Footer Widget -->
                    </div>
                    <!-- End col -->
                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget">
                            <div class="section-heading">
                                <h3>Subscribe</h3>
                                <span class="animate-border border-black"></span>
                            </div>
                            <p>Ne manquez pas de vous abonner à notre neswsletter, veuillez remplir le formulaire ci-dessous.</p>
                            <form action="#">
                                <div class="form-row">
                                    <div class="col tw-footer-form">
                                        <input type="email" class="form-control" placeholder="Adresse courriel">
                                        <button type="submit"><i class="fa fa-send"></i></button>
                                    </div>
                                </div>
                            </form>
                            <!-- End form -->
                        </div>
                        <!-- End footer widget -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Widget Row -->
    </div>
    <!-- End Contact Container -->


    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span>Copyright &copy; {{date('Y')}}, Tous droits réservés L'agenda du Québec</span>
                </div>
                <!-- End Col -->
                <div class="col-md-6">
                    <div class="copyright-menu">
                        <ul>
                            <!-- <li><a href="#">Home</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Contact</a></li> -->
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Copyright Container -->
    </div>
    <!-- End Copyright -->
    <!-- Back to top -->
    <div id="back-to-top" class="back-to-top">
        <button class="btn btn-dark" title="Back to Top">
            <i class="fa fa-angle-up"></i>
        </button>
    </div>
    <!-- End Back to top -->
</footer>
<!-- End Footer -->
