<?php

return [
    'admin_nav_items' => [
        'dashboard' => "Podsumowanie",
        'clients' => "Klienci",
        'bills' => "Rachunki"
    ],
    'client_inputs' => [
        ['name' => 'first_name', 'type' => 'text', 'label' => 'Imię', 'placeholder' => 'Imię'],
        ['name' => 'last_name', 'type' => 'text', 'label' => 'Nazwisko', 'placeholder' => 'Nazwisko'],
        ['name' => 'arrival_date', 'type' => 'date', 'label' => 'Data przyjazdu', 'required' => true],
        ['name' => 'departure_date', 'type' => 'date', 'label' => 'Data odjazdu', 'required' => true],
        ['name' => 'adults', 'type' => 'number', 'label' => 'Dorośli', 'placeholder' => 0],
        ['name' => 'children', 'type' => 'number', 'label' => 'Dzieci', 'placeholder' => 0],
        ['name' => 'electricity', 'type' => 'number', 'label' => 'Prąd', 'placeholder' => 0],
        ['name' => 'small_places', 'type' => 'number', 'label' => 'Małe miejsca', 'placeholder' => 0],
        ['name' => 'big_places', 'type' => 'number', 'label' => 'Duże miejsca', 'placeholder' => 0],
        ['name' => 'comment', 'type' => 'text', 'label' => 'Komentarz', 'placeholder' => 'Komentarz'],
        ['name' => 'discount', 'type' => 'select', 'label' => 'Rabat', 'options' => [0 => '0%', 5 => '5%', 10 => '10%']]
    ]
];
