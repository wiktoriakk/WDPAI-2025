<?php

require_once 'AppController.php';


class DashboardController extends AppController {

    private $cardsData = [
        [
            'id' => 1,
            'title' => 'Ace of Spades',
            'subtitle' => 'Legendary card',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/AS.png',
            'href' => '/cards/ace-of-spades'
        ],
        [
            'id' => 2,
            'title' => 'Queen of Hearts',
            'subtitle' => 'Classic romance',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/QH.png',
            'href' => '/cards/queen-of-hearts'
        ],
        [
            'id' => 3,
            'title' => 'King of Clubs',
            'subtitle' => 'Royal strength',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/KC.png',
            'href' => '/cards/king-of-clubs'
        ],
        [
            'id' => 4,
            'title' => 'Jack of Diamonds',
            'subtitle' => 'Sly and sharp',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/JD.png',
            'href' => '/cards/jack-of-diamonds'
        ],
        [
            'id' => 5,
            'title' => 'Ten of Hearts',
            'subtitle' => 'Lucky draw',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/0H.png',
            'href' => '/cards/ten-of-hearts'
        ],
    ];

    public function index() {
        $this->render("dashboard", ['cards' => $this->cardsData]);
    }

    public function show($id) {
        // Znajdź kartę o podanym ID
        $card = null;
        foreach ($this->cardsData as $c) {
            if ($c['id'] == $id) {
                $card = $c;
                break;
            }
        }

        // Wyświetl dashboard z pojedynczą kartą lub wszystkie karty jeśli nie znaleziono
        if ($card) {
            $this->render("dashboard", ['cards' => [$card]]);
        } else {
            $this->render("dashboard", ['cards' => $this->cardsData]);
        }
    }
}