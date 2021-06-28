@extends('layouts.default')

@section('head')
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="{{mix('css/style.css')}}"/>
@endsection

@section('navbar')
    <div class="parallax pb-5 text-center" data-parallax="scroll" data-image-src="{{mix('images/bgsc.jpg')}}">
        <nav class="navbar navbar-expand-md navbar-homepage pt-3 pt-md-4">
            <button class="navbar-toggler text-yellow border-yellow" type="button" data-toggle="collapse"
                    data-target="#menu"
                    aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="menu">
                <ul class="navbar-nav text-left">
                    <li class="nav-item p-0 mx-2">
                        <a class="nav-link" href="#onas">O nas</a>
                    </li>
                    <li class="nav-item p-0 mx-2">
                        <a class="nav-link" href="#pole">Pole namiotowe</a>
                    </li>
                    <li class="nav-item p-0 mx-2">
                        <a class="nav-link" href="#domki">Domki</a>
                    </li>
                    <li class="nav-item p-0 mx-2">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                    <li class="nav-item p-0 mx-2">
                        <a class="nav-link" href="#kontakt">Kontakt</a>
                    </li>
                </ul>
            </div>
        </nav>
        <a href="#">
            <img class="img-fluid px-4 mt-3 mt-md-5" alt="Nadmorski Sonet"
                 src="{{mix('images/sloneczny_camping.png')}}">
        </a>
    </div>
@endsection

@section('about')
    <div id="onas" class="section">
        <div class="container">
            <h1 class="text-yellow">Słoneczny Camping</h1>
            <p>
                Wicie to atrakcyjna miejscowość turystyczna środkowego wybrzeża bałtyku. Leży między Darłówkiem a
                Jarosławcem, ma róœnież bezpośrednim dostępem do dzikiego jeziora Kopań. Słoneczny Camping usytuowany
                jest w odległości 200 metrów od morza i około 800 metrów od jeziora.
            </p>
        </div>
    </div>
@endsection

@section('campsite')
    <div id="pole" class="parallax section" data-parallax="scroll"
         data-image-src="{{mix('images/pole.jpg')}}">
        <div class="rooms_content container">
            <h1 class="text-white">Pole namiotowe</h1>
            <p>
                Na terenie campingu znajdują się nowoczesne, murowane sanitariaty, osobno dla kobiet oraz mężczyzn.
                W sanitariatach są bezpłatne prysznice z ciepłą wodą, umywalnie i toalety. Udostępniamy także specjalne
                miejsce do zmywania naczyń oraz do opróżniania pojemników z fekaliami. Pole namiotowe jest podzielone
                żywopłotem na sektory, każdy z dostępem do prądu.
            </p>
        </div>
    </div>
@endsection

@section('bungalows')
    <div id="domki" class="section">
        <div class="container">
            <h1 class="text-yellow">Domki</h1>
            <p>
                Przy domku znajduje się taras oraz parking dla samochodu. W domku na parterze jest pokój z aneksem
                kuchennym oraz toaleta z prysznicem. W aneksie kuchennym jest lodówka, kuchenka elektryczna i
                zlewozmywak, a w pokoju stół oraz kanapa dwuosobowa. Na piętrze znajduje się sypialnia wyposażona
                w dwa łóżka jednoosobowe, z możliwością połączenia. Domek jest przeznaczony dla maksymalnie 4 osób.
            </p>
        </div>
    </div>
@endsection

@section('faq')
    <div id="faq" class="section bg-dark-grey">
        <div class="container">
            <h1 class="text-white mb-4">FAQ</h1>
            <p class="mb-4">
                P: Czy możemy zarezerwować miejsce?<br>
                O: Ze względu na specyfikę wypoczynku na campingu, nie rezerwujemy miejsc. Goście często przedłużają
                pobyt,
                przez co rezerwacje prowadziłyby do wielu niekomfortowych sytuacji zarówno dla nas jak i gości.
            </p>

            <p>
                P: Czy istnieje możliwość kontaktu mailowego lub SMS?<br>
                O: Nie, wszelkie informacje przekazujemy tylko poprzez kontakt telefoniczny.
            </p>
        </div>
    </div>
@endsection

@section('pricing')
    <div id="kontakt" class="section">
        <div class="container">
            <img class="img-fluid" src="{{mix('images/cennik.jpg')}}">
        </div>
    </div>
@endsection

@section('contact')
    <div id="kontakt" class="section">
        <div class="container">
            <h1 class="text-yellow">Kontakt</h1>
            <p>
                W celu uzyskania szczegółowych informacji, sprawdzenia dostępności noclegu lub dokonania
                rezerwacji (tylko w przypadku domków!)
                zapraszamy do kontaktu telefonicznego.<br><br>
            </p>
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span class="pl-1">
                Słoneczny Camping<br>
                Wicie, ul. Słoneczna 11b<br>
            </span>
            <i class="fa fa-mobile" aria-hidden="true"></i>
            <a class="pl-1" href="tel:+48509321120">+48 509 321 120</a>
        </div>
    </div>
@endsection

@section('testimonials')

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
    @yield('faq')
    @yield('pricing')
    @yield('contact')
    @yield('testimonials')
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
    <script src="{{mix('js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/55e5114f06.js"></script>
    <script src="{{mix('js/parallax.min.js')}}"></script>
@endpush
