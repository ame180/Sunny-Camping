@extends('layouts.default')

@section('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{mix('css/style.css')}}"/>
@endsection

@section('navbar')
    <div class="parallax_nav parallax-window" data-parallax="scroll" data-image-src="{{mix('images/bgsc.jpg')}}">
        <a class="navbar_logo navbar-brand" href="#"><img alt="Nadmorski Sonet"
                                                          src="{{mix('images/sloneczny_camping.png')}}"></a>
        <nav class="navbar navbar-default header_nav">
            <div class="container">
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
                    <span class=" glyphicon glyphicon-align-justify"></span>
                </button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="nav navbar-nav">
                        <li><a href="#onas">O nas</a></li>
                        <li><a href="#pole">Pole namiotowe</a></li>
                        <li><a href="#domki">Domki</a></li>
                        <li><a href="#atrakcje">Atrakcje</a></li>
                        <li><a href="#kontakt">Kontakt</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
@endsection

@section('about')
    <div id="onas" class="about_section">
        <div class="container">
            <h1>Słoneczny Camping</h1>
            <span>Serdecznie zapraszamy na wczasy</span>
            <p>Miejscowość Wicie położona jest między Darłówkiem, a Jarosławcem. Odległość z Pensjonatu do morza 300 m,
                do jeziora Kopań 900 m. Spokój, natura, czysta woda, duża plaża.

                Oferujemy Państwu pokoje 1-, 2-, 3- i 4- osobowe z łazienkami i dwupokojowe apartamenty. Wszystkie
                pokoje mają komfortowe wyposażenie. W pensjonacie znajduje się bar z bilardem. Możliwość organizowania
                imprez okolicznościowych.

                Aktualnie nasz obiekt przechodzi generalny remont, aby urlop Naszych Gości stał się jeszcze bardziej
                udany. Zapraszamy na sezon 2016!

                Serdecznie zapraszamy na wczasy do pensjonatu nad morzem "Nadmorski Sonet" w Wiciu!
            </p>
        </div>
    </div>
@endsection

@section('campsite')
    <div id="pole" class="camping_section parallax-window" data-parallax="scroll"
         data-image-src="{{mix('images/pole.jpg')}}">
        <div class="rooms_content container">
            <h1>Pole namiotowe</h1>
            <span>Mamy ich miliardy</span>
            <p>Miejscowość Wicie położona jest między Darłówkiem, a Jarosławcem. Odległość z Pensjonatu do morza 300 m,
                do jeziora Kopań 900 m. Spokój, natura, czysta woda, duża plaża.

                Oferujemy Państwu pokoje 1-, 2-, 3- i 4- osobowe z łazienkami i dwupokojowe apartamenty. Wszystkie
                pokoje mają komfortowe wyposażenie. W pensjonacie znajduje się bar z bilardem. Możliwość organizowania
                imprez okolicznościowych.

                Aktualnie nasz obiekt przechodzi generalny remont, aby urlop Naszych Gości stał się jeszcze bardziej
                udany. Zapraszamy na sezon 2016!

                Serdecznie zapraszamy na wczasy do pensjonatu nad morzem "Nadmorski Sonet" w Wiciu!
            </p>
        </div>
    </div>
@endsection

@section('bungalows')
    <div id="domki" class="bungalow_section">
        <div class="container">
            <h1>Domki</h1>
            <span>Miliardy atrakcji wszędzie</span>
            <p>Miejscowość Wicie położona jest między Darłówkiem, a Jarosławcem. Odległość z Pensjonatu do morza 300 m,
                do jeziora Kopań 900 m. Spokój, natura, czysta woda, duża plaża.

                Oferujemy Państwu pokoje 1-, 2-, 3- i 4- osobowe z łazienkami i dwupokojowe apartamenty. Wszystkie
                pokoje mają komfortowe wyposażenie. W pensjonacie znajduje się bar z bilardem. Możliwość organizowania
                imprez okolicznościowych.

                Aktualnie nasz obiekt przechodzi generalny remont, aby urlop Naszych Gości stał się jeszcze bardziej
                udany. Zapraszamy na sezon 2016!

                Serdecznie zapraszamy na wczasy do pensjonatu nad morzem "Nadmorski Sonet" w Wiciu!
            </p>
        </div>
    </div>
@endsection

@section('attractions')
    <div id="atrakcje" class="attractions_section">
        <div class="container">
            <h1>Atrakcje</h1>
            <span>Miliardy atrakcji wszędzie</span>
            <p>Miejscowość Wicie położona jest między Darłówkiem, a Jarosławcem. Odległość z Pensjonatu do morza 300 m,
                do jeziora Kopań 900 m. Spokój, natura, czysta woda, duża plaża.

                Oferujemy Państwu pokoje 1-, 2-, 3- i 4- osobowe z łazienkami i dwupokojowe apartamenty. Wszystkie
                pokoje mają komfortowe wyposażenie. W pensjonacie znajduje się bar z bilardem. Możliwość organizowania
                imprez okolicznościowych.

                Aktualnie nasz obiekt przechodzi generalny remont, aby urlop Naszych Gości stał się jeszcze bardziej
                udany. Zapraszamy na sezon 2016!

                Serdecznie zapraszamy na wczasy do pensjonatu nad morzem "Nadmorski Sonet" w Wiciu!
            </p>
        </div>
    </div>
@endsection

@section('contact')
    <div id="kontakt" class="contact_section">
        <div class="container">
            <h1>Kontakt</h1>
            <div class="row">
                <div class="col-md-4">
                    <p>
                        W celu uzyskania szczegółowych informacji, sprawdzenia dostępności noclegu lub dokonania
                        rezerwacji
                        zapraszamy do kontaktu telefonicznego, emailowego lub za pośrednictwem formularza
                        kontaktowego.<br><br>
                    </p>
                    <i class="pull-left fa fa-map-marker" aria-hidden="true"></i>
                    <p>
                        Słoneczny Camping<br>
                        Wicie, ul. Słoneczna 11b<br>
                    </p>
                    <i class="pull-left fa fa-mobile" aria-hidden="true"></i>
                    <a href="tel:+48509321120">+48 509 321 120</a>
                    <a href="mailto:nadmorskisonet@gmail.com">nadmorskisonet@gmail.com</a>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form_input form-control" id="name" name="name"
                           placeholder="Imię i nazwisko" value="">
                    <input type="email" class="form_input form-control" id="email" name="email"
                           placeholder="Adres email" value="">
                    <textarea class="form_textarea form-control" rows="4" name="message"
                              placeholder="Treść wiadomości..."></textarea>
                    <input id="submit" name="submit" type="submit" value="Wyślij wiadomość"
                           class="contact_form_button btn btn-primary pull-right">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('map')
    <div class="map_section">
        <iframe id="google_map"
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9265.562287219303!2d16.473439!3d54.508973!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x549f3ebc291d2d79!2sS%C5%82oneczny+Camping+WICIE!5e0!3m2!1spl!2spl!4v1489054569469"
                height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
@endsection

@section('main')
    @yield('about')
    @yield('campsite')
    @yield('bungalows')
    @yield('attractions')
    @yield('contact')
    @yield('map')
@endsection

@section('footer')
    <div class="container">
        <div class="pull-right">
            <span>Created by</span><a target="_blank" href="http://www.vnsoft.pl"><img class="vn_img"
                                                                                       src="{{mix('images/vn.png')}}"></a>
            <span>Design by</span><a target="_blank" href="http://www.jacynodesign.pl"><img class="jd_img"
                                                                                            src="{{mix('images/jd.png')}}"></a>
        </div>
        <div class="pull-left">
            <span>Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2021</span><a
                target="_blank"
                href="http://www.nadmorskisonet.pl"><img
                    class="sc_img" src="{{mix('images/sloneczny_camping.png')}}"></a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/55e5114f06.js"></script>
    <script src="{{mix('js/parallax.min.js')}}"></script>
    <script src="{{mix('js/script.js')}}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endpush
